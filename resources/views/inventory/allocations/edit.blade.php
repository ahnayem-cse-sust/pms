@extends('layouts.app')
@section('title', 'Edit allocation '.$entry)
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ route('inv.allocations.update', $entry) }}">@csrf @method('PUT')
<div class="card inv-form-card mb-3">
    <div class="card-header"><span class="inv-step">1</span> {{ $entry }} @if($isPrevious){{ \App\Support\Inv::pill('PRIOR') }}@endif</div>
    <div class="card-body"><div class="row g-3">
        @php $toType = old('to_type', $first->holder_type); @endphp
        <div class="col-md-3"><label class="form-label">Allocated to *</label><select name="to_type" id="tt" class="form-select" onchange="sw()"><option value="EMPLOYEE" @selected($toType == 'EMPLOYEE')>Employee</option><option value="DEPARTMENT" @selected($toType == 'DEPARTMENT')>Department</option><option value="OFFICE" @selected($toType == 'OFFICE')>Office</option></select></div>
        <div class="col-md-4 t t-EMPLOYEE"><label class="form-label">Employee</label><select name="user_id" class="form-select"><option value="">Select…</option>@foreach($people as $p)<option value="{{ $p->id }}" @selected(old('user_id', $first->holder_user_id) == $p->id)>{{ $p->name }} ({{ $p->employee_id }})</option>@endforeach</select></div>
        <div class="col-md-4 t t-DEPARTMENT" style="display:none"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">Select…</option>@foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('department_id', $first->holder_department_id) == $d->id)>{{ $d->name }}</option>@endforeach</select></div>
        <div class="col-md-4 t t-OFFICE" style="display:none"><label class="form-label">Office</label><select name="section_id" class="form-select"><option value="">Select…</option>@foreach($offices as $o)<option value="{{ $o->id }}" @selected(old('section_id', $first->holder_section_id) == $o->id)>{{ $o->name }}@if($o->department) ({{ $o->department->name }})@endif</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Date *</label><input type="date" name="date" value="{{ old('date', $first->moved_on->format('Y-m-d')) }}" max="{{ today()->format('Y-m-d') }}" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Reference (request no., voucher)</label><input name="reference_no" value="{{ old('reference_no', $first->reference_no) }}" class="form-control"></div>
    </div></div>
</div>

<div class="card inv-form-card">
    <div class="card-header"><span class="inv-step">2</span> Equipment <span class="inv-count">{{ $lines->count() }}</span></div>
    <div class="card-body p-0">
    <div class="table-responsive inv-lines"><table class="table align-middle mb-0"><thead><tr><th>Equipment ID</th><th>Equipment</th><th>Asset ID</th><th>Serial number</th><th style="width:130px">Quantity</th><th>Purpose</th></tr></thead><tbody>
    @foreach($lines as $m)
    @php $e = $m->equipment; $editableQty = ! $m->serial_no && ! $e->is_serialized; $ret = $returned[$m->id] ?? 0; @endphp
    <tr>
        <td class="text-nowrap"><span class="inv-code">{{ $e->code }}</span></td>
        <td style="min-width:160px"><span class="inv-name">{{ $e->name }}</span>@if($ret > 0)<div class="inv-sub text-success">{{ \App\Support\Inv::qty($ret) }} returned</div>@endif</td>
        <td>@if($m->serial_no)<strong class="inv-sn text-body">{{ $m->serial_no }}</strong>@else—@endif</td>
        <td>@if($m->serial_no)<input name="lines[{{ $m->id }}][device_serial_no]" value="{{ old('lines.'.$m->id.'.device_serial_no', $m->device_serial_no) }}" class="form-control form-control-sm" maxlength="120" placeholder="Serial number">@else—@endif</td>
        <td>@if($editableQty)<input type="number" step="0.01" min="0.01" name="lines[{{ $m->id }}][qty]" value="{{ old('lines.'.$m->id.'.qty', \App\Support\Inv::qty(abs($m->qty))) }}" class="form-control form-control-sm" required>@else<span class="inv-q">{{ \App\Support\Inv::qty(abs($m->qty)) }}</span>@endif</td>
        <td><input name="lines[{{ $m->id }}][purpose]" value="{{ old('lines.'.$m->id.'.purpose', $m->remarks) }}" class="form-control form-control-sm" maxlength="500" placeholder="Purpose"></td>
    </tr>
    @endforeach
    </tbody></table></div>
    </div>
    <div class="card-body pt-2"><div class="form-text">The stock is adjusted to match when you save{{ $isPrevious ? ' (a previous allocation does not change the stock)' : '' }}. An Asset ID is system generated and stays as it is. To change the equipment itself, or to add or remove a line, delete this entry and enter it again.</div></div>
</div>
<div class="inv-actionbar"><button class="btn btn-primary"><x-icon name="check" :size="15"/> Save changes</button><a href="{{ route('inv.allocations.show', $entry) }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
@push('scripts')
<script src="{{ asset('js/searchable-select.js') }}"></script>
<script>
function sw() { var v = document.getElementById('tt').value; document.querySelectorAll('.t').forEach(function (e) { var on = e.classList.contains('t-' + v); e.style.display = on ? '' : 'none'; e.querySelectorAll('select').forEach(function (s) { s.disabled = !on; }); }); }
sw();
searchableSelect(document.querySelector('select[name=user_id]'), 'Select…');
searchableSelect(document.querySelector('select[name=department_id]'), 'Select…');
searchableSelect(document.querySelector('select[name=section_id]'), 'Select…');
</script>
@endpush
@endsection
