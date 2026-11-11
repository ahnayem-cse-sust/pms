@extends('layouts.app')
@section('title', 'Allocation records')
@section('content')
@include('inventory._errors')
@php
    $activeFilters = collect(request()->only(['q', 'to_type', 'equipment_id', 'from', 'to']))->filter(fn ($v) => $v !== null && $v !== '')->count();
@endphp
<div class="card inv-panel mb-3"><div class="filter-card">@include('inventory.allocations._tabs', ['csvRoute' => 'inv.allocations.entries', 'counts' => $tabCounts])
<form method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-6 col-xl-3"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Entry, person, department, office, item, asset ID, purpose"></div></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">Allocated to</label><select name="to_type" class="form-select"><option value="">All</option><option value="EMPLOYEE" @selected(request('to_type') == 'EMPLOYEE')>Employees</option><option value="DEPARTMENT" @selected(request('to_type') == 'DEPARTMENT')>Departments</option><option value="OFFICE" @selected(request('to_type') == 'OFFICE')>Offices</option></select></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">Equipment</label><select name="equipment_id" class="form-select"><option value="">All</option>@foreach($equipment as $p)<option value="{{ $p->id }}" @selected(request('equipment_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-xl filter-btns"><div class="fb-main"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Filter</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a></div></div>
</div></div></form>
@include('inventory._intro', ['text' => 'Each row is one allocation entry: equipment given to an employee, department or office.', 'tip' => 'Open an entry to see all its items. To take items back, use Receives → Receive item → Employee/Department/Office (return).'])
</div>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Entry</th><th>Date</th><th>Allocated to</th><th>Equipment</th><th>Status</th><th>Reference / by</th><th></th></tr></thead><tbody>
@forelse($entries as $en)
@php
    $ls = $lines[$en->entry_no];
    $f = $ls->first();
@endphp
<tr class="row-link" data-href="{{ route('inv.allocations.show', $en->entry_no) }}">
    <td class="text-nowrap"><div class="d-flex align-items-center gap-2"><span class="type-ico ti-primary"><x-icon name="arrow-up-right" :size="15"/></span><div><a href="{{ route('inv.allocations.show', $en->entry_no) }}" class="ticket-link">{{ $en->entry_no }}</a><div class="inv-sub">{{ $ls->count() }} {{ \Illuminate\Support\Str::plural('equipment', $ls->count()) }}</div></div></div></td>
    <td class="text-nowrap">{{ $f->moved_on->format('d M Y') }}</td>
    <td><div class="inv-holder">@if($f->holder_type === 'EMPLOYEE')<x-avatar :name="$f->holder_name" :user="$f->holderUser"/>@else<span class="dept-ico"><x-icon name="building" :size="14"/></span>@endif<div><div class="inv-name">{{ $f->holder_name }}</div>@if($f->holderUser)<div class="inv-sub">{{ $f->holderUser->department->name ?? '' }}</div>@elseif($f->holderSection)<div class="inv-sub">{{ $f->holderSection->department->name ?? '' }}</div>@endif</div></div></td>
    @php
        $ret = $ls->sum(fn ($m) => $returned[$m->id] ?? 0);
        $tot = $ls->sum(fn ($m) => abs($m->qty));
        $items = $ls->groupBy('equipment_id')->map(fn ($x) => ['name' => $x->first()->equipment->name, 'qty' => $x->sum(fn ($m) => abs($m->qty))])->values();
    @endphp
    <td style="min-width:240px">@include('inventory._equip_list', ['items' => $items])<div class="d-flex justify-content-between gap-3 border-top mt-1 pt-1 inv-sub"><span>Total</span><span class="inv-q">{{ \App\Support\Inv::qty($tot) }}</span></div></td>
    <td class="text-nowrap">@if($ret <= 0)<span class="pill pill-primary">With holder</span>@elseif($ret + 0.001 >= $tot)<span class="pill pill-success">All returned</span>@else<span class="pill pill-warning">Partly returned</span><div class="inv-sub">{{ \App\Support\Inv::qty($ret) }} of {{ \App\Support\Inv::qty($tot) }} back</div>@endif</td>
    <td>{{ $f->reference_no ?: '—' }}<div class="inv-sub">{{ $f->user->name ?? '' }}</div></td>
    <td class="text-end"><div class="inv-actions-cell"><a class="btn btn-sm btn-outline-primary" href="{{ route('inv.allocations.show', $en->entry_no) }}"><x-icon name="eye" :size="14"/> View</a>@can('inv.edit')<a class="btn btn-sm btn-outline-secondary" href="{{ route('inv.allocations.edit', $en->entry_no) }}"><x-icon name="edit" :size="14"/> Edit</a>@endcan</div></td>
</tr>
@empty
<tr><td colspan="7">@if($activeFilters)@include('inventory._empty', ['icon' => 'search', 'msg' => 'No allocations match these filters', 'hint' => 'Try a different search, or reset the filters.'])@else @can('inv.create')@include('inventory._empty', ['icon' => 'clipboard', 'msg' => 'No allocations yet', 'ctaUrl' => route('inv.allocations.create'), 'ctaLabel' => '+ Allocate equipment'])@else @include('inventory._empty', ['icon' => 'clipboard', 'msg' => 'No allocations yet'])@endcan @endif</td></tr>
@endforelse</tbody></table></div></div>
</div>
<div class="mt-3">{{ $entries->links() }}</div>
@include('inventory._rowlink')
@endsection
