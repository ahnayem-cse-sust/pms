@php
    $f = $ls->first();
    $url = $f ? match (true) {
        $f->type === 'ALLOCATE' => route('inv.allocations.show', $f->entry_no),
        in_array($f->type, ['RECEIVE', 'OPENING', 'RETURN'], true) && $f->entry_no => route('inv.receives.show', $f->entry_no),
        default => route('inv.records.show', $f),   // old correction without an entry
    } : null;
@endphp
@if($f)
<tr class="row-link" data-href="{{ $url }}">
    <td class="text-nowrap"><div class="d-flex align-items-center gap-2"><span class="type-ico ti-{{ \App\Support\Inv::tone($f->type) }}"><x-icon :name="\App\Support\Inv::icon($f->type)" :size="15"/></span><div><a href="{{ $url }}" class="ticket-link">{{ $f->entry_no ?: $f->ref }}</a><div class="inv-sub">{{ $ls->count() }} {{ \Illuminate\Support\Str::plural('equipment', $ls->count()) }}</div></div></div></td>
    <td class="text-nowrap">{{ $f->moved_on->format('d M Y') }}</td>
    <td>@if($f->type === 'ALLOCATE'){{ $f->holder_name }}@if($f->holderUser)<div class="inv-sub">{{ $f->holderUser->department->name ?? '' }}</div>@elseif($f->holderSection)<div class="inv-sub">{{ $f->holderSection->department->name ?? '' }}</div>@endif
        @elseif($f->type === 'RETURN')<span class="pill pill-info">Return</span> {{ $f->holder_name }}
        @elseif($f->type === 'OPENING')<span class="pill pill-secondary">Previous item</span> {{ $f->party }}
        @elseif($f->type === 'RECEIVE')<span class="pill pill-success">Supplier</span> {{ $f->party }}
        @else{{ \App\Support\Inv::pill($f->type) }} {{ $f->holder_name ?: $f->party }}@endif</td>
    <td style="min-width:260px">
        @foreach($ls as $m)
        <div class="d-flex justify-content-between gap-3 {{ $m->equipment_id == $equipmentId ? 'fw-semibold' : 'text-muted' }}">
            <span>{{ $m->equipment->name ?? '—' }} <span class="inv-sub d-inline">({{ $m->equipment->code ?? '' }})</span>@if($m->serial_no)<span class="inv-sub d-inline"> · Asset ID {{ $m->serial_no }}@if($m->device_serial_no) · Serial {{ $m->device_serial_no }}@endif</span>@endif</span>
            <span class="inv-q text-nowrap">{{ \App\Support\Inv::qty(abs($m->qty)) }}</span>
        </div>
        @endforeach
        <div class="d-flex justify-content-between gap-3 border-top mt-1 pt-1 inv-sub"><span>Total</span><span class="inv-q">{{ \App\Support\Inv::qty($ls->sum(fn ($m) => abs($m->qty))) }}</span></div>
    </td>
    <td>{{ $f->reference_no ?: '—' }}@if($f->remarks)<div class="inv-sub">{{ $f->remarks }}</div>@endif<div class="inv-sub">{{ $f->user->name ?? '' }}</div></td>
    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ $url }}"><x-icon name="eye" :size="14"/> View</a></td>
</tr>
@endif
