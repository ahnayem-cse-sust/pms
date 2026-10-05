@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Monthly IT Report</h4>
    <form method="GET" class="d-flex gap-2">
        <input type="month" name="month" value="{{ $month }}" class="form-control">
        <button class="btn btn-secondary">Show</button>
        <a class="btn btn-outline-success" href="{{ route('reports.csv', ['month' => $month]) }}">Export CSV</a>
    </form>
</div>

<div class="row g-3 mb-4">
    @foreach($summary as $label => $v)
        <div class="col-6 col-md-3 col-xl"><div class="card stat"><div class="card-body py-2">
            <div class="small text-muted">{{ $label }}</div><div class="fs-4 fw-semibold">{{ $v }}</div>
        </div></div></div>
    @endforeach
</div>

<div class="row g-4 mb-4">
    @foreach(['Department-wise' => $byDept, 'Category-wise' => $byCat, 'Priority-wise' => $byPrio] as $title => $data)
    <div class="col-md-4"><div class="card"><div class="card-header">{{ $title }}</div>
        <table class="table table-sm mb-0">
            @forelse($data as $k => $v)<tr><td>{{ $k }}</td><td class="text-end">{{ $v }}</td></tr>
            @empty<tr><td class="text-muted">No data</td></tr>@endforelse
        </table></div></div>
    @endforeach
</div>

<div class="card">
    <div class="card-header">IT team – operational summary <span class="small text-muted">(workload and turnaround for management planning; not a performance score)</span></div>
    <table class="table table-sm mb-0">
        <thead><tr><th>IT employee</th><th class="text-end">Assigned</th><th class="text-end">Completed</th><th class="text-end">Pending</th><th class="text-end">Avg resolution (h)</th><th class="text-end">SLA breach</th></tr></thead>
        <tbody>
        @foreach($perMember as $m)
            <tr><td>{{ $m->name }}</td><td class="text-end">{{ $m->assigned }}</td><td class="text-end">{{ $m->completed }}</td><td class="text-end">{{ $m->pending }}</td><td class="text-end">{{ $m->avg_hours ?? '—' }}</td><td class="text-end">{{ $m->sla_breach }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
