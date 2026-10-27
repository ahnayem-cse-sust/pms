@extends('layouts.app')
@section('title', 'Retirement & Disposal')
@section('content')
@include('inventory._errors')
@can('inv.disposal.create')
<form method="POST" action="{{ route('inv.disposals.store') }}" class="card mb-3"><div class="card-body">@csrf
    <div class="fw-semibold mb-2">Propose retirement / disposal <span class="text-muted fw-normal small">– the asset stays in service until approval and completion</span></div>
    <div class="row g-2">
        <div class="col-md-4"><select name="asset_id" class="form-select form-select-sm" required><option value="">Asset…</option>@foreach($assets as $a)<option value="{{ $a->id }}" @selected(old('asset_id', $pre) == $a->id)>{{ $a->asset_code }} · {{ $a->item->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><select name="reason" class="form-select form-select-sm">@foreach(config('inventory.disposal_reasons') as $k => $l)<option value="{{ $k }}">{{ $l }}</option>@endforeach</select></div>
        <div class="col-md-2"><select name="condition_id" class="form-select form-select-sm"><option value="">Condition…</option>@foreach($conditions as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><input name="proposed_action" class="form-control form-control-sm" placeholder="Proposed action"></div>
        <div class="col-md-2"><input type="date" name="proposed_date" class="form-control form-control-sm"></div>
        <div class="col-md-10"><input name="remarks" class="form-control form-control-sm" placeholder="Justification *" required></div><div class="col-md-2"><button class="btn btn-primary btn-sm w-100">Propose</button></div>
    </div>
</div></form>
@endcan
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Reference</th><th>Asset</th><th>Reason</th><th>Proposed by</th><th>Status</th></tr></thead><tbody>
@forelse($rows as $d)<tr><td><a href="{{ route('inv.disposals.show', $d) }}">{{ $d->ref }}</a></td><td>{{ $d->asset->asset_code }} · {{ $d->asset->item->name }}</td><td>{{ config('inventory.disposal_reasons.'.$d->reason) }}</td><td>{{ $d->proposer->name ?? '' }}</td><td>{{ \App\Support\Inv::pill($d->status) }}</td></tr>
@empty<tr><td colspan="5" class="text-center text-muted py-3">None.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}
@endsection
