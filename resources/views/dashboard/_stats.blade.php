@php
    $map = [
        'Total' => ['list', 'indigo'], 'New' => ['inbox', 'blue'], 'Assigned' => ['users', 'cyan'],
        'In Progress' => ['activity', 'amber'], 'Waiting' => ['clock', 'slate'], 'Resolved' => ['check', 'green'],
        'Closed' => ['shield', 'dark'], 'SLA Breached' => ['alert', 'red'],
        'New / Assigned' => ['inbox', 'blue'], 'Overdue' => ['alert', 'red'],
    ];
@endphp
<div class="stat-grid">
    @foreach($stats as $label => $n)
        @php([$icon, $tone] = $map[$label] ?? ['list', 'indigo'])
        <div class="stat-card tone-{{ $tone }} {{ $tone === 'red' && $n ? 'alert-on' : '' }}">
            <div class="stat-icon"><x-icon :name="$icon" :size="22"/></div>
            <div><div class="stat-label">{{ $label }}</div><div class="stat-value">{{ $n }}</div></div>
        </div>
    @endforeach
</div>
