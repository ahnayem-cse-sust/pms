@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Notifications</h4>
    <form method="POST" action="{{ route('notifications.readAll') }}">@csrf<button class="btn btn-sm btn-outline-secondary">Mark all read</button></form>
</div>
<div class="list-group">
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
