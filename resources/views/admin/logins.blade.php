@extends('layouts.app')
@section('title', 'Login history')
@section('content')
<h4 class="mb-3">Login history</h4>
<table class="table table-sm bg-white small">
    <thead class="table-light"><tr><th>When</th><th>Email</th><th>Result</th><th>IP</th><th>Browser</th></tr></thead>
    <tbody>
    @foreach($logins as $l)
        <tr>
            <td class="text-nowrap">{{ $l->created_at->format('d M Y H:i:s') }}</td>
            <td>{{ $l->email_tried }}</td>
            <td>@if($l->successful)<span class="badge text-bg-success">OK</span>@else<span class="badge text-bg-danger">Failed</span>@endif</td>
            <td>{{ $l->ip_address }}</td>
            <td class="text-truncate" style="max-width:380px">{{ $l->user_agent }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $logins->links() }}
@endsection
