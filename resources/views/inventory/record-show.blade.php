@extends('layouts.app')
@section('title', 'Record '.$m->ref)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('inv.records') }}" class="btn btn-outline-secondary">&larr; Records</a>
    @if($entryRoute)<a href="{{ route($entryRoute, $m->entry_no) }}" class="btn btn-outline-primary ms-md-auto">View entry {{ $m->entry_no }}@if($entryCount > 1) ({{ $entryCount }} lines)@endif</a>
    <a href="{{ route($entryRoute === 'inv.allocations.show' ? 'inv.allocations.pdf' : 'inv.receives.pdf', $m->entry_no) }}" class="btn btn-primary">Download PDF</a>@endif
</div>
<div class="card"><div class="card-body"><div class="row g-3">
    <div class="col-6 col-md-3"><div class="text-muted small">Record</div><strong>{{ $m->ref }}</strong></div>
    <div class="col-6 col-md-3"><div class="text-muted small">Entry</div>{{ $m->entry_no ?: '—' }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Date</div>{{ $m->moved_on->format('d M Y') }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Type</div>{{ \App\Support\Inv::pill($m->type) }}</div>
    <div class="col-12 col-md-6"><div class="text-muted small">Equipment</div>{{ $m->equipment->name }} <span class="text-muted">({{ $m->equipment->code }})</span><div class="small text-muted">{{ $m->equipment->classification }}</div></div>
    <div class="col-6 col-md-3"><div class="text-muted small">Serial no.</div>{{ $m->serial_no ?: '—' }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Quantity</div>{{ $m->qty > 0 ? '+' : '' }}{{ \App\Support\Inv::qty($m->qty) }} {{ $m->equipment->unit }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Stock after</div>{{ \App\Support\Inv::qty($m->balance_after) }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Person / department</div>{{ $m->holder_name ?: '—' }}@if($m->holderUser)<div class="small text-muted">{{ $m->holderUser->employee_id }}, {{ $m->holderUser->department->name ?? '' }}</div>@endif</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Reference</div>{{ $m->reference_no ?: '—' }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Supplier</div>{{ $m->party ?: '—' }}</div>
    <div class="col-12 col-md-6"><div class="text-muted small">{{ $m->type === 'ALLOCATE' ? 'Purpose' : 'Remarks' }}</div>{{ $m->remarks ?: '—' }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">By</div>{{ $m->user->name ?? '—' }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Recorded at</div>{{ $m->created_at?->format('d M Y H:i') }}</div>
</div></div></div>
@endsection
