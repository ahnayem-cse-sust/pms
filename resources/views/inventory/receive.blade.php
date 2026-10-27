@extends('layouts.app')
@section('title', 'Receive Item')
@section('content')
@include('inventory._errors')
@php
    // keep this as one block (do not mix with the one-line form in this file)
    $from = old('source') === 'EMPLOYEE' ? 'E:'.old('user_id') : (old('source') === 'DEPARTMENT' ? 'D:'.old('department_id') : ($preset['from'] ?? ''));
    $mode = old('source', str_starts_with((string) $from, 'E:') ? 'EMPLOYEE' : (str_starts_with((string) $from, 'D:') ? 'DEPARTMENT' : 'SUPPLIER'));
    $allJs = $equipment->map(fn ($e) => ['id' => $e->id, 'label' => $e->name.' ('.$e->code.')'])->values();
@endphp
<form method="POST" action="{{ route('inv.receive.store') }}" class="card" id="rf"><div class="card-body">@csrf
    <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Received from *</label>
            <select name="source" id="src" class="form-select" onchange="sw()">
                <option value="SUPPLIER" @selected($mode === 'SUPPLIER')>Supplier (new stock)</option>
                <option value="PREVIOUS" @selected($mode === 'PREVIOUS')>Previous item (existing before this system)</option>
                <option value="EMPLOYEE" @selected($mode === 'EMPLOYEE')>Employee (return)</option>
                <option value="DEPARTMENT" @selected($mode === 'DEPARTMENT')>Department (return)</option>
            </select></div>
        <div class="col-md-3"><label class="form-label">Date *</label><input type="date" name="date" value="{{ old('date', today()->format('Y-m-d')) }}" max="{{ today()->format('Y-m-d') }}" class="form-control" required></div>
        <div class="col-md-6 s s-SUPPLIER s-PREVIOUS"><label class="form-label">Supplier <span class="text-muted small" id="suplabel"></span></label><input name="supplier" value="{{ old('supplier') }}" class="form-control"></div>
        <div class="col-md-3 s s-PREVIOUS" style="display:none"><label class="form-label">Currently with</label><select name="held_type" id="ht" class="form-select" onchange="held()">
            <option value="NONE" @selected(old('held_type', 'NONE') === 'NONE')>In store</option><option value="EMPLOYEE" @selected(old('held_type') === 'EMPLOYEE')>An employee</option><option value="DEPARTMENT" @selected(old('held_type') === 'DEPARTMENT')>A department</option></select></div>
        <div class="col-md-3 s s-PREVIOUS h h-EMPLOYEE" style="display:none"><label class="form-label">Employee *</label><select name="held_user_id" class="form-select"><option value="">Select…</option>@foreach($people as $p)<option value="{{ $p->id }}" @selected(old('held_user_id') == $p->id)>{{ $p->name }} ({{ $p->employee_id }})</option>@endforeach</select></div>
        <div class="col-md-3 s s-PREVIOUS h h-DEPARTMENT" style="display:none"><label class="form-label">Department *</label><select name="held_department_id" class="form-select"><option value="">Select…</option>@foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('held_department_id') == $d->id)>{{ $d->name }}</option>@endforeach</select></div>
        <div class="col-md-6 s s-EMPLOYEE" style="display:none"><label class="form-label">Employee returning *</label><select name="user_id" id="hu" class="form-select" onchange="holderChanged()"><option value="">Select…</option>@foreach($holders->filter(fn ($h) => str_starts_with($h['key'], 'E:')) as $h)<option value="{{ substr($h['key'], 2) }}" @selected($from === $h['key'])>{{ $h['label'] }}</option>@endforeach</select></div>
        <div class="col-md-6 s s-DEPARTMENT" style="display:none"><label class="form-label">Department returning *</label><select name="department_id" id="hd" class="form-select" onchange="holderChanged()"><option value="">Select…</option>@foreach($holders->filter(fn ($h) => str_starts_with($h['key'], 'D:')) as $h)<option value="{{ substr($h['key'], 2) }}" @selected($from === $h['key'])>{{ $h['label'] }}</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label" id="reflabel">Invoice / challan / PO no.</label><input name="reference_no" value="{{ old('reference_no') }}" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">Remarks</label><input name="remarks" value="{{ old('remarks') }}" class="form-control"></div>
    </div>
    <h6 class="mt-4">Items received</h6>
    <div id="none" class="text-muted small mb-2" style="display:none">Select who is returning to see the items they hold.</div>
    <div id="lines"></div><button type="button" class="btn btn-sm btn-outline-secondary" id="addbtn" onclick="addLine()">+ Add item</button>
    <div class="form-text" id="hint">Stock is added as soon as you save, and a record is written.</div>
    <div class="mt-3"><button class="btn btn-primary">Save &amp; receive</button> <a href="{{ route('inv.equipment.index') }}" class="btn btn-link">Cancel</a></div>
</div></form>
@push('scripts')
<script>
var ALL = @json($allJs),
    HOLD = @json($holders->mapWithKeys(fn ($h) => [$h['key'] => $h['items']])),
    PRESET = @json($preset['equipment_id'] ?? null), PSERIAL = @json($preset['serial'] ?? null), n = 0;
function mode() { return document.getElementById('src').value; }
function isNew() { return mode() === 'SUPPLIER' || mode() === 'PREVIOUS'; }
function holderKey() { var m = mode(); if (m === 'EMPLOYEE') return 'E:' + document.getElementById('hu').value; if (m === 'DEPARTMENT') return 'D:' + document.getElementById('hd').value; return ''; }
function esc(s) { return String(s).replace(/</g, '&lt;'); }
function options() {
    if (isNew()) return ALL.map(function (x) { return {id: x.id, label: x.label}; });
    return (HOLD[holderKey()] || []).map(function (x) { return {id: x.id, label: x.label + ' – holds ' + x.held, held: x.held}; });
}
function held() {
    var on = mode() === 'PREVIOUS', t = document.getElementById('ht').value;
    document.querySelectorAll('.h').forEach(function (e) { var show = on && e.classList.contains('h-' + t); e.style.display = show ? '' : 'none'; e.querySelectorAll('select').forEach(function (s) { s.disabled = !show; }); });
}
function sw() {
    var m = mode();
    document.querySelectorAll('.s').forEach(function (e) { var on = e.classList.contains('s-' + m); e.style.display = on ? '' : 'none'; e.querySelectorAll('select,input').forEach(function (s) { s.disabled = !on; }); });
    held();
    document.getElementById('reflabel').textContent = m === 'SUPPLIER' ? 'Invoice / challan / PO no.' : (m === 'PREVIOUS' ? 'Old invoice / voucher no.' : 'Return slip / reference');
    document.getElementById('suplabel').textContent = m === 'PREVIOUS' ? '(original supplier, optional)' : '';
    document.getElementById('hint').textContent = m === 'SUPPLIER' ? 'Stock is added as soon as you save, and a record is written.'
        : (m === 'PREVIOUS' ? 'Use the date the item was originally received. If it is already with an employee or department, choose who: stock stays unchanged and they can return it later through Receives.'
        : 'Returned items go back into stock as soon as you save. Only items the person / department holds can be returned, up to the quantity they hold.');
    rebuild();
}
function holderChanged() { rebuild(); }
function rebuild() {
    document.getElementById('lines').innerHTML = ''; n = 0;
    var ready = isNew() || options().length > 0;
    document.getElementById('none').style.display = ready ? 'none' : '';
    document.getElementById('addbtn').style.display = ready ? '' : 'none';
    if (ready) { addLine(); if (!isNew() && PRESET) { var s = document.querySelector('#lines select'), list = options(); if (s) { list.forEach(function (x, k) { if (String(x.id) === String(PRESET) && (!PSERIAL || x.serial === PSERIAL)) { if (s.selectedIndex === 0) s.selectedIndex = k + 1; } }); lineChanged(s); } PRESET = null; } }
}
function lineChanged(sel) {
    var row = sel.closest('.row'), q = row.querySelector('input[type=number]'), sn = row.querySelector('.sn'), fx = row.querySelector('.fixed'), o = options()[sel.selectedIndex - 1];
    sn.value = (o && o.serial) ? o.serial : '';
    q.readOnly = false; q.required = true; q.style.display = ''; fx.style.display = 'none'; q.removeAttribute('max');
    if (o && o.held !== undefined) {
        q.max = o.held;
        if (o.serialized) { q.value = 1; q.readOnly = true; q.required = false; q.style.display = 'none'; fx.style.display = ''; }   // a serialisable unit is always one
        else q.value = o.held;
    }
}
function addLine() {
    var i = n++, o = options().map(function (x) { return '<option value="' + x.id + '">' + esc(x.label) + '</option>'; }).join('');
    var d = document.createElement('div'); d.className = 'row g-2 mb-2';
    d.innerHTML = '<div class="col-md-6"><select name="lines[' + i + '][equipment_id]" class="form-select form-select-sm" required onchange="lineChanged(this)"><option value="">Item…</option>' + o + '</select></div>' +
      '<div class="col-md-3"><input type="number" step="0.01" min="0.01" name="lines[' + i + '][qty]" class="form-control form-control-sm" placeholder="Quantity" required><span class="fixed small text-muted" style="display:none">1 unit (serial)</span><input type="hidden" class="sn" name="lines[' + i + '][serial_no]"></div>' +
      '<div class="col-md-3"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest(\'.row\').remove()">Remove</button></div>';
    document.getElementById('lines').appendChild(d);
}
sw();
</script>
@endpush
@endsection
