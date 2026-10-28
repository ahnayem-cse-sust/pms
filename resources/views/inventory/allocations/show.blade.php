@extends('layouts.app')
@section('title', 'Allocation '.$entry)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    @can('inv.view')<a href="{{ route('inv.allocations.entries') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Allocation records</a>@endcan
    <a href="{{ route('inv.allocations.pdf', $entry) }}" class="btn btn-primary ms-md-auto inv-back"><x-icon name="download" :size="15"/> Download PDF</a>
</div>
<div class="card">
    <div class="inv-hero">
        <span class="type-ico ti-primary"><x-icon name="arrow-up-right" :size="20"/></span>
        <div><div class="inv-hero-title">{{ $entry }}</div><div class="inv-sub">{{ $first->moved_on->format('d M Y') }} · {{ $lines->count() }} {{ \Illuminate\Support\Str::plural('line', $lines->count()) }}</div></div>
        <div class="ms-auto">{{ \App\Support\Inv::pill($first->type) }}</div>
    </div>
    @php
        $pairs = collect([
            ['Allocated to', $first->holder_name.($first->holderUser ? ' ('.$first->holderUser->employee_id.', '.($first->holderUser->department->name ?? '').')' : '')],
            ['Date', $first->moved_on->format('d M Y')],
            ['Reference', $first->reference_no ?: '—'],
            ['Issued by', $first->user->name ?? '—'],
            ['Entry', $entry],
            ['Equipment lines', $lines->count()],
        ]);
        $half = (int) ceil($pairs->count() / 2);   // same number of rows on both sides; an odd total leaves the right side blank
        $left = $pairs->take($half)->values();
        $right = $pairs->slice($half)->values();
    @endphp
    <div class="table-responsive inv-lines">
    <table class="table table-bordered align-middle inv-info mb-0"><tbody>
        @for($i = 0; $i < $half; $i++)
        <tr>
            <th>{{ $left[$i][0] }}</th><td>{{ $left[$i][1] }}</td>
            @if(isset($right[$i]))<th>{{ $right[$i][0] }}</th><td>{{ $right[$i][1] }}</td>@else<th></th><td></td>@endif
        </tr>
        @endfor
    </tbody></table>
    </div>
<div class="inv-history-head">Equipment <span class="inv-count">{{ $lines->count() }}</span></div>
<div class="table-responsive inv-lines"><table class="table align-middle"><thead><tr><th>Equipment ID</th><th>Equipment</th><th>Asset ID</th><th>Serial number</th><th class="text-end">Quantity</th><th>Purpose</th><th></th></tr></thead><tbody>
@foreach($lines as $m)
@php
    $e = $m->equipment;
    $left = $held[$m->equipment_id.'|'.($m->serial_no ?? '')] ?? 0;
    $returnUrl = route('inv.receive', ['from' => ($first->holder_type === 'EMPLOYEE' ? 'E:'.$first->holder_user_id : 'D:'.$first->holder_department_id), 'equipment_id' => $m->equipment_id, 'serial' => $m->serial_no]);
@endphp
<tr>
    <td class="text-nowrap"><span class="inv-code">{{ $e->code }}</span></td>
    <td style="min-width:180px">@can('inv.view')<a href="{{ route('inv.equipment.show', $e) }}" class="inv-name">{{ $e->name }}</a>@else<span class="inv-name">{{ $e->name }}</span>@endcan</td>
    <td>@if($m->serial_no)<strong class="inv-sn text-body">{{ $m->serial_no }}</strong>@else—@endif</td>
    <td>{{ $m->device_serial_no ?: '—' }}</td>
    <td class="text-end text-nowrap"><span class="inv-q">{{ \App\Support\Inv::qty(abs($m->qty)) }}</span> <span class="text-muted">{{ $e->unit }}</span></td>
    <td>{{ $m->remarks ?: '—' }}</td>
    <td class="text-end text-nowrap">
        @if($left > 0)@can('inv.create')<a class="btn btn-sm btn-outline-primary" href="{{ $returnUrl }}"><x-icon name="corner-up-left" :size="14"/> Return</a>@endcan @endif
        @can('inv.view')<a class="btn btn-sm btn-outline-secondary" href="{{ route('inv.records.show', $m) }}">Record {{ $m->ref }}</a>@endcan
    </td>
</tr>
@endforeach
</tbody></table></div>
</div>
@endsection
