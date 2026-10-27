@extends('layouts.app')
@section('title', 'Stocktake')
@section('content')
@include('inventory._errors')
@can('inv.stocktake.create')
<form method="POST" action="{{ route('inv.stocktakes.store') }}" class="card mb-3"><div class="card-body">@csrf
    <div class="fw-semibold mb-2">Start a verification exercise <span class="text-muted fw-normal small">– system balances and asset statuses are captured now</span></div>
    <div class="row g-2">
        <div class="col-md-3"><input name="title" class="form-control form-control-sm" placeholder="Title, e.g. HO store Q4 count *" required></div>
        <div class="col-md-2"><input type="date" name="count_date" value="{{ today()->format('Y-m-d') }}" class="form-control form-control-sm" required></div>
        <div class="col-md-3"><select name="location_id" class="form-select form-select-sm"><option value="">All locations</option>@foreach($locations as $l)<option value="{{ $l->id }}">{{ $l->path }}</option>@endforeach</select></div>
        <div class="col-md-2"><select name="category_id" class="form-select form-select-sm"><option value="">All categories</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><button class="btn btn-primary btn-sm w-100">Start</button></div>
    </div>
</div></form>
@endcan
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Reference</th><th>Title</th><th>Date</th><th>Scope</th><th>Lines</th><th>Status</th></tr></thead><tbody>
@forelse($rows as $s)<tr><td><a href="{{ route('inv.stocktakes.show', $s) }}">{{ $s->ref }}</a></td><td>{{ $s->title }}</td><td>{{ $s->count_date->format('d M Y') }}</td><td>{{ $s->location->name ?? 'All locations' }} / {{ $s->category->name ?? 'All categories' }}</td><td>{{ $s->lines_count }}</td><td>{{ \App\Support\Inv::pill($s->status) }}</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-3">None.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}
@endsection
