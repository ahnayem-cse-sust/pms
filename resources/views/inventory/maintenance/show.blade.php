@extends('layouts.app')
@section('title', $m->ref)
@section('content')
@include('inventory._errors')
<div class="d-flex gap-2 align-items-center mb-3"><h5 class="mb-0">{{ $m->ref }}</h5> {{ \App\Support\Inv::pill($m->status) }}</div>
<div class="card mb-3"><div class="card-body small"><dl class="row mb-0">
    <dt class="col-md-2">Asset</dt><dd class="col-md-4"><a href="{{ route('inv.assets.show', $m->asset) }}">{{ $m->asset->asset_code }}</a> · {{ $m->asset->item->name }}</dd><dt class="col-md-2">Reported</dt><dd class="col-md-4">{{ $m->reported_date->format('d M Y') }} by {{ $m->creator->name ?? '' }}</dd>
    <dt class="col-md-2">Fault</dt><dd class="col-md-10">{{ $m->fault }}</dd><dt class="col-md-2">Related request</dt><dd class="col-md-4">{{ $m->ticket_no ?: '—' }}</dd><dt class="col-md-2">Warranty status</dt><dd class="col-md-4">{{ $m->asset->warranty_end ? ($m->asset->warranty_end->isPast() ? 'Expired '.$m->asset->warranty_end->format('d M Y') : 'In warranty until '.$m->asset->warranty_end->format('d M Y')) : 'Unknown' }}</dd>
    @if(! $m->is_open)<dt class="col-md-2">Completed</dt><dd class="col-md-4">{{ $m->completed_date?->format('d M Y') }}</dd><dt class="col-md-2">Outcome</dt><dd class="col-md-4">{{ $m->outcome }}</dd>@endif</dl></div></div>
@if($m->is_open) @can('inv.maint.update')
<form method="POST" action="{{ route('inv.maintenance.update', $m) }}" class="card mb-3"><div class="card-body">@csrf @method('PUT')
    <div class="row g-2">
        <div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select form-select-sm" id="st">@foreach(config('inventory.maintenance_statuses') as $k => $l)<option value="{{ $k }}" @selected(old('status', $m->status) == $k)>{{ $l }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label">Service provider / technician</label><input name="vendor" value="{{ old('vendor', $m->vendor) }}" class="form-control form-control-sm"></div>
        <div class="col-md-2"><label class="form-label">Cost (if known)</label><input type="number" step="0.01" min="0" name="cost" value="{{ old('cost', $m->cost) }}" class="form-control form-control-sm"></div>
        <div class="col-md-2"><label class="form-label">Related request</label><input name="ticket_no" value="{{ old('ticket_no', $m->ticket_no) }}" class="form-control form-control-sm"></div>
        <div class="col-md-2"><div class="form-check mt-4"><input class="form-check-input" type="checkbox" name="warranty_claim" value="1" id="wc" @checked(old('warranty_claim', $m->warranty_claim))><label class="form-check-label" for="wc">Warranty claim</label></div></div>
        <div class="col-md-6"><label class="form-label">Action taken / diagnostic notes</label><textarea name="action_taken" rows="2" class="form-control form-control-sm">{{ old('action_taken', $m->action_taken) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">Parts replaced</label><textarea name="parts_replaced" rows="2" class="form-control form-control-sm">{{ old('parts_replaced', $m->parts_replaced) }}</textarea></div>
        <div class="col-md-8 fin"><label class="form-label">Outcome (required to complete)</label><input name="outcome" value="{{ old('outcome', $m->outcome) }}" class="form-control form-control-sm"></div>
        <div class="col-md-4 fin"><label class="form-label">Asset status after repair</label><select name="after" class="form-select form-select-sm"><option value="">—</option><option value="RESTORE">Back in service</option><option value="DAMAGED">Not repairable – damaged</option><option value="UNAVAILABLE">Temporarily unavailable</option></select></div>
    </div><button class="btn btn-primary btn-sm mt-2">Save</button>
</div></form>
@endcan @endif
@include('inventory._docs', ['type' => 'maintenance', 'id' => $m->id, 'docs' => $docs, 'canUpload' => auth()->user()->can('inv.maint.update')])
<div class="card"><div class="card-body small"><b>Work performed:</b> {{ $m->action_taken ?: '—' }}<br><b>Parts:</b> {{ $m->parts_replaced ?: '—' }}<br><b>Cost:</b> {{ $m->cost ?? '—' }}</div></div>
@endsection
