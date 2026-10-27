@extends('layouts.app')
@section('title', 'Records')
@section('content')
@php
    $activeFilters = collect(request()->only(['q', 'type', 'equipment_id', 'from', 'to']))->filter(fn ($v) => $v !== null && $v !== '')->count();
@endphp
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-6 col-xl-3"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Record, entry, reference, supplier, person"></div></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">Type</label><select name="type" class="form-select"><option value="">All</option>@foreach(config('inventory.movement_types') as $k => $l)<option value="{{ $k }}" @selected(request('type') == $k)>{{ $l }}</option>@endforeach</select></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">Equipment</label><select name="equipment_id" class="form-select"><option value="">All</option>@foreach($equipment as $p)<option value="{{ $p->id }}" @selected(request('equipment_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-xl filter-btns"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Filter</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a><a href="{{ route('inv.records', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success"><x-icon name="download" :size="15"/> CSV</a></div>
</div></div></form>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Record</th><th>Date</th><th>Type</th><th>Equipment</th><th class="text-end">Qty</th><th class="text-end">Balance</th><th>Person / dept</th><th>Reference / supplier</th><th>By</th><th></th></tr></thead><tbody>
@forelse($rows as $m)
<tr class="row-link" data-href="{{ route('inv.records.show', $m) }}">
    <td class="text-nowrap"><div class="d-flex align-items-center gap-2"><span class="type-ico ti-{{ \App\Support\Inv::tone($m->type) }}"><x-icon :name="\App\Support\Inv::icon($m->type)" :size="15"/></span><div><a href="{{ route('inv.records.show', $m) }}" class="ticket-link">{{ $m->ref }}</a>@if($m->entry_no)<div class="inv-sub">{{ $m->entry_no }}</div>@endif</div></div></td>
    <td class="text-nowrap">{{ $m->moved_on->format('d M Y') }}</td>
    <td>{{ \App\Support\Inv::pill($m->type) }}</td>
    <td style="min-width:200px"><div class="inv-name">{{ $m->equipment->name }}</div><div class="inv-sub">@if($m->serial_no)<span class="inv-sn">Asset ID {{ $m->serial_no }}</span> · @endif{{ $m->equipment->classification }}</div></td>
    <td class="text-end"><span class="inv-q {{ $m->qty > 0 ? 'pos' : ($m->qty < 0 ? 'neg' : '') }}">{{ $m->qty > 0 ? '+' : '' }}{{ \App\Support\Inv::qty($m->qty) }}</span></td>
    <td class="text-end inv-num">{{ \App\Support\Inv::qty($m->balance_after) }}</td>
    <td>{{ $m->holder_name ?: '—' }}</td>
    <td>{{ trim($m->reference_no.' '.$m->party) ?: '—' }}@if($m->remarks)<div class="inv-sub">{{ $m->remarks }}</div>@endif</td>
    <td>{{ $m->user->name ?? '' }}</td>
    <td class="text-end"><div class="inv-actions-cell"><a class="btn btn-sm btn-outline-primary" href="{{ route('inv.records.show', $m) }}"><x-icon name="eye" :size="14"/> View</a>@if($m->type === 'ALLOCATE')<a class="btn btn-sm btn-outline-secondary" href="{{ route('inv.allocations.pdf', $m->entry_no) }}"><x-icon name="file-text" :size="14"/> PDF</a>@elseif(in_array($m->type, ['RECEIVE', 'OPENING', 'RETURN']))<a class="btn btn-sm btn-outline-secondary" href="{{ route('inv.receives.pdf', $m->entry_no) }}"><x-icon name="file-text" :size="14"/> PDF</a>@endif</div></td>
</tr>
@empty
<tr><td colspan="10">@include('inventory._empty', ['icon' => $activeFilters ? 'search' : 'clipboard', 'msg' => $activeFilters ? 'No records match these filters' : 'No records yet', 'hint' => $activeFilters ? 'Try a different search, or reset the filters.' : 'Every receive, allocation and return is written here.'])</td></tr>
@endforelse</tbody></table></div></div>
<div class="mt-3">{{ $rows->links() }}</div>
@include('inventory._rowlink')
@endsection
