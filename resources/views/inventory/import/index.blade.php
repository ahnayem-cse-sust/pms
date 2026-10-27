@extends('layouts.app')
@section('title', 'Opening Data Import')
@section('content')
@include('inventory._errors')
<div class="card mb-3"><div class="card-body">
    <p class="small text-muted mb-2">Use the template, keep the headers, dates as YYYY-MM-DD. Nothing is posted until the preview shows no errors and you confirm. Opening quantities enter the ledger only through this process.</p>
    <div class="mb-3">@foreach($kinds as $k => $l)<a href="{{ route('inv.import.template', $k) }}" class="btn btn-sm btn-outline-secondary me-1"><x-icon name="download" :size="14"/> {{ $l }} template</a>@endforeach</div>
    <form method="POST" action="{{ route('inv.import.upload') }}" enctype="multipart/form-data" class="row g-2">@csrf
        <div class="col-md-3"><select name="kind" class="form-select form-select-sm">@foreach($kinds as $k => $l)<option value="{{ $k }}">{{ $l }}</option>@endforeach</select></div>
        <div class="col-md-3"><input type="file" name="file" accept=".csv,.txt" class="form-control form-control-sm" required></div>
        <div class="col-md-4"><input name="source_ref" class="form-control form-control-sm" placeholder="Source / reference (e.g. IT register 30-Sep-2026) *" required></div>
        <div class="col-md-2"><button class="btn btn-primary btn-sm w-100">Upload &amp; validate</button></div>
    </form>
</div></div>
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Batch</th><th>Kind</th><th>File / source</th><th>Rows</th><th>Errors</th><th>By</th><th>Status</th></tr></thead><tbody>
@forelse($batches as $b)<tr><td><a href="{{ route('inv.import.show', $b) }}">{{ $b->ref }}</a></td><td>{{ $b->kind }}</td><td>{{ $b->file_name }}<div class="text-muted small">{{ $b->source_ref }}</div></td><td>{{ $b->total_rows }}</td><td>{{ $b->error_rows }}</td><td>{{ $b->uploader->name ?? '' }}</td><td>{{ \App\Support\Inv::pill($b->status) }}</td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-3">No imports yet.</td></tr>@endforelse</tbody></table>
{{ $batches->links() }}
@endsection
