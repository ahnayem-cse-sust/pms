@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="d-flex justify-content-end mb-2">
    <form method="POST" action="{{ route('notifications.readAll') }}">@csrf<button class="btn btn-sm btn-outline-secondary">Mark all read</button></form>
</div>
<div class="list-group" id="notifList">
@forelse($notifications as $n)
    <a href="{{ route('notifications.read', $n->id) }}" class="list-group-item list-group-item-action {{ $n->read_at ? '' : 'fw-semibold bg-white' }}">
        <div>{{ $n->data['message'] }}</div>
        <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
    </a>
@empty
    <div class="list-group-item text-muted">No notifications.</div>
@endforelse
</div>
<div class="mt-3">{{ $notifications->links() }}</div>
@endsection
