@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<div class="mb-3"><h4 class="mb-0">Monthly IT Report</h4></div>
<form method="GET" class="card filter-card mb-4">
    <div class="filter-head">
        <x-icon name="search" :size="18"/>
        <span>Report period</span>
    </div>
    <div class="filter-body">
        <div class="row g-3 align-items-end">
            <div class="col-sm-6 col-md-3">
                <label class="form-label">Month</label>
                <input type="month" name="month" value="{{ $month }}" class="form-control">
            </div>
            <div class="col-sm-6 col-md-9 d-flex flex-wrap gap-2">
                <button class="btn btn-primary d-inline-flex align-items-center gap-2"><x-icon name="search" :size="16"/> Show report</button>
                <a class="btn btn-outline-success ms-md-auto d-inline-flex align-items-center gap-2" href="{{ route('reports.csv', ['month' => $month]) }}"><x-icon name="download" :size="16"/> Export CSV</a>
            </div>
        </div>
    </div>
</form>

<div class="row g-3 mb-4">
    @foreach($summary as $label => $v)
        <div class="col-6 col-md-3 col-xl"><div class="card stat"><div class="card-body py-2">
            <div class="small text-muted">{{ $label }}</div><div class="fs-4 fw-semibold">{{ $v }}</div>
        </div></div></div>
    @endforeach
</div>

<div class="row g-4 mb-4">
    @foreach(['Department-wise' => $byDept, 'Category-wise' => $byCat] as $title => $data)
    <div class="col-md-6"><div class="card"><div class="card-header">{{ $title }}</div>
        <table class="table table-sm mb-0">
            @forelse($data as $k => $v)<tr><td>{{ $k }}</td><td class="text-end">{{ $v }}</td></tr>
            @empty<tr><td class="text-muted">No data</td></tr>@endforelse
        </table></div></div>
    @endforeach
</div>

<div class="card">
    <div class="card-header">IT team – operational summary <span class="small text-muted">(tasks = requests where the employee is primary or supporting; not a performance score)</span></div>
    <table class="table table-sm mb-0">
        <thead><tr><th>IT employee</th><th class="text-end">Tasks</th><th class="text-end">Primary</th><th class="text-end">Supporting</th><th class="text-end">Completed</th><th class="text-end">Pending</th></tr></thead>
        <tbody>
        @foreach($perMember as $m)
            <tr><td>{{ $m->name }}</td><td class="text-end"><b>{{ $m->tasks }}</b></td><td class="text-end">{{ $m->primary }}</td><td class="text-end">{{ $m->supporting }}</td><td class="text-end">{{ $m->completed }}</td><td class="text-end">{{ $m->pending }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
