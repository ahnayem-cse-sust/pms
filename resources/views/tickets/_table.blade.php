@php($mine = ($mode ?? '') === 'mine')
@php($showType = $mine || ($mode ?? '') === '')
@php($showRole = in_array($mode ?? '', ['tasks', 'completed'], true))
<div class="table-card">
<div class="table-responsive">
<table class="table table-hover align-middle">
    <thead>
        <tr><th>Request ID</th><th>Subject</th>@if($showType)<th>Service type</th>@endif<th>Category</th>@unless($mine)<th>Primary</th>@endunless @if($showRole)<th>My role</th>@endif <th>Status</th><th>{{ ($mode ?? '') === 'completed' ? 'Completed' : 'Created' }}</th></tr>
    </thead>
    <tbody>
    @forelse($tickets as $t)
        @php($href = route('tickets.show', $mine ? ['ticket' => $t, 'from' => 'mine'] : $t))
        <tr class="row-link" data-href="{{ $href }}">
            <td class="text-nowrap"><a href="{{ $href }}" class="ticket-link">{{ $t->ticket_no }}</a></td>
            <td style="min-width:240px">{{ \Illuminate\Support\Str::limit($t->subject, 90) }}</td>
            @if($showType)<td class="text-nowrap">{{ $t->type->name ?? '—' }}</td>@endif
            <td>{{ $t->category->name ?? '' }}@if($t->subcategory)<div class="ticket-sub">{{ $t->subcategory->name }}</div>@endif</td>
            @unless($mine)
            <td>
                @if($t->assignee)
                    <span class="d-inline-flex align-items-center gap-2"><x-avatar :name="$t->assignee->name" :user="$t->assignee"/> {{ $t->assignee->name }}</span>
                    @php($sup = $t->relationLoaded('team') ? $t->team->where('role', 'SUPPORT') : collect())
                    @if($sup->isNotEmpty())<span class="pill pill-secondary" title="Supporting: {{ $sup->map(fn ($m) => $m->employee->name)->implode(', ') }}">+{{ $sup->count() }}</span>@endif
                @else <span class="text-muted">Unassigned</span> @endif
            </td>
            @endunless
            @if($showRole)
                <td><span class="pill pill-{{ $t->assigned_to === auth()->id() ? 'primary' : 'secondary' }}">{{ $t->assigned_to === auth()->id() ? 'Primary' : 'Support' }}</span></td>
            @endif
            <td><span class="pill pill-{{ $t->status->color ?? 'secondary' }}">{{ $t->status->name }}</span></td>
            <td class="text-nowrap text-muted">{{ (($mode ?? '') === 'completed' ? ($t->resolved_at ?? $t->closed_at ?? $t->updated_at) : $t->created_at)->format('d M Y h:i A') }}</td>
        </tr>
    @empty
        <tr><td colspan="{{ 5 + ($showType ? 1 : 0) + ($mine ? 0 : 1) + ($showRole ? 1 : 0) }}" class="text-center text-muted py-5">No requests found.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
</div>

@once
@push('scripts')
<script>
// Whole row opens the request; links/buttons inside the row keep their own behaviour.
document.addEventListener('click', function (e) {
    var tr = e.target.closest('tr[data-href]');
    if (!tr || e.target.closest('a, button, input, select, textarea, label, form')) return;
    if (e.ctrlKey || e.metaKey) window.open(tr.dataset.href, '_blank'); else window.location = tr.dataset.href;
});
</script>
@endpush
@endonce
