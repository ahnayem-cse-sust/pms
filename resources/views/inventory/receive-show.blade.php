@extends('layouts.app')
@section('title', 'Receive '.$entry)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('inv.receives') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Receives</a>
    <a href="{{ route('inv.receives.pdf', $entry) }}" class="btn btn-primary ms-md-auto inv-back"><x-icon name="download" :size="15"/> Download PDF</a>
</div>
<div class="card mb-3">
    <div class="inv-hero">
        <span class="type-ico ti-{{ \App\Support\Inv::tone($first->type) }}"><x-icon :name="\App\Support\Inv::icon($first->type)" :size="20"/></span>
        <div><div class="inv-hero-title">{{ $entry }}</div><div class="inv-sub">{{ $first->moved_on->format('d M Y') }} · {{ $lines->count() }} {{ \Illuminate\Support\Str::plural('line', $lines->count()) }}</div></div>
        <div class="ms-auto">{{ \App\Support\Inv::pill($first->type) }}</div>
    </div>
    <dl class="inv-meta">
        <div class="wide"><dt>Received from</dt><dd>@if($first->type === 'RETURN')<span class="pill pill-info">Return</span> {{ $first->holder_name }}@if($first->holderUser) <span class="text-muted fw-normal">({{ $first->holderUser->employee_id }}, {{ $first->holderUser->department->name ?? '' }})</span>@endif @elseif($first->type === 'OPENING')<span class="pill pill-secondary">Previous item</span> {{ $first->party }}@else<span class="pill pill-success">Supplier</span> {{ $first->party }}@endif</dd></div>
        <div><dt>Date</dt><dd>{{ $first->moved_on->format('d M Y') }}</dd></div>
        <div><dt>Reference</dt><dd>{{ $first->reference_no ?: '—' }}</dd></div>
        <div><dt>Entered by</dt><dd>{{ $first->user->name ?? '—' }}</dd></div>
        <div class="wide"><dt>Remarks</dt><dd>{{ $first->remarks ?: '—' }}</dd></div>
    </dl>
</div>
<div class="table-card"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>#</th><th>Equipment</th><th>Classification</th><th>Serial no.</th><th class="text-end">Quantity</th><th class="text-end">Stock after</th><th></th></tr></thead><tbody>
@foreach($lines as $i => $m)
<tr>
    <td class="text-muted">{{ $i + 1 }}</td>
    <td style="min-width:200px"><div class="inv-name">{{ $m->equipment->name }}</div><div class="inv-sub"><span class="inv-code">{{ $m->equipment->code }}</span>@if(trim($m->equipment->brand.' '.$m->equipment->model)) · {{ trim($m->equipment->brand.' '.$m->equipment->model) }}@endif</div></td>
    <td>@include('inventory._crumb', ['e' => $m->equipment])</td>
    <td>@if($m->serial_no)<span class="inv-sn">{{ $m->serial_no }}</span>@else — @endif</td>
    <td class="text-end"><span class="inv-q {{ $m->qty > 0 ? 'pos' : '' }}">{{ \App\Support\Inv::qty($m->qty) }}</span> <span class="text-muted">{{ $m->equipment->unit }}</span></td>
    <td class="text-end inv-num">{{ \App\Support\Inv::qty($m->balance_after) }}</td>
    <td class="text-end"><a href="{{ route('inv.records.show', $m) }}">Record {{ $m->ref }}</a></td>
</tr>
@endforeach
</tbody></table></div></div>
@endsection
