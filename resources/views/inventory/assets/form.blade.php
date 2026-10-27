@extends('layouts.app')
@section('title', 'Edit '.$asset->asset_code)
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ route('inv.assets.update', $asset) }}" class="card"><div class="card-body">@csrf @method('PUT')
<div class="row g-3">
    <div class="col-md-4"><label class="form-label">Serial number</label><input name="serial_no" value="{{ old('serial_no', $asset->serial_no) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Purchase date</label><input type="date" name="purchase_date" value="{{ old('purchase_date', $asset->purchase_date?->format('Y-m-d')) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Cost</label><input type="number" step="0.01" min="0" name="cost" value="{{ old('cost', $asset->cost) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Supplier</label><input name="supplier" value="{{ old('supplier', $asset->supplier) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Warranty ends</label><input type="date" name="warranty_end" value="{{ old('warranty_end', $asset->warranty_end?->format('Y-m-d')) }}" class="form-control"></div>
    @if($asset->status !== 'ALLOCATED')<div class="col-md-4"><label class="form-label">Store</label><select name="location_id" class="form-select"><option value="">—</option>@foreach($locations as $l)<option value="{{ $l->id }}" @selected(old('location_id', $asset->location_id) == $l->id)>{{ $l->name }}</option>@endforeach</select></div>@endif
    <div class="col-12"><label class="form-label">Notes (configuration, accessories …)</label><textarea name="notes" rows="3" class="form-control">{{ old('notes', $asset->notes) }}</textarea></div>
</div><div class="mt-3"><button class="btn btn-primary">Save</button> <a href="{{ route('inv.assets.show', $asset) }}" class="btn btn-link">Cancel</a></div></div></form>
@endsection
