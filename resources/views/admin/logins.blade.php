@extends('layouts.app')
@section('title', 'Login history')
@section('content')
<table class="table table-sm bg-white small">
    <thead class="table-light"><tr><th>When</th><th>Email</th><th>Event</th><th>IP</th><th>Browser</th></tr></thead>
    <tbody>
    @foreach($logins as $l)
        <tr>
            <td class="text-nowrap">{{ $l->created_at->format('d M Y h:i:s A') }}</td>
            <td>{{ $l->email_tried }}</td>
            <td>
                @if($l->event === 'logout')<span class="pill pill-secondary">Logout{{ $l->reason === 'timeout' ? ' (timeout)' : '' }}</span>
                @elseif($l->successful)<span class="pill pill-success">Login</span>
                @else<span class="pill pill-danger">Failed</span>@endif
            </td>
            <td>{{ $l->ip_address }}</td>
            <td class="text-truncate" style="max-width:380px">{{ $l->user_agent }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $logins->links() }}
@endsection
