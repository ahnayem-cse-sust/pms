<div class="table-card">
<div class="table-responsive">
<table class="table table-hover align-middle">
    <thead>
        <tr><th>Ticket</th><th>Department</th><th>Category</th><th>Priority</th><th>Assigned to</th><th>Status</th><th>Due</th><th>Created</th></tr>
    </thead>
    <tbody>
    @forelse($tickets as $t)
        <tr>
            <td style="min-width:260px">
                <a href="{{ route('tickets.show', $t) }}" class="ticket-link">{{ $t->ticket_no }}</a>
                <div class="ticket-sub">{{ \Illuminate\Support\Str::limit($t->subject, 64) }}</div>
            </td>
            <td>{{ $t->department->name ?? '' }}</td>
            <td>{{ $t->category->name ?? '' }}@if($t->subcategory)<div class="ticket-sub">{{ $t->subcategory->name }}</div>@endif</td>
            <td><span class="pill pill-{{ $t->priority->color ?? 'secondary' }}">{{ $t->priority->name }}</span></td>
            <td>
                @if($t->assignee)
                    <span class="d-inline-flex align-items-center gap-2"><x-avatar :name="$t->assignee->name"/> {{ $t->assignee->name }}</span>
                @else <span class="text-muted">Unassigned</span> @endif
            </td>
            <td>
                <span class="pill pill-{{ $t->status->color ?? 'secondary' }}">{{ $t->status->name }}</span>
                @if($t->status->is_open && $t->sla_status === 'breached')<span class="pill pill-danger">SLA</span>
                @elseif($t->status->is_open && $t->sla_status === 'warning')<span class="pill pill-warning">SLA</span>@endif
            </td>
            <td class="text-nowrap">{{ $t->due_date?->format('d M') ?? '—' }}</td>
            <td class="text-nowrap text-muted">{{ $t->created_at->format('d M Y H:i') }}</td>
        </tr>
    @empty
        <tr><td colspan="8" class="text-center text-muted py-5">No requests found.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
</div>
