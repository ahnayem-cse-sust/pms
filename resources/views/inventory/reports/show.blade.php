@extends('layouts.app')
@section('title', $title)
@section('content')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
@foreach($filters as $f)
    @switch($f)
        @case('q')<div class="col-6 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control"></div>@break
        @case('category_id')<div class="col-6 col-md-2"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">All</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>@break
        @case('location_id')<div class="col-6 col-md-2"><label class="form-label">Location</label><select name="location_id" class="form-select"><option value="">All</option>@foreach($locations as $c)<option value="{{ $c->id }}" @selected(request('location_id') == $c->id)>{{ $c->path }}</option>@endforeach</select></div>@break
        @case('department_id')<div class="col-6 col-md-2"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">All</option>@foreach($departments as $c)<option value="{{ $c->id }}" @selected(request('department_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>@break
        @case('user_id')<div class="col-6 col-md-3"><label class="form-label">Employee</label><select name="user_id" class="form-select"><option value="">—</option>@foreach($people as $c)<option value="{{ $c->id }}" @selected(request('user_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>@break
        @case('item_id')<div class="col-6 col-md-3"><label class="form-label">Item</label><select name="item_id" class="form-select"><option value="">All</option>@foreach($items as $c)<option value="{{ $c->id }}" @selected(request('item_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>@break
        @case('status')<div class="col-6 col-md-2"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option>@foreach($statuses as $k => $l)<option value="{{ $k }}" @selected(request('status') == $k)>{{ $l }}</option>@endforeach</select></div>@break
        @case('stocktake_id')<div class="col-6 col-md-3"><label class="form-label">Stocktake</label><select name="stocktake_id" class="form-select"><option value="">All</option>@foreach($stocktakes as $c)<option value="{{ $c->id }}" @selected(request('stocktake_id') == $c->id)>{{ $c->ref }} {{ $c->title }}</option>@endforeach</select></div>@break
        @case('from')<div class="col-6 col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>@break
        @case('to')<div class="col-6 col-md-2"><label class="form-label">{{ $key === 'stock_balance' ? 'As at' : 'To' }}</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>@break
        @case('days')<div class="col-6 col-md-2"><label class="form-label">Within days</label><input type="number" min="1" name="days" value="{{ request('days') }}" class="form-control" placeholder="setting"></div>@break
    @endswitch
@endforeach
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Run</button><a href="{{ route('inv.reports', $key) }}" class="btn btn-outline-secondary">Reset</a>
        <a href="{{ route('inv.reports', [$key] + request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success ms-md-auto"><x-icon name="download" :size="14"/> Export CSV</a></div>
</div></div></form>
@if($note)<div class="alert alert-info py-2 small">{{ $note }}</div>@endif
<div class="table-responsive"><table class="table table-sm bg-white align-middle small"><thead class="table-light"><tr>@foreach($cols as $c)<th>{{ $c }}</th>@endforeach</tr></thead><tbody>
@forelse($rows as $r)<tr>@foreach($r as $v)<td>{{ $v }}</td>@endforeach</tr>@empty<tr><td colspan="{{ count($cols) }}" class="text-center text-muted py-4">No data for these filters.</td></tr>@endforelse</tbody></table></div>
<div class="text-muted small">{{ $total }} row(s){{ $total > count($rows) ? ' – showing the first '.count($rows).'; export for everything' : '' }}. Reports reflect posted transactions only.</div>
@endsection
