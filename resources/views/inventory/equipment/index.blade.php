@extends('layouts.app')
@section('title', 'Equipment & Stock')
@section('content')
@include('inventory._errors')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, code, brand, model"></div>
    <div class="col-6 col-md-2"><label class="form-label">Asset type</label><select name="asset_type_id" id="ft" class="form-select" onchange="fs()"><option value="">All</option>@foreach($types as $c)<option value="{{ $c->id }}" @selected(request('asset_type_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">Category</label><select name="category_id" id="fc" class="form-select" onchange="fs()"><option value="">All</option>@foreach($cats as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">Sub category</label><select name="subcategory_id" id="fsub" class="form-select"><option value="">All</option>@foreach($subs as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(request('subcategory_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-12 col-md-1 d-flex flex-column gap-1 align-items-center pt-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="low" value="1" id="lw" @checked(request('low'))><label for="lw" class="form-check-label">Low stock</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" name="inactive" value="1" id="ia" @checked(request('inactive'))><label for="ia" class="form-check-label">Inactive</label></div></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
        <a href="{{ route('inv.equipment.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success">CSV</a>
        @can('inv.update')<a href="{{ route('inv.equipment.create') }}" class="btn btn-success ms-md-auto">+ New equipment</a>@endcan</div>
</div></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Code</th><th>Equipment</th><th>Asset type</th><th>Category</th><th>Sub category</th><th class="text-end">In stock</th><th class="text-end">Minimum</th><th></th></tr></thead><tbody>
@forelse($rows as $e)
<tr class="{{ $e->is_active ? '' : 'text-muted' }}"><td>{{ $e->code }}</td><td>{{ $e->name }}<div class="text-muted small">{{ $e->brand }} {{ $e->model }}</div></td><td>{{ $e->assetType->name ?? '' }}</td><td>{{ $e->category->name ?? '' }}@if($e->is_serialized) <span class="pill pill-info">serial</span>@endif</td><td>{{ $e->subcategory->name ?? '' }}</td>
<td class="text-end fw-semibold {{ $e->is_low ? 'text-danger' : '' }}">{{ \App\Support\Inv::qty($e->stock_qty) }} {{ $e->unit }}@if($e->is_low) <span class="pill pill-danger">low</span>@endif</td>
<td class="text-end">{{ \App\Support\Inv::qty($e->min_stock) }}</td>
<td class="text-end text-nowrap">@can('inv.update')<a href="{{ route('inv.equipment.edit', $e) }}" class="btn btn-sm btn-outline-primary">Edit</a>@endcan</td></tr>

@empty<tr><td colspan="8" class="text-center text-muted py-4">No equipment yet.</td></tr>@endforelse</tbody></table>
@push('scripts')
<script>
function narrow(sel, parent) { Array.prototype.forEach.call(sel.options, function (o) { if (!o.dataset.p) return; o.hidden = !!parent && o.dataset.p !== parent; if (o.hidden && o.selected) sel.value = ''; }); }
function fs() { narrow(document.getElementById('fc'), document.getElementById('ft').value); narrow(document.getElementById('fsub'), document.getElementById('fc').value); }
fs();
</script>
@endpush
@endsection
