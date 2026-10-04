@extends('layouts.app')
@section('title', 'My Requests')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Everything you have asked IT for, and where it stands.</p>
    @can('ticket.create')<a href="{{ route('tickets.create') }}" class="btn btn-primary">+ New Request</a>@endcan
</div>
@include('tickets._table', ['tickets' => $tickets])
<div class="mt-3">{{ $tickets->links() }}</div>
@endsection
