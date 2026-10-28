@extends('layouts.app')
@section('title', $isEmp ? $who->name : $who->name.' (dept)')
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('inv.allocations.index') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Who has what</a>
</div>
<div class="card">
    <div class="inv-hero">
        @if($isEmp)<x-avatar :name="$who->name"/>@else<span class="type-ico ti-primary"><x-icon name="building" :size="20"/></span>@endif
        <div><div class="inv-hero-title">{{ $who->name }}@unless($isEmp) <span class="text-muted fw-normal">(dept)</span>@endunless</div><div class="inv-sub">{{ $isEmp ? 'Employee' : 'Department' }}</div></div>
        <div class="ms-auto"><span class="inv-q fs-5">{{ \App\Support\Inv::qty($rows->sum('held')) }} <span class="text-muted fs-6 fw-normal">items held</span></span></div>
    </div>
    @php
        $pairs = collect([
            ['Assigned to', $who->name],
            ['Type', $isEmp ? 'Employee' : 'Department'],
            ['Employee ID', $isEmp ? ($who->employee_id ?: '—') : '—'],
            ['Department', $isEmp ? ($who->department->name ?? '—') : $who->name],
            ['Total items', \App\Support\Inv::qty($rows->sum('held'))],
            ['Equipment lines', $rows->count()],
        ]);
        $half = (int) ceil($pairs->count() / 2);
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

<div class="card mt-3">
    <div class="inv-history-head" style="border-top:0">Equipment <span class="inv-count">{{ $rows->count() }}</span></div>
    <div class="table-responsive inv-lines"><table class="table table-hover align-middle"><thead><tr><th>Equipment</th><th>Asset type / category</th><th>Asset ID / serial</th><th class="text-end">Quantity</th><th>Date</th><th></th></tr></thead><tbody>
    @forelse($rows as $x)
    <tr>
        <td style="min-width:180px"><a href="{{ route('inv.equipment.show', $x->equipment) }}" class="inv-name">{{ $x->equipment->name }}</a><div class="inv-sub"><span class="inv-code">{{ $x->equipment->code }}</span>@if(trim($x->equipment->brand.' '.$x->equipment->model)) · {{ trim($x->equipment->brand.' '.$x->equipment->model) }}@endif</div></td>
        <td><div>{{ $x->equipment->assetType->name ?? '—' }}</div><div class="inv-sub">{{ $x->equipment->category->name ?? '—' }}@if($x->equipment->subcategory) › {{ $x->equipment->subcategory->name }}@endif</div></td>
        <td>@if($x->serial_no)<strong class="inv-sn text-body">{{ $x->serial_no }}</strong>@else—@endif @if($x->device_sn)<div class="inv-sub">Serial {{ $x->device_sn }}</div>@endif</td>
        <td class="text-end text-nowrap"><span class="inv-q">{{ \App\Support\Inv::qty($x->held) }}</span> <span class="text-muted">{{ $x->equipment->unit }}</span></td>
        <td class="text-nowrap">{{ $x->since ? \Illuminate\Support\Carbon::parse($x->since)->format('d M Y') : '—' }}</td>
        <td class="text-end">@can('inv.create')<a class="btn btn-sm btn-outline-primary" href="{{ route('inv.receive', ['from' => ($x->holder_type === 'EMPLOYEE' ? 'E:'.$x->holder_user_id : 'D:'.$x->holder_department_id), 'equipment_id' => $x->equipment_id, 'serial' => $x->serial_no]) }}"><x-icon name="corner-up-left" :size="14"/> Return</a>@endcan</td>
    </tr>
    @empty
    <tr><td colspan="6">@include('inventory._empty', ['icon' => 'users', 'msg' => 'Nothing is held', 'hint' => 'Everything allocated here has been returned.'])</td></tr>
    @endforelse
    </tbody></table></div>
</div>
@endsection
