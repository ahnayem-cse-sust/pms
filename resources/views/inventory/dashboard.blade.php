@extends('layouts.app')
@section('title', 'Inventory')
@section('content')
@include('inventory._errors')
<div class="row g-3 mb-3">
@foreach($stats as $label => $n)<div class="col-6 col-md-3"><div class="stat-card"><div><div class="text-muted small">{{ $label }}</div><div class="fs-3 fw-bold">{{ \App\Support\Inv::qty($n) }}</div></div></div></div>@endforeach
</div>
<div class="d-flex flex-wrap gap-2 mb-3">
    @can('inv.create')<a href="{{ route('inv.receive') }}" class="btn btn-success">+ Receive item</a><a href="{{ route('inv.allocations.create') }}" class="btn btn-primary">+ Allocate equipment</a>@endcan
    <a href="{{ route('inv.allocations.index') }}" class="btn btn-outline-secondary">Who has what</a><a href="{{ route('inv.records') }}" class="btn btn-outline-secondary">All records</a>
</div>
<div class="row g-3">
    <div class="col-lg-5"><div class="card h-100"><div class="card-header">Needs attention</div><div class="card-body small">
        @foreach($out as $e)<div class="d-flex justify-content-between border-bottom py-1"><span>{{ $e->name }}</span><span class="pill pill-danger">Out of stock</span></div>@endforeach
        @foreach($low as $e)<div class="d-flex justify-content-between border-bottom py-1"><span>{{ $e->name }}</span><span class="pill pill-warning">{{ \App\Support\Inv::qty($e->stock_qty) }} left (min {{ \App\Support\Inv::qty($e->min_stock) }})</span></div>@endforeach
        @if($out->isEmpty() && $low->isEmpty())<div class="text-muted">Everything is above its minimum level.</div>@endif
    </div></div></div>
    <div class="col-lg-7"><div class="card h-100"><div class="card-header">Latest records</div><div class="card-body small">
        @forelse($recent as $m)<div class="d-flex justify-content-between border-bottom py-1 gap-2"><span>{{ \App\Support\Inv::pill($m->type) }} {{ \App\Support\Inv::qty(abs($m->qty)) }} × {{ $m->equipment->name }} @if($m->holder_name)· {{ $m->holder_name }}@endif</span><span class="text-muted text-nowrap">{{ $m->moved_on->format('d M') }}</span></div>
        @empty<div class="text-muted">Nothing recorded yet. Add equipment, then receive items.</div>@endforelse
    </div></div></div>
</div>
@endsection
