@props(['name' => '?', 'user' => null])
@php
    $parts = preg_split('/\s+/', trim((string) $name));
    $ini = mb_strtoupper(mb_substr($parts[0] ?? '?', 0, 1) . (isset($parts[1]) ? mb_substr($parts[1], 0, 1) : ''));
    $hue = crc32((string) $name) % 360;
@endphp
@if($user && $user->avatar_path)
    <img {{ $attributes->merge(['class' => 'avatar avatar-img']) }} src="{{ route('avatar.show', $user) }}?v={{ optional($user->updated_at)->timestamp }}" alt="{{ $name }}" title="{{ $name }}">
@else
    <span {{ $attributes->merge(['class' => 'avatar']) }} style="--h: {{ $hue }}" title="{{ $name }}">{{ $ini }}</span>
@endif
