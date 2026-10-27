@extends('layouts.app')
@section('title', 'New issue request')
@section('content')
@include('inventory._errors')
<form method="POST" action="{{ route('inv.issues.store') }}" class="card"><div class="card-body">@csrf
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Requested by</label><select name="requested_by" class="form-select">@foreach($people as $p)<option value="{{ $p->id }}" @selected(old('requested_by', auth()->id()) == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Recipient (employee)</label><select name="recipient_user_id" class="form-select"><option value="">—</option>@foreach($people as $p)<option value="{{ $p->id }}" @selected(old('recipient_user_id') == $p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">…or recipient department</label><select name="department_id" class="form-select"><option value="">—</option>@foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('department_id') == $d->id)>{{ $d->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Issue from store</label><select name="location_id" class="form-select"><option value="">Decide at fulfilment</option>@foreach($stores as $s)<option value="{{ $s->id }}" @selected(old('location_id') == $s->id)>{{ $s->path }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Required by</label><input type="date" name="required_date" value="{{ old('required_date') }}" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Related request no. (optional)</label><input name="ticket_no" value="{{ old('ticket_no') }}" class="form-control" placeholder="e.g. IT-2026-000125"></div>
        <div class="col-12"><label class="form-label">Purpose *</label><textarea name="purpose" rows="2" class="form-control" required>{{ old('purpose') }}</textarea></div>
    </div>
    <h6 class="mt-4">Items</h6><div id="lines"></div><button type="button" class="btn btn-sm btn-outline-secondary" onclick="addLine()">+ Add item</button>
    <div class="mt-3"><button class="btn btn-primary">Submit request</button> <a href="{{ route('inv.issues.index') }}" class="btn btn-link">Cancel</a></div>
</div></form>
@push('scripts')
<script>
var ITEMS = @json($items->map(fn ($i) => ['id' => $i->id, 'label' => $i->name.' ('.$i->code.')'])->values()), n = 0;
function addLine() { var i = n++, o = ITEMS.map(function (x) { return '<option value="' + x.id + '">' + x.label.replace(/</g, '&lt;') + '</option>'; }).join('');
    var d = document.createElement('div'); d.className = 'row g-2 mb-2';
    d.innerHTML = '<div class="col-md-5"><select name="lines[' + i + '][item_id]" class="form-select form-select-sm" required><option value="">Item…</option>' + o + '</select></div>' +
      '<div class="col-md-2"><input type="number" step="0.01" min="0.01" name="lines[' + i + '][qty_requested]" value="1" class="form-control form-control-sm" required></div>' +
      '<div class="col-md-4"><input name="lines[' + i + '][remarks]" class="form-control form-control-sm" placeholder="Remarks"></div>' +
      '<div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest(\'.row\').remove()">×</button></div>';
    document.getElementById('lines').appendChild(d); }
addLine();
</script>
@endpush
@endsection
