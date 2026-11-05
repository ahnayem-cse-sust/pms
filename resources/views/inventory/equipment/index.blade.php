@extends('layouts.app')
@section('title', 'Equipment & Stock')
@section('content')
@include('inventory._errors')
@php
    $activeFilters = collect(request()->only(['q', 'asset_type_id', 'category_id', 'subcategory_id', 'low']))->filter(fn ($v) => $v !== null && $v !== '')->count() + ($tab !== 'instock' ? 1 : 0);
@endphp
<form class="card filter-card mb-3" method="GET"><input type="hidden" name="tab" value="{{ $tab }}"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-4 col-xl-3"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Equipment ID, name, brand, model" autofocus></div></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Asset type</label><select name="asset_type_id" id="ft" class="form-select" onchange="fs(); this.form.submit()"><option value="">All</option>@foreach($types as $c)<option value="{{ $c->id }}" @selected(request('asset_type_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Category</label><select name="category_id" id="fc" class="form-select" onchange="fs(); this.form.submit()"><option value="">All</option>@foreach($cats as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Sub category</label><select name="subcategory_id" id="fsub" class="form-select" onchange="this.form.submit()"><option value="">All</option>@foreach($subs as $c)<option value="{{ $c->id }}" data-p="{{ $c->parent_id }}" @selected(request('subcategory_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-12 filter-btns"><div class="fb-main"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a></div><div class="fb-side"><a href="{{ route('inv.equipment.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-secondary"><x-icon name="download" :size="15"/> CSV</a>@can('inv.update')<a href="{{ route('inv.equipment.create') }}" class="btn btn-success">+ New equipment</a>@endcan</div></div>
</div></div></form>

@php
    $tabUrl = fn ($t) => route('inv.equipment.index', collect(request()->except(['page', 'tab', 'low']))->filter(fn ($v) => $v !== null && $v !== '')->all() + ['tab' => $t]);
    $cur = request()->boolean('low') && ! request('tab') ? '' : $tab;
@endphp
<div class="inv-summary">
    <a href="{{ $tabUrl('all') }}" class="inv-chip {{ $cur === 'all' ? 'active' : '' }}">All <strong>{{ $tabs['all'] }}</strong></a>
    <a href="{{ $tabUrl('active') }}" class="inv-chip {{ $cur === 'active' ? 'active' : '' }}">Active <strong>{{ $tabs['active'] }}</strong></a>
    <a href="{{ $tabUrl('inactive') }}" class="inv-chip {{ $cur === 'inactive' ? 'active' : '' }}">Inactive <strong>{{ $tabs['inactive'] }}</strong></a>
    <a href="{{ $tabUrl('instock') }}" class="inv-chip {{ $cur === 'instock' ? 'active' : '' }}">In stock <strong>{{ $tabs['instock'] }}</strong></a>
    <a href="{{ $tabUrl('low') }}" class="inv-chip warn {{ $cur === 'low' ? 'active' : '' }}">Low stock <strong>{{ $tabs['low'] }}</strong></a>
    <a href="{{ $tabUrl('out') }}" class="inv-chip bad {{ $cur === 'out' ? 'active' : '' }}">Out of stock <strong>{{ $tabs['out'] }}</strong></a>
    <span class="ms-auto">Showing <strong class="text-body">{{ $rows->total() }}</strong> {{ \Illuminate\Support\Str::plural('item', $rows->total()) }}</span>
</div>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Equipment ID</th><th>Equipment name</th><th>Asset type</th><th>Category</th><th>Sub category</th><th class="text-end">Stock</th><th></th></tr></thead><tbody>
@forelse($rows as $e)
<tr class="row-link {{ ! $e->is_live ? 'row-off' : '' }}" data-href="{{ route('inv.equipment.show', $e) }}">
    <td class="text-nowrap"><a href="{{ route('inv.equipment.show', $e) }}" class="ticket-link inv-code">{{ $e->code }}</a></td>
    <td style="min-width:200px"><div class="inv-name">{{ $e->name }}</div>@if(! $e->is_live)<span class="pill pill-secondary">Inactive</span>@endif</td>
    <td>{{ $e->assetType->name ?? '—' }}</td>
    <td>{{ $e->category->name ?? '—' }}</td>
    <td>{{ $e->subcategory->name ?? '—' }}</td>
    @php($state = \App\Support\Inv::state($e->stock_qty, $e->min_stock))
    <td class="text-end text-nowrap"><span class="inv-stock inv-num is-{{ $state }}">{{ \App\Support\Inv::qty($e->stock_qty) }}</span> <span class="text-muted">{{ $e->unit }}</span>@if($state !== 'ok')<div><span class="inv-chip {{ $state === 'out' ? 'bad' : 'warn' }}" style="padding:.02rem .45rem;font-size:.68rem">{{ $state === 'out' ? 'Out of stock' : 'Low stock' }}</span></div>@endif @include('inventory._meter', ['e' => $e])</td>
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
<div class="mt-3">{{ $rows->links() }}</div>
@include('inventory._rowlink')
@push('scripts')
<script>
function narrow(sel, parent) {
    var keep = sel.value;
    sel._all = sel._all || Array.prototype.map.call(sel.options, function (o) { return o.cloneNode(true); });
    sel.innerHTML = '';
    sel._all.forEach(function (o) { if (!o.dataset.p || !parent || o.dataset.p === parent) sel.appendChild(o.cloneNode(true)); });
    sel.value = keep; if (sel.value !== keep) sel.value = '';
}
function fs() { narrow(document.getElementById('fc'), document.getElementById('ft').value); narrow(document.getElementById('fsub'), document.getElementById('fc').value); }
fs();
</script>
@endpush
@endsection
