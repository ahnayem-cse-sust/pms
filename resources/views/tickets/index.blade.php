@extends('layouts.app')
@php
    $titles = ['all' => 'Requests', 'mine' => 'My Requests', 'tasks' => 'My Tasks', 'completed' => 'Completed Tasks'];
    $notes = ['mine' => 'Requests you submitted, or that someone submitted on your behalf.', 'tasks' => 'Every request assigned to you.', 'completed' => 'Resolved and closed requests you worked on, as primary or supporting employee.'];
    $self = ['all' => 'tickets.index', 'mine' => 'tickets.mine', 'tasks' => 'tasks.index', 'completed' => 'tasks.completed'][$mode];
@endphp
@section('title', $titles[$mode])
@section('content')
@php($activeFilters = collect(request()->only(['q','department_id','category_id','status_id','ticket_type_id','assigned_to','role','from','to']))->filter(fn ($v) => $v !== null && $v !== '')->count())
@isset($notes[$mode])<div class="text-muted small mb-2">{{ $notes[$mode] }}</div>@endisset
<form method="GET" class="card filter-card mb-3">
    <div class="filter-body">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-8 col-xl-4">
                <label class="form-label">Search</label>
                <div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Request ID, subject, requester, employee ID"></div>
            </div>
            @if($mode === 'all' && auth()->user()->can('ticket.view.all'))
            <div class="col-6 col-md-4 col-xl-2">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select"><option value="">All</option>
                    @foreach($departments as $d)<option value="{{ $d->id }}" @selected(request('department_id') == $d->id)>{{ $d->name }}</option>@endforeach
                </select>
            </div>
            @endif
            <div class="col-6 col-md-4 col-xl-2">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select"><option value="">All</option>
                    @foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach
                </select>
            </div>
            @if($mode !== 'mine')
            <div class="col-6 col-md-4 col-xl-2">
                <label class="form-label">Status</label>
                <select name="status_id" class="form-select"><option value="">{{ $mode === 'tasks' ? 'All active' : 'All' }}</option>
                    @foreach($statuses as $s)<option value="{{ $s->id }}" @selected(request('status_id') == $s->id)>{{ $s->name }}</option>@endforeach
                </select>
            </div>
            @endif
            <div class="col-6 col-md-4 col-xl-2">
                <label class="form-label">Service type</label>
                <select name="ticket_type_id" class="form-select"><option value="">All</option>
                    @foreach($types as $t)<option value="{{ $t->id }}" @selected(request('ticket_type_id') == $t->id)>{{ $t->name }}</option>@endforeach
                </select>
            </div>
            @if($mode === 'all' && auth()->user()->can('ticket.view.all'))
            <div class="col-6 col-md-4 col-xl-2">
                <label class="form-label">Assignee</label>
                <select name="assigned_to" class="form-select"><option value="">Any</option>
                    @foreach($members as $m)<option value="{{ $m->id }}" @selected(request('assigned_to') == $m->id)>{{ $m->name }}</option>@endforeach
                </select>
            </div>
            @endif
            @if(in_array($mode, ['tasks', 'completed']))
            <div class="col-6 col-md-4 col-xl-2">
                <label class="form-label">My role</label>
                <select name="role" class="form-select"><option value="">Primary &amp; supporting</option>
                    <option value="primary" @selected(request('role') === 'primary')>Primary only</option>
                    <option value="support" @selected(request('role') === 'support')>Supporting only</option>
                </select>
            </div>
            @endif
            <div class="col-6 col-md-4 col-xl-2">
                <label class="form-label">{{ $mode === 'completed' ? 'Completed from' : 'From' }}</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <label class="form-label">{{ $mode === 'completed' ? 'Completed to' : 'To' }}</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
            <div class="col-12 col-xl filter-btns">
                <button class="btn btn-primary"><x-icon name="search" :size="15"/> Search</button>
                <a href="{{ route($self) }}" class="btn btn-outline-secondary">Reset @if($activeFilters)<span class="filter-count">{{ $activeFilters }}</span>@endif</a>
                @can('ticket.create')<a href="{{ route('tickets.create') }}" class="btn btn-success ms-xl-auto">+ New Request</a>@endcan
            </div>
        </div>
    </div>
</form>

@include('tickets._table', ['tickets' => $tickets])
{{ $tickets->links() }}
@endsection
