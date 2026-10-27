@extends('layouts.app')
@section('title', $d->ref)
@section('content')
@include('inventory._errors')
@php($u = auth()->user())
<div class="d-flex flex-wrap gap-2 align-items-center mb-3"><h5 class="mb-0">{{ $d->ref }}</h5> {{ \App\Support\Inv::pill($d->status) }}
<div class="ms-auto d-flex flex-wrap gap-2">
@if($d->status === 'PROPOSED' && $u->can('inv.disposal.approve'))<form method="POST" action="{{ route('inv.disposals.act', [$d, 'approve']) }}">@csrf<button class="btn btn-sm btn-success">Approve</button></form>
<form method="POST" action="{{ route('inv.disposals.act', [$d, 'reject']) }}" class="d-flex gap-1">@csrf<input name="reason" class="form-control form-control-sm" placeholder="Reason" required><button class="btn btn-sm btn-outline-danger">Reject</button></form>@endif
@if(in_array($d->status, ['PROPOSED', 'APPROVED']))<form method="POST" action="{{ route('inv.disposals.act', [$d, 'cancel']) }}" onsubmit="return confirm('Cancel this proposal?')">@csrf<button class="btn btn-sm btn-outline-secondary">Cancel</button></form>@endif
</div></div>
<div class="card mb-3"><div class="card-body small"><dl class="row mb-0">
    <dt class="col-md-2">Asset</dt><dd class="col-md-4"><a href="{{ route('inv.assets.show', $d->asset) }}">{{ $d->asset->asset_code }}</a> · {{ $d->asset->item->name }} ({{ \App\Support\Inv::label($d->asset->status) }})</dd><dt class="col-md-2">Reason</dt><dd class="col-md-4">{{ config('inventory.disposal_reasons.'.$d->reason) }}</dd>
    <dt class="col-md-2">Proposed by</dt><dd class="col-md-4">{{ $d->proposer->name ?? '' }}</dd><dt class="col-md-2">Approved by</dt><dd class="col-md-4">{{ $d->approver->name ?? '—' }}</dd>
    <dt class="col-md-2">Proposed action</dt><dd class="col-md-4">{{ $d->proposed_action ?: '—' }}</dd><dt class="col-md-2">Proposed date</dt><dd class="col-md-4">{{ $d->proposed_date?->format('d M Y') ?? '—' }}</dd>
    <dt class="col-md-2">Justification</dt><dd class="col-md-10">{{ $d->remarks }}</dd>@if($d->reject_reason)<dt class="col-md-2">Rejected because</dt><dd class="col-md-10">{{ $d->reject_reason }}</dd>@endif
    @if($d->status === 'COMPLETED')<dt class="col-md-2">Method</dt><dd class="col-md-4">{{ $d->method }}</dd><dt class="col-md-2">Date</dt><dd class="col-md-4">{{ $d->disposal_date?->format('d M Y') }}</dd><dt class="col-md-2">Receiving party</dt><dd class="col-md-4">{{ $d->recipient ?: '—' }}</dd><dt class="col-md-2">Proceeds</dt><dd class="col-md-4">{{ $d->proceeds ?? '—' }}</dd>@endif</dl></div></div>
@if($d->status === 'APPROVED' && $u->can('inv.disposal.complete'))
<form method="POST" action="{{ route('inv.disposals.act', [$d, 'complete']) }}" class="card mb-3" onsubmit="return confirm('Complete the disposal? The asset becomes Retired / Disposed and can never be assigned again.')"><div class="card-body">@csrf
    <div class="fw-semibold mb-2">Complete disposal</div><div class="row g-2">
        <div class="col-md-3"><input name="method" class="form-control form-control-sm" placeholder="Method (sold, scrapped, donated …) *" required></div>
        <div class="col-md-2"><input type="date" name="disposal_date" value="{{ today()->format('Y-m-d') }}" class="form-control form-control-sm" required></div>
        <div class="col-md-3"><input name="recipient" class="form-control form-control-sm" placeholder="Receiving party / vendor"></div>
        <div class="col-md-2"><input type="number" step="0.01" min="0" name="proceeds" class="form-control form-control-sm" placeholder="Proceeds / value"></div>
        <div class="col-md-12"><input name="remarks" class="form-control form-control-sm" placeholder="Final remarks"></div></div><button class="btn btn-danger btn-sm mt-2">Complete disposal</button></div></form>@endif
@include('inventory._docs', ['type' => 'disposal', 'id' => $d->id, 'docs' => $docs, 'canUpload' => $u->can('inv.disposal.create')])
@endsection
