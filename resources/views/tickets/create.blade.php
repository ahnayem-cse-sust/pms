@extends('layouts.app')
@section('title', 'New Request')
@section('content')
@php
    $u = auth()->user();
    $person = fn ($p) => [
        'id' => $p->id, 'name' => $p->name, 'emp' => $p->employee_id, 'desig' => $p->designation?->name,
        'dept' => $p->department?->name, 'deptId' => $p->department_id, 'email' => $p->email,
        'phone' => $p->whatsapp, 'locId' => $p->location_id, 'loc' => $p->location?->name,
        'avatar' => $p->avatar_path ? route('avatar.show', $p) . '?v=' . optional($p->updated_at)->timestamp : null,
        'hue' => crc32((string) $p->name) % 360,
    ];
    $u->loadMissing(['department', 'designation', 'location']);
    $cfg = [
        'me' => $person($u),
        'users' => $requesters->map($person)->values(),
        'maxKb' => \App\Services\AttachmentService::maxKb(),
        'categories' => $categories->map(fn ($c) => [
            'id' => $c->id, 'name' => $c->name,
        ])->values(),
        'subs' => $categories->flatMap(fn ($c) => $c->subcategories->map(fn ($s) => [
            'id' => $s->id, 'name' => $s->name, 'catId' => $c->id, 'catName' => $c->name,
        ]))->values(),
        'old' => [
            'requester' => (string) old('requester_id'),
            'phone' => old('phone'), 'location' => (string) old('location_id'), 'department' => (string) old('department_id'),
            'category' => (string) old('category_id'), 'sub' => (string) old('subcategory_id'),
            'subject' => old('subject', ''), 'description' => old('description', ''),
        ],
    ];
@endphp

<div class="row justify-content-center"><div class="col-xl-10">
<form id="ticketForm" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" v-cloak v-on:submit="submitting = true">
    @csrf
    <div class="card">
        <div class="nr-sec nr-sec-a">

            {{-- Requester --}}
            <div class="nr-h"><span class="nr-ic"><x-icon name="user" :size="14"/></span>Who is the requester?<span v-if="behalf" class="pill pill-warning ms-auto text-capitalize" style="letter-spacing:0;font-weight:600">Filing on behalf of another person</span></div>
            @php($has = $requesters->isNotEmpty())
            <div class="nr-grid">
                <div class="nr-left">
                    @if($has)
                    <div>
                        <label class="form-label">Request for</label>
                        <combo-select name="requester_id" v-model="requesterId" :options="personOptions" placeholder="Myself"></combo-select>
                        <div class="form-text">Search by name or employee ID to file for someone else.</div>
                    </div>
                    @endif
                    <div>
                        <label class="form-label">WhatsApp number</label>
                        <input name="phone" v-model="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+8801XXXXXXXXX" inputmode="tel">
                    </div>
                </div>
                <div class="nr-right">
                    <div class="nr-card">
                        <div class="nr-top">
                            <img v-if="who.avatar" :src="who.avatar" :alt="who.name" class="nr-photo">
                            <span v-else class="nr-photo nr-ini" :style="{ '--h': who.hue }" v-text="initials"></span>
                            <div class="nr-id">
                                <div class="nm" v-text="who.name || '—'"></div>
                                <div class="ds" v-text="who.desig || 'No designation'"></div>
                            </div>
                        </div>
                        <div class="nr-facts">
                            <div class="nr-fact">
                                <span class="ic"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/></svg></span>
                                <div><small>Employee ID</small><b v-text="who.emp || '—'"></b></div>
                            </div>
                            <div class="nr-fact">
                                <span class="ic"><x-icon name="building" :size="15"/></span>
                                {{-- Department comes from the requester's profile; only asked for when the profile has none --}}
                                <div v-if="who.deptId"><small>Department</small><b v-text="who.dept"></b></div>
                                <div v-else class="flex-grow-1">
                                    <small>Department <span class="text-danger">*</span></small>
                                    <select name="department_id" class="form-select form-select-sm @error('department_id') is-invalid @enderror" v-model="departmentId" required>
                                        <option value="">Select…</option>
                                        @foreach($departments as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="nr-fact">
                                <span class="ic"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
                                <div><small>Location</small><b v-text="who.loc || '—'"></b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="nr-sec nr-sec-b">

            {{-- Request --}}
            <div class="nr-h"><span class="nr-ic"><x-icon name="clipboard" :size="14"/></span>Request details</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Service type <span class="text-danger">*</span></label>
                    <select name="ticket_type_id" class="form-select @error('ticket_type_id') is-invalid @enderror" required>
                        @foreach($types as $t)<option value="{{ $t->id }}" @selected(old('ticket_type_id') == $t->id)>{{ $t->name }}</option>@endforeach
                    </select>
                    <div class="form-text">What kind of help is this?</div>
                </div>
                <div class="col-md-6 d-none d-md-block"></div>
                <div class="col-12">
                    <label class="form-label d-flex justify-content-between">Subject <span class="text-danger ms-1 me-auto">*</span><span class="text-muted fw-normal small">[[ subject.length ]]/200</span></label>
                    <input name="subject" v-model="subject" class="form-control @error('subject') is-invalid @enderror" maxlength="200" placeholder="A short summary, e.g. Unable to print Sales Invoice" required v-on:keydown.enter.prevent>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" v-model="category" v-on:change="onCategory" required>
                            <option value="">Select…</option>
                            <option v-for="c in categories" :key="c.id" :value="String(c.id)">[[ c.name ]]</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Sub-category <span class="text-muted fw-normal">(optional)</span></label>
                        <combo-select name="subcategory_id" v-model="sub" :options="subOptions" empty-label="—" v-on:change="onSub"></combo-select>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="nr-tip" :class="{ ok: catNote }">
                        <b v-text="catNote ? 'Category filled in' : 'Tip'"></b>
                        <span v-text="catNote || 'Not sure which category? Search the sub-category list by typing and the category is filled in for you.'"></span>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label d-flex justify-content-between">Detailed description <span class="text-danger ms-1 me-auto">*</span><span class="text-muted fw-normal small">[[ description.length ]] characters</span></label>
                    <textarea name="description" v-model="description" rows="12" class="form-control @error('description') is-invalid @enderror" placeholder="What happened? What did you expect? Any error message? Since when?" required></textarea>
                    <div class="form-text">The more detail you give, the faster IT can help. Include error messages and the steps that lead to the problem.</div>
                </div>
                <div class="col-12">
                    <label class="form-label d-flex justify-content-between">Attachments <span class="text-muted fw-normal small">Max [[ maxMb ]] MB per file</span></label>
                    <div class="dropzone" :class="{ over: dragOver }" style="padding:.8rem"
                         v-on:click="$refs.file.click()"
                         v-on:dragover.prevent="dragOver = true" v-on:dragleave="dragOver = false"
                         v-on:drop.prevent="onDrop">
                        Drop files here, <b>click to browse</b>, or paste a screenshot with <b>Ctrl+V</b>
                    </div>
                    <input type="file" name="attachments[]" ref="file" multiple class="d-none" v-on:change="onPick">
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
        <div class="uf-foot">
            <span class="note" v-if="missing"><span class="text-danger">*</span> [[ missing ]] required field[[ missing > 1 ? 's' : '' ]] left</span>
            <span class="note text-success" v-else>All required fields are filled in.</span>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
            <button class="btn btn-primary px-4" :disabled="submitting"><span v-if="submitting">Submitting…</span><span v-else>Submit request</span></button>
        </div>
    </div>
</form>
</div></div>
@endsection

@push('scripts')
<style>
[v-cloak]{display:none}
#ticketForm .form-label{ color:var(--text); font-weight:600; }
.nr-body{ padding:1.1rem 1.25rem; }
#ticketForm .uf-foot{ position:sticky; bottom:0; z-index:5; border-radius:0 0 var(--radius) var(--radius); }
.nr-h{ display:flex; align-items:center; gap:.45rem; margin-bottom:.7rem; font-size:.98rem; font-weight:650; color:var(--text); }
.nr-grid{ display:grid; grid-template-columns:1fr; gap:1rem; align-items:start; }
.nr-left{ display:flex; flex-direction:column; gap:.9rem; min-width:0; }
.nr-right{ min-width:0; }
@media (min-width:992px){ .nr-grid{ grid-template-columns:5fr 7fr; } }
.nr-card{ border:1px solid var(--border); border-radius:14px; background:color-mix(in srgb,var(--card) 70%,var(--bg)); overflow:hidden; }
.nr-top{ display:flex; align-items:center; gap:.9rem; padding:.85rem 1rem; }
.nr-photo{ width:60px; height:60px; border-radius:50%; flex:none; object-fit:cover; box-shadow:0 0 0 3px var(--card), 0 0 0 4px var(--border); }
.nr-ini{ --h:230; display:grid; place-items:center; color:#fff; font-weight:700; font-size:1.2rem; background:hsl(var(--h) 55% 48%); }
.nr-id{ min-width:0; } .nr-id .nm{ font-size:1.02rem; font-weight:700; line-height:1.25; overflow-wrap:anywhere; } .nr-id .ds{ color:var(--muted); font-size:.84rem; }
.nr-facts{ display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:.6rem 1rem; padding:.7rem 1rem; border-top:1px solid var(--border); background:var(--card); }
.nr-fact{ display:flex; align-items:center; gap:.55rem; min-width:0; }
.nr-fact .ic{ width:30px; height:30px; border-radius:9px; display:grid; place-items:center; background:var(--primary-soft); color:var(--primary); flex:none; }
.nr-fact small{ display:block; color:var(--muted); font-size:.7rem; line-height:1.2; } .nr-fact b{ display:block; font-size:.86rem; font-weight:600; line-height:1.25; overflow-wrap:anywhere; }
/* colour scheme */
#ticketForm > .card{ overflow:hidden; border-color:color-mix(in srgb,var(--primary) 22%,var(--border)); box-shadow:0 6px 24px color-mix(in srgb,var(--primary) 10%,transparent); }
#ticketForm > .card::before{ content:''; display:block; height:4px; background:linear-gradient(90deg,var(--primary),#7c3aed 55%,#14b8a6); }
.nr-sec{ padding:1.1rem 1.25rem; }
.nr-sec-a{ background:color-mix(in srgb,var(--primary) 6%,var(--card)); border-bottom:1px solid color-mix(in srgb,var(--primary) 18%,var(--border)); }
.nr-sec-b{ background:var(--card); }
.nr-ic{ width:28px; height:28px; border-radius:9px; display:grid; place-items:center; color:#fff; background:linear-gradient(135deg,var(--primary),#7c3aed); flex:none; }
.nr-sec-b .nr-ic{ background:linear-gradient(135deg,#0d9488,#14b8a6); }
.nr-sec-a .nr-h{ color:var(--primary-600); } .nr-sec-b .nr-h{ color:#0f766e; }
[data-bs-theme=dark] .nr-sec-b .nr-h{ color:#5eead4; } [data-bs-theme=dark] .nr-sec-a .nr-h{ color:#a5b4fc; }
.nr-card{ background:var(--card); border-color:color-mix(in srgb,var(--primary) 22%,var(--border)); }
.nr-top{ background:linear-gradient(135deg,color-mix(in srgb,var(--primary) 16%,var(--card)),color-mix(in srgb,#14b8a6 14%,var(--card))); }
.nr-facts{ background:var(--card); }
.nr-fact:nth-child(1) .ic{ background:color-mix(in srgb,var(--primary) 14%,var(--card)); color:var(--primary); }
.nr-fact:nth-child(2) .ic{ background:color-mix(in srgb,#14b8a6 16%,var(--card)); color:#0f766e; }
.nr-fact:nth-child(3) .ic{ background:color-mix(in srgb,#f59e0b 18%,var(--card)); color:#b45309; }
[data-bs-theme=dark] .nr-fact:nth-child(2) .ic{ color:#5eead4; } [data-bs-theme=dark] .nr-fact:nth-child(3) .ic{ color:#fcd34d; }
#ticketForm .form-control:focus,#ticketForm .form-select:focus,#ticketForm .ss-btn:focus{ border-color:var(--primary); box-shadow:0 0 0 .2rem color-mix(in srgb,var(--primary) 20%,transparent); }
#ticketForm .dropzone{ border-color:color-mix(in srgb,var(--primary) 40%,var(--border)); background:color-mix(in srgb,var(--primary) 4%,var(--card)); }
#ticketForm .dropzone b{ color:var(--primary); }
#ticketForm .uf-foot{ background:color-mix(in srgb,var(--primary) 6%,var(--card)); border-top-color:color-mix(in srgb,var(--primary) 18%,var(--border)); }
#ticketForm .btn-primary{ background:linear-gradient(135deg,var(--primary),#7c3aed); border:0; box-shadow:0 4px 12px color-mix(in srgb,var(--primary) 30%,transparent); }
#ticketForm .btn-primary:hover:not(:disabled){ filter:brightness(1.08); }
.nr-card{ margin-top:1.5rem; }
@media (max-width:991.98px){ .nr-card{ margin-top:0; } }
.nr-tip{ align-self:flex-end; width:100%; display:flex; flex-direction:column; gap:.15rem; padding:.6rem .85rem; border-radius:12px; font-size:.82rem; color:var(--text); background:color-mix(in srgb,#f59e0b 10%,var(--card)); border:1px dashed color-mix(in srgb,#f59e0b 45%,var(--border)); }
.nr-tip b{ font-size:.72rem; text-transform:uppercase; letter-spacing:.06em; color:#b45309; }
.nr-tip.ok{ background:color-mix(in srgb,#14b8a6 10%,var(--card)); border-color:color-mix(in srgb,#14b8a6 45%,var(--border)); } .nr-tip.ok b{ color:#0f766e; }
[data-bs-theme=dark] .nr-tip b{ color:#fcd34d; } [data-bs-theme=dark] .nr-tip.ok b{ color:#5eead4; }
.nr-hr{ margin:1.15rem 0; border-color:var(--border); opacity:1; }
.ss{ position:relative; }
</style>
<script>
const CFG = @json($cfg);
const app = Vue.createApp({
    delimiters: ['[[', ']]'],
    data() {
        var o = CFG.old;
        var start = o.requester ? (CFG.users.find(function (p) { return String(p.id) === o.requester; }) || CFG.me) : CFG.me;
        return {
            me: CFG.me, users: CFG.users, requesterId: o.requester,
            phone: o.phone !== null && o.phone !== '' ? o.phone : (start.phone || ''),
            departmentId: o.department,
            categories: CFG.categories, allSubs: CFG.subs,
            category: o.category, sub: o.sub, catNote: '',
            subject: o.subject, description: o.description,
            files: [], fileError: '', maxKb: CFG.maxKb, dragOver: false, submitting: false
        };
    },
    computed: {
        // required fields still empty (the server validates again on submit)
        missing() {
            var n = 0;
            if (!this.subject.trim()) n++;
            if (!this.category) n++;
            if (!this.description.trim()) n++;
            if (!this.who.deptId && !this.departmentId) n++;
            return n;
        },
        dirty() { return !this.submitting && (this.subject.trim() !== '' || this.description.trim() !== '' || this.files.length > 0); },
        maxMb() { return Math.round(this.maxKb / 1024 * 10) / 10; },
        who() {
            var id = this.requesterId;
            return id ? (this.users.find(function (p) { return String(p.id) === id; }) || this.me) : this.me;
        },
        initials() {
            var m = (this.who.name || '').trim().split(/\s+/);
            return ((m[0] || '').charAt(0) + (m.length > 1 ? m[m.length - 1].charAt(0) : '')).toUpperCase() || '?';
        },
        behalf() { return !!this.requesterId && this.who !== this.me; },
        personOptions() {
            var list = [{ id: '', label: 'Myself – ' + this.me.name, sub: '', hay: 'myself ' + this.me.name.toLowerCase() }];
            this.users.forEach(function (p) {
                list.push({
                    id: String(p.id), label: p.name + (p.emp ? ' (' + p.emp + ')' : ''), sub: '',
                    hay: [p.name, p.emp].join(' ').toLowerCase()
                });
            });
            return list;
        },
        // every sub-category is always listed; its category is shown beside it and searchable
        subOptions() {
            return this.allSubs.map(function (s) {
                return { id: String(s.id), label: s.name, sub: s.catName, hay: (s.name + ' ' + s.catName).toLowerCase() };
            });
        }
    },
    watch: {
        // switching person refreshes the contact number and office from that person's record
        requesterId() {
            this.phone = this.who.phone || '';
            this.departmentId = '';
        }
    },
    mounted() {
        this._paste = this.onPaste.bind(this); this._leave = this.onLeave.bind(this);
        window.addEventListener('paste', this._paste); window.addEventListener('beforeunload', this._leave);
    },
    unmounted() { window.removeEventListener('paste', this._paste); window.removeEventListener('beforeunload', this._leave); },
    methods: {
        // choosing a sub-category fills in its category automatically
        onSub(id) {
            var s = this.allSubs.find(function (x) { return String(x.id) === String(id); });
            if (s) {
                this.category = String(s.catId);
                this.catNote = 'Category set to \u201c' + s.catName + '\u201d from the sub-category you picked.';
            } else {
                this.catNote = '';
            }
        },
        // changing the category drops a sub-category that belongs to a different one
        onCategory() {
            var s = this.allSubs.find(function (x) { return String(x.id) === this.sub; }, this);
            if (s && String(s.catId) !== this.category) this.sub = '';
            this.catNote = '';
        },
        // paste a screenshot straight from the clipboard
        onPaste(e) {
            var items = e.clipboardData && e.clipboardData.files ? Array.prototype.slice.call(e.clipboardData.files) : [];
            if (!items.length) return;
            var stamp = new Date().toISOString().replace(/[-:T]/g, '').slice(0, 14);
            this.add(items.map(function (f, i) {
                return /^image\.\w+$/i.test(f.name) ? new File([f], 'screenshot-' + stamp + (i ? '-' + i : '') + '.' + (f.type.split('/')[1] || 'png'), { type: f.type }) : f;
            }));
        },
        // warn before leaving a half-written request
        onLeave(e) { if (this.dirty) { e.preventDefault(); e.returnValue = ''; } },
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
});

// Searchable select, same look and behaviour as the sub category picker on the equipment page:
// a select-style button opens a panel with a search box and a list (name left, path right).
app.component('combo-select', {
    props: {
        modelValue: { default: '' }, options: { type: Array, default: function () { return []; } },
        name: String, emptyLabel: { type: String, default: '' }, placeholder: { type: String, default: '' }
    },
    emits: ['update:modelValue', 'change'],
    data() { return { open: false, q: '', hl: 0 }; },
    mounted() {
        this._away = (function (e) { if (this.open && !this.$el.contains(e.target)) this.open = false; }).bind(this);
        document.addEventListener('mousedown', this._away);
    },
    unmounted() { document.removeEventListener('mousedown', this._away); },
    computed: {
        current() {
            var v = String(this.modelValue == null ? '' : this.modelValue);
            return this.options.find(function (o) { return String(o.id) === v && v !== ''; }) || null;
        },
        shown() {
            var q = this.q.trim().toLowerCase();
            if (q) return this.options.filter(function (o) { return o.hay.indexOf(q) !== -1; });
            return this.emptyLabel ? [{ id: '', label: this.emptyLabel, sub: '', hay: '' }].concat(this.options) : this.options;
        }
    },
    methods: {
        toggle() { this.open ? this.close() : this.show(); },
        show() {
            this.open = true; this.q = '';
            var v = String(this.modelValue == null ? '' : this.modelValue), self = this;
            var i = this.shown.findIndex(function (o) { return String(o.id) === v; });
            this.hl = i < 0 ? 0 : i;
            this.$nextTick(function () { self.$refs.box.focus(); self.scroll(); });
        },
        close() { this.open = false; },
        scroll() {
            var el = this.$refs.list && this.$refs.list.children[this.hl];
            if (el && el.scrollIntoView) el.scrollIntoView({ block: 'nearest' });
        },
        move(d) {
            var n = this.shown.length; if (!n) return;
            this.hl = (this.hl + d + n) % n;
            this.$nextTick(this.scroll);
        },
        pickHl() { var o = this.shown[this.hl]; if (o) this.pick(o); },
        pick(o) {
            this.$emit('update:modelValue', o.id); this.$emit('change', o.id);
            this.open = false;
            if (this.$refs.btn) this.$refs.btn.focus();
        }
    },
    template: `
        <div class="ss">
            <input type="hidden" :name="name" :value="modelValue">
            <button type="button" class="form-select ss-btn" :class="{ 'ss-placeholder': !current }"
                    v-on:click="toggle" v-on:keydown.down.prevent="show" v-on:keydown.up.prevent="show" ref="btn"
                    v-text="current ? current.label : (emptyLabel || placeholder)"></button>
            <div class="ss-panel" v-show="open">
                <input type="search" class="form-control form-control-sm" placeholder="Search…" autocomplete="off" ref="box"
                       v-model="q" v-on:input="hl = 0"
                       v-on:keydown.down.prevent="move(1)" v-on:keydown.up.prevent="move(-1)"
                       v-on:keydown.enter.prevent="pickHl" v-on:keydown.esc.prevent="close(); $refs.btn.focus()">
                <div class="ss-list" ref="list">
                    <div v-for="(o, i) in shown" :key="'o' + o.id" class="ss-item" :class="{ hl: i === hl, active: String(o.id) === String(modelValue) }"
                         v-on:mousedown.prevent="pick(o)" v-on:mouseenter="hl = i">
                        <span v-text="o.label"></span><small v-text="o.sub"></small>
                    </div>
                    <div v-if="!shown.length" class="ss-none">Nothing matches.</div>
                </div>
            </div>
        </div>`
});
app.mount('#ticketForm');
</script>
@endpush
