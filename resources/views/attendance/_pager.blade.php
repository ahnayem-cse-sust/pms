@php
    $cur = $rows->currentPage();
    $last = max(1, $rows->lastPage());
    $from = max(1, $cur - 2);
    $to = min($last, $cur + 2);
@endphp
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
    <div class="text-muted small">
        @if($rows->total())
            Showing {{ $rows->firstItem() }}–{{ $rows->lastItem() }} of {{ $rows->total() }} records
        @else
            No records
        @endif
        · {{ $rows->perPage() }} per page
    </div>
    <nav aria-label="Attendance pages">
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item {{ $cur <= 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ $cur > 1 ? $rows->url($cur - 1) : '#' }}">‹ Prev</a></li>
            @if($from > 1)
                <li class="page-item"><a class="page-link" href="{{ $rows->url(1) }}">1</a></li>
                @if($from > 2)<li class="page-item disabled"><span class="page-link">…</span></li>@endif
            @endif
            @for($p = $from; $p <= $to; $p++)
                <li class="page-item {{ $p === $cur ? 'active' : '' }}"><a class="page-link" href="{{ $rows->url($p) }}">{{ $p }}</a></li>
            @endfor
            @if($to < $last)
                @if($to < $last - 1)<li class="page-item disabled"><span class="page-link">…</span></li>@endif
                <li class="page-item"><a class="page-link" href="{{ $rows->url($last) }}">{{ $last }}</a></li>
            @endif
            <li class="page-item {{ $cur >= $last ? 'disabled' : '' }}"><a class="page-link" href="{{ $cur < $last ? $rows->url($cur + 1) : '#' }}">Next ›</a></li>
        </ul>
    </nav>
</div>
