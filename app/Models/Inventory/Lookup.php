<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    protected $table = 'inv_lookups';
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOfType($q, string $t) { return $q->where('type', $t); }
}
