@extends('layouts.app')
@section('title', 'Monthly report')
@section('content')
<div class="mb-3"><a href="{{ route('inv.reports') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Reports</a></div>
@php $q = fn ($n) => \App\Support\Inv::qty($n); @endphp
<form method="GET" class="card filter-card mb-3"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-sm-5 col-md-3"><label class="form-label">Month</label><input type="month" name="month" value="{{ $month }}" class="form-control"></div>
    <div class="col-12 col-sm filter-btns">
        <button class="btn btn-primary"><x-icon name="search" :size="15"/> Show report</button>
        <a class="btn btn-outline-success ms-sm-auto" href="{{ route('inv.monthly', ['month' => $month, 'format' => 'csv']) }}"><x-icon name="download" :size="15"/> Export CSV</a>
        <a class="btn btn-outline-primary" href="{{ route('inv.monthly', ['month' => $month, 'format' => 'pdf']) }}"><x-icon name="download" :size="15"/> Download PDF</a>
    </div>
</div></div></form>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle">
<thead><tr><th>Code</th><th>Equipment</th><th>Asset type</th><th class="text-end">Opening</th><th class="text-end">Received</th><th class="text-end">Returned</th><th class="text-end">Allocated</th>@if($showOther)<th class="text-end">Other</th>@endif<th class="text-end">Closing</th></tr></thead>
<tbody>
@forelse($rows as $x)
<tr><td class="text-nowrap"><span class="inv-code">{{ $x->equipment->code }}</span></td><td><div class="inv-name">{{ $x->equipment->name }}</div></td><td>{{ $x->equipment->assetType->name ?? '—' }}</td>
<td class="text-end">{{ $q($x->opening) }}</td><td class="text-end">{{ $q($x->received) }}</td><td class="text-end">{{ $q($x->returned) }}</td><td class="text-end">{{ $q($x->allocated) }}</td>@if($showOther)<td class="text-end">{{ $q($x->other) }}</td>@endif<td class="text-end"><strong>{{ $q($x->closing) }}</strong></td></tr>
@empty
<tr><td colspan="9" class="text-center text-muted py-4">No stock movement in {{ $monthLabel }}.</td></tr>
@endforelse
</tbody>
@if($rows->count())<tfoot><tr class="fw-semibold"><td colspan="3">Total</td><td class="text-end">{{ $q($totals['opening']) }}</td><td class="text-end">{{ $q($totals['received']) }}</td><td class="text-end">{{ $q($totals['returned']) }}</td><td class="text-end">{{ $q($totals['allocated']) }}</td>@if($showOther)<td class="text-end">{{ $q($totals['other']) }}</td>@endif<td class="text-end">{{ $q($totals['closing']) }}</td></tr></tfoot>@endif
</table></div></div>
<div class="small text-muted mt-2">Received includes new stock and previous items taken into store. Closing = Opening + Received + Returned − Allocated.</div>
@endsection
