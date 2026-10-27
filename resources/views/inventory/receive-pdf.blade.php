<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Receive {{ $entry }}</title>
<style>
    @page { margin: 30px 34px 44px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 10.5px; color: #1c2333; }
    h1 { font-size: 17px; margin: 0; color: #060331; text-align: center; }
    .sub { text-align: center; color: #6a7389; margin: 3px 0 14px; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; }
    .meta td { padding: 4px 6px; border: 1px solid #b8bfcd; vertical-align: top; }
    .meta td.k { width: 22%; background: #f1f3f8; font-weight: bold; }
    .items { margin-top: 14px; }
    .items th { background: #060331; color: #fff; padding: 6px; text-align: left; font-size: 10px; }
    .items td { padding: 6px; border: 1px solid #b8bfcd; vertical-align: top; }
    .r { text-align: right; }
    .note { margin-top: 14px; font-size: 10px; color: #434b60; }
    .sig { width: 100%; margin-top: 64px; }
    .sig td { width: 33%; text-align: center; padding: 0 12px; }
    .sig div { border-top: 1px solid #111; padding-top: 4px; font-size: 10px; }
    .foot { position: fixed; bottom: -26px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; }
</style>
</head><body>
<div class="foot">{{ $entry }} · generated {{ $generatedAt->format('d M Y H:i') }} by {{ $generatedBy }}</div>
<h1>Jamuna Oil PLC – IT Equipment Receipt</h1>
<div class="sub">{{ $entry }}</div>
<table class="meta">
<tr><td class="k">Received from</td><td>@if($first->type === 'RETURN')Return – {{ $first->holder_name }}@if($first->holderUser) ({{ $first->holderUser->employee_id }})@endif @elseif($first->type === 'OPENING')Previous item{{ $first->party ? ' – '.$first->party : '' }}@else{{ $first->party ?: 'Supplier' }}@endif</td><td class="k">Date</td><td>{{ $first->moved_on->format('d M Y') }}</td></tr>
<tr><td class="k">Reference</td><td>{{ $first->reference_no ?: '—' }}</td><td class="k">Entered by</td><td>{{ $first->user->name ?? '—' }}</td></tr>
@if($first->remarks)<tr><td class="k">Remarks</td><td colspan="3">{{ $first->remarks }}</td></tr>@endif
</table>
<table class="items"><thead><tr><th style="width:5%">#</th><th style="width:14%">Code</th><th style="width:31%">Equipment</th><th style="width:26%">Classification</th><th class="r" style="width:12%">Quantity</th><th>Asset ID</th></tr></thead><tbody>
@foreach($lines as $i => $m)
<tr><td>{{ $i + 1 }}</td><td>{{ $m->equipment->code }}</td><td>{{ $m->equipment->name }}@if($m->equipment->brand || $m->equipment->model)<br><span style="color:#6a7389">{{ trim($m->equipment->brand.' '.$m->equipment->model) }}</span>@endif</td>
<td>{{ $m->equipment->classification ?: '—' }}</td><td class="r"><strong>{{ \App\Support\Inv::qty($m->qty) }}</strong> {{ $m->equipment->unit }}</td><td>{{ $m->serial_no ?: '—' }}</td></tr>
@endforeach
</tbody></table>
<table class="sig"><tr><td><div>Received by (IT)</div></td><td><div>@if($first->type === 'RETURN')Returned by @else Delivered by @endif</div></td><td><div>IT Manager</div></td></tr></table>
</body></html>
