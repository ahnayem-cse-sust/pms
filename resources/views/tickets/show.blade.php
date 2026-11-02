@extends('layouts.app')
@section('title', str_replace('-', '', $ticket->ticket_no))
@section('content')
@php
    $steps = ['New', 'Assigned', 'In progress', 'Resolved', 'Closed'];
    $stepOf = ['NEW' => 0, 'ACKNOWLEDGED' => 0, 'ASSIGNED' => 1, 'REOPENED' => 1, 'IN_PROGRESS' => 2, 'WAITING_USER' => 2,
               'ON_HOLD' => 2, 'ESCALATED' => 2, 'BACKLOG' => 0, 'RESOLVED' => 3, 'USER_CONFIRMATION' => 3, 'CLOSED' => 4];
    $cur = $stepOf[$ticket->status->code] ?? null;
    $open = $ticket->status->is_open;
    $reqNo = str_replace('-', '', $ticket->ticket_no);
    // Panels depend only on the viewer's roles and permissions, never on which menu the page was opened from
    $staffTabs = $seeInternal;
@endphp

<div class="row g-4 align-items-start">
    {{-- ───────── Left: description + tabs ───────── --}}
    <div class="col-lg-8">
        {{-- ───────── Top panel: progress + request information table ───────── --}}
        @php
            $overdue = $open && $ticket->sla_resolution_due_at && $ticket->sla_resolution_due_at->isPast();
            $dueLate = $open && $ticket->due_date && $ticket->due_date->endOfDay()->isPast();
            $phone = $ticket->requester_phone;
        @endphp
        <div class="card mb-4 req-head rd">
            @php
                $rq = $ticket->requester;
                $rqHue = crc32((string) $ticket->requester_name) % 360;
                $rqParts = preg_split('/\s+/', trim((string) $ticket->requester_name));
                $rqIni = mb_strtoupper(mb_substr($rqParts[0] ?? '?', 0, 1) . (isset($rqParts[1]) ? mb_substr($rqParts[1], 0, 1) : ''));
                $onBehalf = $ticket->created_by !== $ticket->requester_id;
            @endphp
            {{-- 1. Top bar --}}
            <div class="rd-bar">
                <a href="{{ route('tickets.index') }}" class="req-back" title="Back to requests" aria-label="Back to requests"><x-icon name="arrow-left" :size="18"/></a>
                <h2 class="rd-bar-title" title="{{ $ticket->subject }}">{{ $ticket->subject }}</h2>
                <div class="rd-bar-actions">
                    @if($ticket->status->code === 'CLOSED')
                        <a href="{{ route('tickets.pdf', $ticket) }}" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1" title="Download PDF"><x-icon name="download" :size="15"/><span class="d-none d-sm-inline">Download</span></a>
                    @endif
                    @if(! empty($canEditDetails))<a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1" title="Edit request"><x-icon name="edit" :size="15"/><span class="d-none d-sm-inline">Edit</span></a>@endif
                    <button type="button" class="rd-toggle" id="rdToggle" data-bs-toggle="collapse" data-bs-target="#rdFold" aria-expanded="true" aria-controls="rdFold" title="Expand / collapse details">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 15l6-6 6 6"/></svg>
                    </button>
                </div>
            </div>

            <div class="collapse show" id="rdFold">
            {{-- 2. Requester information (same table style as Request information) --}}
            <section class="rd-sec rd-requester">
                <h3 class="rd-h rd-indigo"><span class="rd-ic"><x-icon name="user" :size="15"/></span>Requester information</h3>
                <table class="rd-grid"><tbody>
                    <tr>
                        <th>Requester</th><td><span class="rd-who">@if($rq && $rq->avatar_path)<img src="{{ route('avatar.show', $rq) }}?v={{ optional($rq->updated_at)->timestamp }}" alt="" class="rd-mini">@else<span class="rd-mini rd-mini-ini" style="--h: {{ $rqHue }}">{{ $rqIni }}</span>@endif {{ $ticket->requester_name }}</span></td>
                        <th>Designation</th><td>{{ $ticket->requester_designation ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th>Employee ID</th><td>{{ $ticket->requester_employee_id ?: '—' }}</td>
                        <th>Department</th><td>{{ $ticket->department->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Location</th><td>{{ $ticket->location->name ?? '—' }}</td>
                        <th>WhatsApp</th><td>@if($phone)<a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="text-decoration-none">{{ $phone }}</a>@else — @endif</td>
                    </tr>
                    <tr>
                        <th>Filed by</th><td>{{ $onBehalf ? ($ticket->creator->name ?? 'IT') : 'Self' }}</td>
                        <th>Submitted</th><td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                </tbody></table>
            </section>

            @php
                $stepDates = [0 => null, 1 => $ticket->assigned_at, 2 => $ticket->started_at, 3 => $ticket->resolved_at, 4 => $ticket->closed_at];
                $pauses = [
                    'ON_HOLD' => ['On hold', 'Work is paused and will continue once the request is resumed.'],
                    'WAITING_USER' => ['Waiting for reply', 'The IT team is waiting for a response from the requester.'],
                ];
                $paused = $pauses[$ticket->status->code] ?? null;
                $stepHints = ['Waiting for the IT team to pick this up.', 'Assigned to the IT team.', 'The IT team is working on it.', 'A fix has been provided – please confirm.', 'Completed. Thank you!'];
            @endphp
            {{-- 3. Request information --}}
            <section class="rd-sec rd-info-sec">
                <h3 class="rd-h rd-teal"><span class="rd-ic"><x-icon name="clipboard" :size="15"/></span>Request information</h3>
                <table class="rd-grid"><tbody>
                    <tr>
                        <th>Request no.</th><td><button type="button" class="ticket-id req-no" id="copyReqNo" data-no="{{ $reqNo }}" title="Click to copy the request number">{{ $reqNo }}</button></td>
                        <th>Status</th><td>
                            <span class="pill pill-{{ $ticket->status->color ?? 'secondary' }}">{{ $ticket->status->name }}</span>
                            @if($ticket->reopen_count)<span class="pill pill-danger ms-1">Reopened ×{{ $ticket->reopen_count }}</span>@endif
                        </td>
                    </tr>
                    <tr>
                        <th>Service type</th><td>{{ $ticket->type->name ?? '—' }}</td>
                        <th>Category</th><td>{{ $ticket->category->name }}@if($ticket->subcategory) <span class="text-muted">/</span> {{ $ticket->subcategory->name }}@endif</td>
                    </tr>
                    <tr><th>Subject</th><td colspan="3" class="fw-semibold">{{ $ticket->subject }}</td></tr>
                    <tr><th>Description</th><td colspan="3"><div class="ticket-body rd-text">{{ $ticket->description }}</div></td></tr>
                    @if($ticket->resolution)
                        <tr class="rd-res-row"><th>Resolution</th><td colspan="3"><div class="ticket-body rd-text">{{ $ticket->resolution }}</div></td></tr>
                    @endif
                </tbody></table>
                <div class="rd-progress">
                    @if($cur !== null)
                        <div class="stepper stepper-lg">
                            @foreach($steps as $i => $label)
                                <div class="step {{ $i < $cur ? 'done' : ($i === $cur ? 'current' : '') }}{{ $i === 4 && $i <= $cur ? ' final' : '' }}{{ $paused && $i === $cur ? ' paused' : '' }}">
                                    <div class="dot">@if($paused && $i === $cur)<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>@elseif($i < $cur || ($i === 4 && $cur === 4))<x-icon name="check" :size="16"/>@else{{ $i + 1 }}@endif</div>
                                    <div class="slabel">{{ $paused && $i === $cur ? $paused[0] : $label }}</div>
                                    <div class="sdate">@if($i <= $cur && ! empty($stepDates[$i])){{ $stepDates[$i]->format('d M, h:i A') }}@else&nbsp;@endif</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="stage-note {{ $paused ? 'is-paused' : ($cur === 4 ? 'is-done' : '') }}"><span class="stage-dot"></span><span class="stage-tag">{{ $paused ? $paused[0] : ($cur === 4 ? 'Completed' : 'Current stage') }}</span><span class="stage-text">{{ $paused ? $paused[1] : $stepHints[$cur] }}</span></div>
                    @else
                        <div class="req-cancelled">This request was cancelled.</div>
                    @endif
                </div>
            </section>


            </div>
        </div>

        {{-- Request activity log: its own card --}}
        @php
            $dayLabel = function ($dt) {
                if ($dt->isToday()) return 'Today';
                if ($dt->isYesterday()) return 'Yesterday';
                return $dt->format('d M Y');
            };
        @endphp
        <div class="card tab-card tab-in-card">
            <div class="card-header">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-conv" type="button" role="tab"><x-icon name="message" :size="16"/> Conversation <span class="count">{{ $ticket->comments->count() }}</span></button></li>
                    @if($staffTabs)
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-notes" type="button" role="tab"><x-icon name="lock" :size="16"/> Internal notes <span class="count">{{ $notes->count() }}</span></button></li>
                    @endif
                    @if($staffTabs && $workUpdates->isNotEmpty())
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-work" type="button" role="tab"><x-icon name="check" :size="16"/> Team progress <span class="count">{{ $workUpdates->count() }}</span></button></li>
                    @endif
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-files" type="button" role="tab"><x-icon name="paperclip" :size="16"/> Attachments <span class="count">{{ $attachments->count() }}</span></button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-history" type="button" role="tab"><x-icon name="clock" :size="16"/> History</button></li>
                </ul>
            </div>
            <div class="card-body tab-content">

                {{-- Conversation (visible to the requester) --}}
                <div class="tab-pane fade show active" id="tab-conv" role="tabpanel">
                    @php($prevDay = null)
                    @if($ticket->comments->isNotEmpty())<div class="thread" data-thread>@endif
                    @forelse($ticket->comments as $c)
                        @if($prevDay !== $c->created_at->format('Y-m-d'))
                            @php($prevDay = $c->created_at->format('Y-m-d'))
                            <div class="day-sep"><span>{{ $dayLabel($c->created_at) }}</span></div>
                        @endif
                        <div class="comment{{ $c->user->id === auth()->id() ? ' mine' : '' }}">
                            <x-avatar :name="$c->user->name" :user="$c->user"/>
                            <div class="comment-bubble">
                                <div class="comment-meta"><b>{{ $c->user->id === auth()->id() ? 'You' : $c->user->name }}</b><span title="{{ $c->created_at->format('d M Y, h:i A') }}">{{ $c->created_at->format('h:i A') }}</span></div>
                                <div class="ticket-body">{{ $c->body }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state"><x-icon name="message" :size="26"/><div>No comments yet.</div><small>Use the box below to ask a question or add an update.</small></div>
                    @endforelse
                    @if($ticket->comments->isNotEmpty())</div>@endif
                    @can('ticket.comment.public')
                        <form method="POST" action="{{ route('tickets.comment', $ticket) }}" enctype="multipart/form-data" class="composer">@csrf
                            <textarea name="body" rows="3" placeholder="Write a comment…" required></textarea>
                            <div class="composer-bar">
                                <label class="composer-attach"><x-icon name="paperclip" :size="15"/> <span data-attach-label>Attach files</span><input type="file" name="attachments[]" multiple></label>
                                <span class="composer-hint ms-auto d-none d-md-inline">Ctrl + Enter to send</span><button class="btn btn-primary btn-sm text-nowrap" data-once>Send comment</button>
                            </div>
                        </form>
                    @endcan
                </div>

                {{-- Internal notes (IT staff only – never sent to the requester) --}}
                @if($staffTabs)
                    <div class="tab-pane fade" id="tab-notes" role="tabpanel">
                        <div class="note-banner"><x-icon name="lock" :size="15"/> Internal notes are visible to IT staff only – the requester never sees them.</div>
                        @php($prevDay = null)
                        @if($notes->isNotEmpty())<div class="thread" data-thread>@endif
                        @forelse($notes as $n)
                            @if($prevDay !== $n->created_at->format('Y-m-d'))
                                @php($prevDay = $n->created_at->format('Y-m-d'))
                                <div class="day-sep"><span>{{ $dayLabel($n->created_at) }}</span></div>
                            @endif
                            <div class="comment note{{ $n->user->id === auth()->id() ? ' mine' : '' }}">
                                <x-avatar :name="$n->user->name" :user="$n->user"/>
                                <div class="comment-bubble">
                                    <div class="comment-meta"><b>{{ $n->user->id === auth()->id() ? 'You' : $n->user->name }}</b><span title="{{ $n->created_at->format('d M Y, h:i A') }}">{{ $n->created_at->format('h:i A') }}</span></div>
                                    <div class="ticket-body">{{ $n->body }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state"><x-icon name="lock" :size="26"/><div>No internal notes.</div><small>Notes added here are visible to IT staff only.</small></div>
                        @endforelse
                        @if($notes->isNotEmpty())</div>@endif
                        <form method="POST" action="{{ route('tickets.note', $ticket) }}" class="composer composer-note">@csrf
                            <textarea name="body" rows="2" placeholder="Add an internal note…" required></textarea>
                            <div class="composer-bar"><span class="composer-hint"><x-icon name="lock" :size="14"/> IT only</span><span class="composer-hint ms-auto d-none d-md-inline">Ctrl + Enter to send</span><button class="btn btn-warning btn-sm" data-once>Add internal note</button></div>
                        </form>
                    </div>
                @endif

                {{-- Team progress (IT staff only) --}}
                @if($staffTabs && $workUpdates->isNotEmpty())
                    @php($wTone = ['ASSIGNED' => 'secondary', 'IN_PROGRESS' => 'warning', 'WAITING' => 'info', 'DONE' => 'success'])
                    <div class="tab-pane fade" id="tab-work" role="tabpanel">
                        @foreach($workUpdates as $w)
                            <div class="comment">
                                <x-avatar :name="$w->user->name" :user="$w->user"/>
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
                    <div class="file-list">
                        @forelse($attachments as $a)
                            <a href="{{ route('attachments.download', $a) }}" class="file-card">
                                <span class="file-ic"><x-icon name="file-text" :size="20"/></span>
                                <span class="file-info">
                                    <span class="file-name">{{ $a->original_name }}@if($a->is_internal) <span class="pill pill-warning ms-1">IT only</span>@endif</span>
                                    <span class="ticket-sub">{{ number_format($a->size_bytes / 1024, 0) }} KB · {{ $a->uploader->name }} · {{ $a->created_at->format('d M h:i A') }}</span>
                                </span>
                                <span class="file-dl"><x-icon name="download" :size="16"/></span>
                            </a>
                        @empty
                            <div class="empty-state"><x-icon name="paperclip" :size="26"/><div>No attachments.</div></div>
                        @endforelse
                    </div>
                    @can('attachment.upload')
                        <form method="POST" action="{{ route('tickets.upload', $ticket) }}" enctype="multipart/form-data" class="row g-2 align-items-center upload-box">@csrf
                            <div class="col"><input type="file" name="attachments[]" class="form-control form-control-sm" multiple required></div>
                            @if($staffTabs)<div class="col-auto form-check"><input type="checkbox" name="internal" value="1" class="form-check-input" id="int"><label class="form-check-label small" for="int">IT only</label></div>@endif
                            <div class="col-auto"><button class="btn btn-secondary btn-sm">Upload</button></div>
                        </form>
                    @endcan
                </div>

                {{-- History --}}
                <div class="tab-pane fade" id="tab-history" role="tabpanel">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('tickets.history.pdf', $ticket) }}" class="btn btn-sm btn-outline-primary">Download history (PDF)</a>
                    </div>
                    <ul class="list-unstyled timeline mb-0">
                        @foreach($history as $h)
                            <li>
                                <span class="text-muted">{{ $h->created_at->format('d M h:i A') }}</span>
                                <b>{{ $h->user->name ?? 'System' }}</b>
                                @include('tickets._history_text', ['h' => $h])
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
                            <textarea name="comment" rows="3" class="form-control mb-2" placeholder="Add a comment (required for actions marked *)"></textarea>
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
                            @if($actionList->where('requires_comment', true)->isNotEmpty())<div class="form-text mt-2">* A comment is required for this action.</div>@endif
                        </form>
                    </div>
                    </div>
                </div>
            @endif

            @if($seeInternal)
            <div class="card mb-3">
                <a class="card-header fold-toggle collapsed" data-bs-toggle="collapse" href="#fold-team" role="button" aria-expanded="false">Assigned IT Team</a>
                <div class="collapse" id="fold-team">
                    <div class="card-body">
                        @include('tickets._team_summary')
                    </div>
                </div>
            </div>
            @endif

            @include('tickets._team')

            @if(auth()->user()->isRole('admin'))
                <div class="card mb-3">
                    <a class="card-header fold-toggle collapsed" data-bs-toggle="collapse" href="#fold-delete" role="button" aria-expanded="false">Delete request</a>
                    <div class="collapse" id="fold-delete">
                        <div class="card-body">
                            <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" onsubmit="return confirm('Delete request {{ $reqNo }}? It will disappear from all lists and reports.');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger w-100">Delete this request</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if($canEdit)
                <div class="card mb-3">
                    <a class="card-header fold-toggle collapsed" data-bs-toggle="collapse" href="#fold-edit" role="button" aria-expanded="false">Edit service type &amp; category</a>
                    <div class="collapse" id="fold-edit">
                    <div class="card-body">
                        <form method="POST" action="{{ route('tickets.update', $ticket) }}">@csrf @method('PUT')
                            <label class="small text-muted">Service type</label>
                            <select name="ticket_type_id" class="form-select form-select-sm mb-2">
                                @foreach($types as $ty)<option value="{{ $ty->id }}" @selected($ticket->ticket_type_id == $ty->id)>{{ $ty->name }}</option>@endforeach
                            </select>
                            <label class="small text-muted">Category</label>
                            <select name="category_id" id="editCat" class="form-select form-select-sm mb-2">
                                @foreach($categories as $c)<option value="{{ $c->id }}" @selected($ticket->category_id == $c->id)>{{ $c->name }}</option>@endforeach
                            </select>
                            <label class="small text-muted">Sub-category</label>
                            <select name="subcategory_id" id="editSub" class="form-select form-select-sm mb-2">
                                <option value="">— None —</option>
                                @foreach($categories as $c)
                                    @foreach($c->subcategories as $sc)
                                        @if($sc->is_active || $ticket->subcategory_id == $sc->id)
                                            <option value="{{ $sc->id }}" data-cat="{{ $c->id }}" @selected($ticket->subcategory_id == $sc->id)>{{ $sc->name }}</option>
                                        @endif
                                    @endforeach
                                @endforeach
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
// Sub-category list follows the chosen category
(function () {
    var cat = document.getElementById('editCat'), sub = document.getElementById('editSub');
    if (!cat || !sub) return;
    function sync() {
        var keep = false;
        Array.prototype.forEach.call(sub.options, function (o) {
            if (!o.value) return;
            var ok = o.getAttribute('data-cat') === cat.value;
            o.hidden = !ok; o.disabled = !ok;
            if (ok && o.selected) keep = true;
        });
        if (!keep) sub.value = '';
    }
    cat.addEventListener('change', sync);
    sync();
})();
// Remember whether the request card is collapsed
(function () {
    var el = document.getElementById('rdFold'), btn = document.getElementById('rdToggle');
    if (!el || !btn) return;
    var key = 'rd-fold', saved = null; try { saved = sessionStorage.getItem(key); } catch (e) {}
    function mark(open) { btn.classList.toggle('collapsed', !open); btn.setAttribute('aria-expanded', open ? 'true' : 'false'); }
    if (saved === 'closed') { el.classList.remove('show'); mark(false); }
    el.addEventListener('shown.bs.collapse', function () { mark(true); try { sessionStorage.setItem(key, 'open'); } catch (e) {} });
    el.addEventListener('hidden.bs.collapse', function () { mark(false); try { sessionStorage.setItem(key, 'closed'); } catch (e) {} });
})();
// Activity log: jump to newest message, Ctrl+Enter sends, auto-grow, attach count, no double submit
(function () {
    function toEnd(root) { (root || document).querySelectorAll('[data-thread]').forEach(function (t) { t.scrollTop = t.scrollHeight; }); }
    toEnd();
    document.querySelectorAll('.tab-in-card [data-bs-toggle="tab"]').forEach(function (b) { b.addEventListener('shown.bs.tab', function () { toEnd(); }); });
    document.querySelectorAll('.composer').forEach(function (f) {
        var ta = f.querySelector('textarea'), file = f.querySelector('input[type=file]'), lab = f.querySelector('[data-attach-label]');
        if (ta) {
            ta.addEventListener('input', function () { ta.style.height = 'auto'; ta.style.height = Math.min(ta.scrollHeight, 220) + 'px'; });
            ta.addEventListener('keydown', function (e) { if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') { e.preventDefault(); if (f.reportValidity()) f.requestSubmit(); } });
        }
        if (file && lab) file.addEventListener('change', function () { lab.textContent = file.files.length ? file.files.length + ' file' + (file.files.length > 1 ? 's' : '') + ' selected' : 'Attach files'; });
        f.addEventListener('submit', function () { var b = f.querySelector('[data-once]'); if (b) setTimeout(function () { b.disabled = true; }, 0); });
    });
})();
// Click the request number to copy it
(function () {
    var b = document.getElementById('copyReqNo');
    if (!b) return;
    b.addEventListener('click', function () {
        var no = b.getAttribute('data-no'), old = b.textContent;
        function done() { b.textContent = 'Copied ✓'; setTimeout(function () { b.textContent = old; }, 1200); }
        if (navigator.clipboard) navigator.clipboard.writeText(no).then(done, function () {});
    });
})();
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
