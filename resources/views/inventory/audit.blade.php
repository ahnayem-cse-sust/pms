@extends('layouts.app')
@section('title', 'Inventory Audit')
@section('content')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-6 col-md-3"><label class="form-label">Event contains</label><input name="event" value="{{ request('event') }}" class="form-control" placeholder="e.g. receipt, asset, stocktake"></div>
    <div class="col-6 col-md-3"><label class="form-label">User</label><select name="user_id" class="form-select"><option value="">All</option>@foreach($people as $p)<option value="{{ $p->id }}" @selected(request('user_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Filter</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a><a href="{{ route('inv.audit', ['format' => 'csv']) }}" class="btn btn-outline-success ms-md-auto">Export CSV</a></div>
</div></div></form>
<table class="table table-sm bg-white align-middle small"><thead class="table-light"><tr><th>When</th><th>User</th><th>Event</th><th>Record</th><th>Details</th></tr></thead><tbody>
@forelse($rows as $l)<tr><td class="text-nowrap">{{ $l->created_at->format('d M Y H:i') }}</td><td>{{ $l->user->name ?? '' }}</td><td>{{ str_replace('inventory.', '', $l->event) }}</td><td>{{ $l->auditable_type }}#{{ $l->auditable_id }}</td>
<td style="max-width:420px;word-break:break-word">{{ $l->new_values ? json_encode($l->new_values) : '' }} @if($l->old_values)<span class="text-muted">← {{ json_encode($l->old_values) }}</span>@endif</td></tr>
@empty<tr><td colspan="5" class="text-center text-muted py-3">No entries.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}
@endsection
