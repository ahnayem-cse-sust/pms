@extends('layouts.app')
@section('title', $def['label'])
@section('content')
<h4 class="mb-3">{{ $def['label'] }}</h4>
@php
    $input = function ($name, $meta, $row = null, $formId = null) use ($selects) {
        $kind = $meta[0];
        $val = $row ? $row->{$name} : '';
        $attr = $formId ? ' form="'.$formId.'"' : '';
        if (str_starts_with($kind, 'select:')) {
            $opts = $selects[substr($kind, 7)];
            $h = '<select name="'.$name.'" class="form-select form-select-sm" required'.$attr.'>';
            foreach ($opts as $id => $label) {
                $h .= '<option value="'.$id.'"'.((string) $val === (string) $id ? ' selected' : '').'>'.e($label).'</option>';
            }
            return new \Illuminate\Support\HtmlString($h.'</select>');
        }
        return new \Illuminate\Support\HtmlString('<input type="'.$kind.'" name="'.$name.'" value="'.e($val).'" class="form-control form-control-sm" placeholder="'.e(str_replace('_', ' ', $name)).'"'.$attr.'>');
    };
@endphp

<ul class="nav nav-pills mb-3">
    @foreach($tabs as $key => $label)
        <li class="nav-item"><a class="nav-link {{ $key === $type ? 'active' : '' }}" href="{{ route('admin.lookups', $key) }}">{{ $label }}</a></li>
    @endforeach
</ul>

<div class="card mb-3"><div class="card-body">
    <form method="POST" action="{{ route('admin.lookups.store', $type) }}" class="row g-2 align-items-end">@csrf
        @foreach($def['fields'] as $name => $meta)
            <div class="col-md">{{ $input($name, $meta) }}</div>
        @endforeach
        <div class="col-auto"><button class="btn btn-primary btn-sm">Add</button></div>
    </form>
</div></div>

<table class="table table-sm bg-white align-middle">
    <thead class="table-light"><tr>@foreach($def['fields'] as $name => $meta)<th>{{ ucwords(str_replace('_', ' ', $name)) }}</th>@endforeach<th>Active</th><th></th></tr></thead>
    <tbody>
    @foreach($rows as $row)
        @php($fid = 'row'.$row->id)
        <tr>
            @foreach($def['fields'] as $name => $meta)
                <td>{{ $input($name, $meta, $row, $fid) }}</td>
            @endforeach
            <td><input type="checkbox" name="is_active" value="1" class="form-check-input" form="{{ $fid }}" @checked($row->is_active)></td>
            <td>
                <form id="{{ $fid }}" method="POST" action="{{ route('admin.lookups.update', [$type, $row->id]) }}">@csrf @method('PUT')
                    <button class="btn btn-sm btn-outline-primary">Save</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
