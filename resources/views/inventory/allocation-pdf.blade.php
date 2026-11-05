<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Handover {{ $entry }}</title>
<style>
    @page { margin: 30px 34px 44px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1c2333; }
    h1 { font-size: 17px; margin: 0; color: #060331; text-align: center; }
    .sub { text-align: center; color: #6a7389; margin: 3px 0 14px; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; }
    .meta td { padding: 4px 6px; border: 1px solid #b8bfcd; vertical-align: top; }
    .meta td.k { width: 22%; background: #f1f3f8; font-weight: bold; }
    .items { margin-top: 30px; }
    .items th { background: #060331; color: #fff; padding: 6px; text-align: left; font-size: 11.5px; }
    .items td { padding: 6px; border: 1px solid #b8bfcd; vertical-align: top; }
    .r { text-align: right; }
    .note { margin-top: 18px; font-size: 11.5px; color: #434b60; }
    .sig { width: 100%; margin-top: 64px; }
    .sig td { width: 33%; text-align: center; padding: 0 12px; }
    .sig1 { margin-top: 118px; }
    .sig2 { margin-top: 126px; }
    .sig div { border-top: 1px solid #111; padding-top: 4px; font-size: 11.5px; }
    .foot { position: fixed; bottom: -26px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; }
</style>
</head><body>
<div class="foot">{{ $entry }} · generated {{ $generatedAt->format('d M Y H:i') }}</div>
<table style="margin-bottom:12px"><tr>
    <td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:56px"></td>
    <td style="vertical-align:middle;text-align:center">
        <div style="font-size:15px;font-weight:bold;color:#060331">Jamuna Oil PLC.</div>
        <div style="font-size:9.5px;color:#434b60">(a subsidiary of Bangladesh Petroleum Corporation)</div>
        <div style="font-size:9.5px;color:#434b60">Agrabad C/A, Chattogram</div>
        <div style="font-size:10.5px;font-weight:bold;margin-top:2px">MIS &amp; IT Department</div>
        <div style="font-size:9.5px;color:#434b60">www.jamunaoil.gov.bd</div>
    </td>
    <td style="width:56px"></td>
</tr></table>
<table class="meta" style="margin-top:28px">
<tr><td class="k">Subject</td><td><strong>IT Equipment Handover</strong></td><td class="k">Allocation ID</td><td>{{ $entry }}</td></tr>
<tr><td class="k">Handed over to</td><td>{{ $first->holder_name }}@if($first->holderUser) – {{ $first->holderUser->employee_id }}@endif</td><td class="k">Date</td><td>{{ $first->moved_on->format('d M Y') }}</td></tr>
<tr><td class="k">Department</td><td>{{ $first->holderUser->department->name ?? ($first->holderDepartment->name ?? ($first->holderSection->department->name ?? '—')) }}</td><td class="k">Location</td><td>{{ $first->location->name ?? $first->holderUser->location->name ?? '—' }}</td></tr>
<tr><td class="k">Reference</td><td>{{ $first->reference_no ?: '—' }}</td><td class="k">Items</td><td>{{ $lines->count() }}</td></tr>
</table>
<table class="items"><thead><tr><th style="width:5%">#</th><th style="width:34%">Equipment</th><th style="width:17%">Asset ID / Qty</th><th style="width:17%">Serial number</th><th>Purpose</th></tr></thead><tbody>
@foreach($lines as $i => $m)
<tr><td>{{ $i + 1 }}</td><td>{{ $m->equipment->name }}<br><span style="color:#6a7389">{{ $m->equipment->code }}@if($m->equipment->brand || $m->equipment->model) · {{ trim($m->equipment->brand.' '.$m->equipment->model) }}@endif</span></td>
<td>@if($m->serial_no)<strong>{{ $m->serial_no }}</strong>@else<strong>{{ \App\Support\Inv::qty(abs($m->qty)) }}</strong> {{ $m->equipment->unit }}@endif</td>
<td>{{ $m->device_serial_no ?: '—' }}</td>
<td>{{ $m->remarks ?: '—' }}</td></tr>
@endforeach
</tbody></table>
<p class="note">The recipient confirms receipt of the equipment listed above and accepts responsibility for its safe custody until it is returned.</p>
<table class="sig sig1"><tr><td></td><td></td><td><div>Approved by</div></td></tr></table>
<table class="sig sig2"><tr><td><div>Handed over by</div></td><td><div>Received by</div></td><td><div>IT Manager</div></td></tr></table>
</body></html>
