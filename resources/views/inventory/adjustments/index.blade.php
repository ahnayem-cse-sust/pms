@extends('layouts.app')
@section('title', 'Adjustments & Stock Ledger')
@section('content')
@include('inventory._errors')
@can('inv.adjust.create')
<form method="POST" action="{{ route('inv.adjustments.store') }}" class="card mb-3"><div class="card-body">@csrf
    <div class="fw-semibold mb-2">New stock adjustment <span class="text-muted fw-normal small">– stock changes only after approval</span></div>
    <div class="row g-2">
        <div class="col-md-3"><select name="item_id" class="form-select form-select-sm" required><option value="">Item…</option>@foreach($items as $i)<option value="{{ $i->id }}">{{ $i->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><select name="location_id" class="form-select form-select-sm" required><option value="">Location…</option>@foreach($locations as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><input type="number" step="0.01" name="qty_delta" class="form-control form-control-sm" placeholder="+ gain / − loss" required></div>
        <div class="col-md-2"><select name="reason_code" class="form-select form-select-sm">@foreach(config('inventory.adjust_reasons') as $k => $l)<option value="{{ $k }}">{{ $l }}</option>@endforeach</select></div>
        <div class="col-md-3"><input name="notes" class="form-control form-control-sm" placeholder="Reason / evidence *" required></div>
    </div><button class="btn btn-primary btn-sm mt-2">Submit</button>
</div></form>
@endcan
<h6>Adjustments</h6>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Reference</th><th>Item</th><th>Location</th><th class="text-end">Qty</th><th>Reason</th><th>Prepared / approved</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($adj as $a)<tr><td>{{ $a->ref }}</td><td>{{ $a->item->name }}</td><td>{{ $a->location->name }}</td><td class="text-end">{{ \App\Support\Inv::qty($a->qty_delta) }}</td><td>{{ config('inventory.adjust_reasons.'.$a->reason_code) }}<div class="text-muted small">{{ $a->notes }}</div></td>
<td>{{ $a->preparer->name ?? '' }} / {{ $a->approver->name ?? '—' }}</td><td>{{ \App\Support\Inv::pill($a->status) }}</td>
<td class="text-nowrap">@if($a->status === 'PENDING')@can('inv.adjust.approve')<form method="POST" action="{{ route('inv.adjustments.act', [$a, 'approve']) }}" class="d-inline">@csrf<button class="btn btn-sm btn-success">Approve</button></form>
<form method="POST" action="{{ route('inv.adjustments.act', [$a, 'reject']) }}" class="d-inline" onsubmit="this.reason.value = prompt('Reason for rejecting?') || ''; return this.reason.value">@csrf<input type="hidden" name="reason"><button class="btn btn-sm btn-outline-danger">Reject</button></form>@endcan @endif</td></tr>
@empty<tr><td colspan="8" class="text-center text-muted py-3">None.</td></tr>@endforelse</tbody></table>
{{ $adj->links() }}
<h6 class="mt-4">Stock ledger</h6>
<form class="row g-2 mb-2" method="GET"><div class="col-md-3"><select name="item_id" class="form-select form-select-sm"><option value="">All items</option>@foreach($items as $i)<option value="{{ $i->id }}" @selected(request('item_id') == $i->id)>{{ $i->name }}</option>@endforeach</select></div>
<div class="col-md-3"><select name="location_id" class="form-select form-select-sm"><option value="">All locations</option>@foreach($locations as $l)<option value="{{ $l->id }}" @selected(request('location_id') == $l->id)>{{ $l->name }}</option>@endforeach</select></div><div class="col-md-2"><button class="btn btn-sm btn-outline-secondary">Filter</button></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Ref</th><th>Date</th><th>Type</th><th>Item</th><th>Location</th><th class="text-end">In</th><th class="text-end">Out</th><th class="text-end">Balance</th><th>By</th><th></th></tr></thead><tbody>
@foreach($ledger as $t)<tr><td>{{ $t->ref }}<div class="text-muted small">{{ $t->source_ref }}</div></td><td>{{ $t->posting_date->format('d M Y') }}</td><td>{{ $t->type }}</td><td>{{ $t->item->name }}</td><td>{{ $t->location->name }}</td><td class="text-end">{{ $t->qty_in > 0 ? \App\Support\Inv::qty($t->qty_in) : '' }}</td><td class="text-end">{{ $t->qty_out > 0 ? \App\Support\Inv::qty($t->qty_out) : '' }}</td><td class="text-end">{{ \App\Support\Inv::qty($t->balance_after) }}</td><td>{{ $t->creator->name ?? '' }}</td>
<td>@if($t->type === 'REVERSAL' || $t->reverses_id)<span class="pill pill-secondary">Reversal</span>@elseif(in_array($t->id, $reversed))<span class="pill pill-secondary">Reversed</span>@else @can('inv.adjust.approve')<form method="POST" action="{{ route('inv.ledger.reverse', $t) }}" onsubmit="this.reason.value = prompt('Reason for reversing {{ $t->ref }}?') || ''; return this.reason.value">@csrf<input type="hidden" name="reason"><button class="btn btn-sm btn-outline-danger">Reverse</button></form>@endcan @endif</td></tr>@endforeach</tbody></table>
{{ $ledger->links() }}
@endsection
