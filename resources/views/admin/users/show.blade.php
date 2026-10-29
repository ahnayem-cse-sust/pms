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

@if($user->hasCustomPermissions())
@php
    $labels = collect(config('itsm.permission_catalog'))->flatMap(fn ($g) => $g);
    $hidden = auth()->user()->isRole('admin') ? [] : config('itsm.privileged_permissions', []);
    $names = fn ($keys) => collect((array) $keys)->reject(fn ($k) => in_array($k, $hidden, true))->map(fn ($k) => $labels[$k] ?? $k)->values();
    $allowed = $names($user->extra_permissions);
    $denied = $names($user->denied_permissions);
@endphp
<div class="card mt-3">
    <div class="inv-history-head" style="border-top:0">Individual permissions <span class="inv-count">{{ $allowed->count() + $denied->count() }}</span></div>
    <div class="card-body pt-2">
        <div class="text-muted small mb-2">On top of the roles, for this user only.</div>
        @if($allowed->isNotEmpty())<div class="mb-2"><span class="fw-semibold me-2">Allowed</span>@foreach($allowed as $n)<span class="pill pill-success me-1 mb-1">{{ $n }}</span>@endforeach</div>@endif
        @if($denied->isNotEmpty())<div><span class="fw-semibold me-2">Denied</span>@foreach($denied as $n)<span class="pill pill-danger me-1 mb-1">{{ $n }}</span>@endforeach</div>@endif
    </div>
</div>
@endif
@endsection
