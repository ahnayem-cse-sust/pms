<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IT Service Desk') – JOPLC</title>
    <script>try{var t=localStorage.getItem('itsm-theme');if(t)document.documentElement.setAttribute('data-bs-theme',t);}catch(e){}</script>
    <link rel="icon" type="image/png" href="{{ asset('images/joplc_logo.png') }}">
    <link href="{{ asset('vendor/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/itsm.css') }}" rel="stylesheet">
</head>
<body>
@auth
@php
    $unread = auth()->user()->unreadNotifications()->count();
@endphp

<aside id="sidebar" class="offcanvas-lg offcanvas-start d-flex flex-column" tabindex="-1">
    <div class="offcanvas-header d-lg-none">
        <h6 class="offcanvas-title">Menu</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-3">
        <a href="{{ route('dashboard') }}" class="brand">
            <img src="{{ asset('images/joplc_logo.png') }}" alt="JOPLC" class="brand-logo">
            <span class="brand-name">JOPLC<small>IT Service Desk</small></span>
        </a>

        <ul class="nav flex-column gap-1">
            <li><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><x-icon name="home"/> Dashboard</a></li>

            @can('ticket.create')
                <li><a class="nav-link {{ request()->routeIs('tickets.create') ? 'active' : '' }}" href="{{ route('tickets.create') }}"><x-icon name="plus"/> New Request</a></li>
            @endcan
            <li><a class="nav-link {{ request()->routeIs('tickets.index', 'tickets.show') && ! request()->has('unassigned') ? 'active' : '' }}" href="{{ route('tickets.index') }}">
                <x-icon name="list"/> {{ auth()->user()->hasPermission('ticket.view.all') ? 'All Requests' : 'My Requests' }}</a></li>
            @can('ticket.assign')
                <li><a class="nav-link {{ request()->has('unassigned') ? 'active' : '' }}" href="{{ route('tickets.index', ['unassigned' => 1]) }}"><x-icon name="inbox"/> Unassigned Queue</a></li>
            @endcan
            <li><a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                <x-icon name="bell"/> Notifications @if($unread)<span class="badge bg-danger count">{{ $unread }}</span>@endif</a></li>

            @can('report.view')
                <li class="nav-section">Management</li>
                <li><a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}"><x-icon name="chart"/> Reports</a></li>
            @endcan

            @canany(['user.manage', 'lookup.manage', 'audit.view'])
                <li class="nav-section">Administration</li>
                @can('user.manage')
                    <li><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><x-icon name="users"/> Users</a></li>
                    <li><a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}"><x-icon name="sliders"/> System Settings</a></li>
                @endcan
                @can('lookup.manage')
                    @php($cfgActive = request()->routeIs('admin.lookups'))
                    <li>
                        <a class="nav-link {{ $cfgActive ? 'active' : '' }}" data-bs-toggle="collapse" href="#cfgMenu" role="button" aria-expanded="{{ $cfgActive ? 'true' : 'false' }}">
                            <x-icon name="folder"/> Configuration
                        </a>
                        <ul class="nav flex-column sub collapse {{ $cfgActive ? 'show' : '' }}" id="cfgMenu">
                            @foreach(['categories' => 'Categories', 'subcategories' => 'Sub-categories', 'departments' => 'Departments', 'designations' => 'Designations', 'locations' => 'Locations'] as $key => $label)
                                <li><a class="nav-link {{ request()->is('admin/lookups/'.$key) ? 'active' : '' }}" href="{{ route('admin.lookups', $key) }}">{{ $label }}</a></li>
                            @endforeach
                            @can('settings.manage')
                                <li><a class="nav-link {{ request()->is('admin/lookups/priorities') ? 'active' : '' }}" href="{{ route('admin.lookups', 'priorities') }}">Priorities &amp; SLA</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('audit.view')
                    <li><a class="nav-link {{ request()->routeIs('admin.audit') ? 'active' : '' }}" href="{{ route('admin.audit') }}"><x-icon name="activity"/> Audit Log</a></li>
                    <li><a class="nav-link {{ request()->routeIs('admin.logins') ? 'active' : '' }}" href="{{ route('admin.logins') }}"><x-icon name="shield"/> Login History</a></li>
                @endcan
            @endcanany
        </ul>

    </div>
</aside>

<div class="with-sidebar">
    <header class="topbar">
        <button class="btn-icon d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-label="Menu"><x-icon name="menu"/></button>
        <h1 class="page-title">@yield('title', 'IT Service Desk')</h1>
        <div class="company d-none d-sm-block">Jamuna Oil PLC</div>
        <div class="ms-auto d-flex align-items-center gap-2">
            <button class="btn-icon" id="themeToggle" type="button" title="Light / dark" aria-label="Toggle theme"><x-icon name="moon"/></button>
            <a class="btn-icon" href="{{ route('notifications.index') }}" title="Notifications"><x-icon name="bell"/>@if($unread)<span class="dot">{{ $unread }}</span>@endif</a>
            <div class="top-user d-none d-md-flex">
                <x-avatar :name="auth()->user()->name" class="avatar-lg"/>
                <div class="lh-sm">
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <div class="small text-muted">{{ auth()->user()->role?->name }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">@csrf
                <button class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1" title="Sign out"><x-icon name="logout" :size="16"/> <span class="d-none d-sm-inline">Sign out</span></button>
            </form>
        </div>
    </header>
    <main class="content">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        @yield('content')
    </main>
    <footer class="app-footer">Developed by MIS &amp; IT Department, JOPLC.</footer>
</div>
@else
    @if($errors->any())
        <div class="alert alert-danger m-3"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
@endauth

<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toasts"></div>

<script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/js/vue.global.prod.js') }}"></script>
<script>
window.toast = function (msg, type) {
    var el = document.createElement('div');
    el.className = 'toast align-items-center text-bg-' + (type || 'success') + ' border-0';
    el.setAttribute('role', 'alert');
    el.innerHTML = '<div class="d-flex"><div class="toast-body"></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
    el.querySelector('.toast-body').textContent = msg;
    document.getElementById('toasts').appendChild(el);
    var t = new bootstrap.Toast(el, { delay: 4500 }); t.show();
    el.addEventListener('hidden.bs.toast', function () { el.remove(); });
};
(function () {
    var b = document.getElementById('themeToggle');
    if (b) b.addEventListener('click', function () {
        var next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', next);
        try { localStorage.setItem('itsm-theme', next); } catch (e) {}
    });
    @if(session('ok'))
        window.toast(@json(session('ok')), 'success');
    @endif
})();
</script>
@stack('scripts')
</body>
</html>
