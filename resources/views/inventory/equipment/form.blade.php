@extends('layouts.app')
@section('title', $equipment->exists ? 'Edit equipment' : 'New equipment')
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ $equipment->exists ? route('inv.equipment.update', $equipment) : route('inv.equipment.store') }}" class="card"><div class="card-body">@csrf @if($equipment->exists) @method('PUT') @endif
<div class="row g-3">
    <div class="col-md-3"><label class="form-label">Code</label><input id="code" value="{{ $equipment->code }}" class="form-control" placeholder="Generated when saved" readonly disabled><div class="form-text" id="codehint">@if($equipment->exists)System generated, cannot be changed.@else First 2 letters of asset type + first 2 letters of category + running number.@endif</div></div>
    <div class="col-md-5"><label class="form-label">Equipment name *</label><input name="name" value="{{ old('name', $equipment->name) }}" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Unit (pcs, box …)</label><input name="unit" value="{{ old('unit', $equipment->unit) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Asset type *</label><select name="asset_type_id" id="t" class="form-select" required onchange="fs()"><option value="">Select…</option>@foreach($types as $c)<option value="{{ $c->id }}" @selected(old('asset_type_id', $equipment->asset_type_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-4"><label class="form-label">Category *</label><select name="category_id" id="c" class="form-select" required onchange="fs()"><option value="">Select…</option>@foreach($cats as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(old('category_id', $equipment->category_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-4"><label class="form-label">Sub category</label><select name="subcategory_id" id="s" class="form-select"><option value="">—</option>@foreach($subs as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(old('subcategory_id', $equipment->subcategory_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-4"><label class="form-label">Minimum stock (alert level)</label><input type="number" step="0.01" min="0" name="min_stock" value="{{ old('min_stock', $equipment->min_stock) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Brand</label><input name="brand" value="{{ old('brand', $equipment->brand) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Model</label><input name="model" value="{{ old('model', $equipment->model) }}" class="form-control"></div>
    <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" rows="2" class="form-control">{{ old('notes', $equipment->notes) }}</textarea></div>
    @if($equipment->exists)<div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="act" @checked(old('is_active', $equipment->is_active))><label class="form-check-label" for="act">Active (can be received and allocated)</label></div></div>@endif
</div>
<div class="mt-3"><button class="btn btn-primary">Save</button> <a href="{{ route('inv.equipment.index') }}" class="btn btn-link">Cancel</a></div></div></form>
@push('scripts')
<script>
function narrow(sel, parent) { Array.prototype.forEach.call(sel.options, function (o) { if (!o.dataset.p) return; o.hidden = !parent || o.dataset.p !== parent; if (o.hidden && o.selected) sel.value = ''; }); }
function fs() { narrow(document.getElementById('c'), document.getElementById('t').value); narrow(document.getElementById('s'), document.getElementById('c').value); }
function pre() {
    @unless($equipment->exists)
    var t = document.getElementById('t'), c = document.getElementById('c'), a = t.selectedOptions[0], b = c.selectedOptions[0];
    function f(o) { var m = o && o.value ? o.textContent.trim().match(/\p{L}/gu) : null; return m ? m.slice(0, 2).join('').toUpperCase() : ''; }
    document.getElementById('codehint').textContent = (f(a) && f(b)) ? 'Will start with ' + f(a) + f(b) + ' (e.g. ' + f(a) + f(b) + '0001), generated when saved.' : 'First 2 letters of asset type + first 2 letters of category + running number.';
    @endunless
}
var _fs = fs; fs = function () { _fs(); pre(); };
fs();
</script>
@endpush
@endsection
