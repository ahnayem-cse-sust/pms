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
        <h5 class="section-title"><span class="title-bar"></span>Assignment board</h5>
        <div class="section-sub">@if($board['canAssign'])Drag a ticket onto an IT employee to make them the primary responsible employee (supporting employees stay; use the ticket page to change the team). @endif Open tickets, oldest first.</div>
    </div>
</div>

<div id="board" v-cloak>
    <div class="board">
        <div v-for="col in cols" :key="col.id === null ? 'u' : col.id"
             class="board-col" :class="{ over: overCol === col.id && col.id !== null, unassigned: col.id === null }"
             v-on:dragover.prevent="col.id !== null && canAssign && (overCol = col.id)"
             v-on:dragleave="overCol = null"
             v-on:drop.prevent="dropOn(col)">
            <div class="board-head">
                <span v-if="col.id !== null" class="avatar" :style="{ '--h': hue(col.name) }">[[ initials(col.name) ]]</span>
                <span>[[ col.name ]]</span>
                <span class="n">[[ col.tickets.length ]]</span>
            </div>
            <div class="board-list">
                <div v-for="t in col.tickets" :key="t.id" class="tcard"
                     :class="{ dragging: dragging && dragging.t.id === t.id }"
                     :draggable="canAssign" v-on:dragstart="onDragStart(t, col)" v-on:dragend="dragging = null; overCol = null">
                    <a :href="t.url" class="no">[[ t.no ]]</a>
                    <div class="subj">[[ t.subject ]]</div>
                    <div v-if="t.support && t.support.length" class="ticket-sub mb-1">+ support: [[ t.support.join(', ') ]]</div>
                    <div class="meta">
                        <span>[[ t.dept ]]<template v-if="t.due"> · due [[ t.due ]]</template></span>
                        <button v-if="canAssign && col.id === null" class="auto" type="button" title="Assign to the member with the fewest open tickets" v-on:click="autoAssign(t, col)">Auto</button>
                    </div>
                </div>
                <div v-if="!col.tickets.length" class="empty-hint">[[ col.id === null ? 'Nothing waiting 🎉' : 'No open tickets' ]]</div>
            </div>
        </div>
    </div>
</div>
</section>

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
<style>[v-cloak]{display:none}</style>
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

const BOARD = @json($board);
Vue.createApp({
    delimiters: ['[[', ']]'],
    data() { return { cols: BOARD.columns, canAssign: BOARD.canAssign, dragging: null, overCol: null }; },
    methods: {
        initials(n) { var p = n.trim().split(/\s+/); return (p[0][0] + (p[1] ? p[1][0] : '')).toUpperCase(); },
        hue(n) { var h = 0; for (var i = 0; i < n.length; i++) h = (h * 31 + n.charCodeAt(i)) % 360; return h; },
        onDragStart(t, from) { if (this.canAssign) this.dragging = { t: t, from: from }; },
        dropOn(col) {
            var d = this.dragging; this.dragging = null; this.overCol = null;
            if (!d || !this.canAssign || col.id === null || col.id === d.from.id) return;
            this.send(d.t, d.from, { assignee_id: col.id });
        },
        autoAssign(t, from) { this.send(t, from, { auto: 1 }); },
        async send(t, from, payload) {
            try {
                var res = await fetch(BOARD.assignUrl.replace('__ID__', t.id), {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json',
                               'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify(payload)
                });
                var data = await res.json().catch(function () { return {}; });
                if (!res.ok) {
                    var first = data.errors ? Object.values(data.errors)[0][0] : null;
                    window.toast(first || data.message || 'Could not assign this ticket.', 'danger');
                    return;
                }
                var to = this.cols.find(function (c) { return c.id === data.assignee_id; });
                from.tickets = from.tickets.filter(function (x) { return x.id !== t.id; });
                if (to) to.tickets.push(t);
                window.toast(t.no + ' assigned to ' + data.assignee_name);
            } catch (e) {
                window.toast('Network error – nothing was changed.', 'danger');
            }
        }
    }
}).mount('#board');
</script>
@endpush
