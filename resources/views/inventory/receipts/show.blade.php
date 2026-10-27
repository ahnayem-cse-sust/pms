@extends('layouts.app')
@section('title', $r->ref)
@section('content')
@include('inventory._errors')
@php($u = auth()->user())
<div class="d-flex flex-wrap gap-2 align-items-center mb-3"><h5 class="mb-0">{{ $r->ref }}</h5> {{ \App\Support\Inv::pill($r->status) }}
<div class="ms-auto d-flex flex-wrap gap-2">
@if($r->status === 'DRAFT' && $u->can('inv.receipt.create'))<form method="POST" action="{{ route('inv.receipts.act', [$r, 'submit']) }}">@csrf<button class="btn btn-sm btn-primary">Submit</button></form>@endif
@if($r->status === 'SUBMITTED' && $u->can('inv.receipt.approve'))<form method="POST" action="{{ route('inv.receipts.act', [$r, 'approve']) }}">@csrf<button class="btn btn-sm btn-success">Approve</button></form>@endif
@if(in_array($r->status, ['SUBMITTED', 'APPROVED']) && $u->can('inv.receipt.approve'))<form method="POST" action="{{ route('inv.receipts.act', [$r, 'reject']) }}" class="d-flex gap-1">@csrf<input name="reason" class="form-control form-control-sm" placeholder="Reason" required><button class="btn btn-sm btn-outline-danger">Reject</button></form>@endif
@if($u->can('inv.receipt.post') && (($needApproval && $r->status === 'APPROVED') || (! $needApproval && in_array($r->status, ['DRAFT', 'SUBMITTED', 'APPROVED']))))<form method="POST" action="{{ route('inv.receipts.act', [$r, 'post']) }}" onsubmit="return confirm('Post this receipt? Stock and assets are created and cannot be silently edited.')">@csrf<button class="btn btn-sm btn-primary">Post receipt</button></form>@endif
@if(in_array($r->status, ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED']))<form method="POST" action="{{ route('inv.receipts.act', [$r, 'cancel']) }}" onsubmit="return confirm('Cancel this receipt?')">@csrf<button class="btn btn-sm btn-outline-secondary">Cancel</button></form>@endif
</div></div>
<div class="card mb-3"><div class="card-body small"><dl class="row mb-0">
    <dt class="col-md-2">Date</dt><dd class="col-md-4">{{ $r->receipt_date->format('d M Y') }}</dd><dt class="col-md-2">Supplier</dt><dd class="col-md-4">{{ $r->supplier->name ?? '—' }}</dd>
    <dt class="col-md-2">PO / procurement</dt><dd class="col-md-4">{{ $r->procurement_ref ?: '—' }}</dd><dt class="col-md-2">Invoice / challan</dt><dd class="col-md-4">{{ $r->invoice_no ?: '—' }}</dd>
    <dt class="col-md-2">Location</dt><dd class="col-md-4">{{ $r->location->path ?? '' }}</dd><dt class="col-md-2">Received by</dt><dd class="col-md-4">{{ $r->receiver->name ?? '—' }}</dd>
    <dt class="col-md-2">Prepared by</dt><dd class="col-md-4">{{ $r->preparer->name ?? '' }}</dd><dt class="col-md-2">Approved by</dt><dd class="col-md-4">{{ $r->approver->name ?? '—' }} {{ $r->approved_at?->format('d M Y') }}</dd>
    @if($r->reason)<dt class="col-md-2">Reason</dt><dd class="col-md-10">{{ $r->reason }}</dd>@endif
    <dt class="col-md-2">Remarks</dt><dd class="col-md-10">{{ $r->remarks ?: '—' }}</dd></dl></div></div>
<table class="table table-sm bg-white"><thead class="table-light"><tr><th>Item</th><th>Type</th><th class="text-end">Received</th><th class="text-end">Rejected</th><th class="text-end">Unit cost</th><th>Serial numbers</th></tr></thead><tbody>
@foreach($r->lines as $l)<tr><td>{{ $l->item->name }}</td><td>{{ $l->item->type }}</td><td class="text-end">{{ \App\Support\Inv::qty($l->qty_received) }}</td><td class="text-end">{{ \App\Support\Inv::qty($l->qty_rejected) }}</td><td class="text-end">{{ $l->unit_cost }}</td><td style="white-space:pre-line">{{ $l->serials }}</td></tr>@endforeach</tbody></table>
@include('inventory._docs', ['type' => 'receipt', 'id' => $r->id, 'docs' => $docs, 'canUpload' => $u->can('inv.receipt.create')])
@endsection
