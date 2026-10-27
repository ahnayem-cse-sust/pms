<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'inv_categories';
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean', 'is_serialized' => 'boolean', 'level' => 'integer'];

    public function parent() { return $this->belongsTo(self::class, 'parent_id'); }
    public function children() { return $this->hasMany(self::class, 'parent_id'); }
}
