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
    /**
     * Equipment that may be picked in Receive Item / Allocations: the item itself is active and so are its asset type,
     * category and sub category (an inactive level hides the equipment under it).
     */
    public function scopeSelectable($q)
    {
        return $q->where('is_active', true)
            ->whereHas('assetType', fn ($t) => $t->where('is_active', true))
            ->whereHas('category', fn ($c) => $c->where('is_active', true))
            ->where(fn ($w) => $w->whereNull('subcategory_id')->orWhereHas('subcategory', fn ($s) => $s->where('is_active', true)));
    }
    /** The opposite of selectable(): the item is inactive, or its asset type, category or sub category is. */
    public function scopeNotLive($q)
    {
        return $q->where(fn ($w) => $w->where('is_active', false)
            ->orWhereDoesntHave('assetType', fn ($t) => $t->where('is_active', true))
            ->orWhereDoesntHave('category', fn ($c) => $c->where('is_active', true))
            ->orWhere(fn ($x) => $x->whereNotNull('subcategory_id')->whereDoesntHave('subcategory', fn ($s) => $s->where('is_active', true))));
    }
    /** Active in practice: the item and every level above it (asset type, category, sub category) are active. */
    public function getIsLiveAttribute(): bool
    {
        return $this->is_active && ($this->assetType?->is_active ?? false) && ($this->category?->is_active ?? false)
            && (! $this->subcategory_id || ($this->subcategory?->is_active ?? false));
    }
    /** "Asset type › Category › Sub category" for display. */
    public function getClassificationAttribute(): string
    {
        return collect([$this->assetType?->name, $this->category?->name, $this->subcategory?->name])->filter()->implode(' › ');
    }
    /** True when the equipment's category is marked serialisable (each unit has a serial number). */
    public function getIsSerializedAttribute(): bool { return (bool) $this->category?->is_serialized; }
    public function getIsLowAttribute(): bool { return (float) $this->min_stock > 0 && (float) $this->stock_qty <= (float) $this->min_stock; }
}
