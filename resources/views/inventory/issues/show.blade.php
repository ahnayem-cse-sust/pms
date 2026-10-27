@extends('layouts.app')
@section('title', $i->ref)
@section('content')
@include('inventory._errors')
@php($u = auth()->user())
@php($canFulfil = $u->can('inv.issue.fulfill') && in_array($i->status, ['APPROVED', 'PARTIAL']) || ($u->can('inv.issue.fulfill') && ! $needApproval && $i->status === 'SUBMITTED'))
<div class="d-flex flex-wrap gap-2 align-items-center mb-3"><h5 class="mb-0">{{ $i->ref }}</h5> {{ \App\Support\Inv::pill($i->status) }}
<div class="ms-auto d-flex flex-wrap gap-2">
@if($i->status === 'SUBMITTED' && $u->can('inv.issue.approve'))<form method="POST" action="{{ route('inv.issues.act', [$i, 'approve']) }}">@csrf<button class="btn btn-sm btn-success">Approve</button></form>
<form method="POST" action="{{ route('inv.issues.act', [$i, 'reject']) }}" class="d-flex gap-1">@csrf<input name="reason" class="form-control form-control-sm" placeholder="Reason" required><button class="btn btn-sm btn-outline-danger">Reject</button></form>@endif
@if(in_array($i->status, ['SUBMITTED', 'APPROVED']))<form method="POST" action="{{ route('inv.issues.act', [$i, 'cancel']) }}" onsubmit="return confirm('Cancel this request?')">@csrf<button class="btn btn-sm btn-outline-secondary">Cancel</button></form>@endif
@if($i->status === 'PARTIAL' && $u->can('inv.issue.fulfill'))<form method="POST" action="{{ route('inv.issues.act', [$i, 'close']) }}" class="d-flex gap-1">@csrf<input name="reason" class="form-control form-control-sm" placeholder="Why close with the balance unfulfilled?" required><button class="btn btn-sm btn-outline-secondary">Close</button></form>@endif
</div></div>
<div class="card mb-3"><div class="card-body small"><dl class="row mb-0">
    <dt class="col-md-2">Requested by</dt><dd class="col-md-4">{{ $i->requester->name ?? '' }}</dd><dt class="col-md-2">Recipient</dt><dd class="col-md-4">{{ $i->recipient->name ?? ($i->department->name ?? '').' (dept)' }}</dd>
    <dt class="col-md-2">Required by</dt><dd class="col-md-4">{{ $i->required_date?->format('d M Y') ?? '—' }}</dd><dt class="col-md-2">Related request</dt><dd class="col-md-4">{{ $i->ticket_no ?: '—' }}</dd>
    <dt class="col-md-2">Store</dt><dd class="col-md-4">{{ $i->location->path ?? '—' }}</dd><dt class="col-md-2">Approved by</dt><dd class="col-md-4">{{ $i->approver->name ?? '—' }}</dd>
    <dt class="col-md-2">Purpose</dt><dd class="col-md-10">{{ $i->purpose }}</dd>@if($i->reason)<dt class="col-md-2">Reason</dt><dd class="col-md-10">{{ $i->reason }}</dd>@endif</dl></div></div>
@if($canFulfil)<form method="POST" action="{{ route('inv.issues.act', [$i, 'fulfil']) }}">@csrf
<div class="row g-2 mb-2"><div class="col-md-4"><label class="form-label">Issue from store *</label><select name="location_id" class="form-select form-select-sm" required>@foreach($stores as $s)<option value="{{ $s->id }}" @selected(($i->location_id) == $s->id)>{{ $s->path }}</option>@endforeach</select></div></div>@endif
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Item</th><th class="text-end">Requested</th><th class="text-end">Issued</th><th>Stock / asset</th>@if($canFulfil)<th style="width:260px">Issue now</th>@endif</tr></thead><tbody>
@foreach($i->lines as $l)@php($left = $l->qty_requested - $l->qty_issued)<tr><td>{{ $l->item->name }}</td><td class="text-end">{{ \App\Support\Inv::qty($l->qty_requested) }} {{ $l->item->unit->name ?? '' }}</td><td class="text-end">{{ \App\Support\Inv::qty($l->qty_issued) }}</td>
<td class="small">@if($l->item->type === 'CONSUMABLE')@foreach(($stock[$l->item_id] ?? []) as $b){{ $b->location->name }}: {{ \App\Support\Inv::qty($b->qty) }}@if(! $loop->last), @endif @endforeach @else {{ $l->asset->asset_code ?? '' }} @endif</td>
@if($canFulfil)<td>@if($left > 0)@if($l->item->type === 'CONSUMABLE')<input type="number" step="0.01" min="0" max="{{ $left }}" name="pick[{{ $l->id }}][qty]" class="form-control form-control-sm" placeholder="max {{ \App\Support\Inv::qty($left) }}">
 @else<select name="pick[{{ $l->id }}][asset_id]" class="form-select form-select-sm"><option value="">Choose asset…</option>@foreach(($assets[$l->item_id] ?? []) as $a)<option value="{{ $a->id }}">{{ $a->asset_code }} {{ $a->serial_no ? '· '.$a->serial_no : '' }}</option>@endforeach</select>@endif @else<span class="text-muted">Done</span>@endif</td>@endif</tr>@endforeach</tbody></table>
@if($canFulfil)<button class="btn btn-primary" onclick="return confirm('Post this issue? Stock reduces / assets are assigned now.')">Post issue</button></form>@endif
@endsection
