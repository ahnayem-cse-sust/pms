@extends('layouts.app')
@section('title', 'My Equipment')
@section('content')
@if($rows->isEmpty())
    <div class="card"><div class="card-body">@include('inventory._empty', ['icon' => 'box', 'msg' => 'Nothing is allocated to you or your department.', 'hint' => 'Equipment issued to you will be listed here.'])</div></div>
@else
    <div class="mine-bar">
        <div class="input-icon"><x-icon name="search" :size="15"/><input type="search" id="mineSearch" class="form-control" placeholder="Search by name, brand, model, asset ID or serial…"></div>
        <div class="mine-count"><strong class="text-body" id="mineShown">{{ $rows->count() }}</strong> of {{ $rows->count() }} {{ \Illuminate\Support\Str::plural('item', $rows->count()) }} with you or your department</div>
    </div>
    <div class="inv-cards" id="mineCards">
    @foreach($rows as $x)
        <div class="inv-hold mine" data-text="{{ strtolower(trim($x->equipment->name.' '.$x->equipment->brand.' '.$x->equipment->model.' '.$x->serial_no.' '.$x->device_sn.' '.$x->holder)) }}">
            <span class="type-ico"><x-icon name="box" :size="20"/></span>
            <div class="min-w-0 flex-grow-1">
                <div class="inv-name">{{ $x->equipment->name }}</div>
                <div class="inv-sub">{{ trim($x->equipment->brand.' '.$x->equipment->model) }}</div>
                <div class="mt-1">@include('inventory._crumb', ['e' => $x->equipment])</div>
                @if($x->serial_no)<div class="mt-1"><span class="inv-sn">Asset ID {{ $x->serial_no }}</span>@if($x->device_sn) <span class="inv-sn">· Serial {{ $x->device_sn }}</span>@endif</div>@endif
                <div class="mine-meta">
                    <span>Assigned to <b>{{ $x->holder }}</b></span>
                    @if($x->since)<span>Since <b>{{ \Illuminate\Support\Carbon::parse($x->since)->format('d M Y') }}</b></span>@endif
                </div>
            </div>
            <div class="inv-hold-qty"><div class="inv-q fs-5">{{ \App\Support\Inv::qty($x->held) }}</div><div class="inv-sub">{{ $x->equipment->unit }}</div></div>
        </div>
    @endforeach
    </div>
    <div class="mine-none" id="mineNone">No equipment matches your search.</div>
    @push('scripts')
    <script>
    (function () {
        var box = document.getElementById('mineSearch'), cards = document.querySelectorAll('#mineCards .inv-hold'), shown = document.getElementById('mineShown'), none = document.getElementById('mineNone');
        box.addEventListener('input', function () {
            var q = this.value.trim().toLowerCase(), n = 0;
            cards.forEach(function (c) { var ok = c.dataset.text.indexOf(q) > -1; c.style.display = ok ? '' : 'none'; if (ok) n++; });
            shown.textContent = n; none.style.display = n ? 'none' : 'block';
        });
    })();
    </script>
    @endpush
@endif
@endsection
