@php
    $tone = ['ASSIGNED' => 'secondary', 'IN_PROGRESS' => 'warning', 'WAITING' => 'info', 'DONE' => 'success'];
@endphp
@forelse($team as $m)
    <div class="team-row">
        <x-avatar :name="$m->employee->name" :user="$m->employee"/>
        <div class="flex-grow-1 lh-sm">
            <div class="fw-semibold">{{ $m->employee->name }}</div>
            <div class="small text-muted">{{ $m->role === 'PRIMARY' ? 'Primary' : 'Support' }}@if($seeInternal) · {{ $workStatuses[$m->work_status] ?? $m->work_status }}@endif</div>
        </div>
        @if($seeInternal)<span class="pill pill-{{ $tone[$m->work_status] ?? 'secondary' }}">{{ $workStatuses[$m->work_status] ?? $m->work_status }}</span>@endif
    </div>
@empty
    <div class="text-muted small">Not assigned yet.</div>
@endforelse
