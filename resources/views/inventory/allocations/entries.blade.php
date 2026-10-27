@extends('layouts.app')
@section('title', 'Allocation records')
@section('content')
@include('inventory._errors')
@include('inventory.allocations._tabs')
@php
    $activeFilters = collect(request()->only(['q', 'to_type', 'equipment_id', 'from', 'to']))->filter(fn ($v) => $v !== null && $v !== '')->count();
@endphp
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-6 col-xl-3"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Entry, person, department, item, serial, purpose"></div></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">Allocated to</label><select name="to_type" class="form-select"><option value="">All</option><option value="EMPLOYEE" @selected(request('to_type') == 'EMPLOYEE')>Employees</option><option value="DEPARTMENT" @selected(request('to_type') == 'DEPARTMENT')>Departments</option></select></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">Equipment</label><select name="equipment_id" class="form-select"><option value="">All</option>@foreach($equipment as $p)<option value="{{ $p->id }}" @selected(request('equipment_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-xl filter-btns"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Filter</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a><a href="{{ route('inv.allocations.entries', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success"><x-icon name="download" :size="15"/> CSV</a>
        @can('inv.create')<a href="{{ route('inv.allocations.create') }}" class="btn btn-success ms-xl-auto">+ Allocate equipment</a>@endcan</div>
</div></div></form>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Entry</th><th>Date</th><th>Allocated to</th><th>Equipment</th><th>Reference</th><th>By</th><th></th></tr></thead><tbody>
@forelse($entries as $en)
@php
    $ls = $lines[$en->entry_no];
    $f = $ls->first();
@endphp
<tr class="row-link" data-href="{{ route('inv.allocations.show', $en->entry_no) }}">
    <td class="text-nowrap"><div class="d-flex align-items-center gap-2"><span class="type-ico ti-primary"><x-icon name="arrow-up-right" :size="15"/></span><div><a href="{{ route('inv.allocations.show', $en->entry_no) }}" class="ticket-link">{{ $en->entry_no }}</a><div class="inv-sub">{{ $ls->count() }} {{ \Illuminate\Support\Str::plural('line', $ls->count()) }}</div></div></div></td>
    <td class="text-nowrap">{{ $f->moved_on->format('d M Y') }}</td>
    <td><div class="inv-holder">@if($f->holder_type === 'EMPLOYEE')<x-avatar :name="$f->holder_name" :user="$f->holderUser"/>@else<span class="dept-ico"><x-icon name="building" :size="14"/></span>@endif<div><div class="inv-name">{{ $f->holder_name }}</div>@if($f->holderUser)<div class="inv-sub">{{ $f->holderUser->department->name ?? '' }}</div>@endif</div></div></td>
    <td><div class="inv-items">
        @foreach($ls->take(3) as $m)<div class="inv-item"><span class="inv-name">{{ $m->equipment->name }}</span> <span class="inv-code">{{ $m->equipment->code }}</span> @if($m->serial_no)<strong class="inv-sn">S/N {{ $m->serial_no }}</strong>@else<span class="inv-q">{{ \App\Support\Inv::qty(abs($m->qty)) }} {{ $m->equipment->unit }}</span>@endif @if($m->remarks)<span class="inv-sub">· {{ $m->remarks }}</span>@endif</div>@endforeach
        @if($ls->count() > 3)<span class="inv-more" title="{{ $ls->slice(3)->map(fn ($m) => $m->equipment->name)->implode(', ') }}">+{{ $ls->count() - 3 }} more</span>@endif
    </div></td>
    <td>{{ $f->reference_no ?: '—' }}</td>
    <td>{{ $f->user->name ?? '' }}</td>
    <td class="text-end"><div class="inv-actions-cell"><a class="btn btn-sm btn-outline-primary" href="{{ route('inv.allocations.show', $en->entry_no) }}"><x-icon name="eye" :size="14"/> View</a><a class="btn btn-sm btn-outline-secondary" href="{{ route('inv.allocations.pdf', $en->entry_no) }}"><x-icon name="file-text" :size="14"/> PDF</a></div></td>
</tr>
@empty
<tr><td colspan="7">@if($activeFilters)@include('inventory._empty', ['icon' => 'search', 'msg' => 'No allocations match these filters', 'hint' => 'Try a different search, or reset the filters.'])@else @can('inv.create')@include('inventory._empty', ['icon' => 'clipboard', 'msg' => 'No allocations yet', 'ctaUrl' => route('inv.allocations.create'), 'ctaLabel' => '+ Allocate equipment'])@else @include('inventory._empty', ['icon' => 'clipboard', 'msg' => 'No allocations yet'])@endcan @endif</td></tr>
@endforelse</tbody></table></div></div>
<div class="mt-3">{{ $entries->links() }}</div>
@include('inventory._rowlink')
@endsection
