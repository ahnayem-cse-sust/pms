<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Location;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function __construct(protected TicketService $svc) {}

    public function index(Request $r)
    {
        $u = auth()->user();
        $q = Ticket::visibleTo($u)->with(['department', 'category', 'subcategory', 'priority', 'status', 'assignee', 'requester']);

        if ($s = trim((string) $r->q)) {
            $q->where(function ($w) use ($s) {
                $w->where('ticket_no', 'like', "%{$s}%")
                    ->orWhere('subject', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%")
                    ->orWhere('requester_name', 'like', "%{$s}%")
                    ->orWhere('requester_employee_id', 'like', "%{$s}%");
            });
        }
        foreach (['department_id', 'category_id', 'status_id', 'priority_id', 'assigned_to', 'ticket_type_id'] as $f) {
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
            'tickets' => $tickets,
            'departments' => Department::orderBy('name')->get(),
            'categories' => TicketCategory::orderBy('name')->get(),
            'statuses' => TicketStatus::orderBy('sort_order')->get(),
            'priorities' => TicketPriority::orderBy('level')->get(),
            'types' => TicketType::all(),
            'members' => $u->hasPermission('ticket.view.all') ? User::active()->withRole('it_member')->orderBy('name')->get() : collect(),
        ]);
    }

    public function create()
    {
        return view('tickets.create', [
            'types' => TicketType::where('is_active', true)->get(),
            'categories' => TicketCategory::with(['subcategories' => fn ($s) => $s->where('is_active', true)])->where('is_active', true)->orderBy('sort_order')->get(),
            'priorities' => TicketPriority::where('is_active', true)->orderBy('level')->get(),
            'locations' => Location::where('is_active', true)->orderBy('name')->get(),
            'departments' => Department::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $r)
    {
        $u = auth()->user();
        $d = $r->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'category_id' => 'required|exists:ticket_categories,id',
            'subcategory_id' => 'nullable|exists:ticket_subcategories,id',
            'priority_id' => 'required|exists:ticket_priorities,id',
            'subject' => 'required|string|max:200',
            'description' => 'required|string|max:10000',
            'preferred_completion_date' => 'nullable|date|after_or_equal:today',
            'phone' => 'nullable|string|max:30',
            'location_id' => 'nullable|exists:locations,id',
            'department_id' => $u->department_id ? 'nullable' : 'required|exists:departments,id',
            'attachments.*' => 'file',
        ]);

        $ticket = $this->svc->create($u, $d, $r->file('attachments', []));
        return redirect()->route('tickets.show', $ticket)->with('ok', "Request {$ticket->ticket_no} submitted.");
    }

    public function show(Ticket $ticket)
    {
        $u = auth()->user();
        abort_unless(Ticket::visibleTo($u)->whereKey($ticket->id)->exists(), 403);

        $ticket->load(['department', 'location', 'category', 'subcategory', 'priority', 'status', 'assignee', 'requester', 'type',
            'comments', 'history', 'assignments', 'attachments']);

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
            'members' => User::active()->withRole('it_member')->orderBy('name')->get(),
            'priorities' => TicketPriority::orderBy('level')->get(),
            'categories' => TicketCategory::with('subcategories')->orderBy('name')->get(),
            'seeInternal' => $seeInternal,
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

    public function update(Request $r, Ticket $ticket)
    {
        $this->authorize('ticket.edit');
        $this->authorizeView($ticket);
        $d = $r->validate([
            'priority_id' => 'nullable|exists:ticket_priorities,id',
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
        $r->validate(['body' => 'required|string|max:5000', 'attachments.*' => 'file']);
        $this->svc->addComment($ticket, auth()->user(), $r->body, $r->file('attachments', []));
        return back()->with('ok', 'Comment added.');
    }

    public function note(Request $r, Ticket $ticket)
    {
        $this->authorize('ticket.note.internal');
        $this->authorizeView($ticket);
        $r->validate(['body' => 'required|string|max:5000', 'attachments.*' => 'file']);
        $this->svc->addNote($ticket, auth()->user(), $r->body, $r->file('attachments', []));
        return back()->with('ok', 'Internal note added.');
    }

    public function upload(Request $r, Ticket $ticket)
    {
        $this->authorize('attachment.upload');
        $this->authorizeView($ticket);
        $r->validate(['attachments' => 'required', 'attachments.*' => 'file']);
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

    protected function authorizeView(Ticket $ticket): void
    {
        abort_unless(Ticket::visibleTo(auth()->user())->whereKey($ticket->id)->exists(), 403);
    }
}
