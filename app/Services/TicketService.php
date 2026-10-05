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
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class TicketService
{
    /** Statuses from which a ticket may be (re)assigned. */
    public const ASSIGNABLE = ['NEW', 'ACKNOWLEDGED', 'ASSIGNED', 'IN_PROGRESS', 'WAITING_USER', 'ON_HOLD', 'REOPENED', 'ESCALATED'];

    public function __construct(protected AttachmentService $attachments) {}

    // ------------------------------------------------------------------ create

    public function create(User $user, array $d, array $files = []): Ticket
    {
        return DB::transaction(function () use ($user, $d, $files) {
            $year = now()->year;
            DB::table('ticket_sequences')->insertOrIgnore(['year' => $year, 'last_number' => 0]);
            $seq = DB::table('ticket_sequences')->where('year', $year)->lockForUpdate()->first();
            $next = $seq->last_number + 1;
            DB::table('ticket_sequences')->where('year', $year)->update(['last_number' => $next]);
            $ticketNo = sprintf('IT-%d-%06d', $year, $next);

            $status = TicketStatus::where('code', 'NEW')->firstOrFail();
            $priority = TicketPriority::findOrFail($d['priority_id']);
            $now = now();

            $ticket = Ticket::create([
                'ticket_no' => $ticketNo,
                'ticket_type_id' => $d['ticket_type_id'],
                'requester_id' => $user->id,
                'department_id' => $user->department_id ?? $d['department_id'],
                'requester_name' => $user->name,
                'requester_employee_id' => $user->employee_id,
                'requester_designation' => $user->designation?->name,
                'requester_phone' => $d['phone'] ?? $user->whatsapp,
                'requester_email' => $user->email,
                'location_id' => $d['location_id'] ?? $user->location_id,
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
                'created_by' => $user->id,
            ]);

            foreach ($files as $file) {
                $this->attachments->store($ticket, $user, $file);
            }

            $this->log($ticket, $user, 'created', null, null, $ticketNo, $ticket->subject);

            $flag = in_array($priority->name, ['Critical', 'High'], true) ? "[{$priority->name}] " : '';
            $this->notify($this->officers(), $ticket, "{$flag}New request {$ticketNo}: {$ticket->subject}", $user);
            $this->notify([$user], $ticket, "Your request {$ticketNo} was submitted.");

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
                    if ($t->sla_resolution_due_at) {
                        $upd['sla_status'] = now()->lte($t->sla_resolution_due_at) ? 'met' : 'breached';
                    }
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

    public function assign(Ticket $t, User $assignee, User $by, ?string $instructions = null, ?string $dueDate = null): Ticket
    {
        $t->loadMissing('status', 'assignee');
        if (! in_array($t->status->code, self::ASSIGNABLE, true)) {
            $this->fail('assignee_id', "A ticket in '{$t->status->name}' cannot be assigned.");
        }
        if (! $assignee->is_active || ! $assignee->hasPermission('ticket.work')) {
            $this->fail('assignee_id', 'That user cannot work on tickets.');
        }

        $previous = $t->assignee;

        DB::transaction(function () use ($t, $assignee, $by, $instructions, $dueDate, $previous) {
            $upd = [
                'assigned_to' => $assignee->id,
                'assigned_at' => now(),
                'updated_by' => $by->id,
                'acknowledged_at' => $t->acknowledged_at ?? now(),
            ];
            if ($dueDate) {
                $upd['due_date'] = $dueDate;
            }

            $oldStatus = $t->status;
            if ($oldStatus->code !== 'ASSIGNED') {
                $assigned = TicketStatus::where('code', 'ASSIGNED')->firstOrFail();
                $upd['status_id'] = $assigned->id;
                $this->log($t, $by, 'status_changed', 'status', $oldStatus->name, $assigned->name, null);
            }
            $t->update($upd);

            TicketAssignment::create([
                'ticket_id' => $t->id,
                'assigned_to' => $assignee->id,
                'assigned_from' => $previous?->id,
                'assigned_by' => $by->id,
                'instructions' => $instructions,
                'created_at' => now(),
            ]);

            $this->log($t, $by, $previous ? 'reassigned' : 'assigned', 'assigned_to',
                $previous?->name, $assignee->name, $instructions);
        });

        $t->refresh()->load('status', 'assignee');
        $verb = $previous ? 'reassigned to you' : 'assigned to you';
        $this->notify([$assignee], $t, "{$t->ticket_no} {$verb}" . ($instructions ? ": {$instructions}" : ''), $by);
        if ($previous) {
            $this->notify([$previous], $t, "{$t->ticket_no} was reassigned to {$assignee->name}", $by);
        }
        $this->notify([$t->requester], $t, "{$t->ticket_no} has been assigned to {$assignee->name}", $by);
        return $t;
    }

    /** IT member with the fewest open tickets. */
    public function autoPickAssignee(): ?User
    {
        $counts = Ticket::open()->whereNotNull('assigned_to')
            ->select('assigned_to', DB::raw('count(*) as c'))->groupBy('assigned_to')->pluck('c', 'assigned_to');

        return User::active()->withRole('it_member')->get()
            ->sortBy(fn ($u) => $counts[$u->id] ?? 0)->first();
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
