@extends('layouts.app')
@section('title', 'New Request')
@section('content')
@php
    $u = auth()->user();
    $person = fn ($p) => [
        'id' => $p->id, 'name' => $p->name, 'emp' => $p->employee_id, 'desig' => $p->designation?->name,
        'dept' => $p->department?->name, 'deptId' => $p->department_id, 'email' => $p->email,
        'phone' => $p->whatsapp, 'locId' => $p->location_id,
    ];
    $u->loadMissing(['department', 'designation']);
    $cfg = [
        'me' => $person($u),
        'users' => $requesters->map($person)->values(),
        'maxKb' => \App\Services\AttachmentService::maxKb(),
        'categories' => $categories->map(fn ($c) => [
            'id' => $c->id, 'name' => $c->name,
            'subs' => $c->subcategories->map(fn ($s) => ['id' => $s->id, 'name' => $s->name])->values(),
        ])->values(),
        'priorities' => $priorities->map(fn ($p) => [
            'id' => $p->id, 'name' => $p->name, 'resp' => $p->response_minutes, 'reso' => $p->resolution_minutes,
        ])->values(),
        'old' => [
            'requester' => (string) old('requester_id'),
            'phone' => old('phone'), 'location' => (string) old('location_id'), 'department' => (string) old('department_id'),
            'category' => (string) old('category_id'), 'sub' => (string) old('subcategory_id'),
            'priority' => (string) old('priority_id', optional($priorities->firstWhere('name', 'Medium'))->id),
            'subject' => old('subject', ''), 'description' => old('description', ''),
        ],
    ];
@endphp

<div class="row justify-content-center"><div class="col-xl-9">
<form id="ticketForm" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" v-cloak v-on:submit="submitting = true">
    @csrf
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Requester</span>
            <span v-if="behalf" class="pill pill-warning">Filing on behalf of another person</span>
        </div>
        <div class="card-body">
            @if($requesters->isNotEmpty())
            <div class="row g-3 mb-3 pb-3 border-bottom">
                <div class="col-md-7">
                    <label class="form-label">Request for</label>
                    <div class="combo">
                        <input type="hidden" name="requester_id" :value="requesterId">
                        <input class="form-control" role="combobox" :aria-expanded="open ? 'true' : 'false'" autocomplete="off"
                               placeholder="Search by name, employee ID or department…"
                               v-model="search"
                               v-on:focus="onFocus($event)" v-on:input="typing = true; open = true; hi = 0"
                               v-on:keydown.down.prevent="move(1)" v-on:keydown.up.prevent="move(-1)"
                               v-on:keydown.enter.prevent="pickHighlighted" v-on:keydown.esc="closeList" v-on:blur="closeList">
                        <span class="chev">▼</span>
                        <ul class="combo-list" v-show="open">
                            <li v-for="(o, i) in options" :key="'o' + o.id" :class="{ active: i === hi }"
                                v-on:mousedown.prevent="pick(o)" v-on:mouseenter="hi = i">
                                [[ o.label ]]<small v-if="o.sub">[[ o.sub ]]</small>
                            </li>
                            <li v-if="!options.length" class="empty">No matching person</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Name</label><input class="form-control" :value="who.name" disabled></div>
                <div class="col-md-2"><label class="form-label">Employee ID</label><input class="form-control" :value="who.emp" disabled></div>
                <div class="col-md-3"><label class="form-label">Designation</label><input class="form-control" :value="who.desig" disabled></div>
                <div class="col-md-3">
                    <label class="form-label">Department</label>
                    <input v-if="who.deptId" class="form-control" :value="who.dept" disabled>
                    <select v-else name="department_id" class="form-select" v-model="departmentId" required>
                        <option value="">Select…</option>
                        @foreach($departments as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-6"><label class="form-label">Contact / WhatsApp number</label><input name="phone" v-model="phone" class="form-control"></div>
                <div class="col-md-6">
                    <label class="form-label">Location / office</label>
                    <select name="location_id" class="form-select" v-model="location"><option value="">—</option>
                        @foreach($locations as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">What do you need?</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Request type *</label>
                    <select name="ticket_type_id" class="form-select" required>
                        @foreach($types as $t)<option value="{{ $t->id }}" @selected(old('ticket_type_id') == $t->id)>{{ $t->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select" v-model="category" required>
                        <option value="">Select…</option>
                        <option v-for="c in categories" :key="c.id" :value="String(c.id)">[[ c.name ]]</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sub-category</label>
                    <select name="subcategory_id" class="form-select" v-model="sub" :disabled="!subs.length">
                        <option value="">[[ subs.length ? '—' : 'Choose a category first' ]]</option>
                        <option v-for="s in subs" :key="s.id" :value="String(s.id)">[[ s.name ]]</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Priority *</label>
                    <div class="prio-grid">
                        <div v-for="p in priorities" :key="p.id">
                            <input type="radio" class="btn-check" name="priority_id" :id="'p' + p.id" :value="String(p.id)" v-model="priority" required>
                            <label class="prio-card" :for="'p' + p.id">
                                <b>[[ p.name ]]</b>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Subject *</label>
                    <input name="subject" v-model="subject" class="form-control" maxlength="200" placeholder="e.g. Unable to print Sales Invoice" required>
                </div>
                <div class="col-12">
                    <label class="form-label d-flex justify-content-between">Detailed description * <span class="text-muted fw-normal">[[ description.length ]] characters</span></label>
                    <textarea name="description" v-model="description" rows="6" class="form-control" placeholder="What happened, what was expected, any error message, since when…" required></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Attachments</label>
                    <div class="dropzone" :class="{ over: dragOver }"
                         v-on:click="$refs.file.click()"
                         v-on:dragover.prevent="dragOver = true" v-on:dragleave="dragOver = false"
                         v-on:drop.prevent="onDrop">
                        Drop screenshots, error messages or documents here, or <b>click to browse</b>
                    </div>
                    <input type="file" name="attachments[]" ref="file" multiple class="d-none" v-on:change="onPick">
                    <div class="form-text">Maximum [[ maxMb ]] MB per file.</div>
                    <div v-if="fileError" class="text-danger small mt-1">[[ fileError ]]</div>
                    <div>
                        <span v-for="(f, i) in files" :key="f.name + f.size" class="file-chip">
                            [[ f.name ]] <small>([[ Math.max(1, Math.round(f.size / 1024)) ]] KB)</small>
                            <button type="button" v-on:click="remove(i)" aria-label="Remove">×</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary px-4" :disabled="submitting"><span v-if="submitting">Submitting…</span><span v-else>Submit request</span></button>
    </div>
</form>
</div></div>
@endsection

@push('scripts')
<style>[v-cloak]{display:none}</style>
<script>
const CFG = @json($cfg);
Vue.createApp({
    delimiters: ['[[', ']]'],
    data() {
        var o = CFG.old;
        var start = o.requester ? (CFG.users.find(function (p) { return String(p.id) === o.requester; }) || CFG.me) : CFG.me;
        return {
            me: CFG.me, users: CFG.users, requesterId: o.requester,
            search: '', typing: false, open: false, hi: 0,
            phone: o.phone !== null && o.phone !== '' ? o.phone : (start.phone || ''),
            location: o.location !== '' ? o.location : (start.locId ? String(start.locId) : ''),
            departmentId: o.department,
            categories: CFG.categories, priorities: CFG.priorities,
            category: o.category, sub: o.sub, priority: o.priority,
            subject: o.subject, description: o.description,
            files: [], fileError: '', maxKb: CFG.maxKb, dragOver: false, submitting: false
        };
    },
    created() { this.search = this.selectedLabel; },
    computed: {
        maxMb() { return Math.round(this.maxKb / 1024 * 10) / 10; },
        who() {
            var id = this.requesterId;
            return id ? (this.users.find(function (p) { return String(p.id) === id; }) || this.me) : this.me;
        },
        behalf() { return !!this.requesterId && this.who !== this.me; },
        allOptions() {
            var list = [{ id: '', label: 'Myself – ' + this.me.name, sub: '', hay: 'myself ' + this.me.name.toLowerCase() }];
            this.users.forEach(function (p) {
                list.push({
                    id: String(p.id), label: p.name + (p.emp ? ' (' + p.emp + ')' : ''),
                    sub: [p.desig, p.dept].filter(Boolean).join(' · '),
                    hay: [p.name, p.emp, p.dept, p.desig, p.email].join(' ').toLowerCase()
                });
            });
            return list;
        },
        selectedLabel() {
            var id = this.requesterId;
            var o = this.allOptions.find(function (x) { return x.id === id; });
            return o ? o.label : '';
        },
        options() {
            var t = this.typing ? this.search.trim().toLowerCase() : '';
            if (!t) return this.allOptions;
            return this.allOptions.filter(function (o) { return o.hay.indexOf(t) !== -1; });
        },
        subs() {
            var c = this.categories.find(function (x) { return String(x.id) === this.category; }, this);
            return c ? c.subs : [];
        }
    },
    watch: {
        // switching person refreshes the contact number and office from that person's record
        requesterId() {
            this.phone = this.who.phone || '';
            this.location = this.who.locId ? String(this.who.locId) : '';
            this.departmentId = '';
        },
        category() {
            if (!this.subs.some(function (s) { return String(s.id) === this.sub; }, this)) this.sub = '';
        }
    },
    methods: {
        onFocus(e) { this.typing = false; this.open = true; this.hi = 0; if (e && e.target) e.target.select(); },
        closeList() { this.open = false; this.typing = false; this.search = this.selectedLabel; },
        move(d) {
            if (!this.open) { this.open = true; return; }
            var n = this.options.length; if (!n) return;
            this.hi = (this.hi + d + n) % n;
        },
        pickHighlighted() { if (this.options[this.hi]) this.pick(this.options[this.hi]); },
        pick(o) { this.requesterId = o.id; this.search = o.label; this.typing = false; this.open = false; },
        fmt(m) {
            if (!m) return '';
            if (m < 60) return m + ' min';
            if (m < 60 * 24) return Math.round(m / 60) + ' h';
            return Math.round(m / 60 / 8) + ' working days';
        },
        sync(list) {
            var dt = new DataTransfer();
            list.forEach(function (f) { dt.items.add(f); });
            this.$refs.file.files = dt.files;
            this.files = list;
        },
        add(picked) {
            var self = this, seen = {}, merged = [], tooBig = [];
            this.files.concat(picked).forEach(function (f) {
                if (f.size > self.maxKb * 1024) { tooBig.push(f.name); return; }
                var k = f.name + ':' + f.size;
                if (!seen[k]) { seen[k] = 1; merged.push(f); }
            });
            this.fileError = tooBig.length
                ? 'Not added (over ' + this.maxMb + ' MB): ' + tooBig.join(', ')
                : '';
            this.sync(merged);
        },
        onPick(e) { this.add(Array.prototype.slice.call(e.target.files)); },
        onDrop(e) { this.dragOver = false; this.add(Array.prototype.slice.call(e.dataTransfer.files)); },
        remove(i) { var l = this.files.slice(); l.splice(i, 1); this.fileError = ''; this.sync(l); }
    }
}).mount('#ticketForm');
</script>
@endpush
