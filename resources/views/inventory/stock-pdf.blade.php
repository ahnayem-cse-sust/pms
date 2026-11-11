<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Inventory stock report</title>
@php $q = fn ($n) => \App\Support\Inv::qty($n); $badge = ['ok' => ['In stock', '#16a34a'], 'low' => ['Low stock', '#d97706'], 'out' => ['Out of stock', '#dc2626']]; @endphp
<style>
    body { font-family: {{ $mpdf ? 'kalpurush' : 'DejaVu Sans, sans-serif' }}; font-size: 10px; color: #1c2333; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 8px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 17px; margin: 0 0 2px; color: #060331; }
    .muted { color: #6a7389; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 5px 6px; font-size: 9.5px; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 4px 6px; vertical-align: top; }
    .r { text-align: right; }
    @unless($mpdf) .foot { position: fixed; bottom: -22px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; } @endunless
</style></head><body>
<table class="head"><tr>
    @if(extension_loaded('gd'))<td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:46px"></td>@endif
    <td><h1>IT Inventory – Stock Report</h1><div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div></td>
    <td style="text-align:right"><div style="font-size:12px;font-weight:bold;color:#4843a5">As of {{ $asOf->format('d M Y') }}</div><div class="muted">{{ $counts['items'] }} items &middot; {{ $counts['low'] }} low &middot; {{ $counts['out'] }} out of stock</div></td>
</tr></table>
<table class="data"><thead><tr><th style="width:4%">#</th><th style="width:9%">Equipment ID</th><th>Equipment</th><th style="width:14%">Category</th><th style="width:14%">Sub category</th><th class="r" style="width:8%">In store</th><th class="r" style="width:9%">With people</th><th class="r" style="width:7%">Total</th><th class="r" style="width:7%">Minimum</th><th style="width:10%">Status</th></tr></thead><tbody>
@forelse($rows as $x)
@php $bg = $loop->even ? 'background:#f6f7fc;' : ''; @endphp
<tr><td style="{{ $bg }}" class="muted">{{ $loop->iteration }}</td><td style="{{ $bg }}">{{ $x->equipment->code }}</td><td style="{{ $bg }}">{{ $x->equipment->name }}@if($x->equipment->brand || $x->equipment->model)<br><span class="muted">{{ trim($x->equipment->brand.' '.$x->equipment->model) }}</span>@endif</td><td style="{{ $bg }}">{{ $x->equipment->category->name ?? '—' }}</td><td style="{{ $bg }}">{{ $x->equipment->subcategory->name ?? '—' }}</td>
<td class="r" style="{{ $bg }}"><strong>{{ $q($x->store) }}</strong></td><td class="r" style="{{ $bg }}">{{ $q($x->use) }}</td><td class="r" style="{{ $bg }}">{{ $q($x->total) }}</td><td class="r muted" style="{{ $bg }}">{{ $x->min > 0 ? $q($x->min) : '—' }}</td>
<td style="{{ $bg }}color:{{ $badge[$x->status][1] }};font-weight:bold">{{ $badge[$x->status][0] }}</td></tr>
@empty
<tr><td colspan="10" class="muted">No equipment.</td></tr>
@endforelse
@if($rows->count())<tr><td colspan="5"><strong>Total</strong></td><td class="r"><strong>{{ $q($totals['store']) }}</strong></td><td class="r"><strong>{{ $q($totals['use']) }}</strong></td><td class="r"><strong>{{ $q($totals['total']) }}</strong></td><td colspan="2"></td></tr>@endif
</tbody></table>
<div class="muted" style="margin-top:4px">In store = available now. With people = allocated to employees or departments and not yet returned. Total = In store + With people.</div>
@unless($mpdf)<div class="foot">Generated {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }}</div>@endunless
</body></html>
