<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Inventory monthly report {{ $monthLabel }}</title>
@php $q = fn ($n) => \App\Support\Inv::qty($n); @endphp
<style>
    body { font-family: {{ $mpdf ? 'kalpurush' : 'DejaVu Sans, sans-serif' }}; font-size: 10px; color: #1c2333; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 10px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 16px; margin: 0 0 2px; color: #060331; }
    .muted { color: #6a7389; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 5px 6px; font-size: 9.5px; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 4px 6px; vertical-align: top; }
    .r { text-align: right; }
    @unless($mpdf) .foot { position: fixed; bottom: -22px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; } @endunless
</style></head><body>
<table class="head"><tr>
    @if(extension_loaded('gd'))<td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:46px"></td>@endif
    <td><h1>IT Inventory – Monthly Report</h1>
        <div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div>
        <div class="muted">{{ $monthLabel }}</div></td>
</tr></table>
<table class="data"><thead><tr><th style="width:9%">Code</th><th>Equipment</th><th style="width:16%">Asset type</th><th class="r">Opening</th><th class="r">Received</th><th class="r">Returned</th><th class="r">Allocated</th>@if($showOther)<th class="r">Other</th>@endif<th class="r">Closing</th></tr></thead><tbody>
@forelse($rows as $x)
@php $bg = $loop->even ? 'background:#f6f7fc' : ''; @endphp
<tr><td style="{{ $bg }}">{{ $x->equipment->code }}</td><td style="{{ $bg }}">{{ $x->equipment->name }}</td><td style="{{ $bg }}">{{ $x->equipment->assetType->name ?? '—' }}</td>
<td class="r" style="{{ $bg }}">{{ $q($x->opening) }}</td><td class="r" style="{{ $bg }}">{{ $q($x->received) }}</td><td class="r" style="{{ $bg }}">{{ $q($x->returned) }}</td><td class="r" style="{{ $bg }}">{{ $q($x->allocated) }}</td>@if($showOther)<td class="r" style="{{ $bg }}">{{ $q($x->other) }}</td>@endif<td class="r" style="{{ $bg }}"><strong>{{ $q($x->closing) }}</strong></td></tr>
@empty
<tr><td colspan="9" class="muted">No stock movement in {{ $monthLabel }}.</td></tr>
@endforelse
@if($rows->count())<tr><td colspan="3"><strong>Total</strong></td><td class="r"><strong>{{ $q($totals['opening']) }}</strong></td><td class="r"><strong>{{ $q($totals['received']) }}</strong></td><td class="r"><strong>{{ $q($totals['returned']) }}</strong></td><td class="r"><strong>{{ $q($totals['allocated']) }}</strong></td>@if($showOther)<td class="r"><strong>{{ $q($totals['other']) }}</strong></td>@endif<td class="r"><strong>{{ $q($totals['closing']) }}</strong></td></tr>@endif
</tbody></table>
<div class="muted" style="margin-top:4px">Received includes new stock and previous items taken into store. Closing = Opening + Received + Returned − Allocated.</div>
@unless($mpdf)<div class="foot">Generated {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }}</div>@endunless
</body></html>
