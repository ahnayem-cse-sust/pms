@extends('layouts.app')
@section('title', 'Record '.$m->ref)
@section('content')
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('inv.records') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Records</a>
    @if($entryRoute)<a href="{{ route($entryRoute, $m->entry_no) }}" class="btn btn-outline-primary ms-md-auto inv-back"><x-icon name="eye" :size="15"/> View entry {{ $m->entry_no }}@if($entryCount > 1) ({{ $entryCount }} lines)@endif</a>
    <a href="{{ route($entryRoute === 'inv.allocations.show' ? 'inv.allocations.pdf' : 'inv.receives.pdf', $m->entry_no) }}" class="btn btn-primary inv-back"><x-icon name="download" :size="15"/> Download PDF</a>@endif
</div>
<div class="card">
    <div class="inv-hero">
        <span class="type-ico ti-{{ \App\Support\Inv::tone($m->type) }}"><x-icon :name="\App\Support\Inv::icon($m->type)" :size="20"/></span>
        <div><div class="inv-hero-title">{{ $m->ref }}</div><div class="inv-sub">{{ $m->moved_on->format('d M Y') }}@if($m->entry_no) · Entry {{ $m->entry_no }}@endif</div></div>
        <div class="ms-auto d-flex align-items-center gap-3">{{ \App\Support\Inv::pill($m->type) }}<span class="inv-q fs-5 {{ $m->qty > 0 ? 'pos' : ($m->qty < 0 ? 'neg' : '') }}">{{ $m->qty > 0 ? '+' : '' }}{{ \App\Support\Inv::qty($m->qty) }} <span class="text-muted fs-6 fw-normal">{{ $m->equipment->unit }}</span></span></div>
    </div>
    @php
        $e = $m->equipment;
        $kind = $m->type === 'ALLOCATE' ? 'Allocation' : 'Receive';
        $sections = [
            $kind.' information' => [
                ['Record ID', e($m->ref)],
                ['Date', e($m->moved_on->format('d M Y'))],
                ['Type', (string) \App\Support\Inv::pill($m->type)],
                [$kind.' ID', e($m->entry_no ?: '—')],
                ['Quantity', e(($m->qty > 0 ? '+' : '').\App\Support\Inv::qty($m->qty).' '.$e->unit)],
                ['Stock after', e(\App\Support\Inv::qty($m->balance_after))],
                ['Person / department', e($m->holder_name ?: '—').($m->holderUser ? ' <span class="text-muted fw-normal">('.e($m->holderUser->employee_id).', '.e($m->holderUser->department->name ?? '').')</span>' : '')],
                ['Reference', e($m->reference_no ?: '—')],
                ['Supplier', e($m->party ?: '—')],
                [$m->type === 'ALLOCATE' ? 'Purpose' : 'Remarks', e($m->remarks ?: '—')],
                ['By', e($m->user->name ?? '—')],
                ['Recorded at', e($m->created_at?->format('d M Y H:i') ?? '—')],
            ],
            'Equipment information' => [
                ['Equipment ID', e($e->code)],
                ['Equipment', e($e->name)],
                ['Asset type', e($e->assetType->name ?? '—')],
                ['Category', e($e->category->name ?? '—')],
                ['Sub category', e($e->subcategory->name ?? '—')],
                ['Asset ID', e($m->serial_no ?: '—')],
                ['Brand', e($e->brand ?: '—')],
                ['Model', e($e->model ?: '—')],
            ],
        ];
    @endphp
    @foreach($sections as $title => $fields)
    @php
        $pairs = collect($fields);
        $half = (int) ceil($pairs->count() / 2);   // same number of rows on both sides; an odd total leaves the right side blank
        $left = $pairs->take($half)->values();
        $right = $pairs->slice($half)->values();
    @endphp
    <div class="inv-history-head">{{ $title }}</div>
    <div class="table-responsive inv-lines">
    <table class="table table-bordered align-middle inv-info mb-0"><tbody>
        @for($i = 0; $i < $half; $i++)
        <tr>
            <th>{{ $left[$i][0] }}</th><td>{!! $left[$i][1] !!}</td>
            @if(isset($right[$i]))<th>{{ $right[$i][0] }}</th><td>{!! $right[$i][1] !!}</td>@else<th></th><td></td>@endif
        </tr>
        @endfor
    </tbody></table>
    </div>
    @endforeach
</div>
@endsection
