@extends('layouts.app')
@section('title', $s->ref)
@section('content')
@include('inventory._errors')
@php($u = auth()->user())
@php($open = $s->status === 'OPEN' && $u->can('inv.stocktake.update'))
<div class="d-flex flex-wrap gap-2 align-items-center mb-3"><h5 class="mb-0">{{ $s->ref }} · {{ $s->title }}</h5> {{ \App\Support\Inv::pill($s->status) }}
<div class="ms-auto d-flex flex-wrap gap-2">
@if($s->status === 'OPEN' && $u->can('inv.stocktake.update'))<form method="POST" action="{{ route('inv.stocktakes.act', [$s, 'review']) }}">@csrf<button class="btn btn-sm btn-primary">Submit for review</button></form>@endif
@if($s->status === 'REVIEW' && $u->can('inv.stocktake.approve'))
  <form method="POST" action="{{ route('inv.stocktakes.act', [$s, 'approve']) }}" onsubmit="return confirm('Approve and post the discrepancies as adjustments?')">@csrf<button class="btn btn-sm btn-success">Approve &amp; post adjustments</button></form>
  <form method="POST" action="{{ route('inv.stocktakes.act', [$s, 'reopen']) }}">@csrf<button class="btn btn-sm btn-outline-secondary">Send back</button></form>@endif
@if(in_array($s->status, ['OPEN', 'REVIEW']))<form method="POST" action="{{ route('inv.stocktakes.act', [$s, 'cancel']) }}" onsubmit="return confirm('Cancel this stocktake?')">@csrf<button class="btn btn-sm btn-outline-danger">Cancel</button></form>@endif
</div></div>
<div class="text-muted small mb-2">{{ $s->count_date->format('d M Y') }} · {{ $s->location->name ?? 'All locations' }} · {{ $s->category->name ?? 'All categories' }} · started by {{ $s->creator->name ?? '' }}@if($s->approver) · closed by {{ $s->approver->name }}@endif</div>
@if($open)<form method="POST" action="{{ route('inv.stocktakes.act', [$s, 'save']) }}">@csrf @endif
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Item / asset</th><th>Location</th><th class="text-end">System</th><th style="width:150px">Physical</th><th>Condition</th><th>Remarks</th><th>Result</th></tr></thead><tbody>
@foreach($lines as $l)@php($d = $l->discrepancy)
<tr class="{{ $d ? 'table-warning' : '' }}"><td>@if($l->unrecorded_desc)<b>Unrecorded:</b> {{ $l->unrecorded_desc }}@elseif($l->asset){{ $l->asset->asset_code }} · {{ $l->item->name }}@else{{ $l->item->name }}@endif</td><td>{{ $l->location->name ?? '' }}</td>
<td class="text-end">@if($l->asset_id){{ \App\Support\Inv::label($l->system_status) }}@elseif(! $l->unrecorded_desc){{ \App\Support\Inv::qty($l->system_qty) }}@endif</td>
<td>@if($l->unrecorded_desc)<span class="text-muted">found</span>@elseif($open)@if($l->asset_id)<select name="lines[{{ $l->id }}][physical_status]" class="form-select form-select-sm"><option value="">—</option>@foreach(['FOUND' => 'Found', 'MISSING' => 'Missing', 'MOVED' => 'Found elsewhere'] as $k => $t)<option value="{{ $k }}" @selected($l->physical_status == $k)>{{ $t }}</option>@endforeach</select>@else<input type="number" step="0.01" min="0" name="lines[{{ $l->id }}][physical_qty]" value="{{ $l->physical_qty }}" class="form-control form-control-sm">@endif
 @else{{ $l->asset_id ? \App\Support\Inv::label($l->physical_status) : ($l->physical_qty === null ? '—' : \App\Support\Inv::qty($l->physical_qty)) }}@endif</td>
<td>@if($open && ! $l->unrecorded_desc)<select name="lines[{{ $l->id }}][condition_id]" class="form-select form-select-sm"><option value="">—</option>@foreach($conditions as $c)<option value="{{ $c->id }}" @selected($l->condition_id == $c->id)>{{ $c->name }}</option>@endforeach</select>@endif</td>
<td>@if($open && ! $l->unrecorded_desc)<input name="lines[{{ $l->id }}][remarks]" value="{{ $l->remarks }}" class="form-control form-control-sm">@else{{ $l->remarks }}@endif</td>
<td>@if($d === null)<span class="text-muted">—</span>@elseif($d == 0)<span class="pill pill-success">OK</span>@else<span class="pill pill-danger">{{ $l->asset_id || $l->unrecorded_desc ? 'Discrepancy' : ($d > 0 ? '+' : '').\App\Support\Inv::qty($d) }}</span>@endif</td></tr>@endforeach</tbody></table>
@if($open)<button class="btn btn-primary btn-sm">Save counts</button></form>
<form method="POST" action="{{ route('inv.stocktakes.act', [$s, 'unrecorded']) }}" class="row g-2 mt-3">@csrf
    <div class="col-md-5"><input name="unrecorded_desc" class="form-control form-control-sm" placeholder="Asset found but not in the register (description, serial)" required></div><div class="col-md-1"><button class="btn btn-sm btn-outline-secondary">Add</button></div></form>@endif
@endsection
