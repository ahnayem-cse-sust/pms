<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'inv_equipment';
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean', 'stock_qty' => 'decimal:2', 'min_stock' => 'decimal:2'];

    public function assetType() { return $this->belongsTo(Category::class, 'asset_type_id'); }
    public function category() { return $this->belongsTo(Category::class); }
    public function subcategory() { return $this->belongsTo(Category::class, 'subcategory_id'); }
    public function movements() { return $this->hasMany(Movement::class)->latest('id'); }
    /** "Asset type › Category › Sub category" for display. */
    public function getClassificationAttribute(): string
    {
        return collect([$this->assetType?->name, $this->category?->name, $this->subcategory?->name])->filter()->implode(' › ');
    }
    /** True when the equipment's category is marked serialisable (each unit has a serial number). */
    public function getIsSerializedAttribute(): bool { return (bool) $this->category?->is_serialized; }
    public function getIsLowAttribute(): bool { return (float) $this->min_stock > 0 && (float) $this->stock_qty <= (float) $this->min_stock; }
}
