@extends('layouts.app')
@section('title', 'File Management')
@section('content')
<form class="card filter-card mb-3" method="GET">
    <div class="filter-body">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-5">
                <label class="form-label">Search</label>
                <div class="input-icon"><x-icon name="search" :size="15"/><input name="q" value="{{ request('q') }}" class="form-control" placeholder="File title, file number, shelf number, section"></div>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label">Section</label>
                <select name="section" class="form-select"><option value="">All sections</option>
                    @foreach($sections as $s)<option value="{{ $s }}" @selected(request('section') === $s)>{{ $s }}</option>@endforeach</select>
            </div>
            <div class="col-12 col-md filter-btns">
                <button class="btn btn-primary"><x-icon name="search" :size="15"/> Search</button>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
                <a href="{{ route('files.pdf', request()->only(['q', 'section'])) }}" class="btn btn-danger ms-md-auto"><x-icon name="download" :size="15"/> Download PDF</a>
                @can('file.create')<a href="{{ route('files.create') }}" class="btn btn-success">+ New file</a>@endcan
            </div>
        </div>
    </div>
</form>
<div class="inv-summary"><span>@if(request()->filled('q') || request()->filled('section'))Found @else Total @endif<strong class="text-body">{{ $files->total() }}</strong> {{ \Illuminate\Support\Str::plural('file', $files->total()) }}</span></div>
<table class="table table-sm bg-white align-middle">
    <thead class="table-light"><tr><th>File title</th><th>File number</th><th>Shelf no</th><th>Section</th><th></th></tr></thead>
    <tbody>
    @forelse($files as $f)
        <tr>
            <td>{{ $f->title }}</td>
            <td class="text-nowrap">{{ $f->file_no }}</td>
            <td class="text-nowrap">{{ $f->shelf_no }}</td>
            <td>{{ $f->section }}</td>
            <td class="text-end text-nowrap">
                @can('file.update')<a href="{{ route('files.edit', $f) }}" class="btn btn-sm btn-outline-primary"><x-icon name="edit" :size="14"/> Edit</a>@endcan
                @can('file.delete')<form method="POST" action="{{ route('files.destroy', $f) }}" class="d-inline" onsubmit="return confirm('Delete file {{ addslashes($f->file_no) }}? This cannot be undone.');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><x-icon name="trash" :size="14"/> Delete</button></form>@endcan
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted py-4">No files found.</td></tr>
    @endforelse
    </tbody>
</table>
{{ $files->links() }}
@endsection
