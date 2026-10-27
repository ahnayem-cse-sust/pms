{{-- Whole table row opens its data-href; links and buttons inside the row keep their own behaviour. --}}
@once
@push('scripts')
<script>
document.addEventListener('click', function (e) {
    var tr = e.target.closest('tr[data-href]');
    if (!tr || e.target.closest('a, button, input, select, textarea, label, form')) return;
    if (e.ctrlKey || e.metaKey) window.open(tr.dataset.href, '_blank'); else window.location = tr.dataset.href;
});
</script>
@endpush
@endonce
