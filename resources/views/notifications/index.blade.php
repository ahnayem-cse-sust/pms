@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
@php
    $dayLabel = function ($dt) {
        if ($dt->isToday()) return 'Today';
        if ($dt->isYesterday()) return 'Yesterday';
        return $dt->format('d M Y');
    };
    $iconFor = function ($m) {
        $m = strtolower($m);
        return match (true) {
            str_contains($m, 'comment') || str_contains($m, 'reply') => 'message',
            str_contains($m, 'new request') || str_contains($m, 'submitted') => 'inbox',
            str_contains($m, 'primary') || str_contains($m, 'supporting') || str_contains($m, 'team') || str_contains($m, 'taken off') => 'users',
            str_contains($m, '→') || str_contains($m, 'resolved') => 'activity',
            default => 'bell',
        };
    };
    $groups = $notifications->getCollection()->groupBy(fn ($n) => $dayLabel($n->created_at));
@endphp
<div class="nf-wrap">
    <div class="nf-head">
        <div class="nf-tabs">
            <a href="{{ route('notifications.index') }}" class="{{ $filter === 'all' ? 'active' : '' }}">All</a>
            <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" class="{{ $filter === 'unread' ? 'active' : '' }}">Unread @if($unreadCount)<span class="count">{{ $unreadCount }}</span>@endif</a>
        </div>
        <div class="nf-actions">
            @if($unreadCount)
                <form method="POST" action="{{ route('notifications.readAll') }}">@csrf<button class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1"><x-icon name="check" :size="14"/> Mark all read</button></form>
            @endif
            @if($readCount)
                <form method="POST" action="{{ route('notifications.clearRead') }}" onsubmit="return confirm('Remove all read notifications?');">@csrf<button class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"><x-icon name="trash" :size="14"/> Clear read</button></form>
            @endif
        </div>
    </div>

    <div class="nf-list" id="notifList">
    @forelse($groups as $day => $items)
        <div class="nf-day">{{ $day }}</div>
        @foreach($items as $n)
            @php
                $msg = $n->data['message'] ?? '';
                $no = $n->data['ticket_no'] ?? null;
                if ($no && str_starts_with($msg, $no . ': ')) $msg = substr($msg, strlen($no) + 2);
            @endphp
            <div class="nf-item {{ $n->read_at ? '' : 'unread' }}">
                <a href="{{ route('notifications.read', $n->id) }}" class="nf-link">
                    <span class="nf-ic"><x-icon :name="$iconFor($n->data['message'] ?? '')" :size="17"/></span>
                    <span class="nf-body">
                        <span class="nf-msg">{{ $msg }}</span>
                        <span class="nf-meta">@if($no)<span class="nf-no">{{ str_replace('-', '', $no) }}</span>@endif<span title="{{ $n->created_at->format('d M Y, h:i A') }}">{{ $n->created_at->diffForHumans() }}</span></span>
                    </span>
                    @unless($n->read_at)<span class="nf-dot" title="Unread"></span>@endunless
                </a>
                <form method="POST" action="{{ route('notifications.destroy', $n->id) }}">@csrf @method('DELETE')<button class="nf-x" title="Remove" aria-label="Remove notification"><x-icon name="x" :size="15"/></button></form>
            </div>
        @endforeach
    @empty
        <div class="nf-empty"><x-icon name="bell" :size="30"/><div class="fw-semibold">{{ $filter === 'unread' ? "You're all caught up" : 'No notifications' }}</div><small>{{ $filter === 'unread' ? 'Nothing new to read.' : 'Updates about your requests will appear here.' }}</small></div>
    @endforelse
    </div>
    <div class="mt-3">{{ $notifications->links() }}</div>
</div>
@endsection
