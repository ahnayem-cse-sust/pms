@extends('layouts.app')
@section('title', 'Equipment & Stock')
@section('content')
@include('inventory._errors')
@php
    $activeFilters = collect(request()->only(['q', 'asset_type_id', 'category_id', 'subcategory_id', 'low', 'inactive']))->filter(fn ($v) => $v !== null && $v !== '')->count();
    $nOut = $rows->filter(fn ($e) => $e->is_active && \App\Support\Inv::state($e->stock_qty, $e->min_stock) === 'out')->count();
    $nLow = $rows->filter(fn ($e) => $e->is_active && \App\Support\Inv::state($e->stock_qty, $e->min_stock) === 'low')->count();
@endphp
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-4 col-xl-3"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, code, brand, model"></div></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Asset type</label><select name="asset_type_id" id="ft" class="form-select" onchange="fs()"><option value="">All</option>@foreach($types as $c)<option value="{{ $c->id }}" @selected(request('asset_type_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Category</label><select name="category_id" id="fc" class="form-select" onchange="fs()"><option value="">All</option>@foreach($cats as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Sub category</label><select name="subcategory_id" id="fsub" class="form-select"><option value="">All</option>@foreach($subs as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(request('subcategory_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-12 col-md-auto d-flex flex-wrap gap-3 align-items-center">
        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="low" value="1" id="lw" @checked(request('low'))><label for="lw" class="form-check-label">Low stock</label></div>
        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="inactive" value="1" id="ia" @checked(request('inactive'))><label for="ia" class="form-check-label">Inactive</label></div>
    </div>
    <div class="col-12 col-xl filter-btns"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a>
        <a href="{{ route('inv.equipment.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success"><x-icon name="download" :size="15"/> CSV</a>
        @can('inv.update')<a href="{{ route('inv.equipment.create') }}" class="btn btn-success ms-xl-auto">+ New equipment</a>@endcan</div>
</div></div></form>

<div class="inv-summary">
    <span><strong class="text-body">{{ $rows->count() }}</strong> {{ \Illuminate\Support\Str::plural('item', $rows->count()) }}</span>
    @if($nOut)<span class="inv-chip bad">{{ $nOut }} out of stock</span>@endif
    @if($nLow)<span class="inv-chip warn">{{ $nLow }} low</span>@endif
</div>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Equipment</th><th>Classification</th><th class="text-end">In stock</th><th class="text-end">Minimum</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($rows as $e)
@php
    $st = \App\Support\Inv::state($e->stock_qty, $e->min_stock);
    $bm = trim($e->brand.' '.$e->model);
@endphp
<tr class="{{ ! $e->is_active ? 'row-off' : ($st === 'out' ? 'row-out' : ($st === 'low' ? 'row-low' : '')) }}">
    <td style="min-width:220px"><div class="inv-name">{{ $e->name }}</div><div class="inv-sub"><span class="inv-code">{{ $e->code }}</span>@if($bm) · {{ $bm }}@endif</div></td>
    <td>@include('inventory._crumb', ['e' => $e])@if($e->is_serialized)<span class="pill pill-info mt-1">Serialisable</span>@endif</td>
    <td class="text-end"><div class="inv-stock inv-num is-{{ $st }}">{{ \App\Support\Inv::qty($e->stock_qty) }} <span class="text-muted fw-normal">{{ $e->unit }}</span></div>@include('inventory._meter', ['e' => $e])</td>
    <td class="text-end inv-num">{{ (float) $e->min_stock > 0 ? \App\Support\Inv::qty($e->min_stock) : '—' }}</td>
    <td>@if(! $e->is_active)<span class="pill pill-secondary">Inactive</span>@elseif($st === 'out')<span class="pill pill-danger">Out of stock</span>@elseif($st === 'low')<span class="pill pill-warning">Low stock</span>@else<span class="pill pill-success">In stock</span>@endif</td>
    <td class="text-end"><div class="inv-actions-cell"><a href="{{ route('inv.records', ['equipment_id' => $e->id]) }}" class="btn btn-sm btn-outline-secondary" title="Movement history"><x-icon name="clock" :size="14"/> History</a>@can('inv.update')<a href="{{ route('inv.equipment.edit', $e) }}" class="btn btn-sm btn-outline-primary"><x-icon name="edit" :size="14"/> Edit</a>@endcan</div></td>
</tr>
@empty
<tr><td colspan="6">
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
@push('scripts')
<script>
function narrow(sel, parent) { Array.prototype.forEach.call(sel.options, function (o) { if (!o.dataset.p) return; o.hidden = !!parent && o.dataset.p !== parent; if (o.hidden && o.selected) sel.value = ''; }); }
function fs() { narrow(document.getElementById('fc'), document.getElementById('ft').value); narrow(document.getElementById('fsub'), document.getElementById('fc').value); }
fs();
</script>
@endpush
@endsection
