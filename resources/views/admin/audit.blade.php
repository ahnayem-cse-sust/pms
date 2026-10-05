@extends('layouts.app')
@section('title', 'Audit log')
@section('content')
<h4 class="mb-3">Audit log</h4>
<form class="row g-2 mb-3" method="GET">
    <div class="col-md-3"><input name="event" value="{{ request('event') }}" class="form-control" placeholder="Event contains… (e.g. ticket.assigned)"></div>
    <div class="col"><button class="btn btn-secondary">Filter</button></div>
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
