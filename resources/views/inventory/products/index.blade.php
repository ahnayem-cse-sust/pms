@extends('layouts.app')
@section('title', 'Products & Stock')
@section('content')
@include('inventory._errors')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, code, brand, model"></div>
    <div class="col-6 col-md-2"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">All</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">Type</label><select name="type" class="form-select"><option value="">All</option><option value="ASSET" @selected(request('type') == 'ASSET')>Serialized</option><option value="CONSUMABLE" @selected(request('type') == 'CONSUMABLE')>Consumable</option></select></div>
    <div class="col-12 col-md-2 d-flex gap-3 align-items-center pt-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="low" value="1" id="lw" @checked(request('low'))><label for="lw" class="form-check-label">Low stock</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" name="inactive" value="1" id="ia" @checked(request('inactive'))><label for="ia" class="form-check-label">Inactive</label></div></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
        <a href="{{ route('inv.products.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success">CSV</a>
        @can('inv.update')<a href="{{ route('inv.products.create') }}" class="btn btn-success ms-md-auto">+ New product</a>@endcan</div>
</div></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Code</th><th>Product</th><th>Category</th><th>Type</th><th class="text-end">In stock</th><th class="text-end">Allocated</th><th>Where</th><th class="text-end">Minimum</th><th></th></tr></thead><tbody>
@forelse($rows as $p)
@php($qty = $p->type === 'ASSET' ? $p->in_stock_count : $p->on_hand_sum)
@php($low = $p->type === 'CONSUMABLE' && $p->min_stock > 0 && (float) $qty <= (float) $p->min_stock)
<tr class="{{ $p->is_active ? '' : 'text-muted' }}"><td>{{ $p->code }}</td><td>{{ $p->name }}<div class="text-muted small">{{ $p->brand }} {{ $p->model }}</div></td><td>{{ $p->category->name ?? '' }}</td>
<td>{{ $p->type === 'ASSET' ? 'Serialized' : 'Consumable' }}</td>
<td class="text-end fw-semibold {{ $low ? 'text-danger' : '' }}">{{ \App\Support\Inv::qty($qty) }} {{ $p->unit }}@if($low) <span class="pill pill-danger">low</span>@endif</td>
<td class="text-end">@if($p->type === 'ASSET')<a href="{{ route('inv.assets.index', ['q' => $p->name, 'status' => 'ALLOCATED']) }}">{{ $p->allocated_count }}</a>@else —@endif</td>
<td class="small">@if($p->type === 'CONSUMABLE')@foreach($p->stock->where('qty', '>', 0) as $s){{ $s->location->name }}: {{ \App\Support\Inv::qty($s->qty) }}@if(! $loop->last), @endif @endforeach @endif</td>
<td class="text-end">{{ $p->type === 'CONSUMABLE' ? \App\Support\Inv::qty($p->min_stock) : '' }}</td>
<td class="text-end text-nowrap">@can('inv.update')<a href="{{ route('inv.products.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
@if($p->type === 'CONSUMABLE')<button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#adj{{ $p->id }}">Correct</button>@endif @endcan</td></tr>
@if($p->type === 'CONSUMABLE')@can('inv.update')<tr class="collapse" id="adj{{ $p->id }}"><td colspan="9" class="bg-light"><form method="POST" action="{{ route('inv.products.adjust', $p) }}" class="row g-2">@csrf
    <div class="col-md-3"><select name="location_id" class="form-select form-select-sm" required>@foreach($locations as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach</select></div>
    <div class="col-md-2"><input type="number" step="0.01" name="qty" class="form-control form-control-sm" placeholder="+ add / − remove" required></div>
    <div class="col-md-5"><input name="reason" class="form-control form-control-sm" placeholder="Reason (count difference, damage, expiry …)" required></div><div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Save correction</button></div></form></td></tr>@endcan @endif
@empty<tr><td colspan="9" class="text-center text-muted py-4">No products yet.</td></tr>@endforelse</tbody></table>
@endsection
