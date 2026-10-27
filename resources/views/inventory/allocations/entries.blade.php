@extends('layouts.app')
@section('title', 'Allocation records')
@section('content')
@include('inventory._errors')
@include('inventory.allocations._tabs')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Entry, person, department, item, serial, purpose"></div>
    <div class="col-6 col-md-2"><label class="form-label">Allocated to</label><select name="to_type" class="form-select"><option value="">All</option><option value="EMPLOYEE" @selected(request('to_type') == 'EMPLOYEE')>Employees</option><option value="DEPARTMENT" @selected(request('to_type') == 'DEPARTMENT')>Departments</option></select></div>
    <div class="col-6 col-md-2"><label class="form-label">Equipment</label><select name="equipment_id" class="form-select"><option value="">All</option>@foreach($equipment as $p)<option value="{{ $p->id }}" @selected(request('equipment_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Filter</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a><a href="{{ route('inv.allocations.entries', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success">CSV</a>
        @can('inv.create')<a href="{{ route('inv.allocations.create') }}" class="btn btn-success ms-md-auto">+ Allocate equipment</a>@endcan</div>
</div></div></form>
<div class="table-responsive"><table class="table table-sm bg-white align-middle small"><thead class="table-light"><tr><th>Entry</th><th>Date</th><th>Allocated to</th><th>Equipment</th><th>Reference</th><th>By</th><th></th></tr></thead><tbody>
@forelse($entries as $en)
@php
    $ls = $lines[$en->entry_no];
    $f = $ls->first();
@endphp
<tr><td class="text-nowrap"><strong>{{ $en->entry_no }}</strong><div class="text-muted">{{ $ls->count() }} {{ \Illuminate\Support\Str::plural('line', $ls->count()) }}</div></td><td class="text-nowrap">{{ $f->moved_on->format('d M Y') }}</td>
<td>{{ $f->holder_name }}@if($f->holderUser)<div class="text-muted">{{ $f->holderUser->department->name ?? '' }}</div>@endif</td>
<td>@foreach($ls as $m)<div>{{ $m->equipment->name }} <span class="text-muted">({{ $m->equipment->code }})</span> – @if($m->serial_no)<strong>S/N {{ $m->serial_no }}</strong>@else<strong>{{ \App\Support\Inv::qty(abs($m->qty)) }} {{ $m->equipment->unit }}</strong>@endif @if($m->remarks)<span class="text-muted">· {{ $m->remarks }}</span>@endif</div>@endforeach</td>
<td>{{ $f->reference_no }}</td><td>{{ $f->user->name ?? '' }}</td>
<td class="text-end text-nowrap"><a class="btn btn-sm btn-outline-primary" href="{{ route('inv.allocations.show', $en->entry_no) }}">View</a> <a class="btn btn-sm btn-outline-secondary" href="{{ route('inv.allocations.pdf', $en->entry_no) }}">PDF</a></td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-4">No allocations yet.</td></tr>@endforelse</tbody></table></div>
{{ $entries->links() }}
@endsection
