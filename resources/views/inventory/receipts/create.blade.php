@extends('layouts.app')
@section('title', 'New goods receipt')
@section('content')
@include('inventory._errors')
@php($itemMeta = $items->mapWithKeys(fn ($i) => [$i->id => $i->type])->all())
<form method="POST" action="{{ route('inv.receipts.store') }}" class="card"><div class="card-body">@csrf
    <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Receipt date *</label><input type="date" name="receipt_date" value="{{ old('receipt_date', today()->format('Y-m-d')) }}" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Supplier</label><select name="supplier_id" class="form-select"><option value="">—</option>@foreach($suppliers as $s)<option value="{{ $s->id }}" @selected(old('supplier_id') == $s->id)>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label">Purchase order / procurement ref</label><input name="procurement_ref" value="{{ old('procurement_ref') }}" class="form-control"></div>
        <div class="col-md-3"><label class="form-label">Invoice / challan no.</label><input name="invoice_no" value="{{ old('invoice_no') }}" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Receiving store / location *</label><select name="location_id" class="form-select" required><option value="">Select…</option>@foreach($locations as $s)<option value="{{ $s->id }}" @selected(old('location_id') == $s->id)>{{ $s->path }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Received by</label><select name="received_by" class="form-select">@foreach($people as $p)<option value="{{ $p->id }}" @selected(old('received_by', auth()->id()) == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Remarks</label><input name="remarks" value="{{ old('remarks') }}" class="form-control"></div>
    </div>
    <h6 class="mt-4">Lines</h6>
    <div id="lines"></div>
    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addLine()">+ Add line</button>
    <div class="form-text">Serialized assets: enter whole quantities and one serial number per line in the box; asset codes are generated when the receipt is posted. Rejected / damaged quantity is not added to stock.</div>
    <div class="mt-3 d-flex gap-2"><button class="btn btn-outline-primary" name="submit" value="0">Save draft</button><button class="btn btn-primary" name="submit" value="1">Save &amp; submit</button><a href="{{ route('inv.receipts.index') }}" class="btn btn-link">Cancel</a></div>
</div></form>
@push('scripts')
<script>
var ITEMS = @json($items->map(fn ($i) => ['id' => $i->id, 'label' => $i->name.' ('.$i->code.')', 'type' => $i->type])->values()), n = 0;
function addLine() {
    var i = n++, o = ITEMS.map(function (x) { return '<option value="' + x.id + '" data-t="' + x.type + '">' + x.label.replace(/</g, '&lt;') + '</option>'; }).join('');
    var d = document.createElement('div'); d.className = 'row g-2 mb-2 border-bottom pb-2';
    d.innerHTML = '<div class="col-md-4"><select name="lines[' + i + '][item_id]" class="form-select form-select-sm" required onchange="tg(this)"><option value="">Item…</option>' + o + '</select></div>' +
      '<div class="col-md-2"><input type="number" step="0.01" min="0" name="lines[' + i + '][qty_received]" class="form-control form-control-sm" placeholder="Received" required></div>' +
      '<div class="col-md-2"><input type="number" step="0.01" min="0" name="lines[' + i + '][qty_rejected]" class="form-control form-control-sm" placeholder="Rejected"></div>' +
      '<div class="col-md-2"><input type="number" step="0.01" min="0" name="lines[' + i + '][unit_cost]" class="form-control form-control-sm" placeholder="Unit cost"></div>' +
      '<div class="col-md-2"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest(\'.row\').remove()">Remove</button></div>' +
      '<div class="col-12 ser" style="display:none"><textarea name="lines[' + i + '][serials]" rows="3" class="form-control form-control-sm" placeholder="Serial numbers – one per line"></textarea></div>';
    document.getElementById('lines').appendChild(d);
}
function tg(s) { var t = s.options[s.selectedIndex].dataset.t; s.closest('.row').querySelector('.ser').style.display = t === 'ASSET' ? '' : 'none'; }
addLine();
</script>
@endpush
@endsection
