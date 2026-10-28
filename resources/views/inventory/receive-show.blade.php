@extends('layouts.app')
@section('title', 'Receive '.$entry)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('inv.receives') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Receives</a>
    <a href="{{ route('inv.receives.pdf', $entry) }}" class="btn btn-primary ms-md-auto inv-back"><x-icon name="download" :size="15"/> Download PDF</a>
</div>
<div class="card">
    <div class="inv-hero">
        <span class="type-ico ti-{{ \App\Support\Inv::tone($first->type) }}"><x-icon :name="\App\Support\Inv::icon($first->type)" :size="20"/></span>
        <div><div class="inv-hero-title">{{ $entry }}</div><div class="inv-sub">{{ $first->moved_on->format('d M Y') }} · {{ $lines->count() }} {{ \Illuminate\Support\Str::plural('equipment', $lines->count()) }}</div></div>
        <div class="ms-auto">{{ \App\Support\Inv::pill($first->type) }}</div>
    </div>
    @php
        $from = $first->type === 'RETURN'
            ? '<span class="pill pill-info">Return</span> '.e($first->holder_name).($first->holderUser ? ' <span class="text-muted fw-normal">('.e($first->holderUser->employee_id).', '.e($first->holderUser->department->name ?? '').')</span>' : '')
            : ($first->type === 'OPENING' ? '<span class="pill pill-secondary">Previous item</span> '.e($first->party) : '<span class="pill pill-success">Supplier</span> '.e($first->party));
        $pairs = collect([
            ['Entry', e($entry)],
            ['Received from', $from],
            ['Date', e($first->moved_on->format('d M Y'))],
            ['Reference', e($first->reference_no ?: '—')],
            ['Entered by', e($first->user->name ?? '—')],
            ['Equipment', e($lines->count())],
            ['Total items', e(\App\Support\Inv::qty($lines->sum(fn ($m) => abs($m->qty))))],
            ['Remarks', e($first->remarks ?: '—')],
        ]);
        $half = (int) ceil($pairs->count() / 2);   // same number of rows on both sides; an odd total leaves the right side blank
        $left = $pairs->take($half)->values();
        $right = $pairs->slice($half)->values();
    @endphp
    <div class="table-responsive inv-lines">
    <table class="table table-bordered align-middle inv-info mb-0"><tbody>
        @for($i = 0; $i < $half; $i++)
        <tr>
            <th>{{ $left[$i][0] }}</th><td>{!! $left[$i][1] !!}</td>
            @if(isset($right[$i]))<th>{{ $right[$i][0] }}</th><td>{!! $right[$i][1] !!}</td>@else<th></th><td></td>@endif
        </tr>
        @endfor
    </tbody></table>
    </div>
<div class="inv-history-head">Equipment <span class="inv-count">{{ $lines->count() }}</span></div>
<div class="table-responsive inv-lines"><table class="table align-middle"><thead><tr><th>Equipment ID</th><th>Equipment</th><th>Asset type</th><th>Category</th><th>Sub category</th><th class="text-end">Quantity</th><th></th></tr></thead><tbody>
@foreach($lines as $m)
<tr>
    <td class="text-nowrap"><span class="inv-code">{{ $m->equipment->code }}</span></td>
    <td style="min-width:180px"><div class="inv-name">{{ $m->equipment->name }}</div>@if(trim($m->equipment->brand.' '.$m->equipment->model))<div class="inv-sub">{{ trim($m->equipment->brand.' '.$m->equipment->model) }}</div>@endif</td>
    <td>{{ $m->equipment->assetType->name ?? '—' }}</td>
    <td>{{ $m->equipment->category->name ?? '—' }}</td>
    <td>{{ $m->equipment->subcategory->name ?? '—' }}</td>
    <td class="text-end text-nowrap"><span class="inv-q {{ $m->qty > 0 ? 'pos' : '' }}">{{ \App\Support\Inv::qty($m->qty) }}</span> <span class="text-muted">{{ $m->equipment->unit }}</span></td>
    <td class="text-end"><a href="{{ route('inv.records.show', $m) }}">Record {{ $m->ref }}</a></td>
</tr>
@endforeach
</tbody></table></div>
</div>
@endsection
