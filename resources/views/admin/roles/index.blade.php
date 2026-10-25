@extends('layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2 gap-2 flex-wrap">
    <div class="text-muted small">Create roles and choose what each one can do. A user can hold several roles, and individual permissions can be added or removed on the user's own page. </div>
    <div class="d-flex gap-2 align-items-center">
        <input type="search" id="roleFilter" class="form-control form-control-sm" placeholder="Filter roles…" style="width:180px">
        @can('role.create')<a href="{{ route('admin.roles.create') }}" class="btn btn-success text-nowrap">+ New role</a>@endcan
    </div>
</div>
@if($errors->any())<div class="alert alert-danger py-2">{{ $errors->first() }}</div>@endif
<div class="card">
<table class="table align-middle mb-0" id="roleTable">
    <thead class="table-light"><tr><th>Role</th><th>Type</th><th class="text-end">Users</th><th></th></tr></thead>
    <tbody>
    @foreach($roles as $role)
        @php($builtIn = array_key_exists($role->slug, config('itsm.roles')))
        @php($perms = $role->permissions ?? [])
        <tr data-name="{{ strtolower($role->name.' '.$role->slug) }}">
            <td><b>{{ $role->name }}</b><div class="text-muted small">{{ $role->slug }} · {{ count($perms) }} permissions</div></td>
            <td>@if($role->slug === 'admin')<span class="pill pill-primary">Built-in · fixed</span>@elseif($builtIn)<span class="pill">Built-in</span>@else<span class="pill pill-success">Custom</span>@endif</td>
            <td class="text-end">@if($role->users_count && auth()->user()->can('user.view'))<a href="{{ route('admin.users.index', ['role_id' => $role->id]) }}" title="Show users with this role">{{ $role->users_count }}</a>@else {{ $role->users_count }} @endif</td>
            <td class="text-end text-nowrap">
                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">{{ ($role->slug === 'admin' || ! auth()->user()->can('role.update')) ? 'View' : 'Edit' }}</a>
                @can('role.create')<a href="{{ route('admin.roles.create', ['from' => $role->id]) }}" class="btn btn-sm btn-outline-secondary" title="Create a new role starting from this one">Duplicate</a>@endcan
                @if(! $builtIn && auth()->user()->can('role.delete'))
                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-inline" onsubmit="return confirm('Delete the role {{ addslashes($role->name) }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" @disabled($role->users_count) title="{{ $role->users_count ? 'Remove this role from its users first' : 'Delete role' }}">Delete</button>
                </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@push('scripts')
<script>
document.getElementById('roleFilter').addEventListener('input', function () {
    var q = this.value.trim().toLowerCase();
    document.querySelectorAll('#roleTable tbody tr').forEach(function (tr) { tr.style.display = tr.dataset.name.indexOf(q) > -1 ? '' : 'none'; });
});
</script>
@endpush
@endsection
