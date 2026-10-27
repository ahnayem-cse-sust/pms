@extends('layouts.app')
@section('title', 'Record '.$m->ref)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('inv.records') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Records</a>
    @if($entryRoute)<a href="{{ route($entryRoute, $m->entry_no) }}" class="btn btn-outline-primary ms-md-auto inv-back"><x-icon name="eye" :size="15"/> View entry {{ $m->entry_no }}@if($entryCount > 1) ({{ $entryCount }} lines)@endif</a>
    <a href="{{ route($entryRoute === 'inv.allocations.show' ? 'inv.allocations.pdf' : 'inv.receives.pdf', $m->entry_no) }}" class="btn btn-primary inv-back"><x-icon name="download" :size="15"/> Download PDF</a>@endif
</div>
<div class="card">
    <div class="inv-hero">
        <span class="type-ico ti-{{ \App\Support\Inv::tone($m->type) }}"><x-icon :name="\App\Support\Inv::icon($m->type)" :size="20"/></span>
        <div><div class="inv-hero-title">{{ $m->ref }}</div><div class="inv-sub">{{ $m->moved_on->format('d M Y') }}@if($m->entry_no) · Entry {{ $m->entry_no }}@endif</div></div>
        <div class="ms-auto d-flex align-items-center gap-3">{{ \App\Support\Inv::pill($m->type) }}<span class="inv-q fs-5 {{ $m->qty > 0 ? 'pos' : ($m->qty < 0 ? 'neg' : '') }}">{{ $m->qty > 0 ? '+' : '' }}{{ \App\Support\Inv::qty($m->qty) }} <span class="text-muted fs-6 fw-normal">{{ $m->equipment->unit }}</span></span></div>
    </div>
    <dl class="inv-meta">
        <div class="wide"><dt>Equipment</dt><dd>{{ $m->equipment->name }} <span class="inv-code">{{ $m->equipment->code }}</span><div class="mt-1">@include('inventory._crumb', ['e' => $m->equipment])</div></dd></div>
        <div><dt>Asset ID</dt><dd>{{ $m->serial_no ?: '—' }}</dd></div>
        <div><dt>Stock after</dt><dd class="inv-num">{{ \App\Support\Inv::qty($m->balance_after) }}</dd></div>
        <div><dt>Entry</dt><dd>{{ $m->entry_no ?: '—' }}</dd></div>
        <div><dt>Date</dt><dd>{{ $m->moved_on->format('d M Y') }}</dd></div>
        <div><dt>Person / department</dt><dd>{{ $m->holder_name ?: '—' }}@if($m->holderUser)<div class="inv-sub fw-normal">{{ $m->holderUser->employee_id }}, {{ $m->holderUser->department->name ?? '' }}</div>@endif</dd></div>
        <div><dt>Reference</dt><dd>{{ $m->reference_no ?: '—' }}</dd></div>
        <div><dt>Supplier</dt><dd>{{ $m->party ?: '—' }}</dd></div>
        <div class="wide"><dt>{{ $m->type === 'ALLOCATE' ? 'Purpose' : 'Remarks' }}</dt><dd>{{ $m->remarks ?: '—' }}</dd></div>
        <div><dt>By</dt><dd>{{ $m->user->name ?? '—' }}</dd></div>
        <div><dt>Recorded at</dt><dd>{{ $m->created_at?->format('d M Y H:i') }}</dd></div>
    </dl>
</div>
@endsection
