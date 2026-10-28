<div class="inv-tabs">
    <a class="inv-tab {{ request()->routeIs('inv.allocations.entries') ? 'active' : '' }}" href="{{ route('inv.allocations.entries') }}"><x-icon name="clipboard" :size="15"/> Allocation records</a>
    <a class="inv-tab {{ request()->routeIs('inv.allocations.index') ? 'active' : '' }}" href="{{ route('inv.allocations.index') }}"><x-icon name="users" :size="15"/> Who has what</a>
</div>
