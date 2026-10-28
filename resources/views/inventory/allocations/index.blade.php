@extends('layouts.app')
@section('title', 'Allocations')
@section('content')
@include('inventory._errors')
@include('inventory.allocations._tabs')
@php
    $activeFilters = collect(request()->only(['q', 'equipment_id', 'user_id', 'department_id']))->filter(fn ($v) => $v !== null && $v !== '')->count();
    $groups = $rows->groupBy(fn ($x) => $x->holder_type.'-'.($x->holder_type === 'EMPLOYEE' ? $x->holder_user_id : $x->holder_department_id));
@endphp
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-6 col-xl-3"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Person, department, equipment, asset ID"></div></div>
    <div class="col-12 col-md-6 col-xl-3"><label class="form-label">Equipment</label><select name="equipment_id" class="form-select"><option value="">All</option>@foreach($equipment as $p)<option value="{{ $p->id }}" @selected(request('equipment_id') == $p->id)>{{ $p->name }} ({{ $p->code }})</option>@endforeach</select></div>
    <div class="col-6 col-xl-3"><label class="form-label">Employee</label><select name="user_id" class="form-select"><option value="">All</option>@foreach($people as $p)<option value="{{ $p->id }}" @selected(request('user_id') == $p->id)>{{ $p->name }}@if($p->employee_id) ({{ $p->employee_id }})@endif</option>@endforeach</select></div>
    <div class="col-6 col-xl-3"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">All</option>@foreach($departments as $d)<option value="{{ $d->id }}" @selected(request('department_id') == $d->id)>{{ $d->name }}</option>@endforeach</select></div>
    <div class="col-12 filter-btns"><div class="fb-main"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a></div><div class="fb-side"><a href="{{ route('inv.allocations.index', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-secondary"><x-icon name="download" :size="15"/> CSV</a>@can('inv.create')<a href="{{ route('inv.allocations.create') }}" class="btn btn-success">+ Allocate equipment</a>@endcan</div></div>
</div></div></form>

<div class="inv-summary">
    <span>assigned to <strong class="text-body">{{ $groups->count() }}</strong></span>
    <span><strong class="text-body">{{ $rows->count() }}</strong> {{ \Illuminate\Support\Str::plural('holding', $rows->count()) }}</span>
    <span>total items <strong class="text-body">{{ \App\Support\Inv::qty($rows->sum('held')) }}</strong></span>
</div>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Assigned to</th><th class="text-end">Total items</th><th></th></tr></thead><tbody>
@forelse($groups as $key => $g)
@php $h = $g->first(); $url = route('inv.allocations.holder', ($h->holder_type === 'EMPLOYEE' ? 'E-'.$h->holder_user_id : 'D-'.$h->holder_department_id)); @endphp
<tr class="row-link" data-href="{{ $url }}">
    <td style="min-width:220px"><div class="inv-holder">@if($h->holder_type === 'EMPLOYEE')<x-avatar :name="$h->holder"/>@else<span class="dept-ico"><x-icon name="building" :size="14"/></span>@endif<div><a href="{{ $url }}" class="inv-name ticket-link">{{ $h->holder }}</a>@if($h->dept)<div class="inv-sub">{{ $h->dept }}</div>@endif</div></div></td>
    <td class="text-end"><span class="inv-q">{{ \App\Support\Inv::qty($g->sum('held')) }}</span></td>
    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ $url }}"><x-icon name="eye" :size="14"/> View</a></td>
</tr>
@empty
<tr><td colspan="3">@if($activeFilters)@include('inventory._empty', ['icon' => 'search', 'msg' => 'No holdings match these filters', 'hint' => 'Try a different search, or reset the filters.'])@else @can('inv.create')@include('inventory._empty', ['icon' => 'users', 'msg' => 'Nothing is allocated', 'hint' => 'Allocate equipment to an employee or a department to see it here.', 'ctaUrl' => route('inv.allocations.create'), 'ctaLabel' => '+ Allocate equipment'])@else @include('inventory._empty', ['icon' => 'users', 'msg' => 'Nothing is allocated'])@endcan @endif</td></tr>
@endforelse</tbody></table></div></div>
@include('inventory._rowlink')
@endsection
