@extends('layouts.app')
@section('title', $user->exists ? 'Edit user' : 'New user')
@section('content')
@php($req = ! $user->exists)
@php($star = $req ? ' *' : '')
@php($r_ = $req ? 'required' : '')
<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="card">
    @csrf
    @if($user->exists) @method('PUT') @endif
    @if($req)<div class="card-header small text-muted fw-normal">All fields are mandatory</div>@endif
    <div class="card-body">
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Full name *</label><input name="name" value="{{ old('name', $user->name) }}" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Email *</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Employee ID{{ $star }}</label><input name="employee_id" value="{{ old('employee_id', $user->employee_id) }}" class="form-control" {{ $r_ }}></div>
        <div class="col-md-2"><label class="form-label">WhatsApp number{{ $star }}</label><input name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="form-control" placeholder="+8801XXXXXXXXX" inputmode="tel" {{ $r_ }}></div>

        <div class="col-12">
            <label class="form-label">Roles * <span class="text-muted fw-normal">– select one or more; permissions are combined</span></label>
            @php($picked = collect(old('role_ids', $user->exists ? $user->roles->pluck('id')->all() : []))->map(fn ($v) => (int) $v)->all())
            <div class="d-flex flex-wrap gap-2">
                @foreach($roles as $r)
                    @php($isSelf = $user->exists && $user->id === auth()->id())
                    @php($isAdminRole = $r->slug === 'admin')
                    <div>
                        <input type="checkbox" class="btn-check" name="role_ids[]" value="{{ $r->id }}" id="role{{ $r->id }}" @checked(in_array($r->id, $picked) || ($isSelf && $isAdminRole)) @disabled($isSelf && (! auth()->user()->isRole('admin') || $isAdminRole))>
                        <label class="btn btn-outline-primary btn-sm" for="role{{ $r->id }}">{{ $r->name }}</label>
                    </div>
                @endforeach
            </div>
            @if($user->exists && $user->id === auth()->id())<div class="form-text">{{ auth()->user()->isRole('admin') ? 'You can change your other roles, but the System Administrator role cannot be removed from your own account.' : 'You cannot change your own roles.' }}</div>@endif
        </div>

        <div class="col-md-4"><label class="form-label">Department{{ $star }}</label>
            <select name="department_id" class="form-select" {{ $r_ }}><option value="">Select…</option>
                @foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('department_id', $user->department_id) == $d->id)>{{ $d->name }}</option>@endforeach
            </select></div>
        <div class="col-md-4"><label class="form-label">Designation{{ $star }}</label>
            <select name="designation_id" class="form-select" {{ $r_ }}><option value="">Select…</option>
                @foreach($designations as $d)<option value="{{ $d->id }}" @selected(old('designation_id', $user->designation_id) == $d->id)>{{ $d->name }}</option>@endforeach
            </select></div>
        <div class="col-md-4"><label class="form-label">Location{{ $star }}</label>
            <select name="location_id" class="form-select" {{ $r_ }}><option value="">Select…</option>
                @foreach($locations as $l)<option value="{{ $l->id }}" @selected(old('location_id', $user->location_id) == $l->id)>{{ $l->name }}</option>@endforeach
            </select></div>

        <div class="col-md-4"><label class="form-label">Password {{ $user->exists ? '(leave blank to keep)' : '*' }}</label>
            <input type="password" name="password" class="form-control" autocomplete="new-password" {{ $user->exists ? '' : 'required' }}></div>
        <div class="col-md-4"><label class="form-label">Confirm password{{ $star }}</label><input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" {{ $user->exists ? '' : 'required' }}></div>
        <div class="col-md-4 pt-4">
            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="act" @checked(old('is_active', $user->is_active))><label for="act" class="form-check-label">Active</label></div>
            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="is_department_head" value="1" id="head" @checked(old('is_department_head', $user->is_department_head))><label for="head" class="form-check-label">Department head</label></div>
            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="show_in_attendance" value="1" id="att" @checked(old('show_in_attendance', $user->show_in_attendance))><label for="att" class="form-check-label">Show on IT attendance</label></div>
            @if($user->exists)<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="unlock" value="1" id="unl"><label for="unl" class="form-check-label">Unlock account</label></div>@endif
        </div>
    </div>
    </div>

@can('role.update')
@if($user->exists && ! $user->isRole('admin') && $user->id !== auth()->id())
@php($fromRoles = $user->rolePermissions())
<div class="card mt-3">
    <div class="card-header">
        <div class="fw-semibold">Individual permissions</div>
        <div class="text-muted fw-normal small">On top of the roles above, for this user only. Most users need no changes here.</div>
    </div>
    <div class="card-body">
        <input type="hidden" name="perm_form" value="1">
        <div class="perm-legend">
            <span><i style="background:var(--border)"></i><b>Inherit</b> – follow the roles</span>
            <span><i style="background:#16a34a"></i><b>Allow</b> – add this permission</span>
            <span><i style="background:#dc2626"></i><b>Deny</b> – remove it, even if a role grants it</span>
            <span><span class="pill pill-primary">role</span> – already granted by the saved roles</span>
        </div>
        <div class="perm-toolbar">
            <div class="input-icon"><x-icon name="search" :size="15"/><input type="search" id="userPermSearch" class="form-control form-control-sm" placeholder="Find a permission…"></div>
            <div class="form-check form-switch mb-0"><input class="form-check-input" type="checkbox" id="permOnlyChanged"><label class="form-check-label small" for="permOnlyChanged">Show only changes</label></div>
            <span class="pill pill-warning ms-auto" id="permOverrides">0 overrides</span>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="permReset">Reset all to Inherit</button>
        </div>
        <div class="row g-3">
        @foreach(config('itsm.permission_catalog') as $group => $items)
            <div class="col-md-6 col-xl-4 perm-col">
                <div class="perm-group">
                    <div class="perm-group-h"><span>{{ $group }}</span><span class="gcount"></span></div>
                    @foreach($items as $key => $label)
                        @continue(! auth()->user()->isRole('admin') && in_array($key, config('itsm.privileged_permissions', []), true))
                        @php($oldPerm = old('perm'))
                        @php($cur = is_array($oldPerm) ? ($oldPerm[$key] ?? '') : $user->permissionOverride($key))
                        @php($ik = md5($key))
                        <div class="perm-row {{ $cur === 'allow' ? 'is-allow' : ($cur === 'deny' ? 'is-deny' : '') }}" data-text="{{ strtolower($label.' '.$key) }}">
                            <span class="small">{{ $label }}@if(in_array($key, $fromRoles))<span class="pill pill-primary ms-1" title="Granted by the user's saved roles">role</span>@endif</span>
                            <div class="btn-group btn-group-sm flex-shrink-0" role="group">
                                <input type="radio" class="btn-check" name="perm[{{ $key }}]" value="" id="pi{{ $ik }}" @checked($cur === '')><label class="btn btn-outline-secondary" for="pi{{ $ik }}">Inherit</label>
                                <input type="radio" class="btn-check" name="perm[{{ $key }}]" value="allow" id="pa{{ $ik }}" @checked($cur === 'allow')><label class="btn btn-outline-success" for="pa{{ $ik }}">Allow</label>
                                <input type="radio" class="btn-check" name="perm[{{ $key }}]" value="deny" id="pd{{ $ik }}" @checked($cur === 'deny')><label class="btn btn-outline-danger" for="pd{{ $ik }}">Deny</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        </div>
        <div class="text-muted small text-center py-3 d-none" id="permNone">No permission matches.</div>
    </div>
</div>
@push('scripts')
<script>
(function () {
    var search = document.getElementById('userPermSearch'), only = document.getElementById('permOnlyChanged');
    function rows() { return document.querySelectorAll('.perm-row'); }
    function refresh() {
        var q = search.value.trim().toLowerCase(), total = 0, visible = 0;
        rows().forEach(function (r) {
            var v = r.querySelector('input[type=radio]:checked').value;
            r.classList.toggle('is-allow', v === 'allow'); r.classList.toggle('is-deny', v === 'deny');
            if (v) total++;
            var show = r.dataset.text.indexOf(q) > -1 && (!only.checked || v);
            r.style.display = show ? '' : 'none'; if (show) visible++;
        });
        document.querySelectorAll('.perm-col').forEach(function (c) {
            var rs = c.querySelectorAll('.perm-row'), changed = 0, shown = 0;
            rs.forEach(function (r) { if (r.querySelector('input[type=radio]:checked').value) changed++; if (r.style.display !== 'none') shown++; });
            c.querySelector('.gcount').textContent = changed ? changed + ' changed' : '';
            c.style.display = shown ? '' : 'none';
        });
        document.getElementById('permOverrides').textContent = total + (total === 1 ? ' override' : ' overrides');
        document.getElementById('permNone').classList.toggle('d-none', visible > 0);
    }
    document.getElementById('permReset').addEventListener('click', function () { document.querySelectorAll('input[name^="perm["][value=""]').forEach(function (r) { r.checked = true; }); refresh(); });
    document.querySelectorAll('input[name^="perm["]').forEach(function (r) { r.addEventListener('change', refresh); });
    search.addEventListener('input', refresh); only.addEventListener('change', refresh);
    refresh();
})();
</script>
@endpush
@endif
@endcan
    <div class="card-body pt-0"><div class="mt-2"><button class="btn btn-primary">Save</button> <a href="{{ $user->exists ? route('admin.users.show', $user) : route('admin.users.index') }}" class="btn btn-link">Cancel</a></div></div>
</form>
@endsection
