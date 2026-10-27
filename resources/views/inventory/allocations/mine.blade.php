@extends('layouts.app')
@section('title', 'My Equipment')
@section('content')
@if($rows->isEmpty())
    <div class="card"><div class="card-body">@include('inventory._empty', ['icon' => 'box', 'msg' => 'Nothing is allocated to you or your department.', 'hint' => 'Equipment issued to you will be listed here.'])</div></div>
@else
    <div class="inv-summary"><span><strong class="text-body">{{ $rows->count() }}</strong> {{ \Illuminate\Support\Str::plural('item', $rows->count()) }} with you or your department</span></div>
    <div class="inv-cards">
    @foreach($rows as $x)
        <div class="inv-hold">
            <span class="type-ico"><x-icon name="box" :size="20"/></span>
            <div class="min-w-0">
                <div class="inv-name">{{ $x->equipment->name }}</div>
                <div class="inv-sub">{{ trim($x->equipment->brand.' '.$x->equipment->model) }}</div>
                <div class="mt-1">@include('inventory._crumb', ['e' => $x->equipment])</div>
                @if($x->serial_no)<div class="mt-1"><span class="inv-sn">Asset ID {{ $x->serial_no }}</span>@if($x->device_sn) <span class="inv-sn">· Serial {{ $x->device_sn }}</span>@endif</div>@endif
                <div class="inv-sub mt-2">Held by {{ $x->holder }}@if($x->since) · since {{ \Illuminate\Support\Carbon::parse($x->since)->format('d M Y') }}@endif</div>
            </div>
            <div class="inv-hold-qty"><div class="inv-q fs-5">{{ \App\Support\Inv::qty($x->held) }}</div><div class="inv-sub">{{ $x->equipment->unit }}</div></div>
        </div>
    @endforeach
    </div>
@endif
@endsection
