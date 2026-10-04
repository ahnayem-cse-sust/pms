@extends('layouts.app')
@section('title', $user->exists ? 'Edit user' : 'New user')
@section('content')
<h4 class="mb-3">{{ $user->exists ? 'Edit user' : 'New user' }}</h4>
<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="card card-body">
    @csrf
    @if($user->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Full name *</label><input name="name" value="{{ old('name', $user->name) }}" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Email *</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Employee ID</label><input name="employee_id" value="{{ old('employee_id', $user->employee_id) }}" class="form-control"></div>
        <div class="col-md-2"><label class="form-label">Phone</label><input name="phone" value="{{ old('phone', $user->phone) }}" class="form-control"></div>

        <div class="col-md-3"><label class="form-label">Role *</label>
            <select name="role_id" class="form-select" required>
                @foreach($roles as $r)<option value="{{ $r->id }}" @selected(old('role_id', $user->role_id) == $r->id)>{{ $r->name }}</option>@endforeach
            </select></div>
        <div class="col-md-3"><label class="form-label">Department</label>
            <select name="department_id" class="form-select"><option value="">—</option>
                @foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('department_id', $user->department_id) == $d->id)>{{ $d->name }}</option>@endforeach
            </select></div>
        <div class="col-md-3"><label class="form-label">Designation</label>
            <select name="designation_id" class="form-select"><option value="">—</option>
                @foreach($designations as $d)<option value="{{ $d->id }}" @selected(old('designation_id', $user->designation_id) == $d->id)>{{ $d->name }}</option>@endforeach
            </select></div>
        <div class="col-md-3"><label class="form-label">Location</label>
            <select name="location_id" class="form-select"><option value="">—</option>
                @foreach($locations as $l)<option value="{{ $l->id }}" @selected(old('location_id', $user->location_id) == $l->id)>{{ $l->name }}</option>@endforeach
            </select></div>

        <div class="col-md-3"><label class="form-label">Password {{ $user->exists ? '(leave blank to keep)' : '*' }}</label>
            <input type="password" name="password" class="form-control" autocomplete="new-password" {{ $user->exists ? '' : 'required' }}></div>
        <div class="col-md-3"><label class="form-label">Confirm password</label><input type="password" name="password_confirmation" class="form-control" autocomplete="new-password"></div>
        <div class="col-md-6 pt-4">
            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="act" @checked(old('is_active', $user->is_active))><label for="act" class="form-check-label">Active</label></div>
            <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="is_department_head" value="1" id="head" @checked(old('is_department_head', $user->is_department_head))><label for="head" class="form-check-label">Department head</label></div>
            @if($user->exists)<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="unlock" value="1" id="unl"><label for="unl" class="form-check-label">Unlock account</label></div>@endif
        </div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">Save</button> <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancel</a></div>
</form>
@endsection
