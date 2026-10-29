@extends('layouts.app')
@section('title', 'Users')
@section('content')
<form class="card filter-card mb-3" method="GET">
    <div class="filter-body">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <label class="form-label">Search</label>
                <div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, email, employee ID"></div>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label">Role</label>
                <select name="role_id" class="form-select"><option value="">All roles</option>
                    @foreach($roles as $r)<option value="{{ $r->id }}" @selected(request('role_id') == $r->id)>{{ $r->name }}</option>@endforeach</select>
            </div>
            <div class="col-12 col-md filter-btns">
                <button class="btn btn-primary"><x-icon name="search" :size="15"/> Search</button>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
                @can('user.create')<a href="{{ route('admin.users.create') }}" class="btn btn-success ms-md-auto">+ New user</a>@endcan
            </div>
        </div>
    </div>
</form>
<table class="table table-sm bg-white align-middle">
    <thead class="table-light"><tr><th>Name</th><th>Employee ID</th><th>Email</th><th>Department</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @foreach($users as $u)
        <tr class="row-link" data-href="{{ route('admin.users.show', $u) }}">
            <td><a href="{{ route('admin.users.show', $u) }}" class="ticket-link">{{ $u->name }}</a>@if($u->is_department_head) <span class="badge text-bg-info">Head</span>@endif</td>
            <td>{{ $u->employee_id }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->department?->name }}</td>
            <td>
                @if(! $u->is_active)<span class="badge text-bg-secondary">Disabled</span>
                @elseif($u->locked_until && $u->locked_until->isFuture())<span class="badge text-bg-danger">Locked</span>
                @else<span class="badge text-bg-success">Active</span>@endif
            </td>
            <td class="text-end"><a href="{{ route('admin.users.show', $u) }}" class="btn btn-sm btn-outline-primary"><x-icon name="eye" :size="14"/> View</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $users->links() }}
@include('inventory._rowlink')
@endsection
