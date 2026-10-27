<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Handover {{ $m->ref }}</title>
<style>body{font-family:Arial,sans-serif;max-width:760px;margin:30px auto;color:#111}h2{text-align:center;margin-bottom:0}.s{text-align:center;color:#555;margin-top:2px}
table{width:100%;border-collapse:collapse;margin:18px 0}td,th{border:1px solid #888;padding:7px 9px;text-align:left;font-size:14px}th{width:30%;background:#f3f4f6}
.sig{display:flex;justify-content:space-between;margin-top:70px}.sig div{width:30%;border-top:1px solid #111;text-align:center;padding-top:5px;font-size:13px}@media print{button{display:none}}</style></head><body>
<button onclick="window.print()">Print</button>
<h2>Jamuna Oil PLC – IT Equipment Handover</h2><div class="s">{{ $m->ref }}</div>
<table>
<tr><th>Equipment</th><td>{{ $m->equipment->name }} ({{ $m->equipment->code }})</td></tr>
<tr><th>Classification</th><td>{{ $m->equipment->classification ?: '—' }}</td></tr>
<tr><th>Brand / model</th><td>{{ $m->equipment->brand }} {{ $m->equipment->model }}</td></tr>
@if($m->serial_no)<tr><th>Serial no.</th><td>{{ $m->serial_no }}</td></tr>@endif
<tr><th>Quantity</th><td>{{ \App\Support\Inv::qty(abs($m->qty)) }} {{ $m->equipment->unit }}</td></tr>
<tr><th>Handed over to</th><td>{{ $m->holder_name }}@if($m->holderUser) – {{ $m->holderUser->employee_id }}, {{ $m->holderUser->department->name ?? '' }}@endif</td></tr>
<tr><th>Date</th><td>{{ $m->moved_on->format('d M Y') }}</td></tr><tr><th>Reference</th><td>{{ $m->reference_no ?: '—' }}</td></tr>
<tr><th>Purpose</th><td>{{ $m->remarks ?: '—' }}</td></tr><tr><th>Issued by</th><td>{{ $m->user->name ?? '—' }}</td></tr></table>
<p style="font-size:13px">The recipient confirms receipt of the above equipment and accepts responsibility for its safe custody until it is returned.</p>
<div class="sig"><div>Handed over by</div><div>Received by</div><div>IT Manager</div></div></body></html>
