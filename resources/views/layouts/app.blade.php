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
            <span class="brand-name">JOPLC.<small>IT Service Desk</small></span>
        </a>

        <ul class="nav flex-column gap-1" id="sideMenu">
            @php
                $authUser = auth()->user();
                $canWork = $authUser->hasPermission('ticket.work');
                $mgmtOpen = request()->has('unassigned') || request()->routeIs('board.index', 'attendance.index', 'attendance.pdf', 'reports.*');
                $cfgOpen = request()->routeIs('admin.lookups');
                $invOpen = request()->routeIs('inv.*') && ! request()->routeIs('inv.mine');
                $adminOpen = request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.settings*', 'admin.audit', 'admin.logins');
            @endphp

            @can('menu.dashboard')
            <li><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><x-icon name="home"/> Dashboard</a></li>
            @endcan

            @can('menu.new_request')
                <li><a class="nav-link {{ request()->routeIs('tickets.create') ? 'active' : '' }}" href="{{ route('tickets.create') }}"><x-icon name="plus"/> New Request</a></li>
            @endcan
            @if($canWork)
                @can('menu.all_requests')
                    <li><a class="nav-link {{ request()->routeIs('tickets.index') && ! request()->has('unassigned') ? 'active' : '' }}" href="{{ route('tickets.index') }}"><x-icon name="list"/> All Requests</a></li>
                @endcan
                @can('menu.my_requests')
                <li><a class="nav-link {{ request()->routeIs('tickets.mine') ? 'active' : '' }}" href="{{ route('tickets.mine') }}"><x-icon name="user"/> My Requests</a></li>
                @endcan
                @can('menu.my_tasks')
                @php($openTasks = \App\Models\Ticket::involving($authUser)->activeTask()->count())
                <li><a class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                    <x-icon name="clipboard"/> My Tasks @if($openTasks)<span class="badge bg-primary count">{{ $openTasks }}</span>@endif</a></li>
                @endcan
                @can('menu.completed_tasks')
                <li><a class="nav-link {{ request()->routeIs('tasks.completed') ? 'active' : '' }}" href="{{ route('tasks.completed') }}"><x-icon name="check-circle"/> Completed Tasks</a></li>
                @endcan
            @else
                @can('menu.all_requests')
                <li><a class="nav-link {{ request()->routeIs('tickets.index', 'tickets.show') && ! request()->has('unassigned') ? 'active' : '' }}" href="{{ route('tickets.index') }}"><x-icon name="list"/> All Requests</a></li>
                @elsecan('menu.my_requests')
                <li><a class="nav-link {{ request()->routeIs('tickets.index', 'tickets.show') && ! request()->has('unassigned') ? 'active' : '' }}" href="{{ route('tickets.index') }}"><x-icon name="list"/> My Requests</a></li>
                @endcan
            @endif
            @can('menu.my_equipment')
                <li><a class="nav-link {{ request()->routeIs('inv.mine') ? 'active' : '' }}" href="{{ route('inv.mine') }}"><x-icon name="list"/> My Equipment</a></li>
            @endcan
            @can('menu.my_attendance')
                <li><a class="nav-link {{ request()->routeIs('attendance.mine') ? 'active' : '' }}" href="{{ route('attendance.mine') }}"><x-icon name="clock"/> My Attendance</a></li>
            @endcan
            @can('menu.notifications')
            <li><a id="navNotif" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                <x-icon name="bell"/> Notifications @if($unread)<span class="badge bg-danger count">{{ $unread }}</span>@endif</a></li>
            @endcan

            {{-- Management --}}
            @canany(['menu.unassigned', 'menu.board', 'menu.it_attendance', 'menu.reports'])
                <x-nav-group id="mgmt" icon="shield" label="Management" :open="$mgmtOpen">
                    @can('menu.unassigned')
                        <li><a class="nav-link {{ request()->has('unassigned') ? 'active' : '' }}" href="{{ route('tickets.index', ['unassigned' => 1]) }}"><x-icon name="inbox"/> Unassigned Queue</a></li>
                    @endcan
                    @can('menu.board')
                        <li><a class="nav-link {{ request()->routeIs('board.index') ? 'active' : '' }}" href="{{ route('board.index') }}"><x-icon name="users"/> Assignment Board</a></li>
                    @endcan
                    @can('menu.it_attendance')
                        <li><a class="nav-link {{ request()->routeIs('attendance.index', 'attendance.pdf') ? 'active' : '' }}" href="{{ route('attendance.index') }}"><x-icon name="clock"/> IT Attendance</a></li>
                    @endcan
                    @can('menu.reports')
                        <li><a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}"><x-icon name="chart"/> Reports</a></li>
                    @endcan
                </x-nav-group>
            @endcanany

            {{-- IT Inventory --}}
            @canany(['menu.inv_dashboard', 'menu.inv_equipment', 'menu.inv_allocations', 'menu.inv_receives', 'menu.inv_records', 'menu.inv_setup'])
                <x-nav-group id="inv" icon="box" label="IT Inventory" :open="$invOpen">
                    @can('menu.inv_dashboard')
                        <li><a class="nav-link {{ request()->routeIs('inv.dashboard') ? 'active' : '' }}" href="{{ route('inv.dashboard') }}"><x-icon name="home"/> Dashboard</a></li>
                    @endcan
                    @can('menu.inv_equipment')
                        <li><a class="nav-link {{ request()->routeIs('inv.equipment.*') ? 'active' : '' }}" href="{{ route('inv.equipment.index') }}"><x-icon name="box"/> Equipment &amp; Stock</a></li>
                    @endcan
                    @can('menu.inv_allocations')
                        <li><a class="nav-link {{ request()->routeIs('inv.allocations.*') ? 'active' : '' }}" href="{{ route('inv.allocations.entries') }}"><x-icon name="users"/> Allocations</a></li>
                    @endcan
                    @can('menu.inv_receives')
                        <li><a class="nav-link {{ request()->routeIs('inv.receive*') ? 'active' : '' }}" href="{{ route('inv.receives') }}"><x-icon name="inbox"/> Receives</a></li>
                    @endcan
                    @can('menu.inv_records')
                        <li><a class="nav-link {{ request()->routeIs('inv.records') ? 'active' : '' }}" href="{{ route('inv.records') }}"><x-icon name="clipboard"/> Records</a></li>
                    @endcan
                    @can('menu.inv_setup')
                        <li><a class="nav-link {{ request()->routeIs('inv.setup*') ? 'active' : '' }}" href="{{ route('inv.setup') }}"><x-icon name="folder"/> Types &amp; Categories</a></li>
                    @endcan
                </x-nav-group>
            @endcanany

            {{-- Configuration --}}
            @can('menu.configuration')
                <li><a class="nav-link {{ request()->routeIs('admin.lookups') ? 'active' : '' }}" href="{{ route('admin.lookups', 'service_types') }}"><x-icon name="folder"/> Configuration</a></li>
            @endcan

            {{-- Administration --}}
            @canany(['menu.users', 'menu.roles', 'menu.settings', 'menu.audit', 'menu.logins'])
                <x-nav-group id="admin" icon="users" label="Administration" :open="$adminOpen">
                    @can('menu.users')
                        <li><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><x-icon name="users"/> Users</a></li>
                    @endcan
                    @can('menu.roles')
                        <li><a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><x-icon name="key"/> Roles &amp; Permissions</a></li>
                    @endcan
                    @can('menu.settings')
                        <li><a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}"><x-icon name="sliders"/> System Settings</a></li>
                    @endcan
                    @can('menu.audit')
                        <li><a class="nav-link {{ request()->routeIs('admin.audit') ? 'active' : '' }}" href="{{ route('admin.audit') }}"><x-icon name="activity"/> Audit Log</a></li>
                    @endcan
                    @can('menu.logins')
                        <li><a class="nav-link {{ request()->routeIs('admin.logins') ? 'active' : '' }}" href="{{ route('admin.logins') }}"><x-icon name="shield"/> Login History</a></li>
                    @endcan
                </x-nav-group>
            @endcanany
        </ul>

    </div>
</aside>

<div class="with-sidebar">
    <header class="topbar">
        <button class="btn-icon d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-label="Menu"><x-icon name="menu"/></button>
        <h1 class="page-title">@yield('title', 'IT Service Desk')</h1>
        <div class="company d-none d-sm-block">Jamuna Oil PLC.</div>
        <div class="ms-auto d-flex align-items-center gap-2">
            <button type="button" id="deskNotif" class="btn btn-sm btn-outline-light d-none" title="Show a desktop notification when a new one arrives">Enable desktop alerts</button>
            <button class="btn-icon" id="themeToggle" type="button" title="Light / dark" aria-label="Toggle theme"><x-icon name="moon"/></button>
            <a id="topNotif" class="btn-icon" href="{{ route('notifications.index') }}" title="Notifications"><x-icon name="bell"/>@if($unread)<span class="dot">{{ $unread }}</span>@endif</a>
            <a href="{{ route('profile.password') }}" class="top-user d-none d-md-flex text-decoration-none" title="My account">
                <x-avatar :name="auth()->user()->name" :user="auth()->user()" class="avatar-lg"/>
                <div class="lh-sm">
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <div class="small text-muted">{{ auth()->user()->role_names }}</div>
                </div>
            </a>
            <a class="btn-icon" href="{{ route('profile.password') }}" title="Change password" aria-label="Change password"><x-icon name="key"/></a>
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
    @hasSection('nofooter')@else<footer class="app-footer">Developed by MIS &amp; IT Department of JOPLC.</footer>@endif
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
@auth
<script>
// Automatic sign-out after {{ (int) config('itsm.inactivity_minutes', 15) }} minutes without activity (any open tab counts).
(function () {
    var LIMIT = {{ (int) config('itsm.inactivity_minutes', 15) }} * 60000, WARN = 60000, PING = 60000, KEY = 'itsm-last-activity';
    var loginUrl = @json(route('login') . '?timeout=1'), logoutUrl = @json(route('logout')), pingUrl = @json(route('session.keepalive'));
    var csrf = document.querySelector('meta[name=csrf-token]').content;
    var start = Date.now(), lastPing = start, lastSeen = 0, warned = false, done = false;

    function stamp() { try { localStorage.setItem(KEY, String(Date.now())); } catch (e) {} }
    function lastActivity() {
        try { return parseInt(localStorage.getItem(KEY) || '0', 10) || start; } catch (e) { return start; }
    }
    function activity() {
        var now = Date.now();
        if (now - lastSeen < 5000) return;          // throttle
        lastSeen = now; warned = false; stamp();
        if (now - lastPing > PING) {                // tell the server the user is still here
            lastPing = now;
            fetch(pingUrl, { method: 'POST', credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' } }).catch(function () {});
        }
    }
    function signOut() {
        if (done) return; done = true;
        fetch(logoutUrl, { method: 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrf }, body: new URLSearchParams({ idle: '1' }) })
            .catch(function () {})
            .then(function () { window.location.href = loginUrl; });
    }
    stamp();
    ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'click'].forEach(function (ev) {
        window.addEventListener(ev, activity, { passive: true });
    });
    setInterval(function () {
        var idle = Date.now() - lastActivity();
        if (idle >= LIMIT) signOut();
        else if (idle >= LIMIT - WARN && !warned) {
            warned = true;
            window.toast('You will be signed out in 1 minute because of inactivity. Move the mouse or press a key to stay signed in.', 'warning');
        }
    }, 5000);
})();
</script>
@endauth
@auth
<script>
// Live notifications: poll the server, update the counters, pop a toast for each new notification, refresh the list when it is open.
(function () {
    var url = @json(route('notifications.poll')), every = 10000, since = {{ now()->timestamp }} - 5, seen = {}, busy = false, stopped = false;
    function badge(el, cls, n) {
        if (!el) return;
        var b = el.querySelector('.' + cls.split(' ')[0]);
        if (n > 0) { if (!b) { b = document.createElement('span'); b.className = cls; el.appendChild(b); } b.textContent = n; }
        else if (b) b.remove();
    }
    function show(n) {
        var el = document.createElement('div');
        el.className = 'toast align-items-center text-bg-primary border-0'; el.setAttribute('role', 'alert');
        el.innerHTML = '<div class="d-flex"><a class="toast-body text-white text-decoration-none flex-grow-1"></a><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
        var a = el.querySelector('a'); a.textContent = n.message; a.href = n.url;
        document.getElementById('toasts').appendChild(el);
        new bootstrap.Toast(el, { delay: 8000 }).show();
        el.addEventListener('hidden.bs.toast', function () { el.remove(); });
    }
    // Desktop (operating-system) notification: needs the user's permission, and a secure page (https or localhost)
    // Over plain http the browser refuses desktop pop-ups (nothing a web page can change), so there the same button turns on
    // the alternatives that do work: a sound and a flashing tab title.
    var dbtn = document.getElementById('deskNotif'), secure = window.isSecureContext !== false, canDesk = secure && 'Notification' in window, ctx = null, flashTimer = null, baseTitle = document.title;
    function lsGet(k) { try { return localStorage.getItem(k); } catch (e) { return null; } }
    function lsSet(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }
    function audio() { try { var A = window.AudioContext || window.webkitAudioContext; if (A && !ctx) ctx = new A(); if (ctx && ctx.state === 'suspended') ctx.resume(); } catch (e) {} return ctx; }
    function chime() {
        if (lsGet('itsm-alerts') !== '1' || !audio()) return;
        try {
            [880, 1175].forEach(function (f, i) {
                var o = ctx.createOscillator(), g = ctx.createGain(), t = ctx.currentTime + i * 0.18;
                o.type = 'sine'; o.frequency.value = f; g.gain.setValueAtTime(0.0001, t); g.gain.exponentialRampToValueAtTime(0.25, t + 0.02); g.gain.exponentialRampToValueAtTime(0.0001, t + 0.3);
                o.connect(g); g.connect(ctx.destination); o.start(t); o.stop(t + 0.32);
            });
        } catch (e) {}
    }
    function flashTitle(n) {
        if (!document.hidden && document.hasFocus()) return;
        if (flashTimer) clearInterval(flashTimer);
        var on = false;
        flashTimer = setInterval(function () { on = !on; document.title = on ? '\uD83D\uDD14 ' + n.message : baseTitle; }, 1000);
    }
    function stopFlash() { if (flashTimer) { clearInterval(flashTimer); flashTimer = null; document.title = baseTitle; } }
    window.addEventListener('focus', stopFlash); document.addEventListener('visibilitychange', function () { if (!document.hidden) stopFlash(); });
    function deskState() {
        if (!dbtn) return;
        var need = canDesk ? Notification.permission === 'default' : lsGet('itsm-alerts') !== '1';
        dbtn.textContent = canDesk ? 'Enable desktop alerts' : 'Enable sound alerts';
        dbtn.classList.toggle('d-none', !need);
    }
    if (dbtn) {
        dbtn.addEventListener('click', function () {
            if (canDesk) { Notification.requestPermission().then(function () { lsSet('itsm-alerts', '1'); audio(); deskState(); }); return; }
            lsSet('itsm-alerts', '1'); audio(); chime(); deskState();
            window.toast('Sound and tab alerts are on. Desktop pop-ups are not available over http (see README).', 'info');
        });
        deskState();
    }
    if (lsGet('itsm-alerts') === '1') document.addEventListener('click', audio, { once: true });
    function desktop(n) {
        chime(); flashTitle(n);
        if (!canDesk || Notification.permission !== 'granted' || (!document.hidden && document.hasFocus())) return;   // only when the user is not looking at the page
        try {
            var d = new Notification('JOPLC IT Service Desk', { body: n.message, tag: n.id, icon: @json(asset('images/joplc_logo.png')) });
            d.onclick = function () { window.focus(); window.location.href = n.url; d.close(); };
        } catch (e) {}
    }
    function refreshList() {
        var box = document.getElementById('notifList');
        if (!box) return;
        fetch(location.href, { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(function (r) { return r.text(); }).then(function (h) {
            var f = new DOMParser().parseFromString(h, 'text/html').getElementById('notifList');
            if (f) box.innerHTML = f.innerHTML;
        }).catch(function () {});
    }
    function tick() {
        if (busy || stopped) return;   // keeps polling in a background tab so desktop alerts still arrive
        busy = true;
        fetch(url + '?since=' + since, { credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { if (r.status === 401 || r.status === 419) { stopped = true; throw 0; } return r.json(); })
            .then(function (d) {
                since = d.now - 5;
                badge(document.getElementById('navNotif'), 'badge bg-danger count', d.unread);
                badge(document.getElementById('topNotif'), 'dot', d.unread);
                var fresh = d.items.filter(function (n) { return !seen[n.id]; });
                fresh.reverse().forEach(function (n) { seen[n.id] = 1; show(n); desktop(n); });
                if (fresh.length) refreshList();
            })
            .catch(function () {}).then(function () { busy = false; });
    }
    setInterval(tick, every);
    document.addEventListener('visibilitychange', function () { if (!document.hidden) tick(); });
    tick();
})();
</script>
@endauth
@stack('scripts')
</body>
</html>
