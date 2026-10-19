@extends('layouts.app')
@section('title', 'My Account')
@section('content')
<div class="row justify-content-center"><div class="col-xl-5 col-lg-6 col-md-8">
    <div class="card mb-3">
        <div class="card-body d-flex align-items-center gap-3">
            <x-avatar :name="$user->name" :user="$user" class="avatar-xl"/>
            <div class="lh-sm">
                <div class="fw-semibold">{{ $user->name }}</div>
                <div class="small text-muted">{{ $user->email }} · {{ $user->role_names }}@if($user->department) · {{ $user->department->name }}@endif</div>
                @if($user->password_changed_at)<div class="small text-muted">Password last changed {{ $user->password_changed_at->diffForHumans() }}</div>@endif
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Profile picture</div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="d-flex flex-wrap align-items-center gap-2">
                @csrf
                <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="form-control @error('photo') is-invalid @enderror" style="max-width:280px" required>
                <button class="btn btn-primary btn-sm">{{ $user->avatar_path ? 'Change picture' : 'Upload picture' }}</button>
                @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </form>
            <div class="form-text">JPG, PNG or WEBP, up to 2 MB. A square picture looks best.</div>
            @if($user->avatar_path)
                <form method="POST" action="{{ route('profile.photo.remove') }}" class="mt-2" onsubmit="return confirm('Remove your profile picture?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Remove picture</button>
                </form>
            @endif
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
