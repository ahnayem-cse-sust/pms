@extends('layouts.app')
@section('title', 'Audit log')
@section('content')
<h4 class="mb-3">Audit log</h4>
<form class="card filter-card mb-3" method="GET">
    <div class="filter-head">
        <x-icon name="search" :size="18"/>
        <span>Search audit log</span>
        @if(request('event'))<span class="filter-count">1 active</span>@endif
    </div>
    <div class="filter-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Event</label>
                <div class="input-icon"><x-icon name="search" :size="16"/><input name="event" value="{{ request('event') }}" class="form-control" placeholder="Event contains… (e.g. ticket.assigned)"></div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary d-inline-flex align-items-center gap-2"><x-icon name="search" :size="16"/> Search</button>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </div>
</form>
<div class="table-responsive">
<table class="table table-sm bg-white align-middle small">
    <thead class="table-light"><tr><th>When</th><th>Who</th><th>Event</th><th>Object</th><th>Old</th><th>New</th><th>IP</th></tr></thead>
    <tbody>
    @foreach($logs as $l)
        <tr>
            <td class="text-nowrap">{{ $l->created_at->format('d M Y H:i:s') }}</td>
            <td>{{ $l->user->name ?? 'System' }}</td>
            <td>{{ $l->event }}</td>
            <td>{{ $l->auditable_type }} {{ $l->auditable_id ? '#'.$l->auditable_id : '' }}</td>
            <td><code>{{ $l->old_values ? json_encode($l->old_values) : '' }}</code></td>
            <td><code>{{ $l->new_values ? json_encode($l->new_values) : '' }}</code></td>
            <td>{{ $l->ip_address }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
{{ $logs->links() }}
@endsection
