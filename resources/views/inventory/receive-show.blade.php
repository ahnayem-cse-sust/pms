@extends('layouts.app')
@section('title', 'Receive '.$entry)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('inv.receives') }}" class="btn btn-outline-secondary">&larr; Receives</a>
    <a href="{{ route('inv.receives.pdf', $entry) }}" class="btn btn-primary ms-md-auto">Download PDF</a>
</div>
<div class="card mb-3"><div class="card-body"><div class="row g-3">
    <div class="col-6 col-md-3"><div class="text-muted small">Entry</div><strong>{{ $entry }}</strong></div>
    <div class="col-6 col-md-3"><div class="text-muted small">Date</div>{{ $first->moved_on->format('d M Y') }}</div>
    <div class="col-12 col-md-6"><div class="text-muted small">Received from</div>@if($first->type === 'RETURN')<span class="pill pill-info">Return</span> {{ $first->holder_name }}@if($first->holderUser) <span class="text-muted">({{ $first->holderUser->employee_id }}, {{ $first->holderUser->department->name ?? '' }})</span>@endif @elseif($first->type === 'OPENING')<span class="pill pill-secondary">Previous item</span> {{ $first->party }}@else<span class="pill pill-success">Supplier</span> {{ $first->party }}@endif</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Reference</div>{{ $first->reference_no ?: '—' }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Entered by</div>{{ $first->user->name ?? '—' }}</div>
    <div class="col-12 col-md-6"><div class="text-muted small">Remarks</div>{{ $first->remarks ?: '—' }}</div>
</div></div></div>
<div class="table-responsive"><table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>#</th><th>Code</th><th>Equipment</th><th>Classification</th><th>Serial no.</th><th class="text-end">Quantity</th><th class="text-end">Stock after</th><th></th></tr></thead><tbody>
@foreach($lines as $i => $m)<tr><td>{{ $i + 1 }}</td><td>{{ $m->equipment->code }}</td><td>{{ $m->equipment->name }}<div class="text-muted small">{{ trim($m->equipment->brand.' '.$m->equipment->model) }}</div></td><td class="small">{{ $m->equipment->classification ?: '—' }}</td>
<td>{{ $m->serial_no ?: '—' }}</td><td class="text-end">{{ \App\Support\Inv::qty($m->qty) }} {{ $m->equipment->unit }}</td><td class="text-end">{{ \App\Support\Inv::qty($m->balance_after) }}</td><td class="text-end"><a href="{{ route('inv.records.show', $m) }}">Record {{ $m->ref }}</a></td></tr>@endforeach
</tbody></table></div>
@endsection
