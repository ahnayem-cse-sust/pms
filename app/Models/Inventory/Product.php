<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'inv_products';
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];

    public function category() { return $this->belongsTo(Category::class); }
    public function assets() { return $this->hasMany(Asset::class); }
    public function stock() { return $this->hasMany(Stock::class); }
    public function getIsAssetAttribute(): bool { return $this->type === 'ASSET'; }
    /** Quantity in hand: sum of store balances (consumables) or number of assets in stock (serialized). */
    public function getOnHandAttribute(): float
    {
        return $this->is_asset ? (float) $this->assets()->where('status', 'AVAILABLE')->count() : (float) $this->stock()->sum('qty');
    }
}
