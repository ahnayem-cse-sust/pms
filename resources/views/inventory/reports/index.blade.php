@extends('layouts.app')
@section('title', 'Inventory Reports')
@section('content')
<div class="row g-3">
@foreach($reports as $k => $r)
    <div class="col-md-4"><a class="card h-100 text-decoration-none" href="{{ route('inv.reports', $k) }}"><div class="card-body"><div class="fw-semibold">{{ $r[0] }}</div><div class="small text-muted">Table view and CSV export (opens in Excel)</div></div></a></div>
@endforeach
@can('inv.audit.view')<div class="col-md-4"><a class="card h-100 text-decoration-none" href="{{ route('inv.audit') }}"><div class="card-body"><div class="fw-semibold">Transaction Audit Report</div><div class="small text-muted">Who did what and when</div></div></a></div>@endcan
</div>
@endsection
