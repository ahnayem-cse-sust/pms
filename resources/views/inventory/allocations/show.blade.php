@extends('layouts.app')
@section('title', 'Allocation '.$entry)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    @can('inv.view')<a href="{{ route('inv.allocations.entries') }}" class="btn btn-outline-secondary">&larr; Allocation records</a>@endcan
    <a href="{{ route('inv.allocations.pdf', $entry) }}" class="btn btn-primary ms-md-auto">Download PDF</a>
</div>
<div class="card mb-3"><div class="card-body"><div class="row g-3">
    <div class="col-6 col-md-3"><div class="text-muted small">Entry</div><strong>{{ $entry }}</strong></div>
    <div class="col-6 col-md-3"><div class="text-muted small">Date</div>{{ $first->moved_on->format('d M Y') }}</div>
    <div class="col-12 col-md-6"><div class="text-muted small">Allocated to</div>{{ $first->holder_name }}@if($first->holderUser) <span class="text-muted">({{ $first->holderUser->employee_id }}, {{ $first->holderUser->department->name ?? '' }})</span>@endif</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Reference</div>{{ $first->reference_no ?: '—' }}</div>
    <div class="col-6 col-md-3"><div class="text-muted small">Issued by</div>{{ $first->user->name ?? '—' }}</div>
    <div class="col-12 col-md-6"><div class="text-muted small">Equipment lines</div>{{ $lines->count() }}</div>
</div></div></div>
<div class="table-responsive"><table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>#</th><th>Code</th><th>Equipment</th><th>Classification</th><th>Serial no. / Quantity</th><th>Purpose</th>@can('inv.view')<th></th>@endcan</tr></thead><tbody>
@foreach($lines as $i => $m)<tr><td>{{ $i + 1 }}</td><td>{{ $m->equipment->code }}</td><td>{{ $m->equipment->name }}<div class="text-muted small">{{ trim($m->equipment->brand.' '.$m->equipment->model) }}</div></td><td class="small">{{ $m->equipment->classification ?: '—' }}</td>
<td>@if($m->serial_no)<strong>{{ $m->serial_no }}</strong>@else<strong>{{ \App\Support\Inv::qty(abs($m->qty)) }}</strong> {{ $m->equipment->unit }}@endif</td><td>{{ $m->remarks ?: '—' }}</td>
@can('inv.view')<td class="text-end"><a href="{{ route('inv.records.show', $m) }}">Record {{ $m->ref }}</a></td>@endcan</tr>@endforeach
</tbody></table></div>
@endsection
