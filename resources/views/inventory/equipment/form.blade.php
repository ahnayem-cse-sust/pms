@extends('layouts.app')
@section('title', $equipment->exists ? 'Edit equipment' : 'New equipment')
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ $equipment->exists ? route('inv.equipment.update', $equipment) : route('inv.equipment.store') }}">@csrf @if($equipment->exists) @method('PUT') @endif
<div class="row g-3">
    <div class="col-lg-8 d-flex flex-column gap-3">
        <div class="card inv-form-card">
            <div class="card-header"><span class="inv-step">1</span> Equipment details</div>
            <div class="card-body"><div class="row g-3">
                <div class="col-md-8"><label class="form-label">Equipment name *</label><input name="name" value="{{ old('name', $equipment->name) }}" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Unit (pcs, box …)</label><input name="unit" value="{{ old('unit', $equipment->unit) }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Brand</label><input name="brand" value="{{ old('brand', $equipment->brand) }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Model</label><input name="model" value="{{ old('model', $equipment->model) }}" class="form-control"></div>
                <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" rows="2" class="form-control">{{ old('notes', $equipment->notes) }}</textarea></div>
            </div></div>
        </div>
        <div class="card inv-form-card">
            <div class="card-header"><span class="inv-step">2</span> Classification</div>
            <div class="card-body"><div class="row g-3">
                <div class="col-md-4"><label class="form-label">Asset type *</label><select name="asset_type_id" id="t" class="form-select" required onchange="fs()"><option value="">Select…</option>@foreach($types as $c)<option value="{{ $c->id }}" @selected(old('asset_type_id', $equipment->asset_type_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Category *</label><select name="category_id" id="c" class="form-select" required onchange="fs()"><option value="">Select…</option>@foreach($cats as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(old('category_id', $equipment->category_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Sub category</label><select name="subcategory_id" id="s" class="form-select" onchange="crumb()"><option value="">—</option>@foreach($subs as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(old('subcategory_id', $equipment->subcategory_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
            </div></div>
        </div>
        <div class="card inv-form-card">
            <div class="card-header"><span class="inv-step">3</span> Stock alert</div>
            <div class="card-body"><div class="row g-3">
                <div class="col-md-5"><label class="form-label">Minimum stock (alert level)</label><input type="number" step="0.01" min="0" name="min_stock" value="{{ old('min_stock', $equipment->min_stock) }}" class="form-control"><div class="form-text">The item shows as low when stock drops to this level or below. Leave empty for no alert.</div></div>
            </div></div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card position-sticky" style="top:4.5rem">
            <div class="card-header">Summary</div>
            <div class="card-body d-flex flex-column gap-3">
                <div><label class="form-label">Code</label><input id="code" value="{{ $equipment->code }}" class="form-control" placeholder="Generated when saved" readonly disabled><div class="form-text" id="codehint">@if($equipment->exists)System generated, cannot be changed.@else First 2 letters of asset type + first 2 letters of category + running number.@endif</div></div>
                <div class="inv-preview"><span class="lbl">Classification</span><div class="inv-crumb" id="crumbPrev"></div></div>
                @if($equipment->exists)
                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="is_active" value="1" id="act" @checked(old('is_active', $equipment->is_active))><label class="form-check-label" for="act">Active <span class="text-muted small d-block">Inactive equipment cannot be received or allocated.</span></label></div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="inv-actionbar"><button class="btn btn-primary"><x-icon name="check" :size="15"/> Save</button><a href="{{ route('inv.equipment.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
@push('scripts')
<script>
function narrow(sel, parent) { Array.prototype.forEach.call(sel.options, function (o) { if (!o.dataset.p) return; o.hidden = !parent || o.dataset.p !== parent; if (o.hidden && o.selected) sel.value = ''; }); }
function esc(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;'); }
function fs() { narrow(document.getElementById('c'), document.getElementById('t').value); narrow(document.getElementById('s'), document.getElementById('c').value); }
function crumb() {
    var parts = ['t', 'c', 's'].map(function (id) { var o = document.getElementById(id).selectedOptions[0]; return o && o.value ? o.textContent.trim() : ''; }).filter(Boolean);
    document.getElementById('crumbPrev').innerHTML = parts.length ? parts.map(function (p) { return '<span>' + esc(p) + '</span>'; }).join('') : '<span class="text-muted">Choose asset type, category and sub category</span>';
}
function pre() {
    @unless($equipment->exists)
    var t = document.getElementById('t'), c = document.getElementById('c'), a = t.selectedOptions[0], b = c.selectedOptions[0];
    function f(o) { var m = o && o.value ? o.textContent.trim().match(/\p{L}/gu) : null; return m ? m.slice(0, 2).join('').toUpperCase() : ''; }
    document.getElementById('codehint').textContent = (f(a) && f(b)) ? 'Will start with ' + f(a) + f(b) + ' (e.g. ' + f(a) + f(b) + '0001), generated when saved.' : 'First 2 letters of asset type + first 2 letters of category + running number.';
    @endunless
}
var _fs = fs; fs = function () { _fs(); pre(); crumb(); };
fs();
</script>
@endpush
@endsection
