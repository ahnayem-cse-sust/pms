<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Allocation report</title>
@php $q = fn ($n) => \App\Support\Inv::qty($n); @endphp
<style>
    @unless($mpdf) @page { margin: 14mm 12mm 16mm 12mm; } @endunless
    body { font-family: {{ $mpdf ? 'kalpurush' : 'DejaVu Sans, sans-serif' }}; font-size: 9pt; color: #1c2333; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 10px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 16pt; margin: 0 0 2px; color: #060331; }
    .muted { color: #6a7389; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 5px 6px; font-size: 8.5pt; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 4px 6px; vertical-align: top; }
    table.data thead { display: table-header-group; }
    table.data tr { page-break-inside: avoid; }
    .r { text-align: right; }
    .item td { background: #eef0ff; border-top: 2px solid #4843a5; font-weight: bold; }
    .sub td { font-size: 8.5pt; color: #3a4258; }
    @unless($mpdf) .foot { position: fixed; bottom: -26px; left: 0; right: 0; font-size: 8pt; color: #6a7389; text-align: center; } @endunless
</style></head><body>
<table class="head"><tr>
    @if(extension_loaded('gd'))<td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:46px"></td>@endif
    <td><h1>IT Inventory – {{ $item ? 'Allocation Records: '.$item->name.' ('.$item->code.')' : 'Allocation Report'.($detail ? ' – detailed' : '') }}</h1><div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div></td>
    <td style="text-align:right"><div style="font-size:12pt;font-weight:bold;color:#4843a5">{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</div><div class="muted">@if($item){{ $records->count() }} records &middot; {{ $q($records->sum('qty')) }} allocated @else{{ $rows->count() }} items &middot; {{ $q($totals['allocated']) }} allocated &middot; {{ $q($totals['returned']) }} returned &middot; {{ $totals['entries'] }} entries @endif</div></td>
</tr></table>

@if($item)
<table class="data"><thead><tr><th style="width:16%">Allocate ID</th><th style="width:14%">Date</th><th>Allocate to</th><th class="r" style="width:12%">Quantity</th><th style="width:22%">Reference</th></tr></thead><tbody>
@forelse($records as $m)
@php $bg = $loop->even ? 'background:#f6f7fc;' : ''; @endphp
<tr><td style="{{ $bg }}"><strong>{{ $m->entry }}</strong></td><td style="{{ $bg }}">{{ $m->date->format('d M Y') }}</td><td style="{{ $bg }}">{{ $m->to }}</td><td class="r" style="{{ $bg }}">{{ $q($m->qty) }}</td><td style="{{ $bg }}">{{ $m->reference ?: '—' }}</td></tr>
@empty
<tr><td colspan="5" class="muted">No allocations of this item in this period.</td></tr>
@endforelse
@if($records->count())<tr><td colspan="3"><strong>Total</strong></td><td class="r"><strong>{{ $q($records->sum('qty')) }}</strong></td><td></td></tr>@endif
</tbody></table>
@else
<table class="data"><thead><tr><th style="width:4%">#</th><th style="width:9%">Equipment ID</th><th>Equipment</th><th style="width:14%">Category</th><th style="width:14%">Sub category</th><th class="r" style="width:8%">Allocated</th><th class="r" style="width:8%">Returned</th><th class="r" style="width:8%">Net out</th><th class="r" style="width:7%">Entries</th><th class="r" style="width:8%">Given to</th></tr></thead><tbody>
@forelse($rows as $x)
@php $bg = ! $detail && $loop->even ? 'background:#f6f7fc;' : ''; @endphp
<tr class="{{ $detail ? 'item' : '' }}"><td style="{{ $bg }}" class="muted">{{ $loop->iteration }}</td><td style="{{ $bg }}">{{ $x->equipment->code }}</td><td style="{{ $bg }}">{{ $x->equipment->name }}@if(! $detail && ($x->equipment->brand || $x->equipment->model))<br><span class="muted">{{ trim($x->equipment->brand.' '.$x->equipment->model) }}</span>@endif</td><td style="{{ $bg }}">{{ $x->equipment->category->name ?? '—' }}</td><td style="{{ $bg }}">{{ $x->equipment->subcategory->name ?? '—' }}</td>
<td class="r" style="{{ $bg }}"><strong>{{ $q($x->allocated) }}</strong></td><td class="r" style="{{ $bg }}">{{ $q($x->returned) }}</td><td class="r" style="{{ $bg }}"><strong>{{ $q($x->net) }}</strong></td><td class="r" style="{{ $bg }}">{{ $x->entries }}</td><td class="r" style="{{ $bg }}">{{ $x->holders }}</td></tr>
@if($detail)
<tr class="sub"><td></td><td colspan="9" style="padding:0 0 6px 0">
    <table style="width:100%;border-collapse:collapse">
    <tr><td style="width:12%;color:#6a7389">Date</td><td style="width:14%;color:#6a7389">Entry</td><td style="color:#6a7389">Allocated to</td><td style="width:18%;color:#6a7389">Reference</td><td class="r" style="width:9%;color:#6a7389">Qty</td></tr>
    @foreach($x->lines->groupBy(fn ($m) => ($m->entry_no ?? $m->ref).'|'.$m->holder_type.$m->holder_user_id.$m->holder_department_id.$m->holder_section_id) as $ls)
    @php $m = $ls->first(); @endphp
    <tr><td>{{ $m->moved_on->format('d M Y') }}</td><td>{{ $m->entry_no ?: $m->ref }}</td><td>{{ $m->holder_name }}@if($m->holderUser) <span class="muted">({{ $m->holderUser->department->name ?? '' }})</span>@endif</td><td>{{ $m->reference_no ?: '—' }}</td><td class="r">{{ $q($ls->sum(fn ($l) => abs($l->qty))) }}</td></tr>
    @endforeach
    </table></td></tr>
@endif
@empty
<tr><td colspan="10" class="muted">No allocations in this period.</td></tr>
@endforelse
@if($rows->count())<tr><td colspan="5"><strong>Total</strong></td><td class="r"><strong>{{ $q($totals['allocated']) }}</strong></td><td class="r"><strong>{{ $q($totals['returned']) }}</strong></td><td class="r"><strong>{{ $q($totals['net']) }}</strong></td><td colspan="2"></td></tr>@endif
</tbody></table>
<div class="muted" style="margin-top:5px">Allocated = quantity given out in the period. Returned = quantity that came back in the period. Net out = Allocated − Returned. Given to = number of different employees, departments or offices.</div>
@endif
@unless($mpdf)<div class="foot">Generated {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }}</div>@endunless
</body></html>
