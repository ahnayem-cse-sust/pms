<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Location;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function __construct(protected TicketService $svc) {}

    /** All requests the user is allowed to see. */
    public function index(Request $r)
    {
        return $this->listing($r, Ticket::visibleTo(auth()->user()), 'all');
    }

    /** My Requests (IT staff): only requests where the user is the requester, whether they filed it or someone filed it for them. */
    public function mine(Request $r)
    {
        return $this->listing($r, Ticket::where('requester_id', auth()->id()), 'mine');
    }

    /** My Tasks (IT staff): every request the user is on the team of, as the primary responsible employee or in support. */
    public function tasks(Request $r)
    {
        return $this->listing($r, Ticket::involving(auth()->user()), 'tasks');
    }

    protected function listing(Request $r, $base, string $mode)
    {
        $u = auth()->user();
        $q = $base->with(['department', 'category', 'subcategory', 'priority', 'status', 'assignee', 'requester', 'team']);

        if ($s = trim((string) $r->q)) {
            $q->where(function ($w) use ($s) {
                $w->where('ticket_no', 'like', "%{$s}%")
                    ->orWhere('subject', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%")
                    ->orWhere('requester_name', 'like', "%{$s}%")
                    ->orWhere('requester_employee_id', 'like', "%{$s}%");
            });
        }
        foreach (['department_id', 'category_id', 'status_id', 'assigned_to', 'ticket_type_id'] as $f) {
            if ($r->filled($f)) {
                $q->where($f, $r->input($f));
            }
        }
        if ($r->filled('unassigned')) {
            $q->whereNull('assigned_to');
        }
        if ($r->filled('from')) {
            $q->whereDate('created_at', '>=', $r->from);
        }
        if ($r->filled('to')) {
            $q->whereDate('created_at', '<=', $r->to);
        }

        $tickets = $q->latest()->paginate(20)->withQueryString();

        return view('tickets.index', [
            'mode' => $mode,
            'tickets' => $tickets,
            'departments' => Department::orderBy('name')->get(),
            'categories' => TicketCategory::orderBy('name')->get(),
            'statuses' => TicketStatus::orderBy('sort_order')->get(),
            'types' => TicketType::all(),
            'members' => ($mode === 'all' && $u->hasPermission('ticket.view.all')) ? User::active()->assignable()->orderBy('name')->get() : collect(),
        ]);
    }

    public function create()
    {
        return view('tickets.create', [
            'types' => TicketType::where('is_active', true)->get(),
            'categories' => TicketCategory::with(['subcategories' => fn ($s) => $s->where('is_active', true)])->where('is_active', true)->orderBy('sort_order')->get(),
            'locations' => Location::where('is_active', true)->orderBy('name')->get(),
            'departments' => Department::where('is_active', true)->orderBy('name')->get(),
            'requesters' => $this->eligibleRequesters(auth()->user()),
        ]);
    }

    /** People the current user may file a request for (empty = may only file for themselves). */
    protected function eligibleRequesters(User $actor)
    {
        $q = User::active()->with(['department', 'designation'])->where('id', '!=', $actor->id)->orderBy('name');

        if ($actor->hasPermission('ticket.create.behalf')) {
            // IT staff and administrators: anyone (System Administrator accounts stay hidden from non-admins)
            if (! $actor->isRole('admin')) {
                $q->whereDoesntHave('roles', fn ($x) => $x->where('slug', 'admin'));
            }
            return $q->get();
        }
        if ($actor->hasPermission('ticket.create.behalf.dept') && $actor->department_id) {
            // Department heads: their own department only
            return $q->where('department_id', $actor->department_id)
                ->whereDoesntHave('roles', fn ($x) => $x->where('slug', 'admin'))->get();
        }
        return collect();
    }

    public function store(Request $r)
    {
        $actor = auth()->user();
        $requester = $actor;

        if ($r->filled('requester_id') && (int) $r->requester_id !== $actor->id) {
            $requester = $this->eligibleRequesters($actor)->firstWhere('id', (int) $r->requester_id);
            abort_if(! $requester, 403, 'You are not allowed to submit a request for that person.');
        }

        $d = $r->validate([
            'requester_id' => 'nullable|integer|exists:users,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'category_id' => 'required|exists:ticket_categories,id',
            'subcategory_id' => 'nullable|exists:ticket_subcategories,id',
            'subject' => 'required|string|max:200',
            'description' => 'required|string|max:10000',
            'preferred_completion_date' => 'nullable|date|after_or_equal:today',
            'phone' => 'nullable|string|max:30',
            'location_id' => 'nullable|exists:locations,id',
            'department_id' => $requester->department_id ? 'nullable' : 'required|exists:departments,id',
            'attachments.*' => $this->fileRule(),
        ], $this->fileMessages());

        $ticket = $this->svc->create($requester, $d, $r->file('attachments', []), $actor);
        $msg = $requester->id === $actor->id
            ? "Request {$ticket->ticket_no} submitted."
            : "Request {$ticket->ticket_no} submitted for {$requester->name}.";
        return redirect()->route('tickets.show', $ticket)->with('ok', $msg);
    }

    public function show(Ticket $ticket)
    {
        $u = auth()->user();
        abort_unless(Ticket::visibleTo($u)->whereKey($ticket->id)->exists(), 403);

        $ticket->load(['department', 'location', 'category', 'subcategory', 'priority', 'status', 'assignee', 'requester', 'type',
            'comments', 'history', 'team', 'attachments', 'creator']);

        $seeInternal = $u->hasPermission('ticket.note.internal');
        $notes = $seeInternal ? $ticket->notes : collect();
        $attachments = $ticket->attachments->filter(fn ($a) => ! $a->is_internal || $u->hasPermission('attachment.download.internal'));

        return view('tickets.show', [
            'ticket' => $ticket,
            'notes' => $notes,
            'attachments' => $attachments,
            'transitions' => $this->svc->allowedTransitions($ticket, $u),
            'canAssign' => $u->can('ticket.assign') && in_array($ticket->status->code, TicketService::ASSIGNABLE, true),
            'canEdit' => $u->can('ticket.edit') && $ticket->status->is_open,
            'members' => User::active()->assignable()->orderBy('name')->get(),
            'categories' => TicketCategory::with('subcategories')->orderBy('name')->get(),
            'seeInternal' => $seeInternal,
            'team' => $ticket->team,
            'myRow' => $ticket->team->firstWhere('employee_id', $u->id),
            'workStatuses' => TicketService::WORK_STATUSES,
            'workUpdates' => $seeInternal ? $ticket->workUpdates()->limit(30)->get() : collect(),
        ]);
    }

    public function transition(Request $r, Ticket $ticket)
    {
        $this->authorizeView($ticket);
        $d = $r->validate(['to' => 'required|string|exists:ticket_statuses,code', 'comment' => 'nullable|string|max:5000']);
        $this->svc->changeStatus($ticket, $d['to'], auth()->user(), $d['comment'] ?? null);
        return back()->with('ok', 'Status updated.');
    }

    public function assign(Request $r, Ticket $ticket)
    {
        $this->authorize('ticket.assign');
        $this->authorizeView($ticket);
        $d = $r->validate([
            'assignee_id' => 'nullable|exists:users,id',
            'auto' => 'nullable|boolean',
            'instructions' => 'nullable|string|max:2000',
            'due_date' => 'nullable|date',
        ]);

        $assignee = $r->boolean('auto') ? $this->svc->autoPickAssignee() : User::find($d['assignee_id'] ?? null);
        if (! $assignee) {
            $msg = 'Choose an IT team member (or tick auto-assign).';
            return $r->expectsJson()
                ? response()->json(['message' => $msg], 422)
                : back()->withErrors(['assignee_id' => $msg]);
        }
        $this->svc->assign($ticket, $assignee, auth()->user(), $d['instructions'] ?? null, $d['due_date'] ?? null);
        if ($r->expectsJson()) {
            return response()->json(['ok' => true, 'assignee_id' => $assignee->id, 'assignee_name' => $assignee->name]);
        }
        return back()->with('ok', "Assigned to {$assignee->name}.");
    }

    /** IT Admin: set the whole team – one primary responsible employee plus supporting employees. */
    public function team(Request $r, Ticket $ticket)
    {
        $this->authorize('ticket.assign');
        $this->authorizeView($ticket);
        $d = $r->validate([
            'primary_id' => 'nullable|integer|exists:users,id',
            'auto' => 'nullable|boolean',
            'support_ids' => 'nullable|array',
            'support_ids.*' => 'integer|exists:users,id',
            'instructions' => 'nullable|string|max:2000',
            'due_date' => 'nullable|date',
        ]);

        $support = $d['support_ids'] ?? [];
        $primary = $r->boolean('auto')
            ? $this->svc->autoPickAssignee(array_map('intval', $support))
            : User::find($d['primary_id'] ?? null);
        if (! $primary) {
            return back()->withErrors(['primary_id' => 'Choose the primary responsible employee (or tick auto-assign).'])->withInput();
        }

        $this->svc->setTeam($ticket, $primary, $support, auth()->user(), $d['instructions'] ?? null, $d['due_date'] ?? null);
        return back()->with('ok', "Team saved – {$primary->name} is the primary responsible employee.");
    }

    /** Any team member: record your own progress and notes. */
    public function work(Request $r, Ticket $ticket)
    {
        $this->authorize('ticket.work');
        $this->authorizeView($ticket);
        $d = $r->validate([
            'work_status' => 'required|in:' . implode(',', array_keys(TicketService::WORK_STATUSES)),
            'note' => 'nullable|string|max:3000',
        ]);
        $this->svc->updateWork($ticket, auth()->user(), $d['work_status'], $d['note'] ?? null);
        return back()->with('ok', 'Your work update was saved.');
    }

    public function update(Request $r, Ticket $ticket)
    {
        $this->authorize('ticket.edit');
        $this->authorizeView($ticket);
        $d = $r->validate([
            'category_id' => 'nullable|exists:ticket_categories,id',
            'subcategory_id' => 'nullable|exists:ticket_subcategories,id',
            'due_date' => 'nullable|date',
        ]);
        $this->svc->updateFields($ticket, auth()->user(), $d);
        return back()->with('ok', 'Ticket updated.');
    }

    public function comment(Request $r, Ticket $ticket)
    {
        $this->authorize('ticket.comment.public');
        $this->authorizeView($ticket);
        $r->validate(['body' => 'required|string|max:5000', 'attachments.*' => $this->fileRule()], $this->fileMessages());
        $this->svc->addComment($ticket, auth()->user(), $r->body, $r->file('attachments', []));
        return back()->with('ok', 'Comment added.');
    }

    public function note(Request $r, Ticket $ticket)
    {
        $this->authorize('ticket.note.internal');
        $this->authorizeView($ticket);
        $r->validate(['body' => 'required|string|max:5000', 'attachments.*' => $this->fileRule()], $this->fileMessages());
        $this->svc->addNote($ticket, auth()->user(), $r->body, $r->file('attachments', []));
        return back()->with('ok', 'Internal note added.');
    }

    public function upload(Request $r, Ticket $ticket)
    {
        $this->authorize('attachment.upload');
        $this->authorizeView($ticket);
        $r->validate(['attachments' => 'required', 'attachments.*' => $this->fileRule()], $this->fileMessages());
        $internal = $r->boolean('internal') && auth()->user()->hasPermission('ticket.note.internal');
        foreach ($r->file('attachments') as $f) {
            app(\App\Services\AttachmentService::class)->store($ticket, auth()->user(), $f, $internal);
        }
        $this->svc->log($ticket, auth()->user(), 'attachment_added');
        return back()->with('ok', 'File(s) uploaded.');
    }

    public function download(TicketAttachment $attachment)
    {
        $u = auth()->user();
        $ticket = $attachment->ticket;
        abort_unless(Ticket::visibleTo($u)->whereKey($ticket->id)->exists(), 403);
        abort_if($attachment->is_internal && ! $u->hasPermission('attachment.download.internal'), 403);
        abort_unless(Storage::disk('local')->exists($attachment->stored_path), 404);
        \App\Models\AuditLog::record('attachment.download', $attachment);
        return Storage::disk('local')->download($attachment->stored_path, $attachment->original_name);
    }

    protected function fileRule(): array
    {
        return ['file', 'max:' . \App\Services\AttachmentService::maxKb()];
    }

    protected function fileMessages(): array
    {
        $mb = rtrim(rtrim(number_format(\App\Services\AttachmentService::maxKb() / 1024, 1), '0'), '.');
        return [
            'attachments.*.max' => "Each attachment must be {$mb} MB or smaller.",
            'attachments.*.file' => 'One of the attachments could not be uploaded (it may be larger than the server allows).',
            'attachments.*.uploaded' => 'One of the attachments could not be uploaded (it may be larger than the server allows).',
        ];
    }

    protected function authorizeView(Ticket $ticket): void
    {
        abort_unless(Ticket::visibleTo(auth()->user())->whereKey($ticket->id)->exists(), 403);
    }
}
