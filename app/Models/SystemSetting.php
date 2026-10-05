<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $guarded = [];

    public static function get(string $key, $default = null)
    {
        $v = static::where('key', $key)->value('value');
        return $v ?? $default;
    }
}
