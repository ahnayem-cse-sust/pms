@props(['name' => '?'])
@php
    $parts = preg_split('/\s+/', trim((string) $name));
    $ini = mb_strtoupper(mb_substr($parts[0] ?? '?', 0, 1) . (isset($parts[1]) ? mb_substr($parts[1], 0, 1) : ''));
    $hue = crc32((string) $name) % 360;
@endphp
<span {{ $attributes->merge(['class' => 'avatar']) }} style="--h: {{ $hue }}" title="{{ $name }}">{{ $ini }}</span>
