@extends('layouts.app')
@section('title', 'IT Employee Attendance')
@section('content')
@php
    $fmt = fn ($s) => intdiv($s, 3600) . 'h ' . str_pad(intdiv($s % 3600, 60), 2, '0', STR_PAD_LEFT) . 'm';
    $tone = ['Present' => 'success', 'Absent' => 'danger', 'Weekend' => 'secondary', 'Not in yet' => 'warning'];
    $q = fn ($f, $t) => route('attendance.index', array_filter(['from' => $f, 'to' => $t, 'employee_id' => $filters['employee_id'], 'status' => $filters['status']]));
@endphp

<form method="GET" class="card card-body mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ $from->format('Y-m-d') }}" max="{{ today()->format('Y-m-d') }}" class="form-control"></div>
        <div class="col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ $to->format('Y-m-d') }}" max="{{ today()->format('Y-m-d') }}" class="form-control"></div>
        <div class="col-md-3">
            <label class="form-label">Employee</label>
            <select name="employee_id" class="form-select"><option value="">All IT employees</option>
                @foreach($everyone as $e)<option value="{{ $e->id }}" @selected($filters['employee_id'] == $e->id)>{{ $e->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select"><option value="">All</option>
                @foreach(['Present', 'Absent', 'Weekend', 'Not in yet'] as $st)<option @selected($filters['status'] === $st)>{{ $st }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary">Show</button>
            <a class="btn btn-outline-secondary" href="{{ $q(today()->format('Y-m-d'), today()->format('Y-m-d')) }}">Today</a>
            <a class="btn btn-outline-secondary" href="{{ $q(today()->subDays(6)->format('Y-m-d'), today()->format('Y-m-d')) }}">7 days</a>
            <a class="btn btn-outline-secondary" href="{{ $q(today()->startOfMonth()->format('Y-m-d'), today()->format('Y-m-d')) }}">This month</a>
        </div>
    </div>
</form>

<div class="stat-grid mb-3">
    <div class="stat-card tone-green"><div class="stat-icon"><x-icon name="check" :size="22"/></div><div><div class="stat-label">Present (days)</div><div class="stat-value">{{ $summary['present'] }}</div></div></div>
    <div class="stat-card tone-red {{ $summary['absent'] ? 'alert-on' : '' }}"><div class="stat-icon"><x-icon name="alert" :size="22"/></div><div><div class="stat-label">Absent (days)</div><div class="stat-value">{{ $summary['absent'] }}</div></div></div>
    <div class="stat-card tone-indigo"><div class="stat-icon"><x-icon name="clock" :size="22"/></div><div><div class="stat-label">Average time in office</div><div class="stat-value">{{ $summary['avg'] !== null ? $fmt($summary['avg']) : '—' }}</div></div></div>
</div>

<div class="table-card">
<div class="table-responsive">
<table class="table table-hover align-middle">
    <thead><tr><th>Employee name</th><th>Date</th><th>Entry time</th><th>Exit time</th><th>Total time</th><th>Status</th></tr></thead>
    <tbody>
    @forelse($rows as $row)
        <tr class="{{ $row->status === 'Weekend' ? 'text-muted' : '' }}">
            <td><span class="d-inline-flex align-items-center gap-2"><x-avatar :name="$row->employee->name"/> {{ $row->employee->name }}</span></td>
            <td class="text-nowrap">{{ $row->date->format('D, d M Y') }}</td>
            <td class="text-nowrap">{{ $row->entry ? $row->entry->format('h:i A') : '—' }}</td>
            <td class="text-nowrap">{{ $row->exit ? $row->exit->format('h:i A') : '—' }}</td>
            <td class="text-nowrap" title="{{ $row->logins ? $row->logins . ' login(s) from office IPs' : '' }}">
                {{ $row->seconds !== null ? $fmt($row->seconds) : '—' }}
                @if($row->logins === 1)<span class="ticket-sub">(single login)</span>@endif
            </td>
            <td><span class="pill pill-{{ $tone[$row->status] }}">{{ $row->status }}</span></td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center text-muted py-5">No records for the selected period.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
</div>

<p class="text-muted small mt-3 mb-0">Logins from devices outside the office network will not be considered for Entry/Exit records.</p>
@endsection
