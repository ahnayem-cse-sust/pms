@extends('layouts.app')
@section('title', 'Inventory')
@section('content')
@include('inventory._errors')
@php
    $map = ['Equipment items' => ['box', 'indigo'], 'Units in stock' => ['inbox', 'green'], 'Units allocated' => ['users', 'cyan'], 'Low or out of stock' => ['alert', 'red']];
    $attn = $out->count() + $low->count();
    $maxUnits = max(1, (float) $byType->max('units'));
@endphp

<div class="stat-grid mb-3">
    @foreach($stats as $label => $n)
        @php
            [$icon, $tone] = $map[$label] ?? ['list', 'indigo'];
        @endphp
        <div class="stat-card tone-{{ $tone }} {{ $tone === 'red' && $n ? 'alert-on' : '' }}">
            <div class="stat-icon"><x-icon :name="$icon" :size="20"/></div>
            <div><div class="stat-label">{{ $label }}</div><div class="stat-value inv-num">{{ \App\Support\Inv::qty($n) }}</div></div>
        </div>
    @endforeach
</div>

<div class="inv-quick mb-3">
    @can('inv.create')
        <a href="{{ route('inv.receive') }}" class="btn btn-success"><x-icon name="arrow-down-left" :size="15"/> Receive item</a>
        <a href="{{ route('inv.allocations.create') }}" class="btn btn-primary"><x-icon name="arrow-up-right" :size="15"/> Allocate equipment</a>
    @endcan
    <a href="{{ route('inv.allocations.index') }}" class="btn btn-outline-secondary"><x-icon name="users" :size="15"/> Who has what</a>
    <a href="{{ route('inv.records') }}" class="btn btn-outline-secondary"><x-icon name="clipboard" :size="15"/> All records</a>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header inv-card-head">Needs attention @if($attn)<span class="pill pill-{{ $out->isNotEmpty() ? 'danger' : 'warning' }}">{{ $attn }}</span>@endif
                @if($attn)<a href="{{ route('inv.equipment.index', ['low' => 1]) }}" class="ms-auto">View all</a>@endif</div>
            @foreach($out as $e)
                <a href="{{ route('inv.equipment.index', ['q' => $e->code]) }}" class="inv-attn">
                    <div class="min-w-0"><div class="inv-name text-truncate">{{ $e->name }}</div><div class="inv-sub"><span class="inv-code">{{ $e->code }}</span> {{ $e->assetType->name ?? '' }}</div></div>
                    <span class="pill pill-danger">Out of stock</span>
                </a>
            @endforeach
            @foreach($low as $e)
                <a href="{{ route('inv.equipment.index', ['q' => $e->code]) }}" class="inv-attn">
                    <div class="min-w-0"><div class="inv-name text-truncate">{{ $e->name }}</div><div class="inv-sub"><span class="inv-code">{{ $e->code }}</span> {{ $e->assetType->name ?? '' }}</div></div>
                    <div class="text-end"><span class="pill pill-warning">{{ \App\Support\Inv::qty($e->stock_qty) }} left (min {{ \App\Support\Inv::qty($e->min_stock) }})</span>@include('inventory._meter', ['e' => $e])</div>
                </a>
            @endforeach
            @if($attn === 0)
                <div class="inv-ok"><span class="type-ico"><x-icon name="check" :size="16"/></span><div>Everything is above its minimum level.</div></div>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header inv-card-head">Latest activity <a href="{{ route('inv.records') }}" class="ms-auto">All records</a></div>
            @forelse($recent as $m)
                <a href="{{ route('inv.records.show', $m) }}" class="inv-feed-item">
                    <span class="type-ico ti-{{ \App\Support\Inv::tone($m->type) }}"><x-icon :name="\App\Support\Inv::icon($m->type)" :size="15"/></span>
                    <div class="flex-grow-1 min-w-0">
                        <div class="text-truncate"><strong class="inv-num">{{ \App\Support\Inv::qty(abs($m->qty)) }} × {{ $m->equipment->name }}</strong></div>
                        <div class="inv-sub text-truncate">{{ \App\Support\Inv::label($m->type) }}@if($m->holder_name) · {{ $m->holder_name }}@endif @if($m->entry_no) · {{ $m->entry_no }}@endif</div>
                    </div>
                    <span class="text-muted small text-nowrap">{{ $m->moved_on->format('d M') }}</span>
                </a>
            @empty
                @include('inventory._empty', ['icon' => 'clipboard', 'msg' => 'Nothing recorded yet', 'hint' => 'Add equipment, then receive items.'])
            @endforelse
        </div>
    </div>
</div>

@if($byType->isNotEmpty())
<div class="card">
    <div class="card-header">Stock by asset type</div>
    <div class="py-2">
        @foreach($byType as $name => $t)
            <div class="inv-bar-row">
                <div class="text-truncate fw-semibold" title="{{ $name }}">{{ $name }}<span class="inv-sub"> · {{ $t['items'] }} {{ \Illuminate\Support\Str::plural('item', $t['items']) }}</span></div>
                <div class="inv-bar"><span style="width:{{ max($t['units'] > 0 ? 2 : 0, round($t['units'] / $maxUnits * 100)) }}%"></span></div>
                <div class="inv-num fw-semibold">{{ \App\Support\Inv::qty($t['units']) }}</div>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
