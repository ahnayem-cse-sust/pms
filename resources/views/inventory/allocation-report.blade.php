@extends('layouts.app')
@section('title', 'Item wise Allocation report')
@section('content')
<div class="mb-3"><a href="{{ route('inv.reports') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Reports</a></div>
@php $q = fn ($n) => \App\Support\Inv::qty($n); @endphp
<div class="card inv-panel inv-panel-open mb-3"><div class="filter-card">
<form method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">From *</label><input type="date" name="from" value="{{ $from->toDateString() }}" class="form-control" required></div>
    <div class="col-6 col-md-3 col-xl-2"><label class="form-label">To *</label><input type="date" name="to" value="{{ $to->toDateString() }}" class="form-control" required></div>
    <div class="col-12 col-md-6 col-xl-3"><label class="form-label">Select item</label><select name="equipment_id" class="form-select" data-ss="All items" data-ss-clear="1"><option value="">All items</option>@foreach($items as $i)<option value="{{ $i->id }}" @selected(request('equipment_id') == $i->id)>{{ $i->name }} ({{ $i->code }})</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-2"><label class="form-label">Category</label><select name="category_id" class="form-select" data-ss="All categories" data-ss-clear="1"><option value="">All</option>@foreach($cats as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-4 col-xl-3"><label class="form-label">Sub category</label><select name="subcategory_id" class="form-select" data-ss="All sub categories" data-ss-clear="1"><option value="">All</option>@foreach($subs as $c)<option value="{{ $c->id }}" @selected(request('subcategory_id') == $c->id)>{{ $c->name }}@php $par = $cats->firstWhere('id', $c->parent_id); @endphp @if($par) ({{ $par->name }})@endif</option>@endforeach</select></div>
    @unless($item)<div class="col-12"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="detail" value="1" id="detail" @checked($detail)><label class="form-check-label" for="detail">Detailed: list every allocation under each item (PDF and CSV)</label></div></div>@endunless
    <div class="col-12 filter-btns">
        <button class="btn btn-primary"><x-icon name="search" :size="15"/> Show report</button>
        <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
        <a class="btn btn-outline-success ms-sm-auto" href="{{ route('inv.allocation_report', array_merge(request()->query(), ['format' => 'csv'])) }}"><x-icon name="download" :size="15"/> Export CSV</a>
        <a class="btn btn-outline-primary" href="{{ route('inv.allocation_report', array_merge(request()->query(), ['format' => 'pdf'])) }}"><x-icon name="download" :size="15"/> Download PDF</a>
    </div>
</div></div></form>

@include('inventory._intro', ['text' => $item ? 'Every allocation of '.$item->name.' ('.$item->code.') between the two dates.' : 'How much of each item was allocated between the two dates, how much came back, and how many people or places received it.', 'tip' => $item ? 'Choose "All items" to see totals per item instead.' : 'Previous allocations count on the date they were originally handed over. Net out = allocated − returned in this period.'])
</div>

@if($item)
<div class="inv-summary">
    <span class="inv-chip">Item <strong>{{ $item->name }} ({{ $item->code }})</strong></span>
    <span class="inv-chip">Period <strong>{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</strong></span>
    <span class="inv-chip">Records <strong>{{ $records->count() }}</strong></span>
    <span class="inv-chip">Quantity <strong>{{ $q($records->sum('qty')) }}</strong></span>
</div>
<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle">
<thead><tr><th>Allocate ID</th><th>Date</th><th>Allocate to</th><th class="text-end">Quantity</th><th>Reference</th></tr></thead><tbody>
@forelse($records as $m)
<tr><td><strong>{{ $m->entry }}</strong></td><td class="text-nowrap">{{ $m->date->format('d M Y') }}</td><td>{{ $m->to }}</td><td class="text-end"><span class="inv-q">{{ $q($m->qty) }}</span></td><td>{{ $m->reference ?: '—' }}</td></tr>
@empty
<tr><td colspan="5">@include('inventory._empty', ['icon' => 'search', 'msg' => 'No allocations of this item in this period', 'hint' => 'Change the dates or choose another item.'])</td></tr>
@endforelse
@if($records->count())<tr><th colspan="3">Total</th><th class="text-end">{{ $q($records->sum('qty')) }}</th><th></th></tr>@endif
</tbody></table></div></div>
@else
<div class="inv-summary">
    <span class="inv-chip">Period <strong>{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</strong></span>
    <span class="inv-chip">Items <strong>{{ $rows->count() }}</strong></span>
    <span class="inv-chip">Allocated <strong>{{ $q($totals['allocated']) }}</strong></span>
    <span class="inv-chip">Returned <strong>{{ $q($totals['returned']) }}</strong></span>
    <span class="inv-chip">Entries <strong>{{ $totals['entries'] }}</strong></span>
</div>

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle">
<thead><tr><th>Equipment ID</th><th>Equipment</th><th>Category</th><th>Sub category</th><th class="text-end">Allocated</th><th class="text-end">Returned</th><th class="text-end">Net out</th><th class="text-end">Entries</th><th class="text-end">Given to</th></tr></thead><tbody>
@forelse($rows as $x)
<tr><td>{{ $x->equipment->code }}</td><td><div class="inv-name">{{ $x->equipment->name }}</div>@if($x->equipment->brand || $x->equipment->model)<div class="inv-sub">{{ trim($x->equipment->brand.' '.$x->equipment->model) }}</div>@endif</td>
<td>{{ $x->equipment->category->name ?? '—' }}</td><td>{{ $x->equipment->subcategory->name ?? '—' }}</td>
<td class="text-end"><span class="inv-q">{{ $q($x->allocated) }}</span></td><td class="text-end">{{ $q($x->returned) }}</td><td class="text-end"><strong>{{ $q($x->net) }}</strong></td><td class="text-end">{{ $x->entries }}</td><td class="text-end">{{ $x->holders }}</td></tr>
@empty
<tr><td colspan="9">@include('inventory._empty', ['icon' => 'search', 'msg' => 'No allocations in this period', 'hint' => 'Change the dates or filters, then show the report again.'])</td></tr>
@endforelse
@if($rows->count())<tfoot><tr><th colspan="4">Total</th><th class="text-end">{{ $q($totals['allocated']) }}</th><th class="text-end">{{ $q($totals['returned']) }}</th><th class="text-end">{{ $q($totals['net']) }}</th><th colspan="2"></th></tr></tfoot>@endif
</tbody></table></div></div>
@endif
</div>
@push('scripts')
<script src="{{ asset('js/searchable-select.js') }}"></script>
<script>
// type to search the item, category and sub category lists (the real <select> still submits the form)
document.querySelectorAll('select[data-ss]').forEach(function (s) { searchableSelect(s, s.dataset.ss); });
</script>
@endpush
@endsection
