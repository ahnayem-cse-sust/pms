@php
    $tone = ['ASSIGNED' => 'secondary', 'IN_PROGRESS' => 'warning', 'WAITING' => 'info', 'DONE' => 'success'];
    $isOpen = $ticket->status->is_open;
    $supporters = $team->where('role', 'SUPPORT');
    $notDone = $supporters->where('work_status', '!=', 'DONE')->count();
@endphp

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Assigned team</span>
        <span class="text-muted small fw-normal">{{ $team->count() }} {{ \Illuminate\Support\Str::plural('member', $team->count()) }}</span>
    </div>
    <ul class="list-group list-group-flush">
        @forelse($team as $m)
            <li class="list-group-item">
                <div class="d-flex align-items-center gap-2">
                    <x-avatar :name="$m->employee->name"/>
                    <div class="flex-grow-1 lh-sm">
                        <div class="fw-semibold">{{ $m->employee->name }}</div>
                        <div class="small text-muted">
                            {{ $m->role === 'PRIMARY' ? 'Responsible for coordination, follow-up and the final resolution' : 'Supporting' }}
                        </div>
                    </div>
                    <span class="pill pill-{{ $m->role === 'PRIMARY' ? 'primary' : 'secondary' }}">{{ $m->role === 'PRIMARY' ? 'Primary' : 'Support' }}</span>
                </div>
                @if($seeInternal)
                    <div class="mt-2 small">
                        <span class="pill pill-{{ $tone[$m->work_status] ?? 'secondary' }}">{{ $workStatuses[$m->work_status] ?? $m->work_status }}</span>
                        @if($m->remarks)<span class="text-muted ms-1">{{ \Illuminate\Support\Str::limit($m->remarks, 140) }}</span>@endif
                    </div>
                    <div class="ticket-sub mt-1">Assigned {{ $m->assigned_at?->format('d M Y H:i') }} by {{ $m->assigner->name ?? '—' }}</div>
                @endif
            </li>
        @empty
            <li class="list-group-item text-muted">Nobody is assigned yet.</li>
        @endforelse
    </ul>
    @if($seeInternal && $isOpen && $notDone > 0)
        <div class="card-body border-top small">
            {{ $notDone }} supporting {{ \Illuminate\Support\Str::plural('employee', $notDone) }} {{ $notDone === 1 ? 'has' : 'have' }} not marked their part as Done.
            The primary employee's resolution marks everyone's part as Done.
        </div>
    @endif
</div>

@if($myRow && $isOpen)
<div class="card mb-3">
    <div class="card-header">My work update <span class="pill pill-{{ $myRow->role === 'PRIMARY' ? 'primary' : 'secondary' }} ms-1">{{ $myRow->role === 'PRIMARY' ? 'Primary' : 'Support' }}</span></div>
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.work', $ticket) }}">@csrf
            <label class="form-label">My status</label>
            <select name="work_status" class="form-select form-select-sm mb-2">
                @foreach($workStatuses as $code => $label)<option value="{{ $code }}" @selected($myRow->work_status === $code)>{{ $label }}</option>@endforeach
            </select>
            <textarea name="note" rows="2" class="form-control form-control-sm mb-2" placeholder="What did you do, what is left? (visible to IT staff only)"></textarea>
            <button class="btn btn-primary btn-sm w-100">Save my update</button>
        </form>
    </div>
</div>
@endif

@if($seeInternal && $workUpdates->isNotEmpty())
<div class="card mb-3">
    <div class="card-header">Team progress <span class="text-muted small fw-normal">(IT staff only)</span></div>
    <ul class="list-group list-group-flush">
        @foreach($workUpdates as $w)
            <li class="list-group-item small">
                <div class="d-flex justify-content-between">
                    <span><b>{{ $w->user->name }}</b> <span class="pill pill-{{ $tone[$w->work_status] ?? 'secondary' }}">{{ $workStatuses[$w->work_status] ?? $w->work_status }}</span></span>
                    <span class="text-muted">{{ $w->created_at->format('d M H:i') }}</span>
                </div>
                @if($w->note)<div class="ticket-body mt-1">{{ $w->note }}</div>@endif
            </li>
        @endforeach
    </ul>
</div>
@endif

@if($canAssign)
<div class="card mb-3">
    <div class="card-header">{{ $team->count() ? 'Change team' : 'Assign team' }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.team', $ticket) }}" id="teamForm">@csrf
            <label class="form-label">Primary responsible employee *</label>
            <select name="primary_id" id="primarySel" class="form-select form-select-sm mb-1">
                <option value="">Select…</option>
                @foreach($members as $m)<option value="{{ $m->id }}" @selected(old('primary_id', $ticket->assigned_to) == $m->id)>{{ $m->name }}</option>@endforeach
            </select>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="auto" value="1" id="auto">
                <label class="form-check-label small" for="auto">Auto-pick the primary (fewest open tickets)</label>
            </div>

            <label class="form-label">Supporting employees</label>
            @php($supportIds = old('support_ids', $supporters->pluck('employee_id')->all()))
            <div class="border rounded p-2 mb-3" style="max-height:190px;overflow:auto">
                @foreach($members as $m)
                    <div class="form-check">
                        <input class="form-check-input support-cb" type="checkbox" name="support_ids[]" value="{{ $m->id }}" id="sup{{ $m->id }}" @checked(in_array($m->id, array_map('intval', (array) $supportIds)))>
                        <label class="form-check-label" for="sup{{ $m->id }}">{{ $m->name }}</label>
                    </div>
                @endforeach
            </div>

            <input type="date" name="due_date" value="{{ $ticket->due_date?->format('Y-m-d') }}" class="form-control form-control-sm mb-2" title="Due date">
            <textarea name="instructions" rows="2" class="form-control form-control-sm mb-2" placeholder="Instructions for the team"></textarea>
            <button class="btn btn-primary btn-sm w-100">Save team</button>
            <div class="form-text">Exactly one primary employee; everyone else supports. The primary coordinates the work and submits the final resolution.</div>
        </form>
    </div>
</div>
@push('scripts')
<script>
(function () {
    var primary = document.getElementById('primarySel');
    if (!primary) return;
    function sync() {
        document.querySelectorAll('.support-cb').forEach(function (cb) {
            var same = primary.value && cb.value === primary.value;
            if (same) cb.checked = false;
            cb.disabled = !!same;
        });
    }
    primary.addEventListener('change', sync);
    sync();
})();
</script>
@endpush
@endif
