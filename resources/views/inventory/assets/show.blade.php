@extends('layouts.app')
@section('title', $asset->asset_code)
@section('content')
@include('inventory._errors')
<div class="d-flex flex-wrap gap-2 align-items-center mb-3"><h5 class="mb-0">{{ $asset->asset_code }} · {{ $asset->product->name }}</h5> {{ \App\Support\Inv::pill($asset->status) }}
<div class="ms-auto d-flex gap-2">@can('inv.update')<a href="{{ route('inv.assets.edit', $asset) }}" class="btn btn-sm btn-outline-primary">Edit</a>@endcan
@if($asset->status === 'ALLOCATED')<a href="{{ route('inv.assets.handover', $asset) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Handover form</a>@endif</div></div>
<div class="row g-3 mb-3">
    <div class="col-lg-6"><div class="card h-100"><div class="card-header">Details</div><div class="card-body small"><dl class="row mb-0">
        <dt class="col-5">Product</dt><dd class="col-7">{{ $asset->product->name }} · {{ $asset->product->category->name ?? '' }}</dd>
        <dt class="col-5">Brand / model</dt><dd class="col-7">{{ $asset->product->brand }} {{ $asset->product->model }}</dd>
        <dt class="col-5">Serial number</dt><dd class="col-7">{{ $asset->serial_no ?: '—' }}</dd>
        <dt class="col-5">Purchased</dt><dd class="col-7">{{ $asset->purchase_date?->format('d M Y') ?? '—' }} @if(! is_null($asset->cost)) · {{ number_format($asset->cost, 2) }} @endif</dd>
        <dt class="col-5">Supplier</dt><dd class="col-7">{{ $asset->supplier ?: '—' }}</dd>
        <dt class="col-5">Warranty ends</dt><dd class="col-7"><span class="{{ $asset->warranty_end?->isPast() ? 'text-danger' : '' }}">{{ $asset->warranty_end?->format('d M Y') ?? '—' }}</span></dd>
        <dt class="col-5">Notes</dt><dd class="col-7">{{ $asset->notes ?: '—' }}</dd></dl></div></div></div>
    <div class="col-lg-6"><div class="card h-100"><div class="card-header">Where it is</div><div class="card-body small">
        @if($asset->status === 'ALLOCATED')<div class="mb-2">Held by <b>{{ $asset->holder_name }}</b>@if($asset->holderUser) ({{ $asset->holderUser->department->name ?? '' }})@endif since {{ $asset->allocated_at?->format('d M Y') }}</div>
        @else<div class="mb-2">Store: <b>{{ $asset->location->name ?? '—' }}</b></div>@endif
        @can('inv.update')@if($asset->status !== 'ALLOCATED')<form method="POST" action="{{ route('inv.assets.status', $asset) }}" class="row g-2">@csrf
            <div class="col-4"><select name="to" class="form-select form-select-sm">@if($asset->status === 'AVAILABLE')<option value="DAMAGED">Mark damaged</option><option value="LOST">Mark lost</option><option value="RETIRED">Retire</option>@else<option value="RESTORE">Put back in stock</option>@endif</select></div>
            <div class="col-5"><input name="note" class="form-control form-control-sm" placeholder="Reason" required></div><div class="col-3"><button class="btn btn-sm btn-outline-secondary w-100">Update</button></div></form>
        @else<span class="text-muted">Return it from the Allocations page before changing its status.</span>@endif @endcan
    </div></div></div>
</div>
<div class="card"><div class="card-header">History</div><div class="card-body small">
    @foreach($asset->movements as $m)<div class="border-bottom py-1"><span class="text-muted">{{ $m->moved_on->format('d M Y') }}</span> · {{ \App\Support\Inv::pill($m->type) }} @if($m->holder_name) {{ $m->holder_name }} @endif @if($m->location)<span class="text-muted">({{ $m->location->name }})</span>@endif @if($m->reference_no) · {{ $m->reference_no }}@endif · {{ $m->user->name ?? '' }} <span class="text-muted">{{ $m->ref }}</span>@if($m->remarks)<div class="text-muted">{{ $m->remarks }}</div>@endif</div>@endforeach
</div></div>
@endsection
