@extends('layouts.app')
@section('title', $user->name)
@section('content')
@php
    $isSelf = $user->id === auth()->id();
    $locked = $user->locked_until && $user->locked_until->isFuture();
    $why = $blockers ? 'Has '.implode(', ', $blockers).' – disable the account instead.' : '';
@endphp
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary inv-back"><x-icon name="arrow-left" :size="15"/> Users</a>
    @can('user.update')<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary ms-md-auto inv-back"><x-icon name="edit" :size="15"/> Edit</a>@endcan
    @can('user.delete')@unless($isSelf)<form method="POST" action="{{ route('admin.users.destroy', $user) }}" @class(['ms-md-auto' => ! auth()->user()->can('user.update')]) onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.');">@csrf @method('DELETE')<span @if($why) title="{{ $why }}" @endif><button class="btn btn-outline-danger inv-back" @disabled($why !== '')><x-icon name="trash" :size="15"/> Delete</button></span></form>@endunless @endcan
</div>
<div class="card">
    <div class="inv-hero">
        <x-avatar :name="$user->name" :user="$user" class="avatar-xl"/>
        <div><div class="inv-hero-title">{{ $user->name }}@if($user->is_department_head) <span class="badge text-bg-info align-middle">Head</span>@endif</div><div class="inv-sub">{{ $user->email }}</div></div>
        <div class="ms-auto">
            @if(! $user->is_active)<span class="pill pill-secondary">Disabled</span>
            @elseif($locked)<span class="pill pill-danger">Locked</span>
            @else<span class="pill pill-success">Active</span>@endif
        </div>
    </div>
    @php
        $roles = $user->roles->map(fn ($ro) => '<span class="pill pill-primary me-1">'.e($ro->name).'</span>')->implode('');
        if ($user->hasCustomPermissions()) $roles .= '<span class="pill pill-warning" title="Has individual permissions">+ custom</span>';
        $yes = fn ($v) => $v ? 'Yes' : 'No';
        $pairs = collect([
            ['Employee ID', e($user->employee_id ?: '—')],
            ['Email', e($user->email)],
            ['WhatsApp', e($user->whatsapp ?: '—')],
            ['Roles', $roles ?: '—'],
            ['Department', e($user->department->name ?? '—')],
            ['Designation', e($user->designation->name ?? '—')],
            ['Location', e($user->location->name ?? '—')],
            ['Department head', $yes($user->is_department_head)],
            ['Shown on IT attendance', $yes($user->show_in_attendance)],
            ['Last login', $user->last_login_at ? e($user->last_login_at->format('d M Y h:i A')).($user->last_login_ip ? ' <span class="text-muted fw-normal">('.e($user->last_login_ip).')</span>' : '') : 'Never'],
            ['Password changed', $user->password_changed_at ? e($user->password_changed_at->format('d M Y')) : '—'],
            ['Created', $user->created_at ? e($user->created_at->format('d M Y')) : '—'],
        ]);
        $half = (int) ceil($pairs->count() / 2);   // same number of rows on both sides; an odd total leaves the right side blank
        $left = $pairs->take($half)->values();
        $right = $pairs->slice($half)->values();
    @endphp
    <div class="table-responsive inv-lines">
    <table class="table table-bordered align-middle inv-info mb-0"><tbody>
        @for($i = 0; $i < $half; $i++)
        <tr>
            <th>{{ $left[$i][0] }}</th><td>{!! $left[$i][1] !!}</td>
            @if(isset($right[$i]))<th>{{ $right[$i][0] }}</th><td>{!! $right[$i][1] !!}</td>@else<th></th><td></td>@endif
        </tr>
        @endfor
    </tbody></table>
    </div>
</div>

@php
    $all = collect($permGroups)->flatten(1);
    $nAllowed = $all->where(1, true)->count();
    $nDenied = $all->where(1, false)->count();
@endphp
<div class="card mt-3">
    <div class="inv-history-head d-flex flex-wrap align-items-center gap-2" style="border-top:0">
        <span>Permissions</span>
        <span class="pill pill-success">{{ $nAllowed }} allowed</span><span class="pill pill-danger">{{ $nDenied }} denied</span>
        @if($canEditPermissions)<a href="{{ route('admin.users.permissions', $user) }}" class="btn btn-sm btn-outline-primary ms-auto"><x-icon name="edit" :size="14"/> Edit permissions</a>@endif
    </div>
    <div class="card-body pt-2">
        <div class="perm-legend">
            <span><b>Allowed / Denied</b> – what applies to this user now</span>
            <span><i style="background:#16a34a"></i>allowed for this user only</span>
            <span><i style="background:#dc2626"></i>denied for this user only</span>
            <span>no colour – follows the user's roles</span>
        </div>
        <div class="perm-toolbar">
            <div class="input-icon"><x-icon name="search" :size="15"/><input type="search" id="viewPermSearch" class="form-control form-control-sm" placeholder="Find a permission…"></div>
            <select id="viewPermShow" class="form-select form-select-sm" style="width:auto"><option value="">All</option><option value="allowed">Allowed only</option><option value="denied">Denied only</option></select>
        </div>
        <div class="row g-3">
        @foreach($permGroups as $group => $items)
            <div class="col-md-6 col-xl-4 perm-col">
                <div class="perm-group">
                    <div class="perm-group-h"><span>{{ $group }}</span><span class="text-muted fw-normal text-lowercase">{{ collect($items)->where(1, true)->count() }}/{{ count($items) }} allowed</span></div>
                    @foreach($items as [$label, $allowed, $source])
                        <div class="perm-row {{ $source === 'individual' ? ($allowed ? 'is-allow' : 'is-deny') : '' }}" data-text="{{ strtolower($label) }}" data-state="{{ $allowed ? 'allowed' : 'denied' }}">
                            <span class="small">{{ $label }}</span>
                            <span class="text-nowrap">@if($source === 'individual')<span class="inv-sub me-1">individual</span>@elseif($source === 'role')<span class="inv-sub me-1">role</span>@endif<span class="pill {{ $allowed ? 'pill-success' : 'pill-danger' }}">{{ $allowed ? 'Allowed' : 'Denied' }}</span></span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        </div>
        <div class="text-muted small text-center py-3 d-none" id="viewPermNone">No permission matches.</div>
        @if($user->isRole('admin'))<div class="text-muted small mt-2">A System Administrator always has the full permissions of the role.</div>@endif
    </div>
</div>
@push('scripts')
<script>
(function () {
    var search = document.getElementById('viewPermSearch'), show = document.getElementById('viewPermShow');
    function refresh() {
        var q = search.value.trim().toLowerCase(), st = show.value, visible = 0;
        document.querySelectorAll('.perm-row').forEach(function (r) {
            var ok = r.dataset.text.indexOf(q) > -1 && (!st || r.dataset.state === st);
            r.style.display = ok ? '' : 'none'; if (ok) visible++;
        });
        document.querySelectorAll('.perm-col').forEach(function (c) {
            var any = Array.prototype.some.call(c.querySelectorAll('.perm-row'), function (r) { return r.style.display !== 'none'; });
            c.style.display = any ? '' : 'none';
        });
        document.getElementById('viewPermNone').classList.toggle('d-none', visible > 0);
    }
    search.addEventListener('input', refresh); show.addEventListener('change', refresh);
})();
</script>
@endpush
@endsection
