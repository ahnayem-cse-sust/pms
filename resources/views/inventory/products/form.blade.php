@extends('layouts.app')
@section('title', $product->exists ? 'Edit product' : 'New product')
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ $product->exists ? route('inv.products.update', $product) : route('inv.products.store') }}" class="card"><div class="card-body">@csrf @if($product->exists) @method('PUT') @endif
<div class="row g-3">
    <div class="col-md-3"><label class="form-label">Code *</label><input name="code" value="{{ old('code', $product->code) }}" class="form-control" required></div>
    <div class="col-md-5"><label class="form-label">Name *</label><input name="name" value="{{ old('name', $product->name) }}" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">—</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-6"><label class="form-label">How is it tracked? *</label><select name="type" class="form-select" required>@foreach(config('inventory.product_types') as $k => $l)<option value="{{ $k }}" @selected(old('type', $product->type) == $k)>{{ $l }}</option>@endforeach</select></div>
    <div class="col-md-3"><label class="form-label">Brand</label><input name="brand" value="{{ old('brand', $product->brand) }}" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Model</label><input name="model" value="{{ old('model', $product->model) }}" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Unit (pcs, box …)</label><input name="unit" value="{{ old('unit', $product->unit) }}" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Minimum stock (consumables)</label><input type="number" step="0.01" min="0" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" class="form-control"></div>
    <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" rows="2" class="form-control">{{ old('notes', $product->notes) }}</textarea></div>
    @if($product->exists)<div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="act" @checked(old('is_active', $product->is_active))><label class="form-check-label" for="act">Active (can be received and allocated)</label></div></div>@endif
</div>
<div class="mt-3"><button class="btn btn-primary">Save</button> <a href="{{ route('inv.products.index') }}" class="btn btn-link">Cancel</a></div></div></form>
@endsection
