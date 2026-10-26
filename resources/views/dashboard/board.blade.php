@extends('layouts.app')
@section('title', 'Assignment Board')
@section('content')
<div class="text-muted small mb-3">Open requests, oldest first.@if($board['canAssign']) Drag an employee's name to reorder the columns.@endif</div>

<div id="board" v-cloak>
    <div class="board">
        <div v-for="col in cols" :key="col.id === null ? 'u' : col.id"
             class="board-col" :class="{ unassigned: col.id === null, 'col-over': colOver === col.id && colDrag && colDrag.id !== col.id, 'col-moving': colDrag && colDrag.id === col.id }"
             v-on:dragover.prevent="onDragOver(col)"
             v-on:dragleave="colOver = null"
             v-on:drop.prevent="moveColumn(col)">
            <div class="board-head" :class="{ 'col-handle': canReorder && col.id !== null }" :draggable="canReorder && col.id !== null"
                 v-on:dragstart="onColDragStart(col, $event)" v-on:dragend="colDrag = null; colOver = null"
                 :title="canReorder && col.id !== null ? 'Drag to change the column order' : ''">
                <template v-if="col.id !== null">
                    <img v-if="col.avatar" :src="col.avatar" :alt="col.name" class="avatar avatar-img">
                    <span v-else class="avatar" :style="{ '--h': hue(col.name) }">[[ initials(col.name) ]]</span>
                </template>
                <span>[[ col.name ]]</span>
                <span class="counts"><span class="n n-primary" title="Primary and supporting requests">[[ col.tickets.length ]]</span></span>
            </div>
            <div class="board-list">
                <a v-for="t in col.tickets" :key="t.id + t.role" :href="t.url" class="tcard"
                   :class="{ support: t.role === 'support', primary: t.role !== 'support' && col.id !== null }" draggable="false">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <span class="no">[[ t.no ]]</span>
                        <span v-if="t.role === 'support'" class="support-tag">Support</span>
                        <span v-else-if="col.id !== null" class="primary-tag">Primary</span>
                    </div>
                    <div class="subj">[[ t.subject ]]</div>
                    <div v-if="t.role === 'support'" class="ticket-sub mb-1">Primary: [[ t.primary || '—' ]]</div>
                    <div v-else-if="t.support && t.support.length" class="ticket-sub mb-1">+ support: [[ t.support.join(', ') ]]</div>
                    <div class="meta"><span>[[ t.dept ]]<template v-if="t.due"> · due [[ t.due ]]</template></span></div>
                </a>
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
    data() { return { cols: BOARD.columns, canReorder: BOARD.canAssign, colDrag: null, colOver: null }; },
    methods: {
        initials(n) { var p = n.trim().split(/\s+/); return (p[0][0] + (p[1] ? p[1][0] : '')).toUpperCase(); },
        hue(n) { var h = 0; for (var i = 0; i < n.length; i++) h = (h * 31 + n.charCodeAt(i)) % 360; return h; },
        // Requests are never dragged; only an employee column can be dragged, to change the column order.
        onColDragStart(col, e) {
            if (!this.canReorder || col.id === null) { e.preventDefault(); return; }
            e.dataTransfer.effectAllowed = 'move'; e.dataTransfer.setData('text/plain', col.name);
            this.colDrag = col;
        },
        onDragOver(col) { if (this.colDrag && col.id !== null && col.id !== this.colDrag.id) this.colOver = col.id; },
        async moveColumn(target) {
            var moving = this.colDrag; this.colDrag = null; this.colOver = null;
            if (!moving || target.id === null || target.id === moving.id) return;
            var from = this.cols.indexOf(moving), to = this.cols.indexOf(target);
            this.cols.splice(from, 1); this.cols.splice(to, 0, moving);   // the Unassigned column always stays first
            var ids = this.cols.filter(function (c) { return c.id !== null; }).map(function (c) { return c.id; });
            try {
                var res = await fetch(BOARD.orderUrl, { method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ ids: ids }) });
                if (!res.ok) throw new Error();
                window.toast('Column order saved');
            } catch (e) { window.toast('Could not save the column order.', 'danger'); }
        }
    }
}).mount('#board');
</script>
@endpush
