@extends('layouts.app')
@section('title', 'Allocations')
@section('content')
@include('inventory._errors')
@include('inventory.allocations._tabs')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-4"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Person, department, equipment"></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a><a href="{{ route('inv.allocations.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success">CSV</a>
        @can('inv.create')<a href="{{ route('inv.allocations.create') }}" class="btn btn-success ms-md-auto">+ Allocate equipment</a>@endcan</div>
</div></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Held by</th><th>Equipment</th><th>Classification</th><th class="text-end">Quantity</th><th>Since</th><th></th></tr></thead><tbody>
@forelse($rows as $x)<tr><td>{{ $x->holder }}<div class="text-muted small">{{ $x->dept }}</div></td><td>{{ $x->equipment->name }}@if($x->serial_no)<div class="small text-muted">S/N {{ $x->serial_no }}</div>@endif</td><td class="small">{{ $x->equipment->classification }}</td>
<td class="text-end">{{ \App\Support\Inv::qty($x->held) }} {{ $x->equipment->unit }}</td><td>{{ $x->since ? \Illuminate\Support\Carbon::parse($x->since)->format('d M Y') : '' }}</td>
<td class="text-end">@can('inv.create')<a class="btn btn-sm btn-outline-primary" href="{{ route('inv.receive', ['from' => ($x->holder_type === 'EMPLOYEE' ? 'E:'.$x->holder_user_id : 'D:'.$x->holder_department_id), 'equipment_id' => $x->equipment_id, 'serial' => $x->serial_no]) }}">Return</a>@endcan</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-4">Nothing is allocated.</td></tr>@endforelse</tbody></table>
@endsection
