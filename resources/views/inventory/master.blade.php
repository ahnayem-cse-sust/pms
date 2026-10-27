@extends('layouts.app')
@section('title', 'Items & Reference Data')
@section('content')
@include('inventory._errors')
<ul class="nav nav-pills mb-3 gap-1 flex-wrap">
    @foreach($types as $k => $l)<li class="nav-item"><a class="nav-link {{ $type === $k ? 'active' : '' }}" href="{{ route('inv.master', $k) }}">{{ $l }}</a></li>@endforeach
</ul>
@php($canWrite = $edit ? auth()->user()->can('inv.master.update') : auth()->user()->can('inv.master.create'))
@if($canWrite)
<form method="POST" action="{{ $edit ? route('inv.master.update', [$type, $edit->id]) : route('inv.master.store', $type) }}" class="card mb-3"><div class="card-body">
    @csrf @if($edit) @method('PUT') @endif
    <div class="fw-semibold mb-2">{{ $edit ? 'Edit' : 'Add' }} – {{ $types[$type] }}</div>
    <div class="row g-2">
    @foreach($fields as $name => $f)
        @php($val = old($name, $edit?->{$name}))
        <div class="col-md-{{ ($f[1] ?? '') === 'textarea' ? 12 : 3 }}">
            @if($f[1] === 'checkbox')
                <div class="form-check mt-4"><input class="form-check-input" type="checkbox" name="{{ $name }}" value="1" id="f_{{ $name }}" @checked($val)><label class="form-check-label" for="f_{{ $name }}">{{ $f[0] }}</label></div>
            @else
                <label class="form-label">{{ $f[0] }}{{ ! empty($f[3]) ? '' : ' *' }}</label>
                @if($f[1] === 'select')
                    <select name="{{ $name }}" class="form-select form-select-sm" @required(empty($f[3]))><option value="">—</option>@foreach($f[2] as $k => $l)<option value="{{ $k }}" @selected((string) $val === (string) $k)>{{ $l }}</option>@endforeach</select>
                @elseif($f[1] === 'textarea')<textarea name="{{ $name }}" rows="2" class="form-control form-control-sm">{{ $val }}</textarea>
                @else<input type="{{ $f[1] === 'number' ? 'number' : 'text' }}" @if($f[1] === 'number') step="0.01" min="0" @endif name="{{ $name }}" value="{{ $val }}" class="form-control form-control-sm" @required(empty($f[3]))>@endif
            @endif
        </div>
    @endforeach
    @if($edit)<div class="col-md-3"><div class="form-check mt-4"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="f_act" @checked(old('is_active', $edit->is_active))><label class="form-check-label" for="f_act">Active (selectable for new records)</label></div></div>@endif
    </div>
    <div class="mt-3"><button class="btn btn-primary btn-sm">Save</button> @if($edit)<a href="{{ route('inv.master', $type) }}" class="btn btn-link btn-sm">Cancel</a>@endif</div>
</div></form>
@endif
<form class="mb-2" method="GET"><input name="q" value="{{ request('q') }}" class="form-control form-control-sm d-inline-block" style="width:240px" placeholder="Search name"> <button class="btn btn-sm btn-outline-secondary">Search</button></form>
<table class="table table-sm bg-white align-middle">
    <thead class="table-light"><tr>
        @if($type === 'items')<th>Code</th><th>Name</th><th>Type</th><th>Category</th><th>Unit</th><th>Min / reorder</th>
        @elseif($type === 'locations')<th>Code</th><th>Location</th><th>Store</th>
        @elseif($type === 'categories')<th>Name</th><th>Parent</th>
        @else<th>Name</th>@endif<th>Status</th><th></th></tr></thead>
    <tbody>
    @foreach($rows as $r)
        <tr>
        @if($type === 'items')<td>{{ $r->code }}</td><td>{{ $r->name }}<div class="text-muted small">{{ $r->brand->name ?? '' }} {{ $r->model }}</div></td><td>{{ config('inventory.item_types.'.$r->type) }}</td><td>{{ $r->category->name ?? '' }}{{ $r->subcategory ? ' › '.$r->subcategory->name : '' }}</td><td>{{ $r->unit->name ?? '' }}</td><td>{{ \App\Support\Inv::qty($r->min_stock) }} / {{ \App\Support\Inv::qty($r->reorder_level) }}</td>
        @elseif($type === 'locations')<td>{{ $r->code }}</td><td>{{ $r->path }}</td><td>{{ $r->is_store ? 'Yes' : '' }}</td>
        @elseif($type === 'categories')<td>{{ $r->name }}</td><td>{{ $r->parent->name ?? '—' }}</td>
        @else<td>{{ $r->name }}</td>@endif
        <td>{!! $r->is_active ? '<span class="pill pill-success">Active</span>' : '<span class="pill pill-secondary">Inactive</span>' !!}</td>
        <td class="text-end">@can('inv.master.update')<a href="{{ route('inv.master', [$type, 'edit' => $r->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>@endcan</td></tr>
    @endforeach
    </tbody>
</table>
{{ $rows->links() }}
@endsection
