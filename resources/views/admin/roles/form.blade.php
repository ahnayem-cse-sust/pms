@extends('layouts.app')
@section('title', $role->exists ? (($locked ?? false) ? 'View role' : 'Edit role') : 'New role')
@section('content')
@php($locked = $locked ?? false)
@php($builtIn = $role->exists && array_key_exists($role->slug, config('itsm.roles')))
@php($picked = collect(old('permissions', $role->permissions ?? []))->all())
@php($labels = collect($catalog)->flatMap(fn ($g) => $g)->all())
@php($acts = ['read' => 'Read', 'add' => 'Add', 'update' => 'Update', 'delete' => 'Delete'])
<form method="POST" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}" class="card">
    @csrf
    @if($role->exists) @method('PUT') @endif
    <div class="card-body">
        @if($role->slug === 'admin')<div class="alert alert-info py-2">The System Administrator role is fixed so administrators can never be locked out. Individual users can still receive extra permissions on their own page.</div>
        @elseif($locked)<div class="alert alert-info py-2">You can view this role but you do not have permission to change it.</div>@endif
        @if(! empty($copiedFrom))<div class="alert alert-info py-2">Starting from <b>{{ $copiedFrom->name }}</b>. Give the new role a name, adjust the access and save.</div>@endif
        @if($errors->any())<div class="alert alert-danger py-2">{{ $errors->first() }}</div>@endif
        <div class="row g-3 mb-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Role name *</label>
                <input name="name" value="{{ old('name', $role->name) }}" class="form-control" required maxlength="100" @readonly($locked || $builtIn) placeholder="e.g. Service Desk Agent">
                @if($builtIn && ! $locked)<div class="form-text">Built-in role names are fixed; only the access can be changed.</div>@endif
            </div>
            @unless($locked)
            <div class="col-md-4"><label class="form-label">Find a module or permission</label><input type="search" id="permSearch" class="form-control" placeholder="Search…"></div>
            <div class="col-md-3 d-flex gap-2 align-items-center">
                <span class="pill pill-primary" id="permCount">0 selected</span>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="permClear">Clear all</button>
            </div>
            @endunless
        </div>
        @if($role->exists && ! empty($users) && $users->count())
            <div class="small text-muted mb-3">Held by: {{ $users->pluck('name')->implode(', ') }}@if($role->users()->count() > $users->count()) and {{ $role->users()->count() - $users->count() }} more @endif</div>
        @endif

        <label class="form-label">Module access *</label>
        <div class="table-responsive mb-4">
        <table class="table table-sm align-middle perm-matrix mb-0">
            <thead class="table-light">
                <tr>
                    <th>Module</th>
                    @foreach($acts as $a => $t)
                        <th class="text-center" style="width:90px">{{ $t }}
                            @unless($locked)<div><input type="checkbox" class="form-check-input col-all" data-act="{{ $a }}" title="Select every {{ $t }} permission"></div>@endunless
                        </th>
                    @endforeach
                    @unless($locked)<th class="text-center" style="width:70px">All</th>@endunless
                </tr>
            </thead>
            <tbody>
            @foreach($matrix as $module => $rows)
                <tr class="table-secondary matrix-module"><td colspan="{{ $locked ? 5 : 6 }}" class="fw-semibold small text-uppercase">{{ $module }}</td></tr>
                @foreach($rows as $row)
                    @php($text = strtolower($module.' '.$row['label'].' '.collect($acts)->keys()->map(fn ($a) => ($row[$a] ?? '').' '.($labels[$row[$a] ?? ''] ?? ''))->implode(' ')))
                    <tr class="matrix-row" data-text="{{ $text }}">
                        <td>{{ $row['label'] }}@if(! empty($row['note']))<div class="text-muted" style="font-size:.72rem">{{ $row['note'] }}</div>@endif</td>
                        @foreach($acts as $a => $t)
                            <td class="text-center">
                                @if($row[$a])
                                    <input class="form-check-input perm-item" type="checkbox" name="permissions[]" value="{{ $row[$a] }}" data-act="{{ $a }}" id="p_{{ md5($row[$a]) }}" title="{{ $labels[$row[$a]] ?? $row[$a] }}" aria-label="{{ $row['label'] }} – {{ $t }}" @checked(in_array($row[$a], $picked)) @disabled($locked)>
                                @else
                                    <span class="text-muted" title="Not available for this module">–</span>
                                @endif
                            </td>
                        @endforeach
                        @unless($locked)<td class="text-center"><input type="checkbox" class="form-check-input row-all" title="Select the whole row"></td>@endunless
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
        </div>

        @if(! empty($menus))
        <label class="form-label mt-4">Sidebar menus <span class="text-muted fw-normal">&ndash; tick the menus this role sees; the access a menu needs is added automatically</span></label>
        <div class="row g-3 mb-2" id="menuGrid">
        @foreach($menus as $section => $items)
            <div class="col-md-6 col-xl-4 perm-col">
                <div class="card h-100 perm-group">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ $section }} <span class="text-muted fw-normal small perm-n"></span></span>
                        @unless($locked)<label class="small fw-normal text-muted mb-0"><input type="checkbox" class="form-check-input me-1 perm-all"> All</label>@endunless
                    </div>
                    <div class="card-body">
                        @foreach($items as $key => $label)
                            @php($req = config("itsm.permission_requires.$key", []))
                            <div class="form-check perm-line" data-text="{{ strtolower($label.' '.$key.' menu sidebar') }}">
                                <input class="form-check-input perm-item" type="checkbox" name="permissions[]" value="{{ $key }}" id="p_{{ md5($key) }}" @checked(in_array($key, $picked)) @disabled($locked)>
                                <label class="form-check-label" for="p_{{ md5($key) }}">{{ $label }}@if($req)<span class="d-block text-muted" style="font-size:.7rem">needs: {{ collect($req)->map(fn ($k) => $labels[$k] ?? $k)->implode(', ') }}</span>@endif</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        @endif

        @if(count($others))
        <label class="form-label mt-3">Workflow &amp; other actions</label>
        <div class="row g-3" id="permGrid">
        @foreach($others as $group => $items)
            <div class="col-md-6 col-xl-4 perm-col">
                <div class="card h-100 perm-group">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ $group }} <span class="text-muted fw-normal small perm-n"></span></span>
                        @unless($locked)<label class="small fw-normal text-muted mb-0"><input type="checkbox" class="form-check-input me-1 perm-all"> All</label>@endunless
                    </div>
                    <div class="card-body">
                        @foreach($items as $key => $label)
                            @php($req = config("itsm.permission_requires.$key", []))
                            <div class="form-check perm-line" data-text="{{ strtolower($label.' '.$key) }}">
                                <input class="form-check-input perm-item" type="checkbox" name="permissions[]" value="{{ $key }}" id="p_{{ md5($key) }}" @checked(in_array($key, $picked)) @disabled($locked)>
                                <label class="form-check-label" for="p_{{ md5($key) }}">{{ $label }}@if($req)<span class="d-block text-muted" style="font-size:.7rem">also needs: {{ collect($req)->map(fn ($k) => $labels[$k] ?? $k)->implode(', ') }}</span>@endif</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        @endif
        <div class="form-text mt-2">Add / Update / Delete automatically switch on Read for the same module, and a permission also switches on the ones it depends on.</div>
        <div class="mt-3">
            @unless($locked)<button class="btn btn-primary">Save</button>@endunless
            <a href="{{ route('admin.roles.index') }}" class="btn btn-link">{{ $locked ? 'Back' : 'Cancel' }}</a>
        </div>
    </div>
</form>
@push('scripts')
<script>
(function () {
    var REQ = @json(config('itsm.permission_requires')), LABEL = @json($labels);
    var items = Array.prototype.slice.call(document.querySelectorAll('.perm-item'));
    var byKey = {}; items.forEach(function (i) { byKey[i.value] = i; });

    function addDeps(key, added) {
        (REQ[key] || []).forEach(function (d) {
            if (byKey[d] && !byKey[d].checked) { byKey[d].checked = true; added.push(LABEL[d] || d); addDeps(d, added); }
        });
    }
    function dropDependants(key, removed) {
        items.forEach(function (o) {
            if (o.checked && (REQ[o.value] || []).indexOf(key) > -1) { o.checked = false; removed.push(LABEL[o.value] || o.value); dropDependants(o.value, removed); }
        });
    }
    function refresh() {
        document.querySelectorAll('.perm-group').forEach(function (g) {
            var its = g.querySelectorAll('.perm-item'), on = g.querySelectorAll('.perm-item:checked').length, all = g.querySelector('.perm-all');
            if (all) all.checked = on === its.length;
            g.querySelector('.perm-n').textContent = '(' + on + '/' + its.length + ')';
        });
        document.querySelectorAll('.matrix-row').forEach(function (r) {
            var its = r.querySelectorAll('.perm-item'), all = r.querySelector('.row-all');
            if (all) all.checked = its.length > 0 && r.querySelectorAll('.perm-item:checked').length === its.length;
        });
        document.querySelectorAll('.col-all').forEach(function (c) {
            var its = document.querySelectorAll('.matrix-row .perm-item[data-act="' + c.dataset.act + '"]');
            c.checked = its.length > 0 && document.querySelectorAll('.matrix-row .perm-item[data-act="' + c.dataset.act + '"]:checked').length === its.length;
        });
        var c = document.getElementById('permCount');
        if (c) c.textContent = items.filter(function (i) { return i.checked; }).length + ' selected';
    }
    function note(prefix, list) { if (list.length && window.toast) window.toast(prefix + list.join(', ')); }
    items.forEach(function (i) {
        i.addEventListener('change', function () {
            var list = [];
            if (i.checked) { addDeps(i.value, list); note('Also added: ', list); }
            else { dropDependants(i.value, list); note('Also removed: ', list); }
            refresh();
        });
    });
    // whole row of the matrix
    document.querySelectorAll('.row-all').forEach(function (b) {
        b.addEventListener('change', function () {
            var row = b.closest('tr');
            row.querySelectorAll('.perm-item').forEach(function (i) { i.checked = b.checked; if (b.checked) addDeps(i.value, []); });
            if (!b.checked) row.querySelectorAll('.perm-item').forEach(function (i) { dropDependants(i.value, []); });
            refresh();
        });
    });
    // one action (Read / Add / Update / Delete) for every visible module
    document.querySelectorAll('.col-all').forEach(function (b) {
        b.addEventListener('change', function () {
            document.querySelectorAll('.matrix-row').forEach(function (r) {
                if (r.style.display === 'none') return;
                var i = r.querySelector('.perm-item[data-act="' + b.dataset.act + '"]');
                if (!i) return;
                i.checked = b.checked;
                if (b.checked) addDeps(i.value, []); else dropDependants(i.value, []);
            });
            refresh();
        });
    });
    // groups below the matrix
    document.querySelectorAll('.perm-group').forEach(function (g) {
        var all = g.querySelector('.perm-all'); if (!all) return;
        all.addEventListener('change', function () {
            g.querySelectorAll('.perm-item').forEach(function (i) { i.checked = all.checked; if (all.checked) addDeps(i.value, []); else dropDependants(i.value, []); });
            refresh();
        });
    });
    var clear = document.getElementById('permClear');
    if (clear) clear.addEventListener('click', function () { items.forEach(function (i) { i.checked = false; }); refresh(); });
    var s = document.getElementById('permSearch');
    if (s) s.addEventListener('input', function () {
        var q = s.value.trim().toLowerCase();
        document.querySelectorAll('.matrix-row').forEach(function (r) { r.style.display = r.dataset.text.indexOf(q) > -1 ? '' : 'none'; });
        document.querySelectorAll('.matrix-module').forEach(function (m) {
            var n = m.nextElementSibling, any = false;
            while (n && n.classList.contains('matrix-row')) { if (n.style.display !== 'none') any = true; n = n.nextElementSibling; }
            m.style.display = any ? '' : 'none';
        });
        document.querySelectorAll('.perm-line').forEach(function (l) { l.style.display = l.dataset.text.indexOf(q) > -1 ? '' : 'none'; });
        document.querySelectorAll('.perm-col').forEach(function (c) { c.style.display = Array.prototype.some.call(c.querySelectorAll('.perm-line'), function (l) { return l.style.display !== 'none'; }) ? '' : 'none'; });
    });
    refresh();
})();
</script>
@endpush
@endsection
