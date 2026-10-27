@extends('layouts.app')
@section('title', 'Records')
@section('content')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Record, entry, reference, supplier, person"></div>
    <div class="col-6 col-md-2"><label class="form-label">Type</label><select name="type" class="form-select"><option value="">All</option>@foreach(config('inventory.movement_types') as $k => $l)<option value="{{ $k }}" @selected(request('type') == $k)>{{ $l }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">Equipment</label><select name="equipment_id" class="form-select"><option value="">All</option>@foreach($equipment as $p)<option value="{{ $p->id }}" @selected(request('equipment_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Filter</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a><a href="{{ route('inv.records', request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-success">CSV</a></div>
</div></div></form>
<div class="table-responsive"><table class="table table-sm bg-white align-middle small"><thead class="table-light"><tr><th>Record</th><th>Entry</th><th>Date</th><th>Type</th><th>Equipment</th><th class="text-end">Qty</th><th class="text-end">Balance</th><th>Person / dept</th><th>Reference / supplier</th><th>By</th><th></th></tr></thead><tbody>
@forelse($rows as $m)<tr><td>{{ $m->ref }}</td><td>{{ $m->entry_no }}</td><td class="text-nowrap">{{ $m->moved_on->format('d M Y') }}</td><td>{{ \App\Support\Inv::pill($m->type) }}</td>
<td>{{ $m->equipment->name }}@if($m->serial_no) <span class="text-muted">S/N {{ $m->serial_no }}</span>@endif<div class="text-muted">{{ $m->equipment->classification }}</div></td>
<td class="text-end">{{ $m->qty > 0 ? '+' : '' }}{{ \App\Support\Inv::qty($m->qty) }}</td><td class="text-end">{{ \App\Support\Inv::qty($m->balance_after) }}</td><td>{{ $m->holder_name }}</td>
<td>{{ $m->reference_no }} {{ $m->party }}@if($m->remarks)<div class="text-muted">{{ $m->remarks }}</div>@endif</td><td>{{ $m->user->name ?? '' }}</td>
<td class="text-nowrap"><a href="{{ route('inv.records.show', $m) }}">View</a> @if($m->type === 'ALLOCATE')<a href="{{ route('inv.allocations.pdf', $m->entry_no) }}">PDF</a>@elseif(in_array($m->type, ['RECEIVE', 'OPENING', 'RETURN']))<a href="{{ route('inv.receives.pdf', $m->entry_no) }}">PDF</a>@endif</td></tr>
@empty<tr><td colspan="11" class="text-center text-muted py-4">No records.</td></tr>@endforelse</tbody></table></div>
{{ $rows->links() }}
@endsection
