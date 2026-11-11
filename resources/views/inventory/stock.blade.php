@extends('layouts.app')
@section('title', 'Stock report')
@section('content')
<div class="mb-3"><a href="{{ route('inv.reports') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Reports</a></div>
@php $q = fn ($n) => \App\Support\Inv::qty($n); $badge = ['ok' => ['In stock', 'success'], 'low' => ['Low stock', 'warning'], 'out' => ['Out of stock', 'danger']]; @endphp
<form method="GET" class="card filter-card mb-3"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-4 col-xl-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Equipment ID, name, brand, model, sub category"></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Asset type</label><select name="asset_type_id" class="form-select"><option value="">All</option>@foreach($types as $c)<option value="{{ $c->id }}" @selected(request('asset_type_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">All</option>@foreach($cats as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Sub category</label><select name="subcategory_id" class="form-select"><option value="">All</option>@foreach($subs as $c)<option value="{{ $c->id }}" @selected(request('subcategory_id') == $c->id)>{{ $c->name }}@php $par = $cats->firstWhere('id', $c->parent_id); @endphp @if($par) ({{ $par->name }})@endif</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option><option value="ok" @selected($status === 'ok')>In stock</option><option value="low" @selected($status === 'low')>Low stock</option><option value="out" @selected($status === 'out')>Out of stock</option></select></div>
    <div class="col-12 filter-btns">
        <button class="btn btn-primary"><x-icon name="search" :size="15"/> Show report</button>
        <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
        <a class="btn btn-outline-success ms-sm-auto" href="{{ route('inv.stock', array_merge(request()->query(), ['format' => 'csv'])) }}"><x-icon name="download" :size="15"/> Export CSV</a>
        <a class="btn btn-outline-primary" href="{{ route('inv.stock', array_merge(request()->query(), ['format' => 'pdf'])) }}"><x-icon name="download" :size="15"/> Download PDF</a>
    </div>
</div></div></form>

<div class="inv-summary">
    <span class="inv-chip">Items <strong>{{ $counts['items'] }}</strong></span>
    <span class="inv-chip">In store <strong>{{ $q($totals['store']) }}</strong></span>
    <span class="inv-chip">With employees / departments <strong>{{ $q($totals['use']) }}</strong></span>
    <span class="inv-chip warn">Low stock <strong>{{ $counts['low'] }}</strong></span>
    <span class="inv-chip bad">Out of stock <strong>{{ $counts['out'] }}</strong></span>
    <span class="ms-auto text-muted">As of {{ $asOf->format('d M Y h:i A') }}</span>
</div>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle">
<thead><tr><th>Equipment ID</th><th>Equipment</th><th>Category</th><th>Sub category</th><th class="text-end">In store</th><th class="text-end">With people</th><th class="text-end">Total</th><th class="text-end">Minimum</th><th>Status</th></tr></thead>
<tbody>
@forelse($rows as $x)
<tr><td class="text-nowrap"><span class="inv-code">{{ $x->equipment->code }}</span></td><td><div class="inv-name">{{ $x->equipment->name }}</div></td><td>{{ $x->equipment->category->name ?? '—' }}</td><td>{{ $x->equipment->subcategory->name ?? '—' }}</td>
<td class="text-end"><strong>{{ $q($x->store) }}</strong></td><td class="text-end">{{ $q($x->use) }}</td><td class="text-end">{{ $q($x->total) }}</td><td class="text-end text-muted">{{ $x->min > 0 ? $q($x->min) : '—' }}</td>
<td><span class="badge text-bg-{{ $badge[$x->status][1] }}">{{ $badge[$x->status][0] }}</span></td></tr>
@empty
<tr><td colspan="9" class="text-center text-muted py-4">No equipment matches.</td></tr>
@endforelse
</tbody>
@if($rows->count())<tfoot><tr class="fw-semibold"><td colspan="4">Total</td><td class="text-end">{{ $q($totals['store']) }}</td><td class="text-end">{{ $q($totals['use']) }}</td><td class="text-end">{{ $q($totals['total']) }}</td><td colspan="2"></td></tr></tfoot>@endif
</table></div></div>
<div class="small text-muted mt-2">In store = available now. With people = allocated to employees or departments and not yet returned. Total = In store + With people.</div>
@endsection
