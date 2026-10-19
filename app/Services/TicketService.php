<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\TicketCategory;
use App\Models\TicketComment;
use App\Models\TicketHistory;
use App\Models\TicketInternalNote;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\TicketSubcategory;
use App\Models\TicketType;
use App\Models\TicketWorkUpdate;
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class TicketService
{
    /** Statuses from which a ticket may be (re)assigned. */
    /** An employee's own progress on a request. */
    public const WORK_STATUSES = [
        'ASSIGNED' => 'To do',
        'IN_PROGRESS' => 'In progress',
        'WAITING' => 'Waiting',
        'DONE' => 'Done',
    ];

    public const ASSIGNABLE = ['NEW', 'ACKNOWLEDGED', 'ASSIGNED', 'IN_PROGRESS', 'WAITING_USER', 'ON_HOLD', 'REOPENED', 'ESCALATED'];

    public function __construct(protected AttachmentService $attachments) {}

    // ------------------------------------------------------------------ create

    /**
     * @param User      $requester  the person the request is for
     * @param User|null $actor      who is submitting it (differs from $requester when filed on someone's behalf)
     */
    public function create(User $requester, array $d, array $files = [], ?User $actor = null): Ticket
    {
        $actor ??= $requester;
        $behalf = $actor->id !== $requester->id;

        return DB::transaction(function () use ($requester, $actor, $behalf, $d, $files) {
            // one running counter (row 0 of ticket_sequences), locked so two simultaneous requests never share a number
            DB::table('ticket_sequences')->insertOrIgnore(['year' => 0, 'last_number' => 0]);
            $seq = DB::table('ticket_sequences')->where('year', 0)->lockForUpdate()->first();
            $next = $seq->last_number + 1;
            DB::table('ticket_sequences')->where('year', 0)->update(['last_number' => $next]);
            $ticketNo = config('itsm.ticket_prefix', 'RQ') . '-' . $next;

            $status = TicketStatus::where('code', 'NEW')->firstOrFail();
            // Priority is no longer chosen by users; every request gets the default (Medium) behind the scenes
            $priority = TicketPriority::where('name', 'Medium')->first() ?? TicketPriority::orderBy('level')->firstOrFail();
            $now = now();

            $ticket = Ticket::create([
                'ticket_no' => $ticketNo,
                'ticket_type_id' => $d['ticket_type_id'],
                'requester_id' => $requester->id,
                'department_id' => $requester->department_id ?? $d['department_id'],
                'requester_name' => $requester->name,
                'requester_employee_id' => $requester->employee_id,
                'requester_designation' => $requester->designation?->name,
                'requester_phone' => $d['phone'] ?? $requester->whatsapp,
                'requester_email' => $requester->email,
                'location_id' => $d['location_id'] ?? $requester->location_id,
                'category_id' => $d['category_id'],
                'subcategory_id' => $d['subcategory_id'] ?? null,
                'priority_id' => $priority->id,
                'status_id' => $status->id,
                'subject' => $d['subject'],
                'description' => $d['description'],
                'preferred_completion_date' => $d['preferred_completion_date'] ?? null,
                'sla_response_due_at' => $priority->response_minutes ? $now->copy()->addMinutes($priority->response_minutes) : null,
                'sla_resolution_due_at' => $priority->resolution_minutes ? $now->copy()->addMinutes($priority->resolution_minutes) : null,
                'sla_status' => 'on_track',
                'created_by' => $actor->id,
            ]);

            foreach ($files as $file) {
                $this->attachments->store($ticket, $actor, $file);
            }

            if ($behalf) {
                $this->log($ticket, $actor, 'created_on_behalf', null, null, $requester->name, $ticket->subject);
            } else {
                $this->log($ticket, $actor, 'created', null, null, $ticketNo, $ticket->subject);
            }

            $suffix = $behalf ? " (for {$requester->name}, filed by {$actor->name})" : '';
            $this->notify($this->officers(), $ticket, "New request {$ticketNo}: {$ticket->subject}{$suffix}", $actor);
            $this->notify([$requester], $ticket, $behalf
                ? "{$actor->name} submitted request {$ticketNo} on your behalf."
                : "Your request {$ticketNo} was submitted.");
            if ($behalf) {
                $this->notify([$actor], $ticket, "Request {$ticketNo} was submitted for {$requester->name}.");
            }

            return $ticket;
        });
    }

    // ----------------------------------------------------------- transitions

    /** Transitions the user may trigger from the ticket's current status (assign has its own form). */
    public function allowedTransitions(Ticket $t, User $u)
    {
        return DB::table('ticket_status_transitions as tr')
            ->join('ticket_statuses as s', 's.id', '=', 'tr.to_status_id')
            ->where('tr.from_status_id', $t->status_id)
            ->select('tr.permission', 'tr.requires_comment', 's.code', 's.name')
            ->get()
            ->filter(fn ($r) => $r->permission !== 'system'
                && $r->code !== 'ASSIGNED'
                && $this->userMay($t, $u, $r->permission))
            ->unique('code')
            ->values();
    }

    protected function userMay(Ticket $t, User $u, string $perm): bool
    {
        if (! $u->hasPermission($perm)) {
            return false;
        }
        $isRequester = $t->requester_id === $u->id;
        $isHead = $u->is_department_head && $u->department_id === $t->department_id;

        switch ($perm) {
            case 'ticket.work':
                return $t->assigned_to === $u->id || $u->hasPermission('ticket.assign');
            case 'ticket.confirm':
                return $isRequester || $isHead;
            case 'ticket.reopen':
                if ($u->hasPermission('ticket.assign')) {
                    return true; // IT Admin: anytime
                }
                $window = (int) SystemSetting::get('ticket.reopen_window_days', 7);
                $inWindow = $t->closed_at === null || $t->closed_at->gte(now()->subDays($window));
                return ($isRequester || $isHead) && $inWindow;
            case 'ticket.escalate':
                // IT Admin, or the primary responsible employee asking for help from the IT Admin
                return $u->hasPermission('ticket.assign') || $t->assigned_to === $u->id;
            case 'ticket.cancel':
                if ($u->hasPermission('ticket.assign')) {
                    return true;
                }
                return $isRequester && $t->status->code === 'NEW';
            default:
                return true;
        }
    }

    public function changeStatus(Ticket $t, string $code, User $user, ?string $comment = null, bool $system = false): Ticket
    {
        $t->loadMissing('status');
        $to = TicketStatus::where('code', $code)->firstOrFail();
        $rows = DB::table('ticket_status_transitions')
            ->where('from_status_id', $t->status_id)->where('to_status_id', $to->id)->get();

        if ($rows->isEmpty()) {
            $this->fail('status', "A ticket in '{$t->status->name}' cannot move to '{$to->name}'.");
        }
        if (! $system && ! $rows->contains(fn ($r) => $r->permission !== 'system' && $this->userMay($t, $user, $r->permission))) {
            $this->fail('status', 'You are not allowed to make this change.');
        }
        if ($rows->max('requires_comment') && ! $system && blank($comment)) {
            $this->fail('comment', 'A comment is required for this change.');
        }

        $old = $t->status;
        DB::transaction(function () use ($t, $to, $code, $user, $comment, $old, $system) {
            $upd = ['status_id' => $to->id, 'updated_by' => $user->id];

            switch ($code) {
                case 'ACKNOWLEDGED': $upd['acknowledged_at'] = $t->acknowledged_at ?? now(); break;
                case 'IN_PROGRESS':  $upd['started_at'] = $t->started_at ?? now(); break;
                case 'RESOLVED':
                    $upd['resolved_at'] = now();
                    $upd['resolution'] = $comment;
                    break;
                case 'CLOSED':
                    $upd['closed_at'] = now();
                    $upd['closed_by'] = $user->id;
                    break;
                case 'REOPENED':
                    $upd['reopened_at'] = now();
                    $upd['reopen_count'] = $t->reopen_count + 1;
                    $upd['closed_at'] = null;
                    $upd['resolved_at'] = null;
                    break;
            }

            $t->update($upd);
            $this->log($t, $user, 'status_changed', 'status', $old->name, $to->name, $comment);
            $this->syncWorkStatus($t, $code);

            if (filled($comment) && ! $system) {
                TicketComment::create(['ticket_id' => $t->id, 'user_id' => $user->id, 'body' => $comment]);
            }
        });

        $t->refresh()->load('status');

        $msg = "{$t->ticket_no}: {$old->name} → {$to->name}";
        $recipients = [$t->requester, $t->assignee];
        if (in_array($code, ['REOPENED', 'ESCALATED', 'RESOLVED'], true)) {
            $recipients = array_merge($recipients, $this->officers()->all());
        }
        $this->notify($recipients, $t, $msg, $user);

        if ($code === 'RESOLVED') {
            return $this->changeStatus($t, 'USER_CONFIRMATION', $user, null, true);
        }
        return $t;
    }

    // ------------------------------------------------------------ assignment

    /**
     * Assign (or reassign) the PRIMARY responsible employee. Supporting employees stay on the team;
     * the previous primary leaves it (use setTeam() to keep them as support).
     */
    public function assign(Ticket $t, User $assignee, User $by, ?string $instructions = null, ?string $dueDate = null): Ticket
    {
        $support = TicketAssignment::where('ticket_id', $t->id)->where('role', TicketAssignment::SUPPORT)->pluck('employee_id')->all();
        return $this->setTeam($t, $assignee, $support, $by, $instructions, $dueDate);
    }

    /**
     * Set the whole team: exactly ONE primary responsible employee plus any number of supporting employees.
     * Everything happens in one transaction; the request is left with exactly one primary or nothing changes.
     */
    public function setTeam(Ticket $t, User $primary, array $supportIds, User $by, ?string $instructions = null, ?string $dueDate = null): Ticket
    {
        $t->loadMissing('status', 'assignee');
        if (! in_array($t->status->code, self::ASSIGNABLE, true)) {
            $this->fail('primary_id', "A ticket in '{$t->status->name}' cannot be assigned.");
        }

        $support = collect($supportIds)->map(fn ($i) => (int) $i)->reject(fn ($i) => $i === $primary->id)->unique()->values()->all();
        $ids = array_merge([$primary->id], $support);
        $people = User::whereIn('id', $ids)->get()->keyBy('id');

        if (! ($primary->is_active && $primary->hasPermission('ticket.work'))) {
            $this->fail('primary_id', 'The primary responsible employee must be an active IT employee.');
        }
        foreach ($support as $id) {
            $p = $people->get($id);
            if (! $p || ! $p->is_active || ! $p->hasPermission('ticket.work')) {
                $this->fail('support_ids', 'Supporting employees must be active IT employees.');
            }
        }

        $existing = TicketAssignment::with('employee')->where('ticket_id', $t->id)->get()->keyBy('employee_id');
        $oldPrimary = $t->assignee;
        $primaryChanged = $oldPrimary?->id !== $primary->id;
        $added = $removed = $demoted = [];

        DB::transaction(function () use ($t, $primary, $people, $existing, $by, $instructions, $dueDate, $oldPrimary, $primaryChanged, &$added, &$removed, &$demoted) {
            // 1) people leaving the team
            foreach ($existing as $empId => $row) {
                if (! $people->has($empId)) {
                    $row->delete();
                    $removed[] = $row->employee;
                    $this->log($t, $by, 'team_removed', 'team', $row->employee->name, null);
                }
            }
            // 2) free the primary slot first (a request can never have two primaries, not even briefly)
            foreach ($existing as $empId => $row) {
                if ($people->has($empId) && $row->role === TicketAssignment::PRIMARY && $empId !== $primary->id) {
                    $row->update(['role' => TicketAssignment::SUPPORT]);
                    $demoted[] = $row->employee;
                    $this->log($t, $by, 'team_role_changed', 'team', $row->employee->name . ' (Primary)', $row->employee->name . ' (Supporting)');
                }
            }
            // 3) add new members / promote the new primary
            foreach ($people as $id => $person) {
                $role = $id === $primary->id ? TicketAssignment::PRIMARY : TicketAssignment::SUPPORT;
                $row = $existing->get($id);
                if ($row) {
                    if ($row->role !== $role) {
                        $row->update(['role' => $role]);
                        $this->log($t, $by, 'team_role_changed', 'team', $person->name . ' (Supporting)', $person->name . ' (Primary)');
                    }
                } else {
                    TicketAssignment::create([
                        'ticket_id' => $t->id, 'employee_id' => $id, 'role' => $role,
                        'assigned_by' => $by->id, 'assigned_at' => now(), 'work_status' => 'ASSIGNED',
                    ]);
                    if ($role === TicketAssignment::SUPPORT) {
                        $added[] = $person;
                    }
                    $this->log($t, $by, 'team_added', 'team', null, $person->name . ($role === TicketAssignment::PRIMARY ? ' (Primary)' : ' (Supporting)'));
                }
            }

            // 4) the request itself
            $upd = ['assigned_to' => $primary->id, 'updated_by' => $by->id, 'acknowledged_at' => $t->acknowledged_at ?? now()];
            if ($primaryChanged || ! $t->assigned_at) {
                $upd['assigned_at'] = now();
            }
            if ($dueDate) {
                $upd['due_date'] = $dueDate;
            }
            $oldStatus = $t->status;
            $toAssigned = $primaryChanged
                ? $oldStatus->code !== 'ASSIGNED'
                : in_array($oldStatus->code, ['NEW', 'ACKNOWLEDGED', 'REOPENED', 'ESCALATED'], true);
            if ($toAssigned) {
                $assigned = TicketStatus::where('code', 'ASSIGNED')->firstOrFail();
                $upd['status_id'] = $assigned->id;
                $this->log($t, $by, 'status_changed', 'status', $oldStatus->name, $assigned->name, null);
            }
            $t->update($upd);

            if ($primaryChanged) {
                TicketAssignment::where('ticket_id', $t->id)->where('employee_id', $primary->id)->update(['work_status' => 'ASSIGNED']);
                $this->log($t, $by, $oldPrimary ? 'reassigned' : 'assigned', 'assigned_to', $oldPrimary?->name, $primary->name, $instructions);
            }

            // exactly one primary – otherwise roll everything back
            if (TicketAssignment::where('ticket_id', $t->id)->where('role', TicketAssignment::PRIMARY)->count() !== 1) {
                $this->fail('primary_id', 'A request must have exactly one primary responsible employee.');
            }
        });

        $t->refresh()->load('status', 'assignee');

        $tail = $instructions ? ": {$instructions}" : '';
        if ($primaryChanged) {
            $this->notify([$primary], $t, "{$t->ticket_no}: you are the primary responsible employee{$tail}", $by);
        }
        $this->notify($added, $t, "{$t->ticket_no}: you were added as a supporting employee ({$primary->name} is primary){$tail}", $by);
        $this->notify($removed, $t, "{$t->ticket_no}: you were removed from the team", $by);
        $this->notify($demoted, $t, "{$t->ticket_no}: you are now a supporting employee ({$primary->name} is primary)", $by);
        if ($primaryChanged) {
            $this->notify([$t->requester], $t, "{$t->ticket_no} has been assigned to {$primary->name}", $by);
        }
        return $t;
    }

    /** An employee records their own progress; the primary is told when a supporting employee does. */
    public function updateWork(Ticket $t, User $user, string $status, ?string $note = null): void
    {
        $t->loadMissing('status');
        $row = TicketAssignment::where('ticket_id', $t->id)->where('employee_id', $user->id)->first();
        if (! $row) {
            $this->fail('work_status', 'You are not part of the team on this request.');
        }
        if (! $t->status->is_open) {
            $this->fail('work_status', 'This request is closed.');
        }
        if (! array_key_exists($status, self::WORK_STATUSES)) {
            $this->fail('work_status', 'Unknown work status.');
        }
        if ($status === $row->work_status && blank($note)) {
            $this->fail('note', 'Change your status or add a note.');
        }

        $old = $row->work_status;
        DB::transaction(function () use ($t, $user, $row, $status, $note) {
            $row->update(['work_status' => $status, 'remarks' => filled($note) ? $note : $row->remarks]);
            TicketWorkUpdate::create([
                'ticket_id' => $t->id, 'user_id' => $user->id, 'work_status' => $status,
                'note' => $note, 'created_at' => now(),
            ]);
        });
        AuditLog::record('ticket.work_update', $t, ['work_status' => $old], ['work_status' => $status, 'note' => $note]);

        if ($t->assigned_to && $t->assigned_to !== $user->id) {
            $label = self::WORK_STATUSES[$status];
            $this->notify([$t->assignee ?? User::find($t->assigned_to)], $t, "{$user->name} updated their work on {$t->ticket_no}: {$label}", $user);
        }
    }

    /** Keep each team member's own work status in step with the request's status. */
    protected function syncWorkStatus(Ticket $t, string $code): void
    {
        $q = TicketAssignment::where('ticket_id', $t->id);
        if ($code === 'RESOLVED') {
            $q->update(['work_status' => 'DONE']);          // the primary resolved it: everyone's part is done
            return;
        }
        if ($code === 'REOPENED') {
            $q->update(['work_status' => 'ASSIGNED']);       // back to the team
            return;
        }
        $map = ['ASSIGNED' => 'ASSIGNED', 'IN_PROGRESS' => 'IN_PROGRESS', 'WAITING_USER' => 'WAITING', 'ON_HOLD' => 'WAITING'];
        if (isset($map[$code])) {
            $q->where('role', TicketAssignment::PRIMARY)->update(['work_status' => $map[$code]]);
        }
    }

    /** Assignable staff member (IT Team Member or IT Admin) with the fewest open tickets. */
    public function autoPickAssignee(array $exclude = []): ?User
    {
        $primary = Ticket::open()->whereNotNull('assigned_to')
            ->select('assigned_to', DB::raw('count(*) as c'))->groupBy('assigned_to')->pluck('c', 'assigned_to');

        $support = DB::table('ticket_assignments as a')
            ->join('tickets as t', 't.id', '=', 'a.ticket_id')
            ->join('ticket_statuses as s', 's.id', '=', 't.status_id')
            ->whereNull('t.deleted_at')->where('s.is_open', 1)->where('a.role', TicketAssignment::SUPPORT)
            ->select('a.employee_id', DB::raw('count(*) as c'))->groupBy('a.employee_id')->pluck('c', 'employee_id');

        return User::active()->assignable()->get()
            ->reject(fn ($u) => in_array($u->id, $exclude, true))
            ->sortBy(fn ($u) => ($primary[$u->id] ?? 0) + ($support[$u->id] ?? 0))->first();
    }

    // ------------------------------------------------------ field maintenance

    public function updateFields(Ticket $t, User $user, array $in): Ticket
    {
        $changes = [];

        if (! empty($in['priority_id']) && (int) $in['priority_id'] !== $t->priority_id) {
            $new = TicketPriority::findOrFail($in['priority_id']);
            $changes[] = ['priority', $t->priority->name, $new->name];
            $t->priority_id = $new->id;
            if ($new->resolution_minutes) {
                $t->sla_resolution_due_at = $t->created_at->copy()->addMinutes($new->resolution_minutes);
            }
            if ($new->response_minutes) {
                $t->sla_response_due_at = $t->created_at->copy()->addMinutes($new->response_minutes);
            }
        }
        if (! empty($in['ticket_type_id']) && (int) $in['ticket_type_id'] !== $t->ticket_type_id) {
            $new = TicketType::findOrFail($in['ticket_type_id']);
            $changes[] = ['service type', $t->type?->name, $new->name];
            $t->ticket_type_id = $new->id;
        }
        if (! empty($in['category_id']) && (int) $in['category_id'] !== $t->category_id) {
            $new = TicketCategory::findOrFail($in['category_id']);
            $changes[] = ['category', $t->category->name, $new->name];
            $t->category_id = $new->id;
            $t->subcategory_id = null;
        }
        if (array_key_exists('subcategory_id', $in) && (int) $in['subcategory_id'] !== (int) $t->subcategory_id) {
            $new = $in['subcategory_id'] ? TicketSubcategory::findOrFail($in['subcategory_id']) : null;
            $changes[] = ['sub-category', $t->subcategory?->name, $new?->name];
            $t->subcategory_id = $new?->id;
        }
        if (! empty($in['due_date']) && $in['due_date'] !== optional($t->due_date)->format('Y-m-d')) {
            $changes[] = ['due date', optional($t->due_date)->format('Y-m-d'), $in['due_date']];
            $t->due_date = $in['due_date'];
        }

        if ($changes) {
            $t->updated_by = $user->id;
            $t->save();
            foreach ($changes as [$field, $old, $new]) {
                $this->log($t, $user, $field . '_changed', $field, $old, $new);
            }
            $this->notify([$t->assignee], $t, "{$t->ticket_no} updated: " . collect($changes)->pluck(0)->implode(', ') . ' changed', $user);
        }
        return $t;
    }

    // ------------------------------------------------------------ conversation

    public function addComment(Ticket $t, User $user, string $body, array $files = []): TicketComment
    {
        $comment = TicketComment::create(['ticket_id' => $t->id, 'user_id' => $user->id, 'body' => $body]);
        foreach ($files as $f) {
            $this->attachments->store($t, $user, $f, false, $comment->id);
        }
        $this->log($t, $user, 'comment_added', null, null, null, null);

        $t->loadMissing('status');
        if ($user->id === $t->requester_id) {
            if ($t->status->code === 'WAITING_USER') {
                $this->changeStatus($t, 'IN_PROGRESS', $user, null, true);
            }
            $this->notify([$t->assignee ?? null] ?: [], $t, "New reply from requester on {$t->ticket_no}", $user);
            if (! $t->assigned_to) {
                $this->notify($this->officers(), $t, "New reply from requester on {$t->ticket_no}", $user);
            }
        } else {
            $this->notify([$t->requester], $t, "IT commented on {$t->ticket_no}", $user);
        }
        return $comment;
    }

    public function addNote(Ticket $t, User $user, string $body, array $files = []): TicketInternalNote
    {
        $note = TicketInternalNote::create(['ticket_id' => $t->id, 'user_id' => $user->id, 'body' => $body]);
        foreach ($files as $f) {
            $this->attachments->store($t, $user, $f, true);
        }
        AuditLog::record('internal_note_added', $t);
        return $note;
    }

    // ----------------------------------------------------------------- helpers

    public function log(Ticket $t, ?User $u, string $action, ?string $field = null, $old = null, $new = null, ?string $remark = null): void
    {
        TicketHistory::create([
            'ticket_id' => $t->id,
            'user_id' => $u?->id,
            'action' => $action,
            'field' => $field,
            'old_value' => $old,
            'new_value' => $new,
            'remark' => $remark,
            'created_at' => now(),
        ]);
        AuditLog::record('ticket.' . $action, $t,
            $field ? [$field => $old] : null,
            $field ? [$field => $new] : null);
    }

    public function officers()
    {
        return User::active()->withRole('it_officer')->get();
    }

    public function notify($users, Ticket $t, string $message, ?User $except = null): void
    {
        $users = collect($users)->filter()->unique('id')
            ->reject(fn ($u) => $except && $u->id === $except->id)
            ->filter(fn ($u) => $u->is_active);
        if ($users->isNotEmpty()) {
            Notification::send($users, new TicketNotification($t->id, $t->ticket_no, $message));
        }
    }

    protected function fail(string $field, string $msg): void
    {
        throw ValidationException::withMessages([$field => $msg]);
    }
}
