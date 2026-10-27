@extends('layouts.app')
@section('title', 'Receives')
@section('content')
@include('inventory._errors')
@php
    $activeFilters = collect(request()->only(['q', 'source', 'equipment_id', 'from', 'to']))->filter(fn ($v) => $v !== null && $v !== '')->count();
@endphp
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-6 col-xl-3"><label class="form-label">Search</label><div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Entry, reference, supplier, person, item, asset ID"></div></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">Received from</label><select name="source" class="form-select"><option value="">All</option>
        <option value="SUPPLIER" @selected(request('source') == 'SUPPLIER')>Supplier</option><option value="PREVIOUS" @selected(request('source') == 'PREVIOUS')>Previous item</option><option value="EMPLOYEE" @selected(request('source') == 'EMPLOYEE')>Employee return</option><option value="DEPARTMENT" @selected(request('source') == 'DEPARTMENT')>Department return</option></select></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">Equipment</label><select name="equipment_id" class="form-select"><option value="">All</option>@foreach($equipment as $p)<option value="{{ $p->id }}" @selected(request('equipment_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-xl filter-btns"><button class="btn btn-primary"><x-icon name="search" :size="15"/> Filter</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a><a href="{{ route('inv.receives', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success"><x-icon name="download" :size="15"/> CSV</a>
        @can('inv.create')<a href="{{ route('inv.receive') }}" class="btn btn-success ms-xl-auto">+ Receive item</a>@endcan</div>
</div></div></form>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Entry</th><th>Date</th><th>Received from</th><th>Items</th><th>Reference</th><th>By</th><th></th></tr></thead><tbody>
@forelse($entries as $en)
@php
    $ls = $lines[$en->entry_no];
    $f = $ls->first();
@endphp
<tr class="row-link" data-href="{{ route('inv.receives.show', $en->entry_no) }}">
    <td class="text-nowrap"><div class="d-flex align-items-center gap-2"><span class="type-ico ti-{{ \App\Support\Inv::tone($f->type) }}"><x-icon :name="\App\Support\Inv::icon($f->type)" :size="15"/></span><div><a href="{{ route('inv.receives.show', $en->entry_no) }}" class="ticket-link">{{ $en->entry_no }}</a><div class="inv-sub">{{ $ls->count() }} {{ \Illuminate\Support\Str::plural('line', $ls->count()) }}</div></div></div></td>
    <td class="text-nowrap">{{ $f->moved_on->format('d M Y') }}</td>
    <td>@if($f->type === 'RETURN')<span class="pill pill-info">Return</span> {{ $f->holder_name }}@elseif($f->type === 'OPENING')<span class="pill pill-secondary">Previous item</span> {{ $f->party }}@else<span class="pill pill-success">Supplier</span> {{ $f->party }}@endif</td>
    <td><div class="inv-items">
        @foreach($ls->take(3) as $m)<div class="inv-item"><span class="inv-q {{ $m->qty > 0 ? 'pos' : ($m->qty < 0 ? 'neg' : '') }}">{{ $m->qty > 0 ? '+' : '' }}{{ \App\Support\Inv::qty($m->qty) }}</span> <span class="inv-name">{{ $m->equipment->name }}</span> <span class="inv-code">{{ $m->equipment->code }}</span>@if($m->serial_no)<span class="inv-sn">Asset ID {{ $m->serial_no }}</span>@endif</div>@endforeach
        @if($ls->count() > 3)<span class="inv-more" title="{{ $ls->slice(3)->map(fn ($m) => $m->equipment->name)->implode(', ') }}">+{{ $ls->count() - 3 }} more</span>@endif
    </div></td>
    <td>{{ $f->reference_no ?: '—' }}@if($f->remarks)<div class="inv-sub">{{ $f->remarks }}</div>@endif</td>
    <td>{{ $f->user->name ?? '' }}</td>
    <td class="text-end"><div class="inv-actions-cell"><a class="btn btn-sm btn-outline-primary" href="{{ route('inv.receives.show', $en->entry_no) }}"><x-icon name="eye" :size="14"/> View</a><a class="btn btn-sm btn-outline-secondary" href="{{ route('inv.receives.pdf', $en->entry_no) }}"><x-icon name="file-text" :size="14"/> PDF</a></div></td>
</tr>
@empty
<tr><td colspan="7">@if($activeFilters)@include('inventory._empty', ['icon' => 'search', 'msg' => 'No receives match these filters', 'hint' => 'Try a different search, or reset the filters.'])@else @can('inv.create')@include('inventory._empty', ['icon' => 'inbox', 'msg' => 'Nothing received yet', 'hint' => 'Items you receive from a supplier or get back from people appear here.', 'ctaUrl' => route('inv.receive'), 'ctaLabel' => '+ Receive item'])@else @include('inventory._empty', ['icon' => 'inbox', 'msg' => 'Nothing received yet'])@endcan @endif</td></tr>
@endforelse</tbody></table></div></div>
<div class="mt-3">{{ $entries->links() }}</div>
@include('inventory._rowlink')
@endsection
