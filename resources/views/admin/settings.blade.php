@extends('layouts.app')
@section('title', 'System settings')
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="card card-body">@csrf @method('PUT')
    @foreach($settings->groupBy('group') as $group => $items)
        <h6 class="text-uppercase text-muted mt-2">{{ $group }}</h6>
        @foreach($items as $s)
            <div class="row mb-2">
                <label class="col-md-3 col-form-label"><code>{{ $s->key }}</code></label>
                <div class="col-md-6"><input name="settings[{{ $s->key }}]" value="{{ $s->value }}" class="form-control" @readonly(! auth()->user()->can('settings.update'))></div>
            </div>
        @endforeach
    @endforeach
    @can('settings.update')<div><button class="btn btn-primary">Save settings</button></div>@endcan
</form>
<p class="text-muted small mt-2">upload.max_kb is in kilobytes; upload.allowed_ext is a comma-separated list; the other values are days or minutes as named.
Users are signed out automatically after 15 minutes of inactivity (<code>ITSM_INACTIVITY_MINUTES</code> in <code>.env</code>).</p>
@endsection
