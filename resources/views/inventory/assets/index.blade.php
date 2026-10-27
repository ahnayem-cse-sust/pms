@extends('layouts.app')
@section('title', auth()->user()->can('inv.view') ? 'Assets' : 'My Items')
@section('content')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Asset code, serial, product"></div>
    <div class="col-6 col-md-2"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option>@foreach(config('inventory.asset_statuses') as $k => $l)<option value="{{ $k }}" @selected(request('status') == $k)>{{ $l }}</option>@endforeach</select></div>
    @can('inv.view')
    <div class="col-6 col-md-2"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">All</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">All</option>@foreach($departments as $c)<option value="{{ $c->id }}" @selected(request('department_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">Held by</label><input name="employee" value="{{ request('employee') }}" class="form-control" placeholder="Employee name"></div>
    @endcan
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>@can('inv.view')<a href="{{ route('inv.assets.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success">CSV</a>@endcan</div>
</div></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Asset code</th><th>Product</th><th>Serial</th><th>Status</th><th>Store</th><th>Held by</th><th>Since</th><th>Warranty</th></tr></thead><tbody>
@forelse($rows as $a)<tr><td><a href="{{ route('inv.assets.show', $a) }}">{{ $a->asset_code }}</a></td><td>{{ $a->product->name }}</td><td>{{ $a->serial_no }}</td><td>{{ \App\Support\Inv::pill($a->status) }}</td><td>{{ $a->status === 'ALLOCATED' ? '' : ($a->location->name ?? '') }}</td><td>{{ $a->holder_name }}</td><td>{{ $a->allocated_at?->format('d M Y') }}</td>
<td>@if($a->warranty_end)<span class="{{ $a->warranty_end->isPast() ? 'text-danger' : '' }}">{{ $a->warranty_end->format('d M Y') }}</span>@endif</td></tr>
@empty<tr><td colspan="8" class="text-center text-muted py-4">Nothing found.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}
@endsection
