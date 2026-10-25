@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="section-head dash-now">
    <div>
        <h5 class="section-title"><span class="title-bar"></span><span id="nowStamp" data-ts="{{ now()->getTimestamp() * 1000 }}" data-tz="{{ config('app.timezone') }}">{{ now()->format('l, d F Y · h:i A') }}</span></h5>
        <div class="section-sub">Overview of all requests and the IT team.</div>
    </div>
</div>

<section class="dash-section">@include('dashboard._stats', ['stats' => $stats])</section>

<section class="dash-section">
<div class="section-head">
    <div>
        <h5 class="section-title"><span class="title-bar teal"></span>Team workload</h5>
        <div class="section-sub">Live view of what each IT team member is carrying. Click a name to see their requests.</div>
    </div>
    <div class="wl-summary">
        <div><b>{{ $team->count() }}</b><span>Members</span></div>
        <div><b>{{ $team->sum('open') }}</b><span>Open load</span></div>
        <div><b>{{ $team->where('open', '>', 6)->count() }}</b><span>Heavily loaded</span></div>
    </div>
</div>
<div class="card wl-card">
    <div class="table-responsive">
    <table class="table align-middle dash-table wl-table">
        <thead><tr>
            <th>Employee</th>
            <th class="text-center">New / Assigned</th>
            <th class="text-center">In progress</th>
            <th class="text-center">Pending</th>
            <th class="text-center">Supporting</th>
            <th class="text-center">Resolved</th>
            <th style="width:26%">Open load</th>
        </tr></thead>
        <tbody>
        @forelse($team as $row)
            @php($level = $row->open > 6 ? ['Heavy', 'heavy'] : ($row->open > 3 ? ['Balanced', 'mid'] : ['Light', 'light']))
            <tr>
                <td>
                    <a href="{{ route('tickets.index', ['assigned_to' => $row->user->id]) }}" class="wl-person text-decoration-none text-reset">
                        <x-avatar :name="$row->user->name" :user="$row->user" class="avatar-lg"/>
                        <span><b>{{ $row->user->name }}</b><small>{{ $row->open }} open &middot; {{ $row->supporting }} supporting</small></span>
                    </a>
                </td>
                <td class="text-center"><span class="wl-num n-blue">{{ $row->assigned }}</span></td>
                <td class="text-center"><span class="wl-num n-amber">{{ $row->in_progress }}</span></td>
                <td class="text-center"><span class="wl-num n-slate">{{ $row->pending }}</span></td>
                <td class="text-center"><span class="wl-num n-cyan">{{ $row->supporting }}</span></td>
                <td class="text-center"><span class="wl-num n-green">{{ $row->resolved }}</span></td>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div class="loadbar loadbar-lg flex-grow-1"><span style="width:{{ min(100, $row->open * 10) }}%"></span></div>
                        <b class="wl-open">{{ $row->open }}</b>
                        <span class="load-pill {{ $level[1] }}">{{ $level[0] }}</span>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-muted text-center py-4">No IT team members yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
</section>

<section class="dash-section">
<div class="section-head"><h5 class="section-title"><span class="title-bar violet"></span>Insights</h5><div class="section-sub">Request volume and where requests come from.</div></div>
<div class="row g-4">
    <div class="col-lg-4"><div class="card h-100"><div class="card-header">Monthly trend <small class="text-muted fw-normal">&middot; last 6 months</small></div><div class="card-body"><canvas id="trend"></canvas></div></div></div>
    <div class="col-lg-4"><div class="card h-100"><div class="card-header">By department</div><div class="card-body"><canvas id="dept"></canvas></div></div></div>
    <div class="col-lg-4"><div class="card h-100"><div class="card-header">By category</div><div class="card-body"><canvas id="cat"></canvas></div></div></div>
</div>
</section>
@endsection

@push('scripts')
<script>
// Date and time heading (12-hour), kept current every 30 seconds in the app time zone.
(function () {
    var el = document.getElementById('nowStamp'); if (!el) return;
    var offset = parseInt(el.dataset.ts, 10) - Date.now();
    var fmt = new Intl.DateTimeFormat('en-GB', { timeZone: el.dataset.tz, weekday: 'long', day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });
    function tick() {
        var p = {}; fmt.formatToParts(new Date(Date.now() + offset)).forEach(function (x) { p[x.type] = x.value; });
        el.textContent = p.weekday + ', ' + p.day + ' ' + p.month + ' ' + p.year + ' · ' + p.hour + ':' + p.minute + ' ' + (p.dayPeriod || '').toUpperCase();
    }
    tick(); setInterval(tick, 30000);
})();
</script>
<script src="{{ asset('vendor/js/chart.umd.js') }}"></script>
<script>
(function () {
    var palette = ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#06b6d4', '#a855f7', '#84cc16', '#f97316'];
    var mk = function (id, type, labels, data) {
        new Chart(document.getElementById(id), {
            type: type,
            data: { labels: labels, datasets: [{ label: 'Requests', data: data, borderRadius: 6, tension: .35,
                backgroundColor: type === 'line' ? 'rgba(99,102,241,.15)' : palette, borderColor: '#6366f1', fill: type === 'line' }] },
            options: { plugins: { legend: { display: type === 'doughnut', position: 'bottom' } }, scales: type === 'doughnut' ? {} : { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
    };
    mk('trend', 'line', @json($trend->keys()), @json($trend->values()));
    mk('dept', 'bar', @json($byDept->keys()), @json($byDept->values()));
    mk('cat', 'bar', @json($byCat->keys()), @json($byCat->values()));
})();

</script>
@endpush
