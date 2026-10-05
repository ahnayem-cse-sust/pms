@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="mb-4">@include('dashboard._stats', ['stats' => $stats])</div>

<div class="row g-4 mb-4">
    <div class="col-xl-7">
        <div class="card h-100">
            <div class="card-header">Team workload</div>
            <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Employee</th><th class="text-center">New / Assigned</th><th class="text-center">In progress</th><th class="text-center">Pending</th><th class="text-center">Resolved</th><th style="width:170px">Open load</th></tr></thead>
                <tbody>
                @forelse($team as $row)
                    <tr>
                        <td><a href="{{ route('tickets.index', ['assigned_to' => $row->user->id]) }}" class="text-decoration-none d-inline-flex align-items-center gap-2 text-reset"><x-avatar :name="$row->user->name"/> {{ $row->user->name }}</a></td>
                        <td class="text-center">{{ $row->assigned }}</td>
                        <td class="text-center">{{ $row->in_progress }}</td>
                        <td class="text-center">{{ $row->pending }}</td>
                        <td class="text-center">{{ $row->resolved }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="loadbar flex-grow-1"><span style="width:{{ min(100, $row->open * 10) }}%"></span></div>
                                <b>{{ $row->open }}</b>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted text-center py-4">No IT team members yet.</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card h-100"><div class="card-header">Monthly trend</div><div class="card-body"><canvas id="trend" height="170"></canvas></div></div>
    </div>
</div>

<div class="d-flex align-items-end justify-content-between mb-2">
    <div>
        <h5 class="mb-0">Assignment board</h5>
        <div class="text-muted small">@if($board['canAssign'])Drag a ticket onto an IT member to assign or reassign it. @endif Open tickets, highest priority first.</div>
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
                     :class="['prio-' + t.priority.toLowerCase(), { dragging: dragging && dragging.t.id === t.id }]"
                     :draggable="canAssign" v-on:dragstart="onDragStart(t, col)" v-on:dragend="dragging = null; overCol = null">
                    <a :href="t.url" class="no">[[ t.no ]]</a>
                    <span v-if="t.sla === 'breached'" class="pill pill-danger ms-1">SLA</span>
                    <span v-else-if="t.sla === 'warning'" class="pill pill-warning ms-1">SLA</span>
                    <div class="subj">[[ t.subject ]]</div>
                    <div class="meta">
                        <span>[[ t.dept ]] · [[ t.priority ]]<template v-if="t.due"> · due [[ t.due ]]</template></span>
                        <button v-if="canAssign && col.id === null" class="auto" type="button" title="Assign to the member with the fewest open tickets" v-on:click="autoAssign(t, col)">Auto</button>
                    </div>
                </div>
                <div v-if="!col.tickets.length" class="empty-hint">[[ col.id === null ? 'Nothing waiting 🎉' : 'No open tickets' ]]</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-md-4"><div class="card"><div class="card-header">By department</div><div class="card-body"><canvas id="dept"></canvas></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-header">By category</div><div class="card-body"><canvas id="cat"></canvas></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-header">By priority</div><div class="card-body"><canvas id="prio"></canvas></div></div></div>
</div>
@endsection

@push('scripts')
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
    mk('prio', 'doughnut', @json($byPrio->keys()), @json($byPrio->values()));
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
