<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>IT Employee Attendance</title>
<style>
    @page { margin: 28px 30px 40px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1c2333; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 10px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 16px; margin: 0 0 2px; color: #060331; }
    .muted { color: #6a7389; }
    .meta { width: 100%; margin-bottom: 10px; }
    .meta td { padding: 2px 0; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 6px 7px; font-size: 9.5px; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 5px 7px; }
    table.data tr:nth-child(even) td { background: #f6f7fc; }
    .st-Present { color: #166534; font-weight: bold; }
    .st-Absent { color: #b91c1c; font-weight: bold; }
    .st-Weekend { color: #6b7280; }
    .st-Notinyet { color: #92400e; font-weight: bold; }
    .foot { position: fixed; bottom: -22px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; }
</style>
</head>
<body>
<table class="head"><tr>
    {{-- dompdf needs the PHP GD extension to embed a PNG; without it the logo is skipped so the PDF still works --}}
    @if(extension_loaded('gd'))
    <td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:46px"></td>
    @endif
    <td>
        <h1>IT Employee Attendance</h1>
        <div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div>
    </td>
</tr></table>

<table class="meta"><tr>
    <td><b>Period:</b> {{ $from->format('d M Y') }} to {{ $to->format('d M Y') }}</td>
    <td><b>Employee:</b> {{ $employeeName }}</td>
    <td><b>Status filter:</b> {{ $status ?: 'All' }}</td>
    <td style="text-align:right"><b>Generated:</b> {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }}</td>
</tr></table>
<table class="data">
    <thead><tr><th>Employee name</th><th>Date</th><th>Entry time</th><th>Status</th></tr></thead>
    <tbody>
    @forelse($rows as $row)
        <tr>
            <td>{{ $row->employee->name }}</td>
            <td>{{ $row->date->format('D, d M Y') }}</td>
            <td>{{ $row->entry ? $row->entry->format('h:i A') : '—' }}</td>
            <td class="st-{{ str_replace(' ', '', $row->status) }}">{{ $row->status }}</td>
        </tr>
    @empty
        <tr><td colspan="4" style="text-align:center" class="muted">No records for the selected period.</td></tr>
    @endforelse
    </tbody>
</table>

<p class="muted" style="margin-top:10px">Logins from devices outside the office network will not be considered for entry records.</p>
<div class="foot">Developed by MIS &amp; IT Department of JOPLC.</div>
</body>
</html>
