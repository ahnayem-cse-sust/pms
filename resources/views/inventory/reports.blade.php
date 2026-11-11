@extends('layouts.app')
@section('title', 'Inventory reports')
@section('content')
<div class="row g-3">
    <div class="col-md-6 col-xl-4"><a href="{{ route('inv.stock') }}" class="card h-100 text-decoration-none"><div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-2"><span class="type-ico ti-primary"><x-icon name="box" :size="18"/></span><h5 class="mb-0 text-body">Stock report</h5></div>
        <p class="text-muted mb-2">What is in the store now and what is out with employees and departments, with low and out-of-stock status.</p>
        <span class="small text-primary">View · PDF · CSV</span></div></a></div>
    <div class="col-md-6 col-xl-4"><a href="{{ route('inv.monthly') }}" class="card h-100 text-decoration-none"><div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-2"><span class="type-ico ti-primary"><x-icon name="clipboard" :size="18"/></span><h5 class="mb-0 text-body">Monthly report</h5></div>
        <p class="text-muted mb-2">Month-wise opening stock, received, returned, allocated and closing quantity of every equipment.</p>
        <span class="small text-primary">View · PDF · CSV</span></div></a></div>
    <div class="col-md-6 col-xl-4"><a href="{{ route('inv.allocation_report') }}" class="card h-100 text-decoration-none"><div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-2"><span class="type-ico ti-primary"><x-icon name="arrow-up-right" :size="18"/></span><h5 class="mb-0 text-body">Item wise Allocation report</h5></div>
        <p class="text-muted mb-2">For any date range: how much of each item was allocated and returned, and to whom. The PDF can list every allocation under each item.</p>
        <span class="small text-primary">View · PDF · CSV</span></div></a></div>
</div>
@endsection
