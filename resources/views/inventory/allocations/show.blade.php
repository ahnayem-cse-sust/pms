@extends('layouts.app')
@section('title', 'Allocation '.$entry)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    @can('inv.view')<a href="{{ route('inv.allocations.entries') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Allocation records</a>@endcan
    <a href="{{ route('inv.allocations.pdf', $entry) }}" class="btn btn-primary ms-md-auto inv-back"><x-icon name="download" :size="15"/> Download PDF</a>
</div>
<div class="card mb-3">
    <div class="inv-hero">
        <span class="type-ico ti-primary"><x-icon name="arrow-up-right" :size="20"/></span>
        <div><div class="inv-hero-title">{{ $entry }}</div><div class="inv-sub">{{ $first->moved_on->format('d M Y') }} · {{ $lines->count() }} {{ \Illuminate\Support\Str::plural('line', $lines->count()) }}</div></div>
        <div class="ms-auto">{{ \App\Support\Inv::pill($first->type) }}</div>
    </div>
    <dl class="inv-meta">
        <div class="wide"><dt>Allocated to</dt><dd>{{ $first->holder_name }}@if($first->holderUser) <span class="text-muted fw-normal">({{ $first->holderUser->employee_id }}, {{ $first->holderUser->department->name ?? '' }})</span>@endif</dd></div>
        <div><dt>Date</dt><dd>{{ $first->moved_on->format('d M Y') }}</dd></div>
        <div><dt>Reference</dt><dd>{{ $first->reference_no ?: '—' }}</dd></div>
        <div><dt>Issued by</dt><dd>{{ $first->user->name ?? '—' }}</dd></div>
        <div><dt>Equipment lines</dt><dd>{{ $lines->count() }}</dd></div>
    </dl>
</div>
<div class="table-card"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>#</th><th>Equipment</th><th>Classification</th><th>Asset ID / Quantity</th><th>Serial number</th><th>Purpose</th>@can('inv.view')<th></th>@endcan</tr></thead><tbody>
@foreach($lines as $i => $m)
<tr>
    <td class="text-muted">{{ $i + 1 }}</td>
    <td style="min-width:200px"><div class="inv-name">{{ $m->equipment->name }}</div><div class="inv-sub"><span class="inv-code">{{ $m->equipment->code }}</span>@if(trim($m->equipment->brand.' '.$m->equipment->model)) · {{ trim($m->equipment->brand.' '.$m->equipment->model) }}@endif</div></td>
    <td>@include('inventory._crumb', ['e' => $m->equipment])</td>
    <td>@if($m->serial_no)<strong class="inv-sn text-body">{{ $m->serial_no }}</strong>@else<span class="inv-q">{{ \App\Support\Inv::qty(abs($m->qty)) }}</span> <span class="text-muted">{{ $m->equipment->unit }}</span>@endif</td>
    <td>{{ $m->device_serial_no ?: '—' }}</td>
    <td>{{ $m->remarks ?: '—' }}</td>
    @can('inv.view')<td class="text-end"><a href="{{ route('inv.records.show', $m) }}">Record {{ $m->ref }}</a></td>@endcan
</tr>
@endforeach
</tbody></table></div></div>
@endsection
