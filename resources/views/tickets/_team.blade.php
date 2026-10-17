@php
    $tone = ['ASSIGNED' => 'secondary', 'IN_PROGRESS' => 'warning', 'WAITING' => 'info', 'DONE' => 'success'];
    $isOpen = $ticket->status->is_open;
    $supporters = $team->where('role', 'SUPPORT');
    $notDone = $supporters->where('work_status', '!=', 'DONE')->count();
@endphp

@if($myRow && $isOpen)
<div class="card mb-3">
    <a class="card-header fold-toggle" data-bs-toggle="collapse" href="#fold-mywork" role="button" aria-expanded="true">My work update <span class="pill pill-{{ $myRow->role === 'PRIMARY' ? 'primary' : 'secondary' }} ms-1">{{ $myRow->role === 'PRIMARY' ? 'Primary' : 'Support' }}</span></a>
    <div class="collapse show" id="fold-mywork">
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.work', $ticket) }}">@csrf
            <label class="form-label">My status</label>
            <select name="work_status" class="form-select form-select-sm mb-2">
                @foreach($workStatuses as $code => $label)<option value="{{ $code }}" @selected($myRow->work_status === $code)>{{ $label }}</option>@endforeach
            </select>
            <textarea name="note" rows="2" class="form-control form-control-sm mb-2" placeholder="Progress note…"></textarea>
            <button class="btn btn-primary btn-sm w-100">Save my update</button>
        </form>
    </div>
    </div>
</div>
@endif

@if($canAssign)
<div class="card mb-3">
    <a class="card-header fold-toggle {{ ($team->isEmpty() || $errors->has('primary_id') || $errors->has('support_ids')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#teamEdit" role="button" aria-expanded="{{ ($team->isEmpty() || $errors->has('primary_id') || $errors->has('support_ids')) ? 'true' : 'false' }}">{{ $team->count() ? 'Change team' : 'Assign team' }}</a>
    <div class="collapse {{ ($team->isEmpty() || $errors->has('primary_id') || $errors->has('support_ids')) ? 'show' : '' }}" id="teamEdit">
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.team', $ticket) }}" id="teamForm">@csrf
            <label class="form-label">Primary responsible employee *</label>
            <select name="primary_id" id="primarySel" class="form-select form-select-sm mb-1">
                <option value="">Select…</option>
                @foreach($members as $m)<option value="{{ $m->id }}" @selected(old('primary_id', $ticket->assigned_to) == $m->id)>{{ $m->name }}</option>@endforeach
            </select>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="auto" value="1" id="auto">
                <label class="form-check-label small" for="auto">Auto-pick primary</label>
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
            <textarea name="instructions" rows="2" class="form-control form-control-sm mb-2" placeholder="Instructions"></textarea>
            <button class="btn btn-primary btn-sm w-100">Save team</button>
        </form>
    </div>
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
