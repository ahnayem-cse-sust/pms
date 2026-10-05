@extends('layouts.app')
@section('title', 'New Request')
@section('content')
@php
    $u = auth()->user();
    $cfg = [
        'categories' => $categories->map(fn ($c) => [
            'id' => $c->id, 'name' => $c->name,
            'subs' => $c->subcategories->map(fn ($s) => ['id' => $s->id, 'name' => $s->name])->values(),
        ])->values(),
        'priorities' => $priorities->map(fn ($p) => [
            'id' => $p->id, 'name' => $p->name, 'resp' => $p->response_minutes, 'reso' => $p->resolution_minutes,
        ])->values(),
        'old' => [
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
        <div class="card-header">Requester</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Name</label><input class="form-control" value="{{ $u->name }}" disabled></div>
                <div class="col-md-2"><label class="form-label">Employee ID</label><input class="form-control" value="{{ $u->employee_id }}" disabled></div>
                <div class="col-md-3"><label class="form-label">Designation</label><input class="form-control" value="{{ $u->designation?->name }}" disabled></div>
                <div class="col-md-3">
                    <label class="form-label">Department</label>
                    @if($u->department_id)
                        <input class="form-control" value="{{ $u->department->name }}" disabled>
                    @else
                        <select name="department_id" class="form-select" required>
                            <option value="">Select…</option>
                            @foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('department_id') == $d->id)>{{ $d->name }}</option>@endforeach
                        </select>
                    @endif
                </div>
                <div class="col-md-4"><label class="form-label">Contact number</label><input name="phone" value="{{ old('phone', $u->phone) }}" class="form-control"></div>
                <div class="col-md-4">
                    <label class="form-label">Location / office</label>
                    <select name="location_id" class="form-select"><option value="">—</option>
                        @foreach($locations as $l)<option value="{{ $l->id }}" @selected(old('location_id', $u->location_id) == $l->id)>{{ $l->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Preferred completion date</label><input type="date" name="preferred_completion_date" value="{{ old('preferred_completion_date') }}" class="form-control"></div>
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
                                <small v-if="p.resp">Response ~[[ fmt(p.resp) ]] · fix ~[[ fmt(p.reso) ]]</small>
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
                    <textarea name="description" v-model="description" rows="6" class="form-control" placeholder="What happened, what you expected, any error message, since when…" required></textarea>
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
        return {
            categories: CFG.categories, priorities: CFG.priorities,
            category: CFG.old.category, sub: CFG.old.sub, priority: CFG.old.priority,
            subject: CFG.old.subject, description: CFG.old.description,
            files: [], dragOver: false, submitting: false
        };
    },
    computed: {
        subs() {
            var c = this.categories.find(function (x) { return String(x.id) === this.category; }, this);
            return c ? c.subs : [];
        }
    },
    watch: {
        category() {
            if (!this.subs.some(function (s) { return String(s.id) === this.sub; }, this)) this.sub = '';
        }
    },
    methods: {
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
            var seen = {}; var merged = [];
            this.files.concat(picked).forEach(function (f) {
                var k = f.name + ':' + f.size;
                if (!seen[k]) { seen[k] = 1; merged.push(f); }
            });
            this.sync(merged);
        },
        onPick(e) { this.add(Array.prototype.slice.call(e.target.files)); },
        onDrop(e) { this.dragOver = false; this.add(Array.prototype.slice.call(e.dataTransfer.files)); },
        remove(i) { var l = this.files.slice(); l.splice(i, 1); this.sync(l); }
    }
}).mount('#ticketForm');
</script>
@endpush
