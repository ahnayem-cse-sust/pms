@extends('layouts.app')
@section('title', 'Assign / Transfer / Return')
@section('content')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Reference, asset code, serial"></div>
    <div class="col-6 col-md-2"><label class="form-label">Kind</label><select name="kind" class="form-select"><option value="">All</option>@foreach($kinds as $k => $l)<option value="{{ $k }}" @selected(request('kind') == $k)>{{ $l }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option>@foreach(['REQUESTED', 'APPROVED', 'POSTED', 'REJECTED', 'CANCELLED'] as $s)<option @selected(request('status') == $s)>{{ $s }}</option>@endforeach</select></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
        @can('inv.assign.create')<span class="ms-md-auto d-flex gap-1">@foreach($kinds as $k => $l)<a href="{{ route('inv.movements.create', $k) }}" class="btn btn-success btn-sm">+ {{ $l }}</a>@endforeach</span>@endcan</div>
</div></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Reference</th><th>Kind</th><th>Asset / item</th><th>From</th><th>To</th><th>Requested</th><th>Status</th></tr></thead><tbody>
@forelse($rows as $t)<tr><td><a href="{{ route('inv.movements.show', $t) }}">{{ $t->ref }}</a></td><td>{{ $kinds[$t->kind] ?? $t->kind }}</td>
<td>{{ $t->asset ? $t->asset->asset_code.' · '.$t->asset->item->name : ($t->item->name ?? '').' × '.\App\Support\Inv::qty($t->qty) }}</td><td>{{ $t->party('from') }}</td><td>{{ $t->party('to') }}</td><td>{{ $t->created_at->format('d M Y') }}</td><td>{{ \App\Support\Inv::pill($t->status) }}</td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-4">Nothing found.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}
@endsection
