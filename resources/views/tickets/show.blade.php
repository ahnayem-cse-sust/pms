@extends('layouts.app')
@section('title', $ticket->ticket_no)
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
    <div>
        <h4 class="mb-1">{{ $ticket->ticket_no }} — {{ $ticket->subject }}</h4>
        <span class="pill pill-{{ $ticket->status->color ?? 'secondary' }}">{{ $ticket->status->name }}</span>
        <span class="pill pill-{{ $ticket->priority->color ?? 'secondary' }}">{{ $ticket->priority->name }}</span>
        <span class="pill pill-light">{{ $ticket->type->name }}</span>
        @if($ticket->status->is_open && $ticket->sla_status === 'breached')<span class="pill pill-danger">SLA breached</span>
        @elseif($ticket->status->is_open && $ticket->sla_status === 'warning')<span class="pill pill-warning">SLA approaching</span>@endif
        @if($ticket->reopen_count)<span class="pill pill-danger">Reopened ×{{ $ticket->reopen_count }}</span>@endif
    </div>
    <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-secondary">← All requests</a>
</div>

<div class="row g-4">
<div class="col-lg-8">
    <div class="card mb-3"><div class="card-body">
        <div class="row small mb-3">
            <div class="col-md-4"><b>Requester:</b> {{ $ticket->requester_name }} @if($ticket->requester_employee_id)({{ $ticket->requester_employee_id }})@endif</div>
            <div class="col-md-4"><b>Department:</b> {{ $ticket->department->name }}</div>
            <div class="col-md-4"><b>Designation:</b> {{ $ticket->requester_designation ?? '—' }}</div>
            <div class="col-md-4"><b>Contact / WhatsApp:</b> {{ $ticket->requester_phone ?? '—' }}</div>
            <div class="col-md-4"><b>Email:</b> {{ $ticket->requester_email ?? '—' }}</div>
            <div class="col-md-4"><b>Location:</b> {{ $ticket->location->name ?? '—' }}</div>
            <div class="col-md-4"><b>Category:</b> {{ $ticket->category->name }}@if($ticket->subcategory) / {{ $ticket->subcategory->name }}@endif</div>
            <div class="col-md-4"><b>Created:</b> {{ $ticket->created_at->format('d M Y H:i') }}</div>
            <div class="col-md-4"><b>Preferred date:</b> {{ $ticket->preferred_completion_date?->format('d M Y') ?? '—' }}</div>
            <div class="col-md-4"><b>Assigned to:</b> {{ $ticket->assignee->name ?? 'Unassigned' }}</div>
            <div class="col-md-4"><b>Due:</b> {{ $ticket->due_date?->format('d M Y') ?? '—' }}</div>
            <div class="col-md-4"><b>SLA resolution due:</b> {{ $ticket->sla_resolution_due_at?->format('d M H:i') ?? '—' }}</div>
        </div>
        <h6>Description</h6>
        <div class="ticket-body">{{ $ticket->description }}</div>
        @if($ticket->resolution)
            <hr><h6 class="text-success">Resolution</h6><div class="ticket-body">{{ $ticket->resolution }}</div>
        @endif
    </div></div>

    <div class="card mb-3">
        <div class="card-header">Attachments</div>
        <ul class="list-group list-group-flush">
            @forelse($attachments as $a)
                <li class="list-group-item d-flex justify-content-between">
                    <span>
                        <a href="{{ route('attachments.download', $a) }}">{{ $a->original_name }}</a>
                        <span class="text-muted small">({{ number_format($a->size_bytes / 1024, 0) }} KB, {{ $a->uploader->name }}, {{ $a->created_at->format('d M H:i') }})</span>
                        @if($a->is_internal)<span class="badge text-bg-warning">internal</span>@endif
                    </span>
                </li>
            @empty
                <li class="list-group-item text-muted">No attachments.</li>
            @endforelse
        </ul>
        @can('attachment.upload')
        <div class="card-body border-top">
            <form method="POST" action="{{ route('tickets.upload', $ticket) }}" enctype="multipart/form-data" class="row g-2">@csrf
                <div class="col"><input type="file" name="attachments[]" class="form-control form-control-sm" multiple required></div>
                @if($seeInternal)<div class="col-auto form-check pt-1"><input type="checkbox" name="internal" value="1" class="form-check-input" id="int"><label class="form-check-label small" for="int">IT-only</label></div>@endif
                <div class="col-auto"><button class="btn btn-sm btn-secondary">Upload</button></div>
            </form>
        </div>
        @endcan
    </div>

    <div class="card mb-3">
        <div class="card-header">Conversation</div>
        <div class="card-body">
            @forelse($ticket->comments as $c)
                <div class="comment"><x-avatar :name="$c->user->name"/><div class="comment-bubble"><div class="comment-meta"><b>{{ $c->user->name }}</b>{{ $c->created_at->format('d M Y h:i A') }}</div><div class="ticket-body">{{ $c->body }}</div></div></div>
            @empty
                <p class="text-muted">No comments yet.</p>
            @endforelse
            @can('ticket.comment.public')
            <form method="POST" action="{{ route('tickets.comment', $ticket) }}" enctype="multipart/form-data">@csrf
                <textarea name="body" rows="3" class="form-control mb-2" placeholder="Write a comment visible to the requester and IT…" required></textarea>
                <div class="d-flex gap-2"><input type="file" name="attachments[]" class="form-control form-control-sm" multiple><button class="btn btn-primary btn-sm">Add comment</button></div>
            </form>
            @endcan
        </div>
    </div>

    @if($seeInternal)
    <div class="card mb-3 border-warning">
        <div class="card-header bg-warning-subtle">Internal IT notes <span class="small text-muted">(not visible to the requesting department)</span></div>
        <div class="card-body">
            @forelse($notes as $n)
                <div class="comment"><x-avatar :name="$n->user->name"/><div class="comment-bubble"><div class="comment-meta"><b>{{ $n->user->name }}</b>{{ $n->created_at->format('d M Y h:i A') }}</div><div class="ticket-body">{{ $n->body }}</div></div></div>
            @empty
                <p class="text-muted">No internal notes.</p>
            @endforelse
            <form method="POST" action="{{ route('tickets.note', $ticket) }}">@csrf
                <textarea name="body" rows="2" class="form-control mb-2" placeholder="e.g. Root cause appears to be incorrect ERP database configuration." required></textarea>
                <button class="btn btn-warning btn-sm">Add internal note</button>
            </form>
        </div>
    </div>
    @endif
</div>

<div class="col-lg-4">
    @if($transitions->isNotEmpty())
    <div class="card mb-3">
        <div class="card-header">Actions</div>
        <div class="card-body">
            <form method="POST" action="{{ route('tickets.transition', $ticket) }}">@csrf
                <textarea name="comment" rows="3" class="form-control mb-2" placeholder="Comment / resolution details (required for some actions)"></textarea>
                <div class="d-grid gap-2">
                    @foreach($transitions as $tr)
                        <button name="to" value="{{ $tr->code }}" class="btn btn-sm {{ in_array($tr->code, ['CLOSED','RESOLVED']) ? 'btn-success' : (in_array($tr->code, ['REOPENED','ESCALATED','CANCELLED']) ? 'btn-outline-danger' : 'btn-outline-primary') }}">
                            @switch($tr->code)
                                @case('REOPENED') Problem still exists – Reopen @break
                                @case('CLOSED') Confirm &amp; Close @break
                                @default {{ $tr->name }}
                            @endswitch
                            @if($tr->requires_comment)*@endif
                        </button>
                    @endforeach
                </div>
                <div class="small text-muted mt-1">* comment required</div>
            </form>
        </div>
    </div>
    @endif

    @if($canAssign)
    <div class="card mb-3">
        <div class="card-header">{{ $ticket->assigned_to ? 'Reassign' : 'Assign' }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('tickets.assign', $ticket) }}">@csrf
                <select name="assignee_id" class="form-select form-select-sm mb-2">
                    <option value="">Select IT team member…</option>
                    @foreach($members as $m)<option value="{{ $m->id }}" @selected($ticket->assigned_to == $m->id)>{{ $m->name }}</option>@endforeach
                </select>
                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="auto" value="1" id="auto"><label class="form-check-label small" for="auto">Auto-assign to member with fewest open tickets</label></div>
                <input type="date" name="due_date" value="{{ $ticket->due_date?->format('Y-m-d') }}" class="form-control form-control-sm mb-2" title="Due date">
                <textarea name="instructions" rows="2" class="form-control form-control-sm mb-2" placeholder="Instructions for the assignee"></textarea>
                <button class="btn btn-primary btn-sm w-100">{{ $ticket->assigned_to ? 'Reassign' : 'Assign' }}</button>
            </form>
        </div>
    </div>
    @endif

    @if($canEdit)
    <div class="card mb-3">
        <div class="card-header">Priority / category</div>
        <div class="card-body">
            <form method="POST" action="{{ route('tickets.update', $ticket) }}">@csrf @method('PUT')
                <label class="small">Priority</label>
                <select name="priority_id" class="form-select form-select-sm mb-2">
                    @foreach($priorities as $p)<option value="{{ $p->id }}" @selected($ticket->priority_id == $p->id)>{{ $p->name }}</option>@endforeach
                </select>
                <label class="small">Category</label>
                <select name="category_id" class="form-select form-select-sm mb-2">
                    @foreach($categories as $c)<option value="{{ $c->id }}" @selected($ticket->category_id == $c->id)>{{ $c->name }}</option>@endforeach
                </select>
                <button class="btn btn-outline-secondary btn-sm w-100">Update</button>
            </form>
        </div>
    </div>
    @endif

    <div class="card mb-3">
        <div class="card-header">History</div>
        <div class="card-body">
            <ul class="list-unstyled timeline mb-0">
                @foreach($ticket->history as $h)
                    <li>
                        <span class="text-muted">{{ $h->created_at->format('d M H:i') }}</span>
                        <b>{{ $h->user->name ?? 'System' }}</b>
                        @switch($h->action)
                            @case('created') created the request @break
                            @case('status_changed') changed status: {{ $h->old_value }} → <b>{{ $h->new_value }}</b> @break
                            @case('assigned') assigned to <b>{{ $h->new_value }}</b> @break
                            @case('reassigned') reassigned {{ $h->old_value }} → <b>{{ $h->new_value }}</b> @break
                            @case('comment_added') added a comment @break
                            @case('attachment_added') uploaded attachment(s) @break
                            @case('auto_closed') (auto-closed) @break
                            @default changed {{ $h->field }}: {{ $h->old_value ?? '—' }} → <b>{{ $h->new_value ?? '—' }}</b>
                        @endswitch
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</div>
@endsection
