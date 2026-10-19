@extends('layouts.app')
@section('title', 'Users')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Users</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ New user</a>
</div>
@php($activeFilters = collect(request()->only(['q','role_id']))->filter(fn ($v) => $v !== null && $v !== '')->count())
<form class="card filter-card mb-3" method="GET">
    <div class="filter-head">
        <x-icon name="search" :size="18"/>
        <span>Search users</span>
        @if($activeFilters)<span class="filter-count">{{ $activeFilters }} active</span>@endif
    </div>
    <div class="filter-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Keyword</label>
                <div class="input-icon"><x-icon name="search" :size="16"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, email, employee ID"></div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Role</label>
                <select name="role_id" class="form-select"><option value="">All roles</option>
                    @foreach($roles as $r)<option value="{{ $r->id }}" @selected(request('role_id') == $r->id)>{{ $r->name }}</option>@endforeach</select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary d-inline-flex align-items-center gap-2"><x-icon name="search" :size="16"/> Search</button>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </div>
</form>
<table class="table table-sm bg-white align-middle">
    <thead class="table-light"><tr><th>Name</th><th>Employee ID</th><th>Email</th><th>Role</th><th>Department</th><th>Last login</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}@if($u->is_department_head) <span class="badge text-bg-info">Head</span>@endif</td>
            <td>{{ $u->employee_id }}</td>
            <td>{{ $u->email }}</td>
            <td>@foreach($u->roles as $ro)<span class="pill pill-primary me-1 mb-1">{{ $ro->name }}</span>@endforeach</td>
            <td>{{ $u->department?->name }}</td>
            <td>{{ $u->last_login_at?->format('d M Y H:i') }}</td>
            <td>
                @if(! $u->is_active)<span class="badge text-bg-secondary">Disabled</span>
                @elseif($u->locked_until && $u->locked_until->isFuture())<span class="badge text-bg-danger">Locked</span>
                @else<span class="badge text-bg-success">Active</span>@endif
            </td>
            <td><a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $users->links() }}
@endsection
