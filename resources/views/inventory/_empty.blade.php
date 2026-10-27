{{-- Empty state. In a table wrap it as <tr><td colspan="N">…</td></tr>. Pass: icon, msg; optional: hint, ctaUrl, ctaLabel. --}}
<div class="inv-empty">
    <span class="inv-empty-ico"><x-icon :name="$icon" :size="22"/></span>
    <div class="fw-semibold">{{ $msg }}</div>
    @isset($hint)<div class="text-muted small">{{ $hint }}</div>@endisset
    @isset($ctaUrl)<a href="{{ $ctaUrl }}" class="btn btn-sm btn-primary mt-1">{{ $ctaLabel ?? 'Add' }}</a>@endisset
</div>
