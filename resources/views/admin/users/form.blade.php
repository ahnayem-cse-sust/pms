@extends('layouts.app')
@section('title', $user->exists ? 'Edit user' : 'New user')
@section('content')
@php($req = ! $user->exists)
@php($r_ = $req ? 'required' : '')
@php($isSelf = $user->exists && $user->id === auth()->id())
@php($picked = collect(old('role_ids', $user->exists ? $user->roles->pluck('id')->all() : []))->map(fn ($v) => (int) $v)->all())
@php($rq = '<span class="req">*</span>')
@php($rqa = $req ? $rq : '')
<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="uf-wrap" autocomplete="off">
    @csrf
    @if($user->exists) @method('PUT') @endif

    @if($errors->any())
        <div class="alert alert-danger py-2 small mb-2">Please correct the highlighted fields and try again.</div>
    @endif

    <div class="card">
        @if($req)<div class="card-header small text-muted fw-normal">All fields are mandatory</div>@endif
        <table class="uf-table">
            <tr class="uf-band"><td colspan="4"><x-icon name="user" :size="13"/>Personal information</td></tr>
            <tr>
                <th>Full name {!! $rq !!}</th>
                <td><input name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</td>
                <th>Email {!! $rq !!}</th>
                <td><input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</td>
            </tr>
            <tr>
                <th>Employee ID {!! $rqa !!}</th>
                <td><input name="employee_id" value="{{ old('employee_id', $user->employee_id) }}" class="form-control @error('employee_id') is-invalid @enderror" {{ $r_ }}>@error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</td>
                <th>WhatsApp {!! $rqa !!}</th>
                <td><input name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="form-control @error('whatsapp') is-invalid @enderror" placeholder="+8801XXXXXXXXX" inputmode="tel" {{ $r_ }}>@error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror</td>
            </tr>

            <tr class="uf-band"><td colspan="4"><x-icon name="building" :size="13"/>Organisation</td></tr>
            <tr>
                <th>Department {!! $rqa !!}</th>
                <td><select name="department_id" class="form-select @error('department_id') is-invalid @enderror" {{ $r_ }}><option value="">Select…</option>
                    @foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('department_id', $user->department_id) == $d->id)>{{ $d->name }}</option>@endforeach
                </select>@error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</td>
                <th>Designation {!! $rqa !!}</th>
                <td><select name="designation_id" class="form-select @error('designation_id') is-invalid @enderror" {{ $r_ }}><option value="">Select…</option>
                    @foreach($designations as $d)<option value="{{ $d->id }}" @selected(old('designation_id', $user->designation_id) == $d->id)>{{ $d->name }}</option>@endforeach
                </select>@error('designation_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</td>
            </tr>
            <tr>
                <th>Station {!! $rqa !!}</th>
                <td><select name="location_id" class="form-select @error('location_id') is-invalid @enderror" {{ $r_ }}><option value="">Select…</option>
                    @foreach($locations as $l)<option value="{{ $l->id }}" @selected(old('location_id', $user->location_id) == $l->id)>{{ $l->name }}</option>@endforeach
                </select>@error('location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</td>
                <th>Department head</th>
                <td><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" role="switch" name="is_department_head" value="1" id="head" @checked(old('is_department_head', $user->is_department_head))><label for="head" class="form-check-label">Marked as head of the department</label></div></td>
            </tr>

            <tr class="uf-band"><td colspan="4"><x-icon name="shield" :size="13"/>Access<small>Permissions of all selected roles are combined</small></td></tr>
            <tr>
                <th>Roles {!! $rq !!}</th>
                <td colspan="3" class="span3">
                    <div class="uf-roles">
                        @foreach($roles as $r)
                            @php($isAdminRole = $r->slug === 'admin')
                            <div class="uf-role">
                                <input type="checkbox" name="role_ids[]" value="{{ $r->id }}" id="role{{ $r->id }}" @checked(in_array($r->id, $picked) || ($isSelf && $isAdminRole)) @disabled($isSelf && (! auth()->user()->isRole('admin') || $isAdminRole))>
                                <label for="role{{ $r->id }}">{{ $r->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('role_ids')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    @if($isSelf)<div class="form-text">{{ auth()->user()->isRole('admin') ? 'You can change your other roles, but the System Administrator role cannot be removed from your own account.' : 'You cannot change your own roles.' }}</div>@endif
                </td>
            </tr>
            <tr>
                <th>Account</th>
                <td colspan="3" class="span3"><div class="uf-checks">
                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="is_active" value="1" id="act" @checked(old('is_active', $user->is_active))><label for="act" class="form-check-label">Active</label></div>
                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="show_in_attendance" value="1" id="att" @checked(old('show_in_attendance', $user->show_in_attendance))><label for="att" class="form-check-label">Show on IT attendance</label></div>
                    @if($user->exists)<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="unlock" value="1" id="unl"><label for="unl" class="form-check-label">Unlock account</label></div>@endif
                </div></td>
            </tr>

            <tr class="uf-band"><td colspan="4"><x-icon name="lock" :size="13"/>Sign-in @if($user->exists)<small>Leave blank to keep the current password</small>@endif</td></tr>
            <tr>
                <th>Password {!! $rqa !!}</th>
                <td><div class="uf-pw"><input type="password" name="password" id="uf-pw" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" {{ $r_ }}>
                    <button type="button" class="uf-pw-toggle" data-target="uf-pw" aria-label="Show or hide password"><x-icon name="eye" :size="15"/></button></div>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</td>
                <th>Confirm {!! $rqa !!}</th>
                <td><div class="uf-pw"><input type="password" name="password_confirmation" id="uf-pw2" class="form-control" autocomplete="new-password" {{ $r_ }}>
                    <button type="button" class="uf-pw-toggle" data-target="uf-pw2" aria-label="Show or hide password"><x-icon name="eye" :size="15"/></button></div>
                    <div class="uf-pw-match" id="uf-match"></div></td>
            </tr>
        </table>
        <div class="uf-foot">
            @if($req)<span class="note"><span class="text-danger">*</span> required</span>@endif
            <a href="{{ $user->exists ? route('admin.users.show', $user) : route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button class="btn btn-primary"><x-icon name="check" :size="15"/> {{ $user->exists ? 'Save changes' : 'Create user' }}</button>
        </div>
    </div>
</form>
<script>
(function(){
    document.querySelectorAll('.uf-pw-toggle').forEach(function(b){
        b.addEventListener('click', function(){ var i=document.getElementById(b.dataset.target); i.type = i.type==='password' ? 'text' : 'password'; });
    });
    var p=document.getElementById('uf-pw'), c=document.getElementById('uf-pw2'), m=document.getElementById('uf-match');
    function chk(){ if(!c.value){ m.textContent=''; m.className='uf-pw-match'; return; }
        var ok = p.value===c.value; m.textContent = ok ? 'Passwords match' : 'Passwords do not match'; m.className='uf-pw-match '+(ok?'ok':'bad'); }
    p.addEventListener('input', chk); c.addEventListener('input', chk);
})();
</script>
@endsection
