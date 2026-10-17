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

<form method="GET" class="card card-body mb-3">
    <div class="row g-2">
        <div class="col-md-3"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search ticket no, subject, requester, employee ID"></div>
        @if($mode === 'all' && auth()->user()->can('ticket.view.all'))
        <div class="col-md-2">
            <select name="department_id" class="form-select"><option value="">All departments</option>
                @foreach($departments as $d)<option value="{{ $d->id }}" @selected(request('department_id') == $d->id)>{{ $d->name }}</option>@endforeach
            </select>
        </div>
        @endif
        <div class="col-md-2">
            <select name="category_id" class="form-select"><option value="">All categories</option>
                @foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status_id" class="form-select"><option value="">All statuses</option>
                @foreach($statuses as $s)<option value="{{ $s->id }}" @selected(request('status_id') == $s->id)>{{ $s->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="ticket_type_id" class="form-select"><option value="">All types</option>
                @foreach($types as $t)<option value="{{ $t->id }}" @selected(request('ticket_type_id') == $t->id)>{{ $t->name }}</option>@endforeach
            </select>
        </div>
        @if($mode === 'all' && auth()->user()->can('ticket.view.all'))
        <div class="col-md-2">
            <select name="assigned_to" class="form-select"><option value="">Any assignee</option>
                @foreach($members as $m)<option value="{{ $m->id }}" @selected(request('assigned_to') == $m->id)>{{ $m->name }}</option>@endforeach
            </select>
        </div>
        @endif
        <div class="col-md-2"><input type="date" name="from" value="{{ request('from') }}" class="form-control" title="From date"></div>
        <div class="col-md-2"><input type="date" name="to" value="{{ request('to') }}" class="form-control" title="To date"></div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-secondary">Filter</button>
            <a href="{{ route($self) }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>

@include('tickets._table', ['tickets' => $tickets])
{{ $tickets->links() }}
@endsection
