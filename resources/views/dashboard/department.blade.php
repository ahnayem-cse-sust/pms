@extends('layouts.app')
@section('title', 'My Requests')
@section('content')
<section class="dash-section">
    <div class="section-head">
        <div>
            <h5 class="section-title">My requests</h5>
            <div class="section-sub">Everything you have asked IT for, and where it stands.</div>
        </div>
        @can('ticket.create')<a href="{{ route('tickets.create') }}" class="btn btn-primary">+ New Request</a>@endcan
    </div>
    @include('tickets._table', ['tickets' => $tickets])
    <div class="mt-3">{{ $tickets->links() }}</div>
</section>
@endsection
