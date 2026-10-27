@extends('layouts.app')
@section('title', 'Stock Issues')
@section('content')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Reference, ticket, purpose"></div>
    <div class="col-6 col-md-2"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option>@foreach(['SUBMITTED', 'APPROVED', 'PARTIAL', 'FULFILLED', 'REJECTED', 'CANCELLED', 'CLOSED'] as $s)<option @selected(request('status') == $s)>{{ $s }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>@can('inv.issue.create')<a href="{{ route('inv.issues.create') }}" class="btn btn-success ms-md-auto">+ New issue request</a>@endcan</div>
</div></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Request</th><th>Requested</th><th>Recipient</th><th>Purpose</th><th>Ticket</th><th>Status</th></tr></thead><tbody>
@forelse($rows as $i)<tr><td><a href="{{ route('inv.issues.show', $i) }}">{{ $i->ref }}</a></td><td>{{ $i->created_at->format('d M Y') }}</td><td>{{ $i->recipient->name ?? ($i->department->name ?? '').' (dept)' }}</td><td>{{ \Illuminate\Support\Str::limit($i->purpose, 60) }}</td><td>{{ $i->ticket_no }}</td><td>{{ \App\Support\Inv::pill($i->status) }}</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-4">No requests.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}
@endsection
