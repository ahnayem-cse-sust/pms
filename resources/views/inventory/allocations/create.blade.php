@extends('layouts.app')
@section('title', 'Allocate Equipment')
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ route('inv.allocations.store') }}" class="card"><div class="card-body">@csrf
    <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Allocate to *</label><select name="to_type" id="tt" class="form-select" onchange="sw()"><option value="EMPLOYEE" @selected(old('to_type') == 'EMPLOYEE')>Employee</option><option value="DEPARTMENT" @selected(old('to_type') == 'DEPARTMENT')>Department</option></select></div>
        <div class="col-md-4 t t-EMPLOYEE"><label class="form-label">Employee</label><select name="user_id" class="form-select"><option value="">Select…</option>@foreach($people as $p)<option value="{{ $p->id }}" @selected(old('user_id') == $p->id)>{{ $p->name }} ({{ $p->employee_id }})</option>@endforeach</select></div>
        <div class="col-md-4 t t-DEPARTMENT" style="display:none"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">Select…</option>@foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('department_id') == $d->id)>{{ $d->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Date *</label><input type="date" name="date" value="{{ old('date', today()->format('Y-m-d')) }}" max="{{ today()->format('Y-m-d') }}" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Reference (request no., voucher)</label><input name="reference_no" value="{{ old('reference_no') }}" class="form-control"></div>
    </div>
    <h6 class="mt-4">Equipment</h6>
    <div id="lines"></div><button type="button" class="btn btn-sm btn-outline-secondary" onclick="addLine()">+ Add equipment</button>
    <div class="form-text">Stock reduces as soon as you save, and the allocation is recorded. Serialisable equipment is one unit per line and its serial number is shown (read-only) on the line; other equipment needs a quantity.</div>
    <div class="mt-3"><button class="btn btn-primary">Allocate</button> <a href="{{ route('inv.allocations.index') }}" class="btn btn-link">Cancel</a></div>
</div></form>
@php
    $equipmentJs = $equipment->map(fn ($e) => [
        'id' => $e->id, 'serialized' => $e->is_serialized, 'stock' => (float) $e->stock_qty, 'serial' => $serials[$e->id] ?? null,
        'label' => $e->name.' ('.$e->code.') – '.\App\Support\Inv::qty($e->stock_qty).' in stock'.($e->is_serialized ? ' – serial' : ''),
    ])->values();
@endphp
@push('scripts')
<script>
var E = @json($equipmentJs), n = 0;
function sw() { var v = document.getElementById('tt').value; document.querySelectorAll('.t').forEach(function (e) { var on = e.classList.contains('t-' + v); e.style.display = on ? '' : 'none'; e.querySelectorAll('select').forEach(function (s) { s.disabled = !on; }); }); }
sw();
function pick(sel) {
    var row = sel.closest('.row'), q = row.querySelector('input[type=number]'), sn = row.querySelector('.snum'), lb = row.querySelector('.lbl-q'), x = E.find(function (e) { return String(e.id) === sel.value; });
    if (x && x.serialized) { q.value = ''; q.disabled = true; q.required = false; q.style.display = 'none'; sn.style.display = ''; lb.textContent = 'Serial number'; }
    else { q.disabled = false; q.required = true; q.style.display = ''; sn.style.display = 'none'; sn.value = ''; lb.textContent = 'Quantity'; if (x) q.max = x.stock; else q.removeAttribute('max'); }
    serials();
}
// Shows the serial each serialisable line will get: units that came back first, then new numbers, in line order.
function serials() {
    var used = {};
    document.querySelectorAll('#lines .row').forEach(function (row) {
        var sel = row.querySelector('select'), sn = row.querySelector('.snum'), x = E.find(function (e) { return String(e.id) === sel.value; });
        if (!x || !x.serialized || !x.serial) return;
        var k = used[x.id] || 0; used[x.id] = k + 1;
        var s = k < x.serial.pool.length ? x.serial.pool[k] : x.serial.code + String(x.serial.next + k - x.serial.pool.length).padStart(4, '0');
        sn.value = s;
    });
}
function addLine() {
    var i = n++, o = E.map(function (x) { return '<option value="' + x.id + '">' + x.label.replace(/</g, '&lt;') + '</option>'; }).join('');
    var d = document.createElement('div'); d.className = 'row g-2 mb-2';
    d.innerHTML = '<div class="col-md-4"><label class="form-label small mb-1">Equipment</label><select name="lines[' + i + '][equipment_id]" class="form-select form-select-sm" required onchange="pick(this)"><option value="">Equipment…</option>' + o + '</select></div>' +
      '<div class="col-md-2"><label class="form-label small mb-1 lbl-q">Quantity</label><input type="number" step="0.01" min="0.01" name="lines[' + i + '][qty]" class="form-control form-control-sm" placeholder="Quantity" required><input type="text" class="form-control form-control-sm snum" readonly tabindex="-1" style="display:none" placeholder="Serial number"></div>' +
      '<div class="col-md-4"><label class="form-label small mb-1">Purpose (for this equipment)</label><input name="lines[' + i + '][purpose]" class="form-control form-control-sm" placeholder="Purpose" maxlength="500"></div>' +
      '<div class="col-md-2 d-flex align-items-end"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest(\'.row\').remove(); serials()">Remove</button></div>';
    document.getElementById('lines').appendChild(d);
}
addLine();
</script>
@endpush
@endsection
