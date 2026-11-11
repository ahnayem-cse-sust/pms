<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>IT Requests Monthly Report {{ $monthLabel }}</title>
@php
    $total = (int) ($summary['Total requests'] ?? 0);
    $resolved = (int) ($summary['Resolved'] ?? 0);
    $pending = (int) ($summary['Pending (open)'] ?? 0);
    $hrs = (float) ($summary['Avg resolution (hours)'] ?? 0);
    $avg = $resolved === 0 ? '—' : ($hrs >= 48 ? round($hrs / 24, 1).' days' : $hrs.' hrs');
    $pct = fn ($n) => $total ? round($n * 100 / $total).'%' : '0%';
    $share = fn ($n) => $total ? max(2, round($n * 100 / $total)) : 0;   // bar width, never invisible for a non-zero count
    // two rows of three: the main numbers first, then the detail
    $cardRows = [[
        ['Total requests', $total, 'received this month', '#4843a5'],
        ['Resolved', $resolved, $pct($resolved).' of all requests', '#16a34a'],
        ['Still open', $pending, 'waiting for completion', '#d97706'],
    ], [
        ['Not yet assigned', (int) ($summary['New (unassigned)'] ?? 0), 'open, no one assigned', '#dc2626'],
        ['Closed', (int) ($summary['Closed'] ?? 0), 'finished and confirmed', '#475569'],
        ['Average time to resolve', $avg, 'from request to resolved', '#0891b2'],
    ]];
    $tone = fn ($s) => match (true) { in_array($s, ['Resolved', 'Closed', 'User Confirmation'], true) => '#16a34a', in_array($s, ['On Hold', 'Waiting for User'], true) => '#d97706', default => '#4843a5' };
    $active = $perMember->filter(fn ($m) => $m->tasks > 0)->sortByDesc('tasks')->values();   // members with no task this month are left out, so the table stays short
    $idle = $perMember->count() - $active->count();
@endphp
<style>
    @unless($mpdf) @page { margin: 16mm 14mm 18mm 14mm; } @endunless
    body { font-family: {{ $mpdf ? 'kalpurush' : 'DejaVu Sans, sans-serif' }}; font-size: 9.5pt; color: #1c2333; line-height: 1.35; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 14px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 18pt; margin: 0 0 2px; color: #060331; }
    h2 { font-size: 12.5pt; margin: 0 0 3px; color: #060331; border-left: 5px solid #4843a5; padding-left: 8px; }
    .section { margin-top: 20px; }
    .muted { color: #6a7389; }
    .hint { color: #6a7389; font-size: 8.5pt; margin: 0 0 7px 13px; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 6px 7px; font-size: 9pt; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 6px 7px; vertical-align: top; font-size: 9pt; }
    table.data thead { display: table-header-group; }
    table.data tr { page-break-inside: avoid; }
    .r { text-align: right; }
    .card { border: 1px solid #d9dcea; padding: 9px 11px; }
    .card .n { font-size: 22pt; font-weight: bold; line-height: 1.1; }
    .card .l { font-size: 10pt; font-weight: bold; color: #1c2333; margin-top: 2px; }
    .card .d { font-size: 8.5pt; color: #6a7389; }
    .guide { border: 1px solid #d9dcea; background: #f6f7fc; padding: 8px 11px; font-size: 8.5pt; line-height: 1.5; margin-top: 12px; }
    .bar { background: #e2e5f0; height: 7px; }
    .bar div { height: 7px; background: #4843a5; }
    .pagebreak { page-break-before: always; }
    @unless($mpdf) .foot { position: fixed; bottom: -30px; left: 0; right: 0; font-size: 8pt; color: #6a7389; text-align: center; } .pagenum:before { content: counter(page); } @endunless
</style></head><body>
<table class="head"><tr>
    @if(extension_loaded('gd'))<td style="width:60px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:48px"></td>@endif
    <td><h1>IT Requests – Monthly Report</h1>
        <div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div></td>
    <td style="text-align:right;vertical-align:middle"><div style="font-size:16pt;font-weight:bold;color:#4843a5">{{ $monthLabel }}</div><div class="muted">Report month</div></td>
</tr></table>

<div class="section"><h2>1. Requests by department</h2>
<div class="hint">Which departments asked for help.</div>
<table class="data"><thead><tr><th style="width:34%">Department</th><th class="r" style="width:12%">Requests</th><th class="r" style="width:10%">Share</th><th>&nbsp;</th></tr></thead><tbody>
@forelse($byDept as $k => $v)<tr><td>{{ $k }}</td><td class="r"><strong>{{ $v }}</strong></td><td class="r muted">{{ $pct($v) }}</td><td style="padding-top:9px"><div class="bar"><div style="width:{{ $share($v) }}%"></div></div></td></tr>@empty<tr><td colspan="4" class="muted">No requests</td></tr>@endforelse
</tbody></table></div>

<div class="section"><h2>2. Requests by category</h2>
<div class="hint">What kind of help was needed.</div>
<table class="data"><thead><tr><th style="width:34%">Category</th><th class="r" style="width:12%">Requests</th><th class="r" style="width:10%">Share</th><th>&nbsp;</th></tr></thead><tbody>
@forelse($byCat as $k => $v)<tr><td>{{ $k }}</td><td class="r"><strong>{{ $v }}</strong></td><td class="r muted">{{ $pct($v) }}</td><td style="padding-top:9px"><div class="bar"><div style="width:{{ $share($v) }}%"></div></div></td></tr>@empty<tr><td colspan="4" class="muted">No requests</td></tr>@endforelse
</tbody></table></div>

<div class="section"><h2>3. Work by IT team member</h2>
<div class="hint">A task is any request the person worked on, as the main assignee or as a supporting member. This is a workload summary, not a performance score.@if($idle > 0) {{ $idle }} team {{ $idle === 1 ? 'member' : 'members' }} with no tasks this month {{ $idle === 1 ? 'is' : 'are' }} not listed.@endif</div>
<table class="data"><thead><tr><th>IT team member</th><th class="r">Tasks</th><th class="r">Main assignee</th><th class="r">Supporting</th><th class="r">Completed</th><th class="r">Still pending</th></tr></thead><tbody>
@forelse($active as $m)<tr><td>{{ $m->name }}</td><td class="r"><strong>{{ $m->tasks }}</strong></td><td class="r">{{ $m->primary }}</td><td class="r">{{ $m->supporting }}</td><td class="r">{{ $m->completed }}</td><td class="r">{{ $m->pending }}</td></tr>@empty<tr><td colspan="6" class="muted">No tasks this month.</td></tr>@endforelse
</tbody></table></div>

<div class="pagebreak"></div>
<div><h2>4. All requests this month ({{ $tickets->count() }})</h2>
<div class="hint">Listed by the date they were raised, oldest first.</div></div>
<table class="data"><thead><tr><th style="width:5%">#</th><th style="width:14%;white-space:nowrap">Request ID</th><th style="width:13%;white-space:nowrap">Date</th><th style="width:15%">Department</th><th>Subject</th><th style="width:12%">Status</th><th style="width:14%">Assigned to</th></tr></thead><tbody>
@forelse($tickets->sortBy('created_at') as $t)
@php $bg = $loop->even ? 'background:#f6f7fc;' : ''; @endphp
<tr><td style="{{ $bg }}" class="muted">{{ $loop->iteration }}</td><td style="{{ $bg }}white-space:nowrap"><strong>{{ $t->ticket_no }}</strong></td><td style="{{ $bg }}white-space:nowrap">{{ $t->created_at->format('d M Y') }}</td><td style="{{ $bg }}">{{ $t->department->name }}</td><td style="{{ $bg }}">{{ $t->subject }}</td><td style="{{ $bg }}color:{{ $tone($t->status->name) }};font-weight:bold">{{ $t->status->name }}</td><td style="{{ $bg }}">{{ $t->assignee?->name ?? 'Not assigned' }}</td></tr>
@empty<tr><td colspan="7" class="muted">No requests in this month.</td></tr>@endforelse
</tbody></table>
<div class="section" style="page-break-inside:avoid"><h2>5. Summary</h2>
<div class="hint">The main numbers for the month, in one place.</div>
<table style="width:100%;border-collapse:separate;border-spacing:6px">
@foreach($cardRows as $row)
<tr>
    @foreach($row as [$label, $value, $desc, $color])
    <td class="card" style="width:33.3%;border-top:4px solid {{ $color }}"><div class="n" style="color:{{ $color }}">{{ $value }}</div><div class="l">{{ $label }}</div><div class="d">{{ $desc }}</div></td>
    @endforeach
</tr>
@endforeach
</table>

<div class="guide"><strong>How to read this report.</strong>
    <strong>Resolved</strong> – the IT team has finished the work (the requester may still need to confirm).
    <strong>Closed</strong> – finished and confirmed.
    <strong>Still open</strong> – not finished yet.
    <strong>Not yet assigned</strong> – open and nobody has been given the request.
    <strong>Share</strong> – the part of all requests this month.</div></div>
@unless($mpdf)<div class="foot">Generated {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }} &middot; Page <span class="pagenum"></span></div>@endunless
</body></html>
