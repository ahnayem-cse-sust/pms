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

    /** Icon (see components/icon) for a movement type. */
    public static function icon(?string $code): string
    {
        return ['RECEIVE' => 'arrow-down-left', 'OPENING' => 'clock', 'ALLOCATE' => 'arrow-up-right', 'RETURN' => 'corner-up-left', 'ADJUST' => 'sliders'][$code] ?? 'list';
    }

    /** Colour tone (success / primary / info / warning / secondary) for a movement type, same as its pill. */
    public static function tone(?string $code): string
    {
        return (string) config('inventory.pills.'.$code, 'secondary');
    }

    /** out = nothing left, low = at or under the minimum level, ok = otherwise. */
    public static function state($stock, $min): string
    {
        $s = (float) $stock; $m = (float) $min;

        return $s <= 0 ? 'out' : ($m > 0 && $s <= $m ? 'low' : 'ok');
    }

    /** Fill (0-100) of the stock meter: the minimum level sits at the half-way mark, so a full bar means twice the minimum or more. */
    public static function fill($stock, $min): int
    {
        $m = (float) $min;

        return $m > 0 ? (int) max(0, min(100, round((float) $stock / ($m * 2) * 100))) : 0;
    }
}
