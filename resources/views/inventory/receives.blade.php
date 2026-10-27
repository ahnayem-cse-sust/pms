@extends('layouts.app')
@section('title', 'Receives')
@section('content')
@include('inventory._errors')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Entry, reference, supplier, person, item, serial"></div>
    <div class="col-6 col-md-2"><label class="form-label">Received from</label><select name="source" class="form-select"><option value="">All</option>
        <option value="SUPPLIER" @selected(request('source') == 'SUPPLIER')>Supplier</option><option value="PREVIOUS" @selected(request('source') == 'PREVIOUS')>Previous item</option><option value="EMPLOYEE" @selected(request('source') == 'EMPLOYEE')>Employee return</option><option value="DEPARTMENT" @selected(request('source') == 'DEPARTMENT')>Department return</option></select></div>
    <div class="col-6 col-md-2"><label class="form-label">Equipment</label><select name="equipment_id" class="form-select"><option value="">All</option>@foreach($equipment as $p)<option value="{{ $p->id }}" @selected(request('equipment_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Filter</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a><a href="{{ route('inv.receives', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success">CSV</a>
        @can('inv.create')<a href="{{ route('inv.receive') }}" class="btn btn-success ms-md-auto">+ Receive item</a>@endcan</div>
</div></div></form>
<div class="table-responsive"><table class="table table-sm bg-white align-middle small"><thead class="table-light"><tr><th>Entry</th><th>Date</th><th>Received from</th><th>Items</th><th>Reference</th><th>By</th><th></th></tr></thead><tbody>
@forelse($entries as $en)
@php
    $ls = $lines[$en->entry_no];
    $f = $ls->first();
@endphp
<tr><td class="text-nowrap"><strong>{{ $en->entry_no }}</strong><div class="text-muted">{{ $ls->count() }} {{ \Illuminate\Support\Str::plural('line', $ls->count()) }}</div></td><td class="text-nowrap">{{ $f->moved_on->format('d M Y') }}</td>
<td>@if($f->type === 'RETURN')<span class="pill pill-info">Return</span> {{ $f->holder_name }}@elseif($f->type === 'OPENING')<span class="pill pill-secondary">Previous item</span> {{ $f->party }}@else<span class="pill pill-success">Supplier</span> {{ $f->party }}@endif</td>
<td>@foreach($ls as $m)<div>{{ $m->equipment->name }} <span class="text-muted">({{ $m->equipment->code }})</span>@if($m->serial_no) <span class="text-muted">S/N {{ $m->serial_no }}</span>@endif – <strong>{{ \App\Support\Inv::qty($m->qty) }} {{ $m->equipment->unit }}</strong></div>@endforeach</td>
<td>{{ $f->reference_no }}@if($f->remarks)<div class="text-muted">{{ $f->remarks }}</div>@endif</td><td>{{ $f->user->name ?? '' }}</td>
<td class="text-end text-nowrap"><a class="btn btn-sm btn-outline-primary" href="{{ route('inv.receives.show', $en->entry_no) }}">View</a> <a class="btn btn-sm btn-outline-secondary" href="{{ route('inv.receives.pdf', $en->entry_no) }}">PDF</a></td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-4">Nothing received yet.</td></tr>@endforelse</tbody></table></div>
{{ $entries->links() }}
@endsection
