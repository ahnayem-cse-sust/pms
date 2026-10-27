@extends('layouts.app')
@section('title', 'Goods Receipts')
@section('content')
<form class="card filter-card mb-3" method="GET"><div class="filter-body"><div class="row g-2 align-items-end">
    <div class="col-12 col-md-3"><label class="form-label">Search</label><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Receipt, PO, invoice"></div>
    <div class="col-6 col-md-2"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option>@foreach(['DRAFT', 'SUBMITTED', 'APPROVED', 'POSTED', 'REJECTED', 'CANCELLED'] as $s)<option @selected(request('status') == $s)>{{ $s }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">Supplier</label><select name="supplier_id" class="form-select"><option value="">All</option>@foreach($suppliers as $s)<option value="{{ $s->id }}" @selected(request('supplier_id') == $s->id)>{{ $s->name }}</option>@endforeach</select></div>
    <div class="col-6 col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-6 col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-12 col-md filter-btns"><button class="btn btn-primary">Search</button><a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>@can('inv.receipt.create')<a href="{{ route('inv.receipts.create') }}" class="btn btn-success ms-md-auto">+ New receipt</a>@endcan</div>
</div></div></form>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Receipt</th><th>Date</th><th>Supplier</th><th>PO / invoice</th><th>Location</th><th>Prepared by</th><th>Status</th></tr></thead><tbody>
@forelse($rows as $r)<tr><td><a href="{{ route('inv.receipts.show', $r) }}">{{ $r->ref }}</a></td><td>{{ $r->receipt_date->format('d M Y') }}</td><td>{{ $r->supplier->name ?? '' }}</td><td>{{ $r->procurement_ref }} {{ $r->invoice_no ? '/ '.$r->invoice_no : '' }}</td><td>{{ $r->location->name ?? '' }}</td><td>{{ $r->preparer->name ?? '' }}</td><td>{{ \App\Support\Inv::pill($r->status) }}</td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-4">No receipts.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}
@endsection
