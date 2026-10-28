@extends('layouts.app')
@section('title', 'Equipment & Stock')
@section('content')
@include('inventory._errors')
@php
    $activeFilters = collect(request()->only(['q', 'asset_type_id', 'category_id', 'subcategory_id', 'low', 'inactive']))->filter(fn ($v) => $v !== null && $v !== '')->count();
@endphp
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-4 col-xl-3"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Equipment ID, name, brand, model"></div></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Asset type</label><select name="asset_type_id" id="ft" class="form-select" onchange="fs()"><option value="">All</option>@foreach($types as $c)<option value="{{ $c->id }}" @selected(request('asset_type_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Category</label><select name="category_id" id="fc" class="form-select" onchange="fs()"><option value="">All</option>@foreach($cats as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Sub category</label><select name="subcategory_id" id="fsub" class="form-select"><option value="">All</option>@foreach($subs as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(request('subcategory_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-12 col-md-auto d-flex flex-wrap gap-3 align-items-center">
        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="inactive" value="1" id="ia" @checked(request('inactive'))><label for="ia" class="form-check-label">Inactive</label></div>
    </div>
    <div class="col-12 filter-btns"><div class="fb-main"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a></div><div class="fb-side"><a href="{{ route('inv.equipment.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-secondary"><x-icon name="download" :size="15"/> CSV</a>@can('inv.update')<a href="{{ route('inv.equipment.create') }}" class="btn btn-success">+ New equipment</a>@endcan</div></div>
</div></div></form>

<div class="inv-summary">
    <span><strong class="text-body">{{ $rows->count() }}</strong> {{ \Illuminate\Support\Str::plural('item', $rows->count()) }}</span>
</div>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Equipment ID</th><th>Equipment name</th><th>Asset type</th><th>Category</th><th>Sub category</th><th class="text-end">Stock</th><th></th></tr></thead><tbody>
@forelse($rows as $e)
<tr class="row-link {{ ! $e->is_active ? 'row-off' : '' }}" data-href="{{ route('inv.equipment.show', $e) }}">
    <td class="text-nowrap"><a href="{{ route('inv.equipment.show', $e) }}" class="ticket-link inv-code">{{ $e->code }}</a></td>
    <td style="min-width:200px"><div class="inv-name">{{ $e->name }}</div>@if(! $e->is_active)<span class="pill pill-secondary">Inactive</span>@endif</td>
    <td>{{ $e->assetType->name ?? '—' }}</td>
    <td>{{ $e->category->name ?? '—' }}</td>
    <td>{{ $e->subcategory->name ?? '—' }}</td>
    <td class="text-end text-nowrap"><span class="inv-stock inv-num">{{ \App\Support\Inv::qty($e->stock_qty) }}</span> <span class="text-muted">{{ $e->unit }}</span></td>
    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('inv.equipment.show', $e) }}"><x-icon name="eye" :size="14"/> View</a></td>
</tr>
@empty
<tr><td colspan="7">
    @if($activeFilters)
        @include('inventory._empty', ['icon' => 'search', 'msg' => 'No equipment matches these filters', 'hint' => 'Try a different search, or reset the filters.'])
    @else
        @can('inv.update')
            @include('inventory._empty', ['icon' => 'box', 'msg' => 'No equipment yet', 'hint' => 'Add the first item, then receive stock for it.', 'ctaUrl' => route('inv.equipment.create'), 'ctaLabel' => '+ New equipment'])
        @else
            @include('inventory._empty', ['icon' => 'box', 'msg' => 'No equipment yet'])
        @endcan
    @endif
</td></tr>
@endforelse</tbody></table></div></div>
@include('inventory._rowlink')
@push('scripts')
<script>
function narrow(sel, parent) { Array.prototype.forEach.call(sel.options, function (o) { if (!o.dataset.p) return; o.hidden = !!parent && o.dataset.p !== parent; if (o.hidden && o.selected) sel.value = ''; }); }
function fs() { narrow(document.getElementById('fc'), document.getElementById('ft').value); narrow(document.getElementById('fsub'), document.getElementById('fc').value); }
fs();
</script>
@endpush
@endsection
