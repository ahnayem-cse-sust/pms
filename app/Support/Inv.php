<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

/** Small view helpers for the inventory module. */
class Inv
{
    public static function label(?string $code): string
    {
        return $code ? (config('inventory.movement_types.'.$code) ?? ucfirst(strtolower($code))) : '—';
    }

    public static function pill(?string $code): HtmlString
    {
        if (! $code) return new HtmlString('<span class="text-muted">—</span>');
        return new HtmlString('<span class="pill pill-'.e(config('inventory.pills.'.$code, 'secondary')).'">'.e(self::label($code)).'</span>');
    }

    public static function qty($n): string
    {
        return rtrim(rtrim(number_format((float) $n, 2, '.', ''), '0'), '.') ?: '0';
    }
}
