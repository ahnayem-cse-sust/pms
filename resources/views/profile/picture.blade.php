@extends('layouts.app')
@section('title', 'Profile Picture')
@section('content')
<div class="row justify-content-center"><div class="col-xl-5 col-lg-6 col-md-8">
    <div class="card">
        <div class="card-body text-center pt-4">
            <div class="pic-preview" id="picPreview">
                <x-avatar :name="$user->name" :user="$user" class="pic-xl"/>
            </div>
            <div class="fw-semibold mt-3">{{ $user->name }}</div>
            <div class="small text-muted">{{ $user->email }}@if($user->department) · {{ $user->department->name }}@endif</div>
        </div>
        <div class="card-body border-top">
            <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data">
                @csrf
                <label class="form-label">{{ $user->avatar_path ? 'Choose a new picture' : 'Choose a picture' }}</label>
                <input type="file" name="photo" id="picFile" accept="image/jpeg,image/png,image/webp" class="form-control @error('photo') is-invalid @enderror" required>
                @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                <div class="form-text mb-3">JPG, PNG or WEBP, up to 8 MB. A square picture looks best.</div>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-primary">{{ $user->avatar_path ? 'Save new picture' : 'Upload picture' }}</button>
                    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" class="btn btn-link">Cancel</a>
                </div>
            </form>
            @if($user->avatar_path)
                <form method="POST" action="{{ route('profile.photo.remove') }}" class="mt-3 pt-3 border-top" onsubmit="return confirm('Remove your profile picture?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Remove current picture</button>
                </form>
            @endif
        </div>
    </div>
    <div class="text-center mt-3"><a href="{{ route('profile.password') }}" class="small text-decoration-none">Change password instead →</a></div>
</div></div>
@endsection

@push('scripts')
<script>
// Show the chosen picture before saving
(function () {
    var f = document.getElementById('picFile'), box = document.getElementById('picPreview');
    if (!f || !box) return;
    f.addEventListener('change', function () {
        var file = f.files && f.files[0];
        if (!file || !/^image\//.test(file.type)) return;
        var img = document.createElement('img');
        img.className = 'avatar pic-xl avatar-img'; img.alt = 'Preview';
        img.src = URL.createObjectURL(file);
        box.innerHTML = ''; box.appendChild(img);
    });
})();
</script>
@endpush
