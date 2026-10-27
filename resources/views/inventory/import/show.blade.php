@extends('layouts.app')
@section('title', $b->ref)
@section('content')
@include('inventory._errors')
<div class="d-flex gap-2 align-items-center mb-3"><h5 class="mb-0">{{ $b->ref }} · {{ $b->kind }}</h5> {{ \App\Support\Inv::pill($b->status) }}</div>
<div class="small text-muted mb-3">{{ $b->file_name }} · source: {{ $b->source_ref }} · uploaded by {{ $b->uploader->name ?? '' }} on {{ $b->created_at->format('d M Y H:i') }}@if($b->posted_at) · posted {{ $b->posted_at->format('d M Y H:i') }}@endif</div>
@if($b->status === 'PREVIEW')
    @if(count($rowErrors))
        <div class="alert alert-danger"><b>{{ count($rowErrors) }} problem(s) – fix the file and upload it again. Nothing has been posted.</b></div>
    @else
        <div class="alert alert-success">All {{ $total }} rows are valid.</div>
        <form method="POST" action="{{ route('inv.import.post', $b) }}" class="mb-3" onsubmit="return confirm('Post this import now?')">@csrf
            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="verified" value="1" id="v" required><label for="v" class="form-check-label">I have reviewed the preview and the data has been verified by the inventory owner.</label></div>
            <button class="btn btn-primary">Post import</button></form>
    @endif
@endif
@if(! empty($rowErrors))
<table class="table table-sm bg-white"><thead class="table-light"><tr><th style="width:80px">Line</th><th>Problem</th></tr></thead><tbody>@foreach($rowErrors as $e)<tr><td>{{ $e['line'] }}</td><td>{{ $e['message'] }}</td></tr>@endforeach</tbody></table>
@endif
@if($preview)
<h6>Preview (first {{ count($preview) }} of {{ $total }} rows)</h6>
<div class="table-responsive"><table class="table table-sm bg-white small"><thead class="table-light"><tr><th>Line</th>@foreach($head as $h)<th>{{ $h }}</th>@endforeach</tr></thead><tbody>
@foreach($preview as $r)<tr><td>{{ $r['_line'] }}</td>@foreach($head as $h)<td>{{ $r[$h] ?? '' }}</td>@endforeach</tr>@endforeach</tbody></table></div>
@endif
@endsection
