@extends('layouts.app')
@section('title', $t->ref)
@section('content')
@include('inventory._errors')
@php($u = auth()->user())
<div class="d-flex flex-wrap gap-2 align-items-center mb-3"><h5 class="mb-0">{{ $t->ref }} · {{ $t->kind }}</h5> {{ \App\Support\Inv::pill($t->status) }}
<div class="ms-auto d-flex flex-wrap gap-2">
@if($t->status === 'REQUESTED' && $u->can('inv.assign.approve'))<form method="POST" action="{{ route('inv.movements.act', [$t, 'approve']) }}">@csrf<button class="btn btn-sm btn-success">Approve</button></form>@endif
@if(in_array($t->status, ['REQUESTED', 'APPROVED']) && $u->can('inv.assign.approve'))<form method="POST" action="{{ route('inv.movements.act', [$t, 'reject']) }}" class="d-flex gap-1">@csrf<input name="reason" class="form-control form-control-sm" placeholder="Reason" required><button class="btn btn-sm btn-outline-danger">Reject</button></form>@endif
@if($u->can('inv.assign.complete') && (($needApproval && $t->status === 'APPROVED') || (! $needApproval && in_array($t->status, ['REQUESTED', 'APPROVED']))))<form method="POST" action="{{ route('inv.movements.act', [$t, 'post']) }}" onsubmit="return confirm('Post now? Custody / stock changes immediately.')">@csrf<button class="btn btn-sm btn-primary">Post</button></form>@endif
@if(in_array($t->status, ['REQUESTED', 'APPROVED']))<form method="POST" action="{{ route('inv.movements.act', [$t, 'cancel']) }}" onsubmit="return confirm('Cancel?')">@csrf<button class="btn btn-sm btn-outline-secondary">Cancel</button></form>@endif
</div></div>
<div class="card"><div class="card-body small"><dl class="row mb-0">
    <dt class="col-md-2">{{ $t->asset ? 'Asset' : 'Item' }}</dt><dd class="col-md-10">@if($t->asset)<a href="{{ route('inv.assets.show', $t->asset) }}">{{ $t->asset->asset_code }}</a> · {{ $t->asset->item->name }}@else {{ $t->item->name ?? '' }} × {{ \App\Support\Inv::qty($t->qty) }}@endif</dd>
    <dt class="col-md-2">From</dt><dd class="col-md-4">{{ $t->party('from') }}</dd><dt class="col-md-2">To</dt><dd class="col-md-4">{{ $t->party('to') }}</dd>
    <dt class="col-md-2">Requested by</dt><dd class="col-md-4">{{ $t->requester->name ?? '' }} · {{ $t->created_at->format('d M Y') }}</dd><dt class="col-md-2">Approved by</dt><dd class="col-md-4">{{ $t->approver->name ?? '—' }}</dd>
    <dt class="col-md-2">Condition</dt><dd class="col-md-4">{{ $t->condition->name ?? '—' }}</dd><dt class="col-md-2">Accessories</dt><dd class="col-md-4">{{ $t->accessories ?: '—' }}</dd>
    <dt class="col-md-2">Effective date</dt><dd class="col-md-4">{{ $t->effective_date?->format('d M Y') ?? '—' }}</dd><dt class="col-md-2">Posted</dt><dd class="col-md-4">{{ $t->posted_at?->format('d M Y H:i') ?? '—' }}</dd>
    <dt class="col-md-2">Remarks</dt><dd class="col-md-10">{{ $t->remarks ?: '—' }}</dd>@if($t->reason)<dt class="col-md-2">Reason</dt><dd class="col-md-10">{{ $t->reason }}</dd>@endif</dl></div></div>
@endsection
