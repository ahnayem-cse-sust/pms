@extends('layouts.app')
@section('title', 'Permissions – '.$user->name)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> {{ $user->name }}</a>
</div>
<form method="POST" action="{{ route('admin.users.permissions.update', $user) }}">
@csrf @method('PUT')
@php($fromRoles = $user->rolePermissions())
<div class="card">
    <div class="card-header">
        <div class="fw-semibold">Individual permissions</div>
        <div class="text-muted fw-normal small">On top of the user's roles, for this user only. Most users need no changes here.</div>
    </div>
    <div class="card-body">
        <input type="hidden" name="perm_form" value="1">
        <div class="perm-legend">
            <span><i style="background:var(--border)"></i><b>Inherit</b> – follow the roles</span>
            <span><i style="background:#16a34a"></i><b>Allow</b> – add this permission</span>
            <span><i style="background:#dc2626"></i><b>Deny</b> – remove it, even if a role grants it</span>
            <span><b>Inherit</b> shows what the saved roles give: <b class="text-success">Allowed</b> or <b class="text-danger">Denied</b></span>
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
                            <span class="small">{{ $label }}</span>
                            <div class="btn-group btn-group-sm flex-shrink-0" role="group">
                                <input type="radio" class="btn-check" name="perm[{{ $key }}]" value="" id="pi{{ $ik }}" @checked($cur === '')><label class="btn {{ in_array($key, $fromRoles) ? 'btn-inh-allow' : 'btn-inh-deny' }}" for="pi{{ $ik }}" title="The user's saved roles {{ in_array($key, $fromRoles) ? 'grant' : 'do not grant' }} this permission">Inherit · {{ in_array($key, $fromRoles) ? 'Allowed' : 'Denied' }}</label>
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
<div class="mt-3"><button class="btn btn-primary">Save permissions</button> <a href="{{ route('admin.users.show', $user) }}" class="btn btn-link">Cancel</a></div>
</form>
@endsection
