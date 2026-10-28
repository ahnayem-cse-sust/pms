@extends('layouts.app')
@section('title', 'Asset Types & Categories')
@section('content')
@include('inventory._errors')
@php
    $names = ['types' => ['Asset types', 'asset type', 'folder'], 'categories' => ['Categories', 'category', 'list'], 'subcategories' => ['Sub categories', 'sub category', 'list']];
    $parentLabel = ['categories' => 'Asset type', 'subcategories' => 'Category'][$kind] ?? '';
    $cols = 3;
@endphp
<div class="inv-tabs">@foreach($names as $k => $n)<a class="inv-tab {{ $kind === $k ? 'active' : '' }}" href="{{ route('inv.setup', $k) }}"><x-icon :name="$n[2]" :size="15"/> {{ $n[0] }}@if($kind === $k)<span class="n">{{ $rows->count() }}</span>@endif</a>@endforeach</div>
<div class="inv-flow">Equipment is classified as <b>Asset type</b><span class="sep">›</span><b>Category</b><span class="sep">›</span><b>Sub category</b> <span>e.g. Computing › Laptop › Business laptop. Create them in that order.</span></div>

@can('inv.update')
<form method="POST" action="{{ $edit ? route('inv.setup.update', [$kind, $edit->id]) : route('inv.setup.store', $kind) }}" class="card mb-3"><div class="card-body">@csrf @if($edit) @method('PUT') @endif
    <div class="row g-2 align-items-end">
    @if($level > 1)<div class="col-md-4"><label class="form-label">{{ $parentLabel }} *</label><select name="parent_id" class="form-select" required><option value="">Select…</option>
        @foreach($parents as $p)<option value="{{ $p->id }}" @selected(old('parent_id', $edit?->parent_id) == $p->id)>{{ $level === 3 ? ($p->parent->name ?? '').' › ' : '' }}{{ $p->name }}</option>@endforeach</select></div>@endif
    <div class="col-md-4"><label class="form-label">{{ $edit ? 'Edit' : 'Add' }} {{ $names[$kind][1] }} *</label><input name="name" value="{{ old('name', $edit?->name) }}" class="form-control" required></div>
    @if($level === 2)<div class="col-md-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="is_serialized" value="1" id="sr" @checked(old('is_serialized', $edit?->is_serialized))><label class="form-check-label" for="sr">Serialisable <span class="text-muted small">(each unit has an Asset ID)</span></label></div></div>@endif
    @if($edit)<div class="col-md-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="is_active" value="1" id="a" @checked(old('is_active', $edit->is_active))><label class="form-check-label" for="a">Active</label></div></div>@endif
    <div class="col-md-3 d-flex gap-2"><button class="btn btn-primary">{{ $edit ? 'Save changes' : '+ Add' }}</button>@if($edit)<a href="{{ route('inv.setup', $kind) }}" class="btn btn-outline-secondary">Cancel</a>@endif</div></div></div></form>
@endcan

<div class="table-card"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Name</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($rows as $r)
<tr class="{{ $edit && $edit->id === $r->id ? 'row-edit' : '' }}"><td><div class="inv-name">{{ $r->name }}</div>@if($level > 1)<div class="inv-sub">{{ $level === 3 ? ($r->parent->parent->name ?? '').' › ' : '' }}{{ $r->parent->name ?? '' }}</div>@endif</td><td>{!! $r->is_active ? '<span class="pill pill-success">Active</span>' : '<span class="pill pill-secondary">Inactive</span>' !!}@if($level === 2 && $r->is_serialized) <span class="pill pill-info">Serialisable</span>@endif</td>
<td class="text-end">@can('inv.update')<a href="{{ route('inv.setup', [$kind, 'edit' => $r->id]) }}" class="btn btn-sm btn-outline-primary inv-actions-cell"><x-icon name="edit" :size="14"/> Edit</a>@endcan</td></tr>
@empty
<tr><td colspan="{{ $cols }}">@include('inventory._empty', ['icon' => 'folder', 'msg' => 'No '.strtolower($names[$kind][0]).' yet', 'hint' => $level === 1 ? 'Start with an asset type such as Computing or Networking.' : 'Add one using the form above.'])</td></tr>
@endforelse</tbody></table></div></div>
@endsection
