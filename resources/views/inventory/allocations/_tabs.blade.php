<ul class="nav nav-pills mb-3">
    <li class="nav-item"><a class="nav-link {{ request()->routeIs('inv.allocations.index') ? 'active' : '' }}" href="{{ route('inv.allocations.index') }}">Who has what</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->routeIs('inv.allocations.entries') ? 'active' : '' }}" href="{{ route('inv.allocations.entries') }}">Allocation records</a></li>
</ul>
