<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Request {{ $reqNo }}</title>
<style>
    @page { margin: 28px 30px 40px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1c2333; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 10px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 16px; margin: 0 0 2px; color: #060331; }
    h2 { font-size: 12px; margin: 16px 0 6px; color: #4843a5; }
    .muted { color: #6a7389; }
    .body { white-space: pre-wrap; }
    table.info { width: 100%; border-collapse: collapse; }
    table.info th { width: 22%; text-align: left; color: #6a7389; font-weight: normal; padding: 4px 6px; border-bottom: 1px solid #e2e5f0; vertical-align: top; }
    table.info td { padding: 4px 6px; border-bottom: 1px solid #e2e5f0; vertical-align: top; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 6px 7px; font-size: 9.5px; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 5px 7px; vertical-align: top; }
    table.data tr:nth-child(even) td { background: #f6f7fc; }
    .msg { border-bottom: 1px solid #e2e5f0; padding: 5px 6px; page-break-inside: avoid; }
    .msg .who { color: #4843a5; font-weight: bold; } .msg .when { color: #6a7389; margin-left: 6px; }
    .tag { background: #fef3c7; color: #92400e; padding: 1px 5px; border-radius: 6px; font-size: 8.5px; }
    .foot { position: fixed; bottom: -22px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; }
</style>
</head>
<body>
<table class="head"><tr>
    @if(extension_loaded('gd'))
    <td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:46px"></td>
    @endif
    <td>
        <h1>Request {{ $reqNo }}</h1>
        <div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div>
    </td>
</tr></table>

<h2 style="margin-top:0">Request details</h2>
<table class="info">
    <tr><th>Subject</th><td><b>{{ $ticket->subject }}</b></td></tr>
    <tr><th>Status</th><td>{{ $ticket->status->name }}@if($ticket->reopen_count) &middot; reopened {{ $ticket->reopen_count }} time(s)@endif</td></tr>
    <tr><th>Service type</th><td>{{ $ticket->type->name ?? '—' }}</td></tr>
    <tr><th>Category</th><td>{{ $ticket->category->name }}@if($ticket->subcategory) / {{ $ticket->subcategory->name }}@endif</td></tr>
    @if($ticket->priority)<tr><th>Priority</th><td>{{ $ticket->priority->name }}</td></tr>@endif
    <tr><th>Requester</th><td>{{ $ticket->requester_name }}@if($ticket->department) &middot; {{ $ticket->department->name }}@endif</td></tr>
    @if($ticket->location)<tr><th>Location</th><td>{{ $ticket->location->name }}</td></tr>@endif
    <tr><th>Submitted at</th><td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td></tr>
    @if($ticket->resolved_at)<tr><th>Resolved at</th><td>{{ $ticket->resolved_at->format('d M Y, h:i A') }}</td></tr>@endif
    @if($ticket->closed_at)<tr><th>Closed at</th><td>{{ $ticket->closed_at->format('d M Y, h:i A') }}</td></tr>@endif
    <tr><th>Description</th><td><div class="body">{{ $ticket->description }}</div></td></tr>
    @if($ticket->resolution)<tr><th>Resolution</th><td><div class="body">{{ $ticket->resolution }}</div></td></tr>@endif
</table>

@if($seeInternal && $ticket->team->isNotEmpty())
<h2>IT team</h2>
<table class="info">
    @foreach($ticket->team as $m)
        <tr><th>{{ $m->role === 'PRIMARY' ? 'Primary' : 'Supporting' }}</th><td>{{ $m->employee->name }}</td></tr>
    @endforeach
</table>
@endif

<h2>Conversation</h2>
@forelse($ticket->comments as $c)
    <div class="msg"><span class="who">{{ $c->user->name }}</span><span class="when">{{ $c->created_at->format('d M Y, h:i A') }}</span>
        <div class="body">{{ $c->body }}</div></div>
@empty
    <div class="muted">No comments.</div>
@endforelse

@if($seeInternal && $notes->isNotEmpty())
<h2>Internal notes <span class="tag">IT only</span></h2>
@foreach($notes as $n)
    <div class="msg"><span class="who">{{ $n->user->name }}</span><span class="when">{{ $n->created_at->format('d M Y, h:i A') }}</span>
        <div class="body">{{ $n->body }}</div></div>
@endforeach
@endif

@if($seeInternal && $workUpdates->isNotEmpty())
<h2>Team progress <span class="tag">IT only</span></h2>
@foreach($workUpdates as $w)
    <div class="msg"><span class="who">{{ $w->user->name }}</span><span class="when">{{ $w->created_at->format('d M Y, h:i A') }} &middot; {{ $workStatuses[$w->work_status] ?? $w->work_status }}</span>
        @if($w->note)<div class="body">{{ $w->note }}</div>@endif</div>
@endforeach
@endif

<h2>Attachments</h2>
@forelse($attachments as $a)
    <div class="msg">{{ $a->original_name }}@if($a->is_internal) <span class="tag">IT only</span>@endif
        <span class="when">{{ number_format($a->size_bytes / 1024, 0) }} KB &middot; {{ $a->uploader->name }} &middot; {{ $a->created_at->format('d M Y, h:i A') }}</span></div>
@empty
    <div class="muted">No attachments.</div>
@endforelse

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

<div class="foot">Request {{ $reqNo }} &middot; generated {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }}</div>
</body>
</html>
