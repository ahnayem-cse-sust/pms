@extends('layouts.app')
@section('title', 'Allocations')
@section('content')
@include('inventory._errors')
@include('inventory.allocations._tabs')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-6 col-xl-4"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Person, department, equipment"></div></div>
    <div class="col-12 col-xl filter-btns"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if(request('q'))<span class="filter-count">1</span>@endif</a><a href="{{ route('inv.allocations.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success"><x-icon name="download" :size="15"/> CSV</a>
        @can('inv.create')<a href="{{ route('inv.allocations.create') }}" class="btn btn-success ms-xl-auto">+ Allocate equipment</a>@endcan</div>
</div></div></form>

<div class="inv-summary">
    <span><strong class="text-body">{{ $rows->count() }}</strong> {{ \Illuminate\Support\Str::plural('holding', $rows->count()) }}</span>
    <span>held by <strong class="text-body">{{ $rows->pluck('holder')->unique()->count() }}</strong></span>
</div>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Held by</th><th>Equipment</th><th>Classification</th><th class="text-end">Quantity</th><th>Since</th><th></th></tr></thead><tbody>
@forelse($rows as $x)
<tr>
    <td><div class="inv-holder">@if($x->holder_type === 'EMPLOYEE')<x-avatar :name="$x->holder"/>@else<span class="dept-ico"><x-icon name="building" :size="14"/></span>@endif<div><div class="inv-name">{{ $x->holder }}</div>@if($x->dept)<div class="inv-sub">{{ $x->dept }}</div>@endif</div></div></td>
    <td style="min-width:200px"><div class="inv-name">{{ $x->equipment->name }}</div><div class="inv-sub"><span class="inv-code">{{ $x->equipment->code }}</span>@if($x->serial_no) <span class="inv-sn">Asset ID {{ $x->serial_no }}</span>@endif @if($x->device_sn)<span class="inv-sn">· Serial {{ $x->device_sn }}</span>@endif</div></td>
    <td>@include('inventory._crumb', ['e' => $x->equipment])</td>
    <td class="text-end"><span class="inv-q">{{ \App\Support\Inv::qty($x->held) }}</span> <span class="text-muted">{{ $x->equipment->unit }}</span></td>
    <td class="text-nowrap">{{ $x->since ? \Illuminate\Support\Carbon::parse($x->since)->format('d M Y') : '' }}</td>
    <td class="text-end">@can('inv.create')<a class="btn btn-sm btn-outline-primary inv-actions-cell" href="{{ route('inv.receive', ['from' => ($x->holder_type === 'EMPLOYEE' ? 'E:'.$x->holder_user_id : 'D:'.$x->holder_department_id), 'equipment_id' => $x->equipment_id, 'serial' => $x->serial_no]) }}"><x-icon name="corner-up-left" :size="14"/> Return</a>@endcan</td>
</tr>
@empty
<tr><td colspan="6">@if(request('q'))@include('inventory._empty', ['icon' => 'search', 'msg' => 'No holdings match your search', 'hint' => 'Try a different name or equipment.'])@else @can('inv.create')@include('inventory._empty', ['icon' => 'users', 'msg' => 'Nothing is allocated', 'hint' => 'Allocate equipment to an employee or a department to see it here.', 'ctaUrl' => route('inv.allocations.create'), 'ctaLabel' => '+ Allocate equipment'])@else @include('inventory._empty', ['icon' => 'users', 'msg' => 'Nothing is allocated'])@endcan @endif</td></tr>
@endforelse</tbody></table></div></div>
@endsection
