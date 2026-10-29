@extends('layouts.app')
@section('title', 'Asset Types & Categories')
@section('content')
@include('inventory._errors')
@php
    $names = ['types' => ['Asset types', 'asset type', 'folder', 1], 'categories' => ['Categories', 'category', 'list', 2], 'subcategories' => ['Sub categories', 'sub category', 'list', 3]];
    $parentLabel = ['categories' => 'Asset type', 'subcategories' => 'Category'][$kind] ?? '';
    $cols = 3;
    $keep = request()->only('type_id', 'category_id');   // filters survive edit / cancel
    $selectedCategory = $level === 3 ? $parents->firstWhere('id', (int) old('parent_id', $edit?->parent_id)) : null;
@endphp
<div class="inv-tabs">@foreach($names as $k => $n)<a class="inv-tab {{ $kind === $k ? 'active' : '' }}" href="{{ route('inv.setup', $k) }}"><x-icon :name="$n[2]" :size="15"/> {{ $n[0] }}<span class="n">{{ $counts[$n[3]] ?? 0 }}</span></a>@endforeach</div>
<div class="inv-flow">Equipment is classified as <b>Asset type</b><span class="sep">›</span><b>Category</b><span class="sep">›</span><b>Sub category</b> <span>e.g. Computing › Laptop › Business laptop. Create them in that order.</span></div>

@can('inv.update')
<form method="POST" action="{{ $edit ? route('inv.setup.update', [$kind, $edit->id]) : route('inv.setup.store', $kind) }}" class="card mb-3"><div class="card-body">@csrf @if($edit) @method('PUT') @endif
    <div class="row g-2 align-items-end">
    @if($level === 2)
        <div class="col-md-4"><label class="form-label">Asset type *</label><select name="parent_id" class="form-select" required><option value="">Select…</option>
            @foreach($parents as $p)<option value="{{ $p->id }}" @selected(old('parent_id', $edit?->parent_id) == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    @elseif($level === 3)
        <div class="col-md-3"><label class="form-label">Asset type</label><input type="text" id="subType" class="form-control" value="{{ $selectedCategory?->parent?->name }}" placeholder="Filled from the category" readonly tabindex="-1" style="background:var(--bs-secondary-bg, #f1f3f5)"></div>
        <div class="col-md-3"><label class="form-label">Category *</label><select name="parent_id" id="subCategory" class="form-select" required><option value="">Select…</option>
            @foreach($parents as $p)<option value="{{ $p->id }}" data-type="{{ $p->parent->name ?? '' }}" @selected(old('parent_id', $edit?->parent_id) == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    @endif
    <div class="col-md-{{ $level === 3 ? 3 : 4 }}"><label class="form-label">{{ $edit ? 'Edit' : 'Add' }} {{ $names[$kind][1] }} *</label><input name="name" value="{{ old('name', $edit?->name) }}" class="form-control" required></div>
    @if($level === 2)<div class="col-md-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="is_serialized" value="1" id="sr" @checked(old('is_serialized', $edit?->is_serialized))><label class="form-check-label" for="sr">Serialisable <span class="text-muted small">(each unit has an Asset ID)</span></label></div></div>@endif
    @if($edit)<div class="col-md-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="is_active" value="1" id="a" @checked(old('is_active', $edit->is_active))><label class="form-check-label" for="a">Active</label></div></div>@endif
    <div class="col-md-3 d-flex gap-2"><button class="btn btn-primary">{{ $edit ? 'Save changes' : '+ Add' }}</button>@if($edit)<a href="{{ route('inv.setup', array_merge([$kind], $keep)) }}" class="btn btn-outline-secondary">Cancel</a>@endif</div></div></div></form>
@endcan

@if($level > 1)
<form method="GET" action="{{ route('inv.setup', $kind) }}" class="card filter-card mb-3"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-6 col-md-3 col-xl-3"><label class="form-label">Asset type</label><select name="type_id" id="fType" class="form-select"><option value="">All</option>
        @foreach($filterTypes as $t)<option value="{{ $t->id }}" @selected($typeId == $t->id)>{{ $t->name }}</option>@endforeach</select></div>
    @if($level === 3)
    <div class="col-6 col-md-3 col-xl-3"><label class="form-label">Category</label><select name="category_id" id="fCategory" class="form-select"><option value="">All</option>
        @foreach($filterCategories as $c)<option value="{{ $c->id }}" data-type="{{ $c->parent_id }}" @selected($categoryId == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    @endif
    <div class="col-12 col-md filter-btns"><div class="fb-main"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Filter</button><a href="{{ route('inv.setup', $kind) }}" class="btn btn-outline-secondary">Reset</a></div></div>
</div></div></form>
@endif

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Name</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($rows as $r)
@php
    $used = (int) ($items[$r->id] ?? 0);
    $child = (int) ($kids[$r->id] ?? 0);
    $why = $used ? 'In use by '.$used.' equipment '.\Illuminate\Support\Str::plural('item', $used).' – cannot be deleted' : ($child ? 'Has '.$child.' '.($level === 1 ? 'categories' : 'sub categories').' – delete them first' : '');
@endphp
<tr class="{{ $edit && $edit->id === $r->id ? 'row-edit' : '' }}"><td><div class="inv-name">{{ $r->name }}</div>@if($level > 1)<div class="inv-sub">{{ $level === 3 ? ($r->parent->parent->name ?? '').' › ' : '' }}{{ $r->parent->name ?? '' }}</div>@endif</td><td>{!! $r->is_active ? '<span class="pill pill-success">Active</span>' : '<span class="pill pill-secondary">Inactive</span>' !!}@if($level === 2 && $r->is_serialized) <span class="pill pill-info">Serialisable</span>@endif @if($used)<span class="pill pill-secondary">{{ $used }} equipment</span>@endif</td>
<td class="text-end">@can('inv.update')<div class="inv-actions-cell"><a href="{{ route('inv.setup', array_merge([$kind, 'edit' => $r->id], $keep)) }}" class="btn btn-sm btn-outline-primary"><x-icon name="edit" :size="14"/> Edit</a>
    <form method="POST" action="{{ route('inv.setup.destroy', [$kind, $r->id]) }}" class="d-inline" onsubmit="return confirm('Delete {{ $names[$kind][1] }} “{{ addslashes($r->name) }}”? This cannot be undone.');">@csrf @method('DELETE')<span @if($why) title="{{ $why }}" @endif><button class="btn btn-sm btn-outline-danger" @disabled($why !== '')><x-icon name="trash" :size="14"/> Delete</button></span></form></div>@endcan</td></tr>
@empty
<tr><td colspan="{{ $cols }}">@include('inventory._empty', ['icon' => 'folder', 'msg' => ($typeId || $categoryId) ? 'No '.strtolower($names[$kind][0]).' match this filter' : 'No '.strtolower($names[$kind][0]).' yet', 'hint' => ($typeId || $categoryId) ? 'Try a different filter, or reset it.' : ($level === 1 ? 'Start with an asset type such as Computing or Networking.' : 'Add one using the form above.')])</td></tr>
@endforelse</tbody></table></div></div>

@push('scripts')
<script>
(function () {
    // Sub category form: the asset type is read-only and follows the chosen category.
    var cat = document.getElementById('subCategory'), type = document.getElementById('subType');
    if (cat && type) {
        function showType() { var o = cat.options[cat.selectedIndex]; type.value = o && o.value ? (o.getAttribute('data-type') || '') : ''; }
        cat.addEventListener('change', showType); showType();
    }
    // Filter: the category list only offers the categories of the chosen asset type.
    var ft = document.getElementById('fType'), fc = document.getElementById('fCategory');
    if (ft && fc) {
        function narrow() {
            Array.prototype.forEach.call(fc.options, function (o) {
                if (!o.value) return;
                var ok = !ft.value || o.getAttribute('data-type') === ft.value;
                o.hidden = !ok; o.disabled = !ok;
                if (!ok && o.selected) fc.value = '';
            });
        }
        ft.addEventListener('change', narrow); narrow();
    }
})();
</script>
@endpush
@endsection
