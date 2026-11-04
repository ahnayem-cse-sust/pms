<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>IT Requests Monthly Report {{ $monthLabel }}</title>
@php
    $total = (int) ($summary['Total requests'] ?? 0);
    $resolved = (int) ($summary['Resolved'] ?? 0);
    $pending = (int) ($summary['Pending (open)'] ?? 0);
    $hrs = (float) ($summary['Avg resolution (hours)'] ?? 0);
    $avg = $resolved === 0 ? '—' : ($hrs >= 48 ? round($hrs / 24, 1).' days' : $hrs.' hrs');
    $pct = fn ($n) => $total ? round($n * 100 / $total).'%' : '0%';
    $cards = [
        ['Total requests', $total, 'received this month', '#4843a5'],
        ['Resolved', $resolved, $pct($resolved).' of all requests', '#16a34a'],
        ['Still open', $pending, 'waiting for completion', '#d97706'],
        ['Not yet assigned', (int) ($summary['New (unassigned)'] ?? 0), 'open, no one assigned', '#dc2626'],
        ['Closed', (int) ($summary['Closed'] ?? 0), 'fully completed', '#475569'],
        ['Average time to resolve', $avg, 'from request to resolved', '#0891b2'],
    ];
    $tone = fn ($s) => match (true) { in_array($s, ['Resolved', 'Closed', 'User Confirmation'], true) => '#16a34a', in_array($s, ['On Hold', 'Waiting for User'], true) => '#d97706', default => '#4843a5' };
@endphp
<style>
    body { font-family: {{ $mpdf ? 'kalpurush' : 'DejaVu Sans, sans-serif' }}; font-size: 10px; color: #1c2333; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 8px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 17px; margin: 0 0 2px; color: #060331; }
    h2 { font-size: 12px; margin: 16px 0 2px; color: #060331; border-left: 4px solid #4843a5; padding-left: 6px; }
    .muted { color: #6a7389; }
    .lead { font-size: 10.5px; line-height: 1.5; margin: 6px 0 8px; }
    .hint { color: #6a7389; font-size: 9px; margin: 0 0 5px 10px; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 5px 6px; font-size: 9.5px; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 4px 6px; vertical-align: top; }
    .r { text-align: right; }
    .card { border: 1px solid #d9dcea; padding: 6px 8px; }
    .card .n { font-size: 19px; font-weight: bold; }
    .card .l { font-size: 10px; font-weight: bold; color: #1c2333; }
    .card .d { font-size: 8.5px; color: #6a7389; }
    @unless($mpdf) .foot { position: fixed; bottom: -22px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; } @endunless
</style></head><body>
<table class="head"><tr>
    @if(extension_loaded('gd'))<td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:46px"></td>@endif
    <td><h1>IT Requests – Monthly Report</h1>
        <div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div></td>
    <td style="text-align:right;vertical-align:middle"><div style="font-size:15px;font-weight:bold;color:#4843a5">{{ $monthLabel }}</div><div class="muted">Report month</div></td>
</tr></table>


<table style="width:100%;border-collapse:separate;border-spacing:4px 0"><tr>
@foreach($cards as $i => [$label, $value, $desc, $color])
    <td class="card" style="width:16.6%;border-top:3px solid {{ $color }}"><div class="n" style="color:{{ $color }}">{{ $value }}</div><div class="l">{{ $label }}</div><div class="d">{{ $desc }}</div></td>
@endforeach
</tr></table>

<table style="width:100%"><tr>
@foreach(['By department' => [$byDept, 'Department', 'Which departments asked for help'], 'By category' => [$byCat, 'Category', 'What kind of help was needed'] ] as $title => [$rows, $col, $hint])
    <td style="width:50%;vertical-align:top;{{ $loop->first ? 'padding-right:8px' : 'padding-left:8px' }}"><h2>{{ $title }}</h2><div class="hint">{{ $hint }}</div>
    <table class="data"><thead><tr><th>{{ $col }}</th><th class="r" style="width:16%">Requests</th><th class="r" style="width:14%">Share</th></tr></thead><tbody>
    @forelse($rows as $k => $v)<tr><td>{{ $k }}</td><td class="r"><strong>{{ $v }}</strong></td><td class="r muted">{{ $pct($v) }}</td></tr>@empty<tr><td colspan="3" class="muted">No requests</td></tr>@endforelse
    </tbody></table></td>
@endforeach
</tr></table>

<h2>Work by IT team member</h2>
<div class="hint">A task is any request the person worked on, as the main (primary) assignee or as a supporting member. This is a workload summary, not a performance score.</div>
<table class="data"><thead><tr><th>IT team member</th><th class="r">Tasks</th><th class="r">As main assignee</th><th class="r">As supporting member</th><th class="r">Completed</th><th class="r">Still pending</th></tr></thead><tbody>
@foreach($perMember as $m)<tr><td>{{ $m->name }}</td><td class="r"><strong>{{ $m->tasks }}</strong></td><td class="r">{{ $m->primary }}</td><td class="r">{{ $m->supporting }}</td><td class="r">{{ $m->completed }}</td><td class="r">{{ $m->pending }}</td></tr>@endforeach
</tbody></table>

<h2>All requests this month ({{ $tickets->count() }})</h2>
<div class="hint">Listed by the date they were raised.</div>
<table class="data"><thead><tr><th style="width:5%">#</th><th style="width:11%">Request ID</th><th style="width:11%">Date</th><th style="width:15%">Department</th><th>Subject</th><th style="width:12%">Status</th><th style="width:14%">Assigned to</th></tr></thead><tbody>
@forelse($tickets->sortBy('created_at') as $t)
@php $bg = $loop->even ? 'background:#f6f7fc;' : ''; @endphp
<tr><td style="{{ $bg }}" class="muted">{{ $loop->iteration }}</td><td style="{{ $bg }}"><strong>{{ $t->ticket_no }}</strong></td><td style="{{ $bg }}">{{ $t->created_at->format('d M Y') }}</td><td style="{{ $bg }}">{{ $t->department->name }}</td><td style="{{ $bg }}">{{ $t->subject }}</td><td style="{{ $bg }}color:{{ $tone($t->status->name) }};font-weight:bold">{{ $t->status->name }}</td><td style="{{ $bg }}">{{ $t->assignee?->name ?? 'Not assigned' }}</td></tr>
@empty<tr><td colspan="7" class="muted">No requests in this month.</td></tr>@endforelse
</tbody></table>
@unless($mpdf)<div class="foot">Generated {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }}</div>@endunless
</body></html>
