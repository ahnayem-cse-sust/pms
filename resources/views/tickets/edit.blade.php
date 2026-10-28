@extends('layouts.app')
@section('title', 'Edit request '.str_replace('-', '', $ticket->ticket_no))
@section('content')
<div class="row justify-content-center"><div class="col-xl-9">
<form method="POST" action="{{ route('tickets.details', $ticket) }}">
    @csrf @method('PUT')
    <div class="alert alert-info py-2">You can edit this request until it is assigned to an IT employee.</div>
    <div class="card mb-3">
        <div class="card-header">Requester</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" value="{{ $ticket->requester_name }}" disabled></div>
                <div class="col-md-6"><label class="form-label">Employee ID</label><input class="form-control" value="{{ $ticket->requester_employee_id }}" disabled></div>
                <div class="col-md-6"><label class="form-label">WhatsApp number</label><input name="phone" value="{{ old('phone', $ticket->requester_phone) }}" class="form-control" maxlength="30" inputmode="tel"></div>
                <div class="col-md-6"><label class="form-label">Location</label>
                    <select name="location_id" class="form-select"><option value="">—</option>@foreach($locations as $l)<option value="{{ $l->id }}" @selected(old('location_id', $ticket->location_id) == $l->id)>{{ $l->name }}</option>@endforeach</select></div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">Request</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Service type *</label>
                    <select name="ticket_type_id" class="form-select" required>@foreach($types as $t)<option value="{{ $t->id }}" @selected(old('ticket_type_id', $ticket->ticket_type_id) == $t->id)>{{ $t->name }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Category *</label>
                    <select name="category_id" id="edCat" class="form-select" required>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('category_id', $ticket->category_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Sub-category</label>
                    <select name="subcategory_id" id="edSub" class="form-select"><option value="">—</option>
                        @foreach($categories as $c)@foreach($c->subcategories as $sc)@if($sc->is_active || $ticket->subcategory_id == $sc->id)<option value="{{ $sc->id }}" data-cat="{{ $c->id }}" @selected(old('subcategory_id', $ticket->subcategory_id) == $sc->id)>{{ $sc->name }}</option>@endif @endforeach @endforeach
                    </select></div>
                <div class="col-12"><label class="form-label">Subject *</label><input name="subject" value="{{ old('subject', $ticket->subject) }}" class="form-control" maxlength="200" required></div>
                <div class="col-12"><label class="form-label">Detailed description *</label><textarea name="description" rows="7" class="form-control" required>{{ old('description', $ticket->description) }}</textarea></div>
                <div class="col-md-4"><label class="form-label">Preferred completion date</label><input type="date" name="preferred_completion_date" value="{{ old('preferred_completion_date', optional($ticket->preferred_completion_date)->format('Y-m-d')) }}" class="form-control"></div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2 justify-content-end">
        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-primary px-4">Save changes</button>
    </div>
</form>
</div></div>
@push('scripts')
<script>
(function () {
    var cat = document.getElementById('edCat'), sub = document.getElementById('edSub');
    function filter() {
        Array.prototype.forEach.call(sub.options, function (o) {
            if (!o.dataset.cat) return;
            o.hidden = o.dataset.cat !== cat.value;
            if (o.hidden && o.selected) sub.value = '';
        });
    }
    cat.addEventListener('change', filter); filter();
})();
</script>
@endpush
@endsection
