{{-- vars: $type, $id, $docs, $canUpload --}}
<div class="card mb-3"><div class="card-header">Supporting documents</div><div class="card-body">
    @forelse($docs as $d)
        <div class="d-flex justify-content-between border-bottom py-1 small">
            <span><x-icon name="paperclip" :size="14"/> <a href="{{ route('inv.documents.download', $d) }}">{{ $d->original_name }}</a> @if($d->doc_type)<span class="pill pill-light">{{ $d->doc_type }}</span>@endif</span>
            <span class="text-muted">{{ $d->created_at->format('d M Y') }} · {{ $d->uploader->name ?? '' }}</span>
        </div>
    @empty <div class="text-muted small">No documents attached.</div> @endforelse
    @if($canUpload)
    <form method="POST" action="{{ route('inv.documents.store', [$type, $id]) }}" enctype="multipart/form-data" class="row g-2 mt-2">
        @csrf
        <div class="col-md-4"><select name="doc_type" class="form-select form-select-sm">@foreach(['Invoice', 'Warranty certificate', 'Delivery note', 'Handover form', 'Repair document', 'Image', 'Other'] as $t)<option>{{ $t }}</option>@endforeach</select></div>
        <div class="col-md-5"><input type="file" name="file" class="form-control form-control-sm" required></div>
        <div class="col-md-3"><button class="btn btn-sm btn-outline-primary w-100">Attach</button></div>
    </form>
    @endif
</div></div>
