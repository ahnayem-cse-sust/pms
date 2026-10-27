@extends('layouts.app')
@section('title', 'Maintenance & Repair')
@section('content')
@include('inventory._errors')
@can('inv.maint.create')
<form method="POST" action="{{ route('inv.maintenance.store') }}" class="card mb-3"><div class="card-body">@csrf
    <div class="fw-semibold mb-2">Log a maintenance / repair request</div>
    <div class="row g-2">
        <div class="col-md-4"><select name="asset_id" class="form-select form-select-sm" required><option value="">Asset…</option>@foreach($assets as $a)<option value="{{ $a->id }}" @selected(old('asset_id', $pre) == $a->id)>{{ $a->asset_code }} · {{ $a->item->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><input type="date" name="reported_date" value="{{ today()->format('Y-m-d') }}" class="form-control form-control-sm" required></div>
        <div class="col-md-3"><input name="ticket_no" class="form-control form-control-sm" placeholder="Related request no. (optional)"></div>
        <div class="col-md-3"><input name="vendor" class="form-control form-control-sm" placeholder="Service provider (optional)"></div>
        <div class="col-md-9"><input name="fault" class="form-control form-control-sm" placeholder="Reported issue *" required></div>
        <div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="warranty_claim" value="1" id="wc"><label class="form-check-label" for="wc">Warranty claim</label></div></div>
    </div><button class="btn btn-primary btn-sm mt-2">Log</button>
</div></form>
@endcan
<form class="row g-2 mb-2" method="GET"><div class="col-md-3"><input name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Reference, asset, vendor"></div>
<div class="col-md-3"><select name="status" class="form-select form-select-sm"><option value="">All statuses</option>@foreach(config('inventory.maintenance_statuses') as $k => $l)<option value="{{ $k }}" @selected(request('status') == $k)>{{ $l }}</option>@endforeach</select></div>
<div class="col-md-2"><div class="form-check mt-1"><input type="checkbox" class="form-check-input" name="open" value="1" id="op" @checked(request('open'))><label for="op" class="form-check-label">Open only</label></div></div><div class="col-md-2"><button class="btn btn-sm btn-outline-secondary">Filter</button></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Reference</th><th>Asset</th><th>Fault</th><th>Reported</th><th>Vendor</th><th>Status</th></tr></thead><tbody>
@forelse($rows as $m)<tr><td><a href="{{ route('inv.maintenance.show', $m) }}">{{ $m->ref }}</a></td><td>{{ $m->asset->asset_code }} · {{ $m->asset->item->name }}</td><td>{{ \Illuminate\Support\Str::limit($m->fault, 70) }}</td><td>{{ $m->reported_date->format('d M Y') }}</td><td>{{ $m->vendor }}</td><td>{{ \App\Support\Inv::pill($m->status) }}</td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-3">None.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}
@endsection
