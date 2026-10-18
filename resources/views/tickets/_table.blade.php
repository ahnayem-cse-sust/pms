@php($mine = ($mode ?? '') === 'mine')
<div class="table-card">
<div class="table-responsive">
<table class="table table-hover align-middle">
    <thead>
        <tr><th>Ticket</th><th>Department</th><th>Category</th>@unless($mine)<th>Primary</th>@endunless @if(($mode ?? '') === 'tasks')<th>My role</th>@endif @unless($mine)<th>Status</th>@endunless<th>Due</th><th>Created</th></tr>
    </thead>
    <tbody>
    @forelse($tickets as $t)
        <tr>
            <td style="min-width:260px">
                <a href="{{ route('tickets.show', ($mode ?? '') === 'mine' ? ['ticket' => $t, 'from' => 'mine'] : $t) }}" class="ticket-link">{{ $t->ticket_no }}</a>
                <div class="ticket-sub">{{ \Illuminate\Support\Str::limit($t->subject, 64) }}</div>
            </td>
            <td>{{ $t->department->name ?? '' }}</td>
            <td>{{ $t->category->name ?? '' }}@if($t->subcategory)<div class="ticket-sub">{{ $t->subcategory->name }}</div>@endif</td>
            @unless($mine)
            <td>
                @if($t->assignee)
                    <span class="d-inline-flex align-items-center gap-2"><x-avatar :name="$t->assignee->name"/> {{ $t->assignee->name }}</span>
                    @php($sup = $t->relationLoaded('team') ? $t->team->where('role', 'SUPPORT') : collect())
                    @if($sup->isNotEmpty())<span class="pill pill-secondary" title="Supporting: {{ $sup->map(fn ($m) => $m->employee->name)->implode(', ') }}">+{{ $sup->count() }}</span>@endif
                @else <span class="text-muted">Unassigned</span> @endif
            </td>
            @endunless
            @if(($mode ?? '') === 'tasks')
                <td><span class="pill pill-{{ $t->assigned_to === auth()->id() ? 'primary' : 'secondary' }}">{{ $t->assigned_to === auth()->id() ? 'Primary' : 'Support' }}</span></td>
            @endif
            @unless($mine)
                <td><span class="pill pill-{{ $t->status->color ?? 'secondary' }}">{{ $t->status->name }}</span></td>
            @endunless
            <td class="text-nowrap">{{ $t->due_date?->format('d M') ?? '—' }}</td>
            <td class="text-nowrap text-muted">{{ $t->created_at->format('d M Y H:i') }}</td>
        </tr>
    @empty
        <tr><td colspan="{{ $mine ? 4 : (($mode ?? '') === 'tasks' ? 8 : 7) }}" class="text-center text-muted py-5">No requests found.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
</div>
