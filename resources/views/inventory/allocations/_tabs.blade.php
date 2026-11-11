{{-- Top bar of the Allocations card: the two views as tabs like the request details page (left), CSV and Allocate equipment (right). Pass: csvRoute, counts. --}}
<div class="inv-bar">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('inv.allocations.index') ? 'active' : '' }}" href="{{ route('inv.allocations.index') }}"><x-icon name="users" :size="16"/> Who has what @isset($counts)<span class="count">{{ $counts['holders'] }}</span>@endisset</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('inv.allocations.entries') ? 'active' : '' }}" href="{{ route('inv.allocations.entries') }}"><x-icon name="clipboard" :size="16"/> Allocation records @isset($counts)<span class="count">{{ $counts['entries'] }}</span>@endisset</a></li>
    </ul>
    <div class="inv-bar-actions">
        <a href="{{ route('inv.allocation_report', array_filter(['from' => request('from'), 'to' => request('to')])) }}" class="btn btn-outline-primary"><x-icon name="clipboard" :size="15"/> Allocation report</a>
        @isset($csvRoute)<a href="{{ route($csvRoute, request()->query() + ['format' => 'csv']) }}" class="btn btn-outline-secondary"><x-icon name="download" :size="15"/> CSV</a>@endisset
        @can('inv.create')<a href="{{ route('inv.allocations.create') }}" class="btn btn-success"><x-icon name="plus" :size="15"/> Allocate equipment</a>@endcan
    </div>
</div>
