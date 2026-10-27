<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Handover {{ $asset->asset_code }}</title>
<style>body{font-family:Arial,sans-serif;max-width:760px;margin:30px auto;color:#111}h2{text-align:center;margin-bottom:0}.s{text-align:center;color:#555;margin-top:2px}
table{width:100%;border-collapse:collapse;margin:18px 0}td,th{border:1px solid #888;padding:7px 9px;text-align:left;font-size:14px}th{width:30%;background:#f3f4f6}
.sig{display:flex;justify-content:space-between;margin-top:70px}.sig div{width:30%;border-top:1px solid #111;text-align:center;padding-top:5px;font-size:13px}@media print{button{display:none}}</style></head><body>
<button onclick="window.print()">Print</button>
<h2>Jamuna Oil PLC – IT Item Handover</h2><div class="s">{{ $asset->asset_code }}</div>
<table>
<tr><th>Item</th><td>{{ $asset->product->name }}</td></tr><tr><th>Brand / model</th><td>{{ $asset->product->brand }} {{ $asset->product->model }}</td></tr>
<tr><th>Serial number</th><td>{{ $asset->serial_no ?: '—' }}</td></tr>
<tr><th>Handed over to</th><td>{{ $asset->holder_name }}@if($asset->holderUser) – {{ $asset->holderUser->employee_id }}, {{ $asset->holderUser->department->name ?? '' }}@endif</td></tr>
<tr><th>Date</th><td>{{ $asset->allocated_at?->format('d M Y') }}</td></tr><tr><th>Remarks / accessories</th><td>&nbsp;</td></tr></table>
<p style="font-size:13px">The recipient confirms receipt of the above item and accepts responsibility for its safe custody until it is returned.</p>
<div class="sig"><div>Handed over by</div><div>Received by</div><div>IT Manager</div></div></body></html>
