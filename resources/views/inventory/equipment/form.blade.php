@extends('layouts.app')
@section('title', $equipment->exists ? 'Edit equipment' : 'New equipment')
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ $equipment->exists ? route('inv.equipment.update', $equipment) : route('inv.equipment.store') }}">@csrf @if($equipment->exists) @method('PUT') @endif
<div class="card inv-form-card">
    <div class="card-header">{{ $equipment->exists ? 'Edit equipment' : 'New equipment' }}</div>
    <div class="card-body"><div class="row g-3">
        <div class="col-md-3"><label class="form-label">Equipment ID</label><input id="code" value="{{ $equipment->code }}" class="form-control" placeholder="Generated when saved" readonly disabled><div class="form-text" id="codehint">@if($equipment->exists)System generated, cannot be changed.@else First 2 letters of asset type + first 2 letters of category + running number.@endif</div></div>
        <div class="col-md-6"><label class="form-label">Equipment name *</label><input name="name" value="{{ old('name', $equipment->name) }}" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Unit (pcs, box …)</label><input name="unit" value="{{ old('unit', $equipment->unit) }}" class="form-control"></div>

        @php
            $typeNames = $types->pluck('name', 'id');
            $catsById = $cats->keyBy('id');
        @endphp
        <div class="col-md-4"><label class="form-label">Asset type *</label><select name="asset_type_id" id="t" class="form-select" required><option value="">Select…</option>@foreach($types as $c)<option value="{{ $c->id }}" @selected(old('asset_type_id', $equipment->asset_type_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Category *</label><select name="category_id" id="c" class="form-select" required><option value="">Select…</option>@foreach($cats as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" data-path="{{ $typeNames[$c->parent_id] ?? '' }}" @selected(old('category_id', $equipment->category_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Sub category</label><select name="subcategory_id" id="s" class="form-select"><option value="">—</option>@foreach($subs as $c)@php($pc = $catsById[$c->parent_id] ?? null)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" data-path="{{ $pc ? collect([$typeNames[$pc->parent_id] ?? null, $pc->name])->filter()->implode(' › ') : '' }}" @selected(old('subcategory_id', $equipment->subcategory_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-12 form-text mt-0">Pick a sub category or a category and the ones above it are filled in for you. Search in Category and Sub category by typing.</div>

        <div class="col-md-6"><label class="form-label">Brand</label><input name="brand" value="{{ old('brand', $equipment->brand) }}" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">Model</label><input name="model" value="{{ old('model', $equipment->model) }}" class="form-control"></div>
        <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" rows="2" class="form-control">{{ old('notes', $equipment->notes) }}</textarea></div>
        @if($equipment->exists)
        <div class="col-12"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="is_active" value="1" id="act" @checked(old('is_active', $equipment->is_active))><label class="form-check-label" for="act">Active <span class="text-muted small">· inactive equipment cannot be received or allocated</span></label></div></div>
        @endif
    </div></div>
    <div class="card-footer d-flex flex-wrap gap-2"><button class="btn btn-primary"><x-icon name="check" :size="15"/> Save</button><a href="{{ $equipment->exists ? route('inv.equipment.show', $equipment) : route('inv.equipment.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
</div>
</form>
@push('scripts')
<script>
(function () {
    var T = document.getElementById('t'), C = document.getElementById('c'), S = document.getElementById('s');

    // The parent id stored on the chosen option ('' when nothing is chosen).
    function parentOf(sel) { var o = sel.selectedOptions[0]; return o && o.value ? o.dataset.p : ''; }
    function refresh() { [C, S].forEach(function (x) { x.dispatchEvent(new Event('ss:refresh')); }); hint(); }

    // Every asset type, category and sub category is always listed. Picking a lower level fills in the ones above it.
    T.addEventListener('change', function () {
        if (C.value && parentOf(C) !== T.value) { C.value = ''; S.value = ''; }
        refresh();
    });
    C.addEventListener('change', function () {
        if (C.value) {
            T.value = parentOf(C);
            if (S.value && parentOf(S) !== C.value) S.value = '';
        } else {
            S.value = '';
        }
        refresh();
    });
    S.addEventListener('change', function () {
        if (S.value) { C.value = parentOf(S); T.value = parentOf(C); }
        refresh();
    });

    // Searchable select: the real <select> stays in the form (hidden), a button + search box sit on top of it.
    function searchable(sel, emptyLabel) {
        var wrap = document.createElement('div'); wrap.className = 'ss';
        sel.parentNode.insertBefore(wrap, sel); wrap.appendChild(sel);
        sel.classList.add('ss-native'); sel.tabIndex = -1;
        var btn = document.createElement('button'); btn.type = 'button'; btn.className = 'form-select ss-btn';
        var panel = document.createElement('div'); panel.className = 'ss-panel'; panel.hidden = true;
        var box = document.createElement('input'); box.type = 'search'; box.className = 'form-control form-control-sm'; box.placeholder = 'Search…'; box.autocomplete = 'off';
        var list = document.createElement('div'); list.className = 'ss-list';
        panel.appendChild(box); panel.appendChild(list); wrap.appendChild(btn); wrap.appendChild(panel);
        var hl = -1;

        function label() {
            var o = sel.selectedOptions[0], has = o && o.value;
            btn.textContent = has ? o.textContent.trim() : emptyLabel;
            btn.classList.toggle('ss-placeholder', !has);
        }
        function items() { return list.querySelectorAll('.ss-item'); }
        function mark(i) {
            var its = items(); if (!its.length) return;
            hl = (i + its.length) % its.length;
            its.forEach(function (x, k) { x.classList.toggle('hl', k === hl); });
            its[hl].scrollIntoView({ block: 'nearest' });
        }
        function render() {
            var q = box.value.trim().toLowerCase(), shown = 0;
            list.innerHTML = ''; hl = -1;
            Array.prototype.forEach.call(sel.options, function (o) {
                var txt = o.textContent.trim(), path = o.dataset.path || '';
                if (q && (!o.value || (txt + ' ' + path).toLowerCase().indexOf(q) < 0)) return;
                var it = document.createElement('div'), a = document.createElement('span'), b = document.createElement('small');
                it.className = 'ss-item' + (o.selected ? ' active' : ''); it.dataset.v = o.value;
                a.textContent = o.value ? txt : emptyLabel; b.textContent = path;
                it.appendChild(a); it.appendChild(b); list.appendChild(it);
                if (o.value) shown++;
            });
            if (!shown) { var n = document.createElement('div'); n.className = 'ss-none'; n.textContent = 'Nothing matches.'; list.appendChild(n); }
            var cur = list.querySelector('.ss-item.active'); if (cur && !q) mark(Array.prototype.indexOf.call(items(), cur));
        }
        function open() { panel.hidden = false; box.value = ''; render(); box.focus(); }
        function close() { panel.hidden = true; }
        function pick(v) { sel.value = v; sel.dispatchEvent(new Event('change', { bubbles: true })); label(); close(); btn.focus(); }

        btn.addEventListener('click', function () { panel.hidden ? open() : close(); });
        btn.addEventListener('keydown', function (e) { if (e.key === 'ArrowDown' || e.key === 'ArrowUp') { e.preventDefault(); open(); } });
        box.addEventListener('input', function () { render(); mark(0); });
        box.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') { e.preventDefault(); mark(hl + 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); mark(hl - 1); }
            else if (e.key === 'Enter') { e.preventDefault(); var its = items(); if (its[hl < 0 ? 0 : hl]) pick(its[hl < 0 ? 0 : hl].dataset.v); }
            else if (e.key === 'Escape') { e.preventDefault(); close(); btn.focus(); }
        });
        list.addEventListener('mousedown', function (e) { var it = e.target.closest('.ss-item'); if (it) { e.preventDefault(); pick(it.dataset.v); } });
        document.addEventListener('mousedown', function (e) { if (!wrap.contains(e.target)) close(); });
        sel.addEventListener('ss:refresh', label);
        label();
    }
    searchable(C, 'Select…');
    searchable(S, '—');

    function hint() {
        @unless($equipment->exists)
        var a = T.selectedOptions[0], b = C.selectedOptions[0];
        function f(o) { var m = o && o.value ? o.textContent.trim().match(/\p{L}/gu) : null; return m ? m.slice(0, 2).join('').toUpperCase() : ''; }
        document.getElementById('codehint').textContent = (f(a) && f(b)) ? 'Will start with ' + f(a) + f(b) + ' (e.g. ' + f(a) + f(b) + '0001), generated when saved.' : 'First 2 letters of asset type + first 2 letters of category + running number.';
        @endunless
    }
    hint();
})();
</script>
@endpush
@endsection
