@extends('layouts.app')
@section('title', 'Edit receive '.$entry)
@section('content')
@include('inventory._errors')
@php $isReturn = $first->type === 'RETURN'; @endphp
<form method="POST" action="{{ route('inv.receives.update', $entry) }}">@csrf @method('PUT')
<div class="card inv-form-card mb-3">
    <div class="card-header"><span class="inv-step">1</span> {{ $entry }} {{ \App\Support\Inv::pill($first->type) }}</div>
    <div class="card-body"><div class="row g-3">
        @if($isReturn)
        <div class="col-md-6"><label class="form-label">Returned by</label><input class="form-control" value="{{ $first->holder_name }}{{ $first->holderUser ? ' ('.$first->holderUser->employee_id.', '.($first->holderUser->department->name ?? '').')' : '' }}" disabled></div>
        @else
        <div class="col-md-6"><label class="form-label">{{ $first->type === 'OPENING' ? 'Supplier (previous item)' : 'Supplier' }}</label><input name="supplier" value="{{ old('supplier', $first->party) }}" class="form-control" maxlength="255"></div>
        @endif
        <div class="col-md-3"><label class="form-label">Date *</label><input type="date" name="date" value="{{ old('date', $first->moved_on->format('Y-m-d')) }}" max="{{ today()->format('Y-m-d') }}" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">{{ $isReturn ? 'Return slip / reference' : 'Invoice / challan / PO no.' }}</label><input name="reference_no" value="{{ old('reference_no', $first->reference_no) }}" class="form-control" maxlength="255"></div>
        <div class="col-12"><label class="form-label">Remarks</label><input name="remarks" value="{{ old('remarks', $first->remarks) }}" class="form-control" maxlength="1000"></div>
    </div></div>
</div>

<div class="card inv-form-card">
    <div class="card-header"><span class="inv-step">2</span> Items received <span class="inv-count">{{ $lines->count() }}</span></div>
    <div class="card-body p-0">
    <div class="table-responsive inv-lines"><table class="table align-middle mb-0"><thead><tr><th>Equipment ID</th><th>Equipment</th><th>Asset ID</th><th style="width:130px">Quantity</th></tr></thead><tbody>
    @foreach($lines as $m)
    <tr>
        <td class="text-nowrap"><span class="inv-code">{{ $m->equipment->code }}</span></td>
        <td style="min-width:180px"><span class="inv-name">{{ $m->equipment->name }}</span></td>
        <td>@if($m->serial_no)<strong class="inv-sn text-body">{{ $m->serial_no }}</strong>@else—@endif</td>
        <td>@if($svc->qtyEditable($m))<input type="number" step="0.01" min="0.01" name="lines[{{ $m->id }}][qty]" value="{{ old('lines.'.$m->id.'.qty', \App\Support\Inv::qty(abs($m->qty))) }}" class="form-control form-control-sm" required>@else<span class="inv-q">{{ \App\Support\Inv::qty(abs($m->qty)) }}</span>@endif</td>
    </tr>
    @endforeach
    </tbody></table></div>
    </div>
    <div class="card-body pt-2"><div class="form-text">The stock is adjusted to match when you save; a change is refused if it would make the stock negative{{ $isReturn ? ' or if the person did not hold that much' : '' }}. To change the equipment itself, or to add or remove a line, delete this entry and enter it again.</div></div>
</div>
<div class="inv-actionbar"><button class="btn btn-primary"><x-icon name="check" :size="15"/> Save changes</button><a href="{{ route('inv.receives.show', $entry) }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
@endsection
