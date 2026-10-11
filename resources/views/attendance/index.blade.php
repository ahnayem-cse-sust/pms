@extends('layouts.app')
@section('title', $mine ? 'My Attendance' : 'IT Employee Attendance')
@section('content')
@php
    $fmt = fn ($s) => intdiv($s, 3600) . 'h ' . str_pad(intdiv($s % 3600, 60), 2, '0', STR_PAD_LEFT) . 'm';
    $tone = ['Present' => 'success', 'Absent' => 'danger', 'Weekend' => 'secondary', 'Not in yet' => 'warning'];
    $route = $mine ? 'attendance.mine' : 'attendance.index';
    $today = today();
    $ranges = [
        'Today' => [$today->format('Y-m-d'), $today->format('Y-m-d')],
        'Last 7 days' => [$today->copy()->subDays(6)->format('Y-m-d'), $today->format('Y-m-d')],
        'This month' => [$today->copy()->startOfMonth()->format('Y-m-d'), $today->format('Y-m-d')],
        'Last month' => [$today->copy()->subMonthNoOverflow()->startOfMonth()->format('Y-m-d'), $today->copy()->subMonthNoOverflow()->endOfMonth()->format('Y-m-d')],
    ];
    $chipUrl = fn ($r) => route($route, array_filter(['from' => $r[0], 'to' => $r[1], 'employee_id' => $filters['employee_id'], 'status' => $filters['status']]));
    $current = [$from->format('Y-m-d'), $to->format('Y-m-d')];
    $pdfUrl = route('attendance.pdf', array_filter([
        'from' => $from->format('Y-m-d'), 'to' => $to->format('Y-m-d'),
        'employee_id' => $filters['employee_id'], 'status' => $filters['status'],
    ]));
    $canPdf = ! $mine && auth()->user()->can('attendance.view');
@endphp

<form method="GET" id="attendanceFilter" class="card filter-card mb-3" data-max-months="{{ (int) config('itsm.attendance.max_months', 6) }}" data-today="{{ $today->format('Y-m-d') }}">
    <div class="filter-head">
        <x-icon name="search" :size="18"/>
        <span>Search attendance</span>
        <div class="range-chips ms-auto">
            @foreach($ranges as $label => $r)
                <a href="{{ $chipUrl($r) }}" class="range-chip {{ $r === $current ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>

    <div class="filter-body">
        <div class="row g-3">
            <div class="col-sm-6 col-lg-{{ $mine ? 4 : 3 }}">
                <label class="form-label">From date</label>
                <input type="date" id="fromDate" name="from" value="{{ $from->format('Y-m-d') }}" min="{{ $to->copy()->subMonthsNoOverflow(6)->format('Y-m-d') }}" max="{{ $to->format('Y-m-d') }}" class="form-control" required>
            </div>
            <div class="col-sm-6 col-lg-{{ $mine ? 4 : 3 }}">
                <label class="form-label">To date</label>
                <input type="date" id="toDate" name="to" value="{{ $to->format('Y-m-d') }}" min="{{ $from->format('Y-m-d') }}" max="{{ min($today, $from->copy()->addMonthsNoOverflow(6))->format('Y-m-d') }}" class="form-control" required>
            </div>
            @unless($mine)
            <div class="col-sm-6 col-lg-3">
                <label class="form-label">Employee</label>
                <select name="employee_id" class="form-select"><option value="">All IT employees</option>
                    @foreach($everyone as $e)<option value="{{ $e->id }}" @selected($filters['employee_id'] == $e->id)>{{ $e->name }}</option>@endforeach
                </select>
            </div>
            @endunless
            <div class="col-sm-6 col-lg-{{ $mine ? 4 : 3 }}">
                <label class="form-label">Status</label>
                <select name="status" class="form-select"><option value="">All statuses</option>
                    @foreach(['Present', 'Absent', 'Weekend', 'Not in yet'] as $st)<option @selected($filters['status'] === $st)>{{ $st }}</option>@endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="filter-actions">
        <button class="btn btn-primary d-inline-flex align-items-center gap-2"><x-icon name="search" :size="16"/> Search</button>
        <a href="{{ route($route) }}" class="btn btn-outline-secondary">Reset</a>

        @if($canPdf)
            <a href="{{ $pdfUrl }}" class="btn btn-danger ms-auto d-inline-flex align-items-center gap-2"><x-icon name="download" :size="16"/> Download PDF</a>
        @endif
    </div>
</form>

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
            <td class="text-nowrap" title="{{ $row->logins || $row->logouts ? $row->logins . ' login(s), ' . $row->logouts . ' logout(s) from office IPs' : '' }}">
                {{ $row->seconds !== null ? $fmt($row->seconds) : '—' }}
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

@include('attendance._pager')

<p class="text-muted small mt-3 mb-0">Logins from devices outside the office network will not be considered for Entry/Exit records.</p>
@endsection

@push('scripts')
<script>
// From/To stay in order and within 6 months of each other (the server enforces the same rules).
(function () {
    var form = document.getElementById('attendanceFilter');
    var from = document.getElementById('fromDate'), to = document.getElementById('toDate');
    var N = parseInt(form.dataset.maxMonths, 10) || 6, today = form.dataset.today;

    function pad(n) { return (n < 10 ? '0' : '') + n; }
    function iso(d) { return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()); }
    function shift(str, n) {                       // add n months, clamping the day (31 Aug + 6 months = 28 Feb)
        var p = str.split('-').map(Number);
        var d = new Date(p[0], p[1] - 1 + n, 1);
        var last = new Date(d.getFullYear(), d.getMonth() + 1, 0).getDate();
        d.setDate(Math.min(p[2], last));
        return iso(d);
    }
    function sync() {
        if (from.value) { to.min = from.value; var cap = shift(from.value, N); to.max = cap < today ? cap : today; }
        else { to.removeAttribute('min'); to.max = today; }
        if (to.value) { from.max = to.value; from.min = shift(to.value, -N); }
        else { from.max = today; from.removeAttribute('min'); }
    }
    from.addEventListener('change', sync);
    to.addEventListener('change', sync);
    sync();

    form.addEventListener('submit', function (e) {
        if (from.value && to.value && from.value > to.value) {
            e.preventDefault(); window.toast('From date cannot be after To date.', 'danger');
        } else if (from.value && to.value && to.value > shift(from.value, N)) {
            e.preventDefault(); window.toast('The date range cannot be more than ' + N + ' months.', 'danger');
        }
    });
})();
</script>
@endpush
