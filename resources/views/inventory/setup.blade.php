@extends('layouts.app')
@section('title', 'Asset Types & Categories')
@section('content')
@include('inventory._errors')
@php($names = ['types' => ['Asset types', 'asset type'], 'categories' => ['Categories', 'category'], 'subcategories' => ['Sub categories', 'sub category']])
@php($parentLabel = ['categories' => 'Asset type', 'subcategories' => 'Category'][$kind] ?? '')
<ul class="nav nav-pills mb-2 gap-1">@foreach($names as $k => $n)<li class="nav-item"><a class="nav-link {{ $kind === $k ? 'active' : '' }}" href="{{ route('inv.setup', $k) }}">{{ $n[0] }}</a></li>@endforeach</ul>
<div class="text-muted small mb-3">Equipment is classified as <b>Asset type › Category › Sub category</b>, e.g. Computing › Laptop › Business laptop. Create them in that order.</div>
@can('inv.update')
<form method="POST" action="{{ $edit ? route('inv.setup.update', [$kind, $edit->id]) : route('inv.setup.store', $kind) }}" class="card mb-3"><div class="card-body">@csrf @if($edit) @method('PUT') @endif
    <div class="row g-2 align-items-end">
    @if($level > 1)<div class="col-md-4"><label class="form-label">{{ $parentLabel }} *</label><select name="parent_id" class="form-select" required><option value="">Select…</option>
        @foreach($parents as $p)<option value="{{ $p->id }}" @selected(old('parent_id', $edit?->parent_id) == $p->id)>{{ $level === 3 ? ($p->parent->name ?? '').' › ' : '' }}{{ $p->name }}</option>@endforeach</select></div>@endif
    <div class="col-md-4"><label class="form-label">{{ $edit ? 'Edit' : 'Add' }} {{ $names[$kind][1] }} *</label><input name="name" value="{{ old('name', $edit?->name) }}" class="form-control" required></div>
    @if($level === 2)<div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_serialized" value="1" id="sr" @checked(old('is_serialized', $edit?->is_serialized))><label class="form-check-label" for="sr">Serialisable <span class="text-muted small">(each unit has a serial number)</span></label></div></div>@endif
    @if($edit)<div class="col-md-2"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="a" @checked(old('is_active', $edit->is_active))><label class="form-check-label" for="a">Active</label></div></div>@endif
    <div class="col-md-3"><button class="btn btn-primary">Save</button> @if($edit)<a href="{{ route('inv.setup', $kind) }}" class="btn btn-link">Cancel</a>@endif</div></div></div></form>
@endcan
<table class="table table-sm bg-white"><thead class="table-light"><tr>@if($level === 3)<th>Asset type</th>@endif @if($level > 1)<th>{{ $parentLabel }}</th>@endif<th>Name</th>@if($level === 2)<th>Serial number</th>@endif<th>Status</th><th></th></tr></thead><tbody>
@forelse($rows as $r)<tr>@if($level === 3)<td>{{ $r->parent->parent->name ?? '' }}</td>@endif @if($level > 1)<td>{{ $r->parent->name ?? '' }}</td>@endif<td>{{ $r->name }}</td>@if($level === 2)<td>{!! $r->is_serialized ? '<span class="pill pill-info">Serialisable</span>' : '<span class="text-muted">No</span>' !!}</td>@endif<td>{!! $r->is_active ? '<span class="pill pill-success">Active</span>' : '<span class="pill pill-secondary">Inactive</span>' !!}</td>
<td class="text-end">@can('inv.update')<a href="{{ route('inv.setup', [$kind, 'edit' => $r->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>@endcan</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-3">None yet.</td></tr>@endforelse</tbody></table>
@endsection
