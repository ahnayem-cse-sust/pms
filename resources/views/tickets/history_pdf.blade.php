<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Request {{ $reqNo }} – History</title>
<style>
    @page { margin: 28px 30px 40px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1c2333; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 10px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 16px; margin: 0 0 2px; color: #060331; }
    h2 { font-size: 12px; margin: 16px 0 6px; color: #4843a5; }
    .muted { color: #6a7389; }
    table.info { width: 100%; border-collapse: collapse; }
    table.info th { width: 22%; text-align: left; color: #6a7389; font-weight: normal; padding: 4px 6px; border-bottom: 1px solid #e2e5f0; vertical-align: top; }
    table.info td { padding: 4px 6px; border-bottom: 1px solid #e2e5f0; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 6px 7px; font-size: 9.5px; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 5px 7px; vertical-align: top; }
    table.data tr:nth-child(even) td { background: #f6f7fc; }
    .foot { position: fixed; bottom: -22px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; }
</style>
</head>
<body>
<table class="head"><tr>
    @if(extension_loaded('gd'))
    <td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:46px"></td>
    @endif
    <td>
        <h1>Request History – {{ $reqNo }}</h1>
        <div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div>
    </td>
</tr></table>

<table class="info">
    <tr><th>Subject</th><td><b>{{ $ticket->subject }}</b></td></tr>
    <tr><th>Status</th><td>{{ $ticket->status->name }}</td></tr>
    <tr><th>Category</th><td>{{ $ticket->category->name }}@if($ticket->subcategory) / {{ $ticket->subcategory->name }}@endif</td></tr>
    <tr><th>Requester</th><td>{{ $ticket->requester_name }}@if($ticket->department) &middot; {{ $ticket->department->name }}@endif</td></tr>
    <tr><th>Submitted at</th><td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td></tr>
</table>

<h2>History</h2>
<table class="data">
    <thead><tr><th style="width:24%">Date &amp; time</th><th>Activity</th></tr></thead>
    <tbody>
    @forelse($history as $h)
        <tr>
            <td>{{ $h->created_at->format('d M Y, h:i A') }}</td>
            <td><b>{{ $h->user->name ?? 'System' }}</b> @include('tickets._history_text', ['h' => $h])</td>
        </tr>
    @empty
        <tr><td colspan="2" class="muted">No history recorded.</td></tr>
    @endforelse
    </tbody>
</table>

<div class="foot">Generated {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }}</div>
</body>
</html>
