@extends('layouts.app')
@section('title', 'Assignment Board')
@section('content')
<div class="text-muted small mb-3">@if($board['canAssign'])Drag a ticket onto an IT employee to make them the primary responsible employee (supporting employees stay; use the ticket page to change the team). @endif Open tickets, oldest first. Cards marked <span class="primary-tag">Primary</span> (blue) are the employee's own responsibility; cards marked <span class="support-tag">Support</span> (teal) are requests where the employee is a supporting team member; the primary employee is named on the card and only the primary can be changed here.</div>

<div id="board" v-cloak>
    <div class="board">
        <div v-for="col in cols" :key="col.id === null ? 'u' : col.id"
             class="board-col" :class="{ over: overCol === col.id && col.id !== null, unassigned: col.id === null }"
             v-on:dragover.prevent="col.id !== null && canAssign && (overCol = col.id)"
             v-on:dragleave="overCol = null"
             v-on:drop.prevent="dropOn(col)">
            <div class="board-head">
                <template v-if="col.id !== null">
                    <img v-if="col.avatar" :src="col.avatar" :alt="col.name" class="avatar avatar-img">
                    <span v-else class="avatar" :style="{ '--h': hue(col.name) }">[[ initials(col.name) ]]</span>
                </template>
                <span>[[ col.name ]]</span>
                <span class="counts">
                    <span class="n n-primary" title="Primary responsibility">[[ primaryCount(col) ]]</span>
                    <span v-if="supportCount(col)" class="n n-support" title="Supporting">+[[ supportCount(col) ]] support</span>
                </span>
            </div>
            <div class="board-list">
                <div v-for="t in col.tickets" :key="t.id + t.role" class="tcard"
                     :class="{ dragging: dragging && dragging.t === t, support: t.role === 'support', primary: t.role !== 'support' && col.id !== null }"
                     :draggable="canAssign && t.role !== 'support'" v-on:dragstart="onDragStart(t, col)" v-on:dragend="dragging = null; overCol = null">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <a :href="t.url" class="no">[[ t.no ]]</a>
                        <span v-if="t.role === 'support'" class="support-tag">Support</span>
                        <span v-else-if="col.id !== null" class="primary-tag">Primary</span>
                    </div>
                    <div class="subj">[[ t.subject ]]</div>
                    <div v-if="t.role === 'support'" class="ticket-sub mb-1">Primary: [[ t.primary || '—' ]]</div>
                    <div v-else-if="t.support && t.support.length" class="ticket-sub mb-1">+ support: [[ t.support.join(', ') ]]</div>
                    <div class="meta">
                        <span>[[ t.dept ]]<template v-if="t.due"> · due [[ t.due ]]</template></span>
                        <button v-if="canAssign && col.id === null && t.role !== 'support'" class="auto" type="button" title="Assign to the member with the fewest open tickets" v-on:click="autoAssign(t, col)">Auto</button>
                    </div>
                </div>
                <div v-if="!col.tickets.length" class="empty-hint">[[ col.id === null ? 'Nothing waiting 🎉' : 'No open tickets' ]]</div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>[v-cloak]{display:none}</style>
<script>
const BOARD = @json($board);
Vue.createApp({
    delimiters: ['[[', ']]'],
    data() { return { cols: BOARD.columns, canAssign: BOARD.canAssign, dragging: null, overCol: null }; },
    methods: {
        initials(n) { var p = n.trim().split(/\s+/); return (p[0][0] + (p[1] ? p[1][0] : '')).toUpperCase(); },
        hue(n) { var h = 0; for (var i = 0; i < n.length; i++) h = (h * 31 + n.charCodeAt(i)) % 360; return h; },
        primaryCount(c) { return c.tickets.filter(function (t) { return t.role !== 'support'; }).length; },
        supportCount(c) { return c.tickets.filter(function (t) { return t.role === 'support'; }).length; },
        onDragStart(t, from) { if (this.canAssign && t.role !== 'support') this.dragging = { t: t, from: from }; },
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
                // the previous primary leaves the request; a supporting employee who becomes primary no longer shows a support card
                from.tickets = from.tickets.filter(function (x) { return x !== t; });
                t.primary = data.assignee_name;
                t.support = (t.support || []).filter(function (n) { return n !== data.assignee_name; });
                if (to) {
                    to.tickets = to.tickets.filter(function (x) { return !(x.id === t.id && x.role === 'support'); });
                    var firstSupport = to.tickets.findIndex(function (x) { return x.role === 'support'; });
                    if (firstSupport < 0) to.tickets.push(t); else to.tickets.splice(firstSupport, 0, t);
                }
                this.cols.forEach(function (c) { c.tickets.forEach(function (x) {
                    if (x.id === t.id && x.role === 'support') { x.primary = data.assignee_name; x.support = t.support; }
                }); });
                window.toast(t.no + ' assigned to ' + data.assignee_name);
            } catch (e) {
                window.toast('Network error – nothing was changed.', 'danger');
            }
        }
    }
}).mount('#board');
</script>
@endpush
