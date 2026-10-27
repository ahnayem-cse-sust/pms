<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'inv_items';
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];

    public function category() { return $this->belongsTo(Category::class); }
    public function subcategory() { return $this->belongsTo(Category::class, 'subcategory_id'); }
    public function unit() { return $this->belongsTo(Lookup::class, 'unit_id'); }
    public function brand() { return $this->belongsTo(Lookup::class, 'brand_id'); }
    public function assets() { return $this->hasMany(Asset::class); }
    public function scopeActive($q) { return $q->where('is_active', true); }
    public function getIsAssetAttribute(): bool { return $this->type === 'ASSET'; }
}
