@extends('layouts.app')
@section('title', 'Change Password')
@section('content')
<div class="row justify-content-center"><div class="col-xl-5 col-lg-6 col-md-8">
    <div class="card mb-3">
        <div class="card-body d-flex align-items-center gap-3">
            <x-avatar :name="$user->name" class="avatar-lg"/>
            <div class="lh-sm">
                <div class="fw-semibold">{{ $user->name }}</div>
                <div class="small text-muted">{{ $user->email }} · {{ $user->role_names }}@if($user->department) · {{ $user->department->name }}@endif</div>
                @if($user->password_changed_at)<div class="small text-muted">Password last changed {{ $user->password_changed_at->diffForHumans() }}</div>@endif
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('profile.password.update') }}" class="card">
        @csrf @method('PUT')
        <div class="card-header">Change your password</div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Current password *</label>
                <input type="password" name="current_password" class="form-control" autocomplete="current-password" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">New password *</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirm new password *</label>
                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
            </div>
            <button class="btn btn-primary">Update password</button>
            <a href="{{ route('dashboard') }}" class="btn btn-link">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
