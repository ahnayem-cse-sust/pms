@extends('layouts.app')
@section('title', $title)
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ route('inv.movements.store') }}" class="card"><div class="card-body">@csrf
<input type="hidden" name="kind" value="{{ $kind }}">
<div class="row g-3">
@if($kind === 'STOCK')
    <div class="col-md-4"><label class="form-label">Consumable item *</label><select name="item_id" class="form-select" required><option value="">Select…</option>@foreach($items as $i)<option value="{{ $i->id }}" @selected(old('item_id') == $i->id)>{{ $i->name }}</option>@endforeach</select></div>
    <div class="col-md-2"><label class="form-label">Quantity *</label><input type="number" step="0.01" min="0.01" name="qty" value="{{ old('qty') }}" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">From store *</label><select name="from_location_id" class="form-select" required>@foreach($locations as $l)<option value="{{ $l->id }}" @selected(old('from_location_id') == $l->id)>{{ $l->path }}</option>@endforeach</select></div>
    <div class="col-md-3"><label class="form-label">To store *</label><select name="to_location_id" class="form-select" required>@foreach($locations as $l)<option value="{{ $l->id }}" @selected(old('to_location_id') == $l->id)>{{ $l->path }}</option>@endforeach</select></div>
@else
    <div class="col-md-6"><label class="form-label">Asset *</label><select name="asset_id" class="form-select" required><option value="">Select…</option>
        @foreach($assets as $a)<option value="{{ $a->id }}" @selected(old('asset_id', $pre) == $a->id)>{{ $a->asset_code }} · {{ $a->item->name }}{{ $a->serial_no ? ' · '.$a->serial_no : '' }} — {{ $a->custodian_name }}</option>@endforeach</select></div>
    @if($kind === 'RETURN')
        <div class="col-md-6"><label class="form-label">Return to store / location *</label><select name="to_location_id" class="form-select" required>@foreach(($stores->isNotEmpty() ? $stores : $locations) as $l)<option value="{{ $l->id }}" @selected(old('to_location_id') == $l->id)>{{ $l->path }}</option>@endforeach</select></div>
    @else
        <div class="col-md-6"><label class="form-label">{{ $kind === 'ASSIGN' ? 'Assign to' : 'Transfer to' }} *</label>
            <select name="to_type" id="tt" class="form-select" onchange="sw()"><option value="EMPLOYEE">Employee</option><option value="DEPARTMENT">Department</option><option value="LOCATION">Location / store</option></select></div>
        <div class="col-md-4 t t-EMPLOYEE"><label class="form-label">Employee</label><select name="to_user_id" class="form-select"><option value="">Select…</option>@foreach($people as $p)<option value="{{ $p->id }}" @selected(old('to_user_id') == $p->id)>{{ $p->name }} ({{ $p->employee_id }})</option>@endforeach</select></div>
        <div class="col-md-4 t t-DEPARTMENT" style="display:none"><label class="form-label">Department</label><select name="to_department_id" class="form-select"><option value="">Select…</option>@foreach($departments as $p)<option value="{{ $p->id }}" @selected(old('to_department_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-md-4 t t-LOCATION" style="display:none"><label class="form-label">Location</label><select name="to_location_id" class="form-select"><option value="">Select…</option>@foreach($locations as $p)<option value="{{ $p->id }}" @selected(old('to_location_id') == $p->id)>{{ $p->path }}</option>@endforeach</select></div>
    @endif
    <div class="col-md-4"><label class="form-label">{{ $kind === 'RETURN' ? 'Condition on return' : 'Condition at handover' }}</label><select name="condition_id" class="form-select"><option value="">—</option>@foreach($conditions as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-8"><label class="form-label">{{ $kind === 'RETURN' ? 'Missing accessories' : 'Accessories handed over' }}</label><input name="accessories" value="{{ old('accessories') }}" class="form-control" placeholder="Charger, bag, mouse …"></div>
@endif
    <div class="col-md-4"><label class="form-label">Effective date</label><input type="date" name="effective_date" value="{{ old('effective_date', today()->format('Y-m-d')) }}" class="form-control"></div>
    <div class="col-md-8"><label class="form-label">Remarks</label><input name="remarks" value="{{ old('remarks') }}" class="form-control"></div>
</div>
<div class="mt-3"><button class="btn btn-primary">Submit</button> <a href="{{ route('inv.movements.index') }}" class="btn btn-link">Cancel</a></div>
<div class="form-text mt-2">The asset is marked "In Transfer" until this is posted, so it cannot be assigned twice. Custody and location change only when the transaction is posted.</div>
</div></form>
@push('scripts')
<script>
function sw() { var v = document.getElementById('tt').value; document.querySelectorAll('.t').forEach(function (e) { var on = e.classList.contains('t-' + v); e.style.display = on ? '' : 'none'; e.querySelectorAll('select').forEach(function (s) { s.disabled = !on; }); }); }
if (document.getElementById('tt')) sw();
</script>
@endpush
@endsection
