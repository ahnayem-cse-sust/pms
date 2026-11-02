@extends('layouts.app')
@section('title', $file->exists ? 'Edit file' : 'New file')
@section('content')
@if($errors->any())<div class="alert alert-danger py-2">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
<form method="POST" action="{{ $file->exists ? route('files.update', $file) : route('files.store') }}">@csrf @if($file->exists) @method('PUT') @endif
<div class="card inv-form-card">
    <div class="card-header">{{ $file->exists ? 'Edit file' : 'New file' }}</div>
    <div class="card-body"><div class="row g-3">
        <div class="col-md-8"><label class="form-label">File title *</label><input name="title" value="{{ old('title', $file->title) }}" class="form-control" maxlength="255" required></div>
        <div class="col-md-4"><label class="form-label">File number *</label><input name="file_no" value="{{ old('file_no', $file->file_no) }}" class="form-control" maxlength="50" required></div>
        <div class="col-md-4"><label class="form-label">Shelf no *</label><input name="shelf_no" value="{{ old('shelf_no', $file->shelf_no) }}" class="form-control" maxlength="50" required></div>
        <div class="col-md-8"><label class="form-label">Section *</label><input name="section" value="{{ old('section', $file->section) }}" class="form-control" maxlength="150" list="sections" autocomplete="off" required>
            <datalist id="sections">@foreach($sections as $s)<option value="{{ $s }}">@endforeach</datalist></div>
    </div></div>
    <div class="card-footer d-flex flex-wrap gap-2"><button class="btn btn-primary"><x-icon name="check" :size="15"/> Save</button><a href="{{ route('files.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
</div>
</form>
@endsection
