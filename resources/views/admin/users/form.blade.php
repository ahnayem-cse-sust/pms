@extends('layouts.app')
@section('title', $user->exists ? 'Edit user' : 'New user')
@section('content')
@php($req = ! $user->exists)
@php($star = $req ? ' *' : '')
@php($r_ = $req ? 'required' : '')
<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="card">
    @csrf
    @if($user->exists) @method('PUT') @endif
    <div class="card-header">{{ $user->exists ? 'Edit user' : 'New user' }}@if($req) <span class="text-muted fw-normal small">– all fields are mandatory</span>@endif</div>
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
                    <div>
                        <input type="checkbox" class="btn-check" name="role_ids[]" value="{{ $r->id }}" id="role{{ $r->id }}" @checked(in_array($r->id, $picked)) @disabled($user->id === auth()->id())>
                        <label class="btn btn-outline-primary btn-sm" for="role{{ $r->id }}">{{ $r->name }}</label>
                    </div>
                @endforeach
            </div>
            @if($user->exists && $user->id === auth()->id())<div class="form-text">You cannot change your own roles.</div>@endif
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
            @if($user->exists)<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="unlock" value="1" id="unl"><label for="unl" class="form-check-label">Unlock account</label></div>@endif
        </div>
    </div>
    <div class="mt-4"><button class="btn btn-primary">Save</button> <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancel</a></div>
    </div>
</form>
@endsection
