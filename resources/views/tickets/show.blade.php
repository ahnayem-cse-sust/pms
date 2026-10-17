@extends('layouts.app')
@section('title', str_replace('-', '', $ticket->ticket_no))
@section('content')
@php
    $steps = ['New', 'Assigned', 'In progress', 'Resolved', 'Closed'];
    $stepOf = ['NEW' => 0, 'ACKNOWLEDGED' => 0, 'ASSIGNED' => 1, 'REOPENED' => 1, 'IN_PROGRESS' => 2, 'WAITING_USER' => 2,
               'ON_HOLD' => 2, 'ESCALATED' => 2, 'RESOLVED' => 3, 'USER_CONFIRMATION' => 3, 'CLOSED' => 4];
    $cur = $stepOf[$ticket->status->code] ?? null;
    $open = $ticket->status->is_open;
    $reqNo = str_replace('-', '', $ticket->ticket_no);
@endphp

<div class="row g-4 align-items-start">
    {{-- ───────── Left: description + tabs ───────── --}}
    <div class="col-lg-8">
        {{-- ───────── Top panel: id + subject, summary table, description, progress ───────── --}}
        <div class="card mb-4 req-head">
            <div class="card-header d-flex align-items-center gap-2">
                <a class="fold-toggle flex-grow-1 min-w-0" data-bs-toggle="collapse" href="#fold-top" role="button" aria-expanded="true">
                    <span class="d-flex align-items-center gap-2 min-w-0"><span class="ticket-id">{{ $reqNo }}</span><span class="req-subject">{{ $ticket->subject }}</span></span>
                </a>
                <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-secondary flex-none">← Back</a>
            </div>
            <div class="collapse show" id="fold-top">
                <table class="table table-sm info-table mb-0">
                    <tbody>
                        <tr><th>Status</th><td>
                            <span class="pill pill-{{ $ticket->status->color ?? 'secondary' }}">{{ $ticket->status->name }}</span>
                            @if($open && $ticket->sla_status === 'breached')<span class="pill pill-danger ms-1">SLA breached</span>
                            @elseif($open && $ticket->sla_status === 'warning')<span class="pill pill-warning ms-1">SLA approaching</span>@endif
                            @if($ticket->reopen_count)<span class="pill pill-danger ms-1">Reopened ×{{ $ticket->reopen_count }}</span>@endif
                        </td></tr>
                        <tr><th>Category</th><td>{{ $ticket->category->name }}@if($ticket->subcategory) / {{ $ticket->subcategory->name }}@endif</td></tr>
                        <tr><th>Submitted at</th><td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td></tr>
                        <tr><th>Description</th><td><div class="ticket-body">{{ $ticket->description }}</div></td></tr>
                        @if($ticket->resolution)
                            <tr><th>Resolution</th><td><div class="ticket-body">{{ $ticket->resolution }}</div></td></tr>
                        @endif
                    </tbody>
                </table>
                @if($cur !== null)
                    <div class="card-body border-top">
                        <div class="stepper">
                            @foreach($steps as $i => $label)
                                <div class="step {{ $i < $cur ? 'done' : ($i === $cur ? 'current' : '') }}">
                                    <div class="dot">@if($i < $cur)<x-icon name="check" :size="14"/>@else{{ $i + 1 }}@endif</div>
                                    {{ $label }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="card-body border-top text-muted small">Cancelled</div>
                @endif
            </div>
        </div>

        <div class="card tab-card">
            <div class="card-header">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-conv" type="button" role="tab"><x-icon name="message" :size="16"/> Conversation <span class="count">{{ $ticket->comments->count() }}</span></button></li>
                    @if($seeInternal)
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-notes" type="button" role="tab"><x-icon name="lock" :size="16"/> Internal notes <span class="count">{{ $notes->count() }}</span></button></li>
                    @endif
                    @if($seeInternal && $workUpdates->isNotEmpty())
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-work" type="button" role="tab"><x-icon name="check" :size="16"/> Team progress <span class="count">{{ $workUpdates->count() }}</span></button></li>
                    @endif
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-files" type="button" role="tab"><x-icon name="paperclip" :size="16"/> Attachments <span class="count">{{ $attachments->count() }}</span></button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-history" type="button" role="tab"><x-icon name="clock" :size="16"/> History</button></li>
                </ul>
            </div>
            <div class="card-body tab-content">

                {{-- Conversation (visible to the requester) --}}
                <div class="tab-pane fade show active" id="tab-conv" role="tabpanel">
                    @forelse($ticket->comments as $c)
                        <div class="comment">
                            <x-avatar :name="$c->user->name"/>
                            <div class="comment-bubble">
                                <div class="comment-meta"><b>{{ $c->user->name }}</b>{{ $c->created_at->format('d M Y h:i A') }}</div>
                                <div class="ticket-body">{{ $c->body }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No comments yet.</p>
                    @endforelse
                    @can('ticket.comment.public')
                        <form method="POST" action="{{ route('tickets.comment', $ticket) }}" enctype="multipart/form-data" class="mt-3">@csrf
                            <textarea name="body" rows="3" class="form-control mb-2" placeholder="Write a comment…" required></textarea>
                            <div class="d-flex gap-2"><input type="file" name="attachments[]" class="form-control form-control-sm" multiple><button class="btn btn-primary btn-sm text-nowrap">Add comment</button></div>
                        </form>
                    @endcan
                </div>

                {{-- Internal notes (IT staff only – never sent to the requester) --}}
                @if($seeInternal)
                    <div class="tab-pane fade" id="tab-notes" role="tabpanel">
                        @forelse($notes as $n)
                            <div class="comment">
                                <x-avatar :name="$n->user->name"/>
                                <div class="comment-bubble">
                                    <div class="comment-meta"><b>{{ $n->user->name }}</b>{{ $n->created_at->format('d M Y h:i A') }}</div>
                                    <div class="ticket-body">{{ $n->body }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No internal notes.</p>
                        @endforelse
                        <form method="POST" action="{{ route('tickets.note', $ticket) }}" class="mt-3">@csrf
                            <textarea name="body" rows="2" class="form-control mb-2" placeholder="Add an internal note…" required></textarea>
                            <button class="btn btn-warning btn-sm">Add internal note</button>
                        </form>
                    </div>
                @endif

                {{-- Team progress (IT staff only) --}}
                @if($seeInternal && $workUpdates->isNotEmpty())
                    @php($wTone = ['ASSIGNED' => 'secondary', 'IN_PROGRESS' => 'warning', 'WAITING' => 'info', 'DONE' => 'success'])
                    <div class="tab-pane fade" id="tab-work" role="tabpanel">
                        @foreach($workUpdates as $w)
                            <div class="comment">
                                <x-avatar :name="$w->user->name"/>
                                <div class="comment-bubble">
                                    <div class="comment-meta"><b>{{ $w->user->name }}</b>{{ $w->created_at->format('d M Y h:i A') }}
                                        <span class="pill pill-{{ $wTone[$w->work_status] ?? 'secondary' }} ms-1">{{ $workStatuses[$w->work_status] ?? $w->work_status }}</span></div>
                                    @if($w->note)<div class="ticket-body">{{ $w->note }}</div>@endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Attachments --}}
                <div class="tab-pane fade" id="tab-files" role="tabpanel">
                    <ul class="list-group list-group-flush mb-3">
                        @forelse($attachments as $a)
                            <li class="list-group-item px-0">
                                <a href="{{ route('attachments.download', $a) }}" class="fw-semibold text-decoration-none">{{ $a->original_name }}</a>
                                @if($a->is_internal)<span class="pill pill-warning ms-1">IT only</span>@endif
                                <div class="ticket-sub">{{ number_format($a->size_bytes / 1024, 0) }} KB · {{ $a->uploader->name }} · {{ $a->created_at->format('d M H:i') }}</div>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">No attachments.</li>
                        @endforelse
                    </ul>
                    @can('attachment.upload')
                        <form method="POST" action="{{ route('tickets.upload', $ticket) }}" enctype="multipart/form-data" class="row g-2 align-items-center">@csrf
                            <div class="col"><input type="file" name="attachments[]" class="form-control form-control-sm" multiple required></div>
                            @if($seeInternal)<div class="col-auto form-check"><input type="checkbox" name="internal" value="1" class="form-check-input" id="int"><label class="form-check-label small" for="int">IT only</label></div>@endif
                            <div class="col-auto"><button class="btn btn-secondary btn-sm">Upload</button></div>
                        </form>
                    @endcan
                </div>

                {{-- History --}}
                <div class="tab-pane fade" id="tab-history" role="tabpanel">
                    <ul class="list-unstyled timeline mb-0">
                        @foreach($ticket->history as $h)
                            <li>
                                <span class="text-muted">{{ $h->created_at->format('d M H:i') }}</span>
                                <b>{{ $h->user->name ?? 'System' }}</b>
                                @switch($h->action)
                                    @case('created') created the request @break
                                    @case('created_on_behalf') created the request on behalf of <b>{{ $h->new_value }}</b> @break
                                    @case('status_changed') changed status: {{ $h->old_value }} → <b>{{ $h->new_value }}</b> @break
                                    @case('assigned') made <b>{{ $h->new_value }}</b> the primary responsible employee @break
                                    @case('reassigned') changed the primary responsible employee: {{ $h->old_value }} → <b>{{ $h->new_value }}</b> @break
                                    @case('team_added') added <b>{{ $h->new_value }}</b> to the team @break
                                    @case('team_removed') removed <b>{{ $h->old_value }}</b> from the team @break
                                    @case('team_role_changed') changed the role: {{ $h->old_value }} → <b>{{ $h->new_value }}</b> @break
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

    {{-- ───────── Right: actions, details, team ───────── --}}
    <div class="col-lg-4">
        <div class="sticky-side">
            @php($actionList = $transitions->where('code', '!=', 'ESCALATED'))
            @if($actionList->isNotEmpty())
                <div class="card mb-3">
                    <a class="card-header fold-toggle" data-bs-toggle="collapse" href="#fold-actions" role="button" aria-expanded="true">Actions</a>
                    <div class="collapse show" id="fold-actions">
                    <div class="card-body">
                        <form method="POST" action="{{ route('tickets.transition', $ticket) }}">@csrf
                            <textarea name="comment" rows="3" class="form-control mb-2" placeholder="Comment (* required for some actions)"></textarea>
                            <div class="d-grid gap-2">
                                @foreach($actionList as $tr)
                                    <button name="to" value="{{ $tr->code }}" class="btn btn-sm {{ in_array($tr->code, ['CLOSED', 'RESOLVED']) ? 'btn-success' : (in_array($tr->code, ['REOPENED', 'CANCELLED']) ? 'btn-outline-danger' : 'btn-outline-primary') }}">
                                        @switch($tr->code)
                                            @case('REOPENED') Problem still exists – Reopen @break
                                            @case('CLOSED') Confirm &amp; Close @break
                                            @default {{ $tr->name }}
                                        @endswitch
                                        @if($tr->requires_comment)*@endif
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            @endif

            <div class="card mb-3">
                <a class="card-header fold-toggle collapsed" data-bs-toggle="collapse" href="#fold-info" role="button" aria-expanded="false">Requester</a>
                <div class="collapse" id="fold-info">
                    <table class="table table-sm info-table mb-0">
                        <tbody>
                            <tr><th>Requester</th><td>{{ $ticket->requester_name }}</td></tr>
                            @if($ticket->created_by !== $ticket->requester_id)
                                <tr><th>Filed by</th><td>{{ $ticket->creator->name ?? 'IT' }}</td></tr>
                            @endif
                            <tr><th>Designation</th><td>{{ $ticket->requester_designation ?? '—' }}</td></tr>
                            <tr><th>Employee ID</th><td>{{ $ticket->requester_employee_id ?? '—' }}</td></tr>
                            <tr><th>WhatsApp</th><td>{{ $ticket->requester_phone ?? '—' }}</td></tr>
                            <tr><th>Department</th><td>{{ $ticket->department->name }}</td></tr>
                            <tr><th>Due date</th><td>{{ $ticket->due_date?->format('d M Y') ?? '—' }}</td></tr>
                            <tr><th>Resolve by</th><td>{{ $ticket->sla_resolution_due_at?->format('d M, h:i A') ?? '—' }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-3">
                <a class="card-header fold-toggle collapsed" data-bs-toggle="collapse" href="#fold-team" role="button" aria-expanded="false">Assigned IT Team</a>
                <div class="collapse" id="fold-team">
                    <div class="card-body">
                        @include('tickets._team_summary')
                    </div>
                </div>
            </div>

            @include('tickets._team')

            @if($canEdit)
                <div class="card mb-3">
                    <a class="card-header fold-toggle collapsed" data-bs-toggle="collapse" href="#fold-edit" role="button" aria-expanded="false">Edit category</a>
                    <div class="collapse" id="fold-edit">
                    <div class="card-body">
                        <form method="POST" action="{{ route('tickets.update', $ticket) }}">@csrf @method('PUT')
                            <label class="small text-muted">Category</label>
                            <select name="category_id" class="form-select form-select-sm mb-2">
                                @foreach($categories as $c)<option value="{{ $c->id }}" @selected($ticket->category_id == $c->id)>{{ $c->name }}</option>@endforeach
                            </select>
                            <button class="btn btn-outline-secondary btn-sm w-100">Update</button>
                        </form>
                    </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Remember which side panels are folded
document.querySelectorAll('.fold-toggle').forEach(function (t) {
    var id = t.getAttribute('href'), el = document.querySelector(id), key = 'fold-' + id;
    if (!el) return;
    var saved = null; try { saved = sessionStorage.getItem(key); } catch (e) {}
    if (saved === 'open') { el.classList.add('show'); t.classList.remove('collapsed'); t.setAttribute('aria-expanded', 'true'); }
    if (saved === 'closed') { el.classList.remove('show'); t.classList.add('collapsed'); t.setAttribute('aria-expanded', 'false'); }
    el.addEventListener('shown.bs.collapse', function () { try { sessionStorage.setItem(key, 'open'); } catch (e) {} });
    el.addEventListener('hidden.bs.collapse', function () { try { sessionStorage.setItem(key, 'closed'); } catch (e) {} });
});
// Remember the open tab (a comment/note/upload reloads the page)
(function () {
    var key = 'ticket-tab-{{ $ticket->id }}';
    var saved = null;
    try { saved = sessionStorage.getItem(key); } catch (e) {}
    if (saved) {
        var btn = document.querySelector('[data-bs-target="' + saved + '"]');
        if (btn) new bootstrap.Tab(btn).show();
    }
    document.querySelectorAll('.tab-card [data-bs-toggle="tab"]').forEach(function (b) {
        b.addEventListener('shown.bs.tab', function () {
            try { sessionStorage.setItem(key, b.getAttribute('data-bs-target')); } catch (e) {}
        });
    });
})();
</script>
@endpush
