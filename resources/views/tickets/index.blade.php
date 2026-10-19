@extends('layouts.app')
@php
    $titles = ['all' => 'Requests', 'mine' => 'My Requests', 'tasks' => 'My Tasks'];
    $notes = ['mine' => 'Requests you submitted, or that someone submitted on your behalf.', 'tasks' => 'Every request assigned to you.'];
    $self = ['all' => 'tickets.index', 'mine' => 'tickets.mine', 'tasks' => 'tasks.index'][$mode];
@endphp
@section('title', $titles[$mode])
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">{{ $titles[$mode] }}</h4>
        @isset($notes[$mode])<div class="text-muted small">{{ $notes[$mode] }}</div>@endisset
    </div>
    @can('ticket.create')<a href="{{ route('tickets.create') }}" class="btn btn-primary">+ New Request</a>@endcan
</div>

@php($activeFilters = collect(request()->only(['q','department_id','category_id','status_id','ticket_type_id','assigned_to','from','to']))->filter(fn ($v) => $v !== null && $v !== '')->count())
<form method="GET" class="card filter-card mb-3">
    <div class="filter-head">
        <x-icon name="search" :size="18"/>
        <span>Search &amp; filter requests</span>
        @if($activeFilters)<span class="filter-count">{{ $activeFilters }} active</span>@endif
        <a href="{{ route($self) }}" class="filter-clear ms-auto @unless($activeFilters) invisible @endunless">Clear all</a>
    </div>
    <div class="filter-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Keyword</label>
                <div class="input-icon"><x-icon name="search" :size="16"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Ticket no, subject, requester, employee ID"></div>
            </div>
            @if($mode === 'all' && auth()->user()->can('ticket.view.all'))
            <div class="col-sm-6 col-lg-3">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select"><option value="">All departments</option>
                    @foreach($departments as $d)<option value="{{ $d->id }}" @selected(request('department_id') == $d->id)>{{ $d->name }}</option>@endforeach
                </select>
            </div>
            @endif
            <div class="col-sm-6 col-lg-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select"><option value="">All categories</option>
                    @foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach
                </select>
            </div>
            @if($mode !== 'mine')
            <div class="col-sm-6 col-lg-3">
                <label class="form-label">Status</label>
                <select name="status_id" class="form-select"><option value="">All statuses</option>
                    @foreach($statuses as $s)<option value="{{ $s->id }}" @selected(request('status_id') == $s->id)>{{ $s->name }}</option>@endforeach
                </select>
            </div>
            @endif
            <div class="col-sm-6 col-lg-3">
                <label class="form-label">Service type</label>
                <select name="ticket_type_id" class="form-select"><option value="">All service types</option>
                    @foreach($types as $t)<option value="{{ $t->id }}" @selected(request('ticket_type_id') == $t->id)>{{ $t->name }}</option>@endforeach
                </select>
            </div>
            @if($mode === 'all' && auth()->user()->can('ticket.view.all'))
            <div class="col-sm-6 col-lg-3">
                <label class="form-label">Assignee</label>
                <select name="assigned_to" class="form-select"><option value="">Any assignee</option>
                    @foreach($members as $m)<option value="{{ $m->id }}" @selected(request('assigned_to') == $m->id)>{{ $m->name }}</option>@endforeach
                </select>
            </div>
            @endif
            <div class="col-sm-6 col-lg-3">
                <label class="form-label">From date</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
            </div>
            <div class="col-sm-6 col-lg-3">
                <label class="form-label">To date</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
        </div>
    </div>
    <div class="filter-actions">
        <button class="btn btn-primary d-inline-flex align-items-center gap-2"><x-icon name="search" :size="16"/> Search</button>
        <a href="{{ route($self) }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

@include('tickets._table', ['tickets' => $tickets])
{{ $tickets->links() }}
@endsection
