@extends('layouts.app')
@section('title', 'System settings')
@section('content')
<h4 class="mb-3">System settings</h4>
<form method="POST" action="{{ route('admin.settings.update') }}" class="card card-body">@csrf @method('PUT')
    @foreach($settings->groupBy('group') as $group => $items)
        <h6 class="text-uppercase text-muted mt-2">{{ $group }}</h6>
        @foreach($items as $s)
            <div class="row mb-2">
                <label class="col-md-3 col-form-label"><code>{{ $s->key }}</code></label>
                <div class="col-md-6"><input name="settings[{{ $s->key }}]" value="{{ $s->value }}" class="form-control"></div>
            </div>
        @endforeach
    @endforeach
    <div><button class="btn btn-primary">Save settings</button></div>
</form>
<p class="text-muted small mt-2">upload.max_kb is in kilobytes; upload.allowed_ext is a comma-separated list; the other values are days or minutes as named.
Session timeout is applied from <code>SESSION_LIFETIME</code> in <code>.env</code> (see README).</p>
@endsection
