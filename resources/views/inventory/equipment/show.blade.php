@extends('layouts.app')
@section('title', $e->name)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('inv.equipment.index') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Equipment &amp; Stock</a>
    @can('inv.update')<a href="{{ route('inv.equipment.edit', $e) }}" class="btn btn-primary ms-md-auto inv-back"><x-icon name="edit" :size="15"/> Edit</a>@endcan
</div>
<div class="card">
    <div class="inv-hero">
        <span class="type-ico ti-primary"><x-icon name="box" :size="20"/></span>
        <div><div class="inv-hero-title">{{ $e->name }}</div><div class="inv-sub"><span class="inv-code">{{ $e->code }}</span>@if(trim($e->brand.' '.$e->model)) · {{ trim($e->brand.' '.$e->model) }}@endif</div></div>
        <div class="ms-auto d-flex align-items-center gap-3">@if(! $e->is_active)<span class="pill pill-secondary">Inactive</span>@endif<span class="inv-q fs-5">{{ \App\Support\Inv::qty($e->stock_qty) }} <span class="text-muted fs-6 fw-normal">{{ $e->unit }} in stock</span></span></div>
    </div>
    @php
        $fields = [
            'Equipment ID' => $e->code,
            'Asset type' => $e->assetType->name ?? '—',
            'Category' => $e->category->name ?? '—',
            'Sub category' => $e->subcategory->name ?? '—',
            'Brand' => $e->brand ?: '—',
            'Model' => $e->model ?: '—',
            'Unit' => $e->unit ?: '—',
            'Serialisable' => $e->is_serialized ? 'Yes (each unit has an Asset ID)' : 'No',
            'Status' => $e->is_active ? 'Active' : 'Inactive',
            'Notes' => $e->notes ?: '—',
        ];
        $pairs = collect($fields)->map(fn ($v, $k) => [$k, $v])->values();
        $half = (int) ceil($pairs->count() / 2);   // both sides take the same number of rows; with an odd total the right side ends blank
        $left = $pairs->take($half)->values();
        $right = $pairs->slice($half)->values();
    @endphp
    <div class="table-responsive inv-lines">
    <table class="table table-bordered align-middle inv-info mb-0"><tbody>
        @for($i = 0; $i < $half; $i++)
        <tr>
            <th>{{ $left[$i][0] }}</th><td>{{ $left[$i][1] }}</td>
            @if(isset($right[$i]))<th>{{ $right[$i][0] }}</th><td>{{ $right[$i][1] }}</td>@else<th></th><td></td>@endif
        </tr>
        @endfor
    </tbody></table>
    </div>
</div>

<div class="d-flex flex-wrap gap-2 mt-3" role="tablist">
    <button type="button" class="btn {{ $tab === 'allocation' ? 'btn-primary' : 'btn-outline-primary' }}" data-hist="allocation">Allocation history <span class="inv-count">{{ $allocations->total() }}</span></button>
    <button type="button" class="btn {{ $tab === 'receive' ? 'btn-primary' : 'btn-outline-primary' }}" data-hist="receive">Receive history <span class="inv-count">{{ $receives->total() }}</span></button>
</div>

<div id="hist-allocation" class="hist-pane" @if($tab !== 'allocation') hidden @endif>
<div class="card mt-3">
    <div class="inv-history-head" style="border-top:0">Allocation history <span class="inv-count">{{ $allocations->total() }}</span></div>
    <div class="table-responsive inv-lines">
    <table class="table table-hover align-middle"><thead><tr><th>Record</th><th>Type</th><th class="text-end">Qty / balance</th><th>Person / reference</th><th></th></tr></thead><tbody>
    @forelse($allocations as $m)
    @include('inventory.equipment._history_row', ['m' => $m])
    @empty
    <tr><td colspan="5">@include('inventory._empty', ['icon' => 'clipboard', 'msg' => 'No allocations yet', 'hint' => 'Allocations and returns of this equipment are listed here.'])</td></tr>
    @endforelse
    </tbody></table>
    </div>
</div>
<div class="mt-3">{{ $allocations->links() }}</div>
</div>

<div id="hist-receive" class="hist-pane" @if($tab !== 'receive') hidden @endif>
<div class="card mt-3">
    <div class="inv-history-head" style="border-top:0">Receive history <span class="inv-count">{{ $receives->total() }}</span></div>
    <div class="table-responsive inv-lines">
    <table class="table table-hover align-middle"><thead><tr><th>Record</th><th>Type</th><th class="text-end">Qty / balance</th><th>Person / reference</th><th></th></tr></thead><tbody>
    @forelse($receives as $m)
    @include('inventory.equipment._history_row', ['m' => $m])
    @empty
    <tr><td colspan="5">@include('inventory._empty', ['icon' => 'clipboard', 'msg' => 'No receives yet', 'hint' => 'Stock received for this equipment is listed here.'])</td></tr>
    @endforelse
    </tbody></table>
    </div>
</div>
<div class="mt-3">{{ $receives->links() }}</div>
</div>
@include('inventory._rowlink')
@push('scripts')
<script>
document.querySelectorAll('[data-hist]').forEach(function (b) {
    b.addEventListener('click', function () {
        document.querySelectorAll('[data-hist]').forEach(function (x) {
            var on = x === b;
            x.classList.toggle('btn-primary', on); x.classList.toggle('btn-outline-primary', !on);
            document.getElementById('hist-' + x.dataset.hist).hidden = !on;
        });
    });
});
</script>
@endpush
@endsection
