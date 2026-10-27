<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StocktakeLine extends Model
{
    protected $table = 'inv_stocktake_lines';
    protected $guarded = [];
    protected $casts = ['verified_at' => 'datetime'];

    public $timestamps = false;
    public function item() { return $this->belongsTo(Item::class); }
    public function asset() { return $this->belongsTo(Asset::class); }
    public function location() { return $this->belongsTo(Location::class); }
    /** Quantity lines: physical - system. Asset lines: 1 when not found, 0 when found, null when not yet verified. */
    public function getDiscrepancyAttribute(): ?float
    {
        if ($this->unrecorded_desc) return 1.0;
        if ($this->asset_id) return $this->physical_status ? ($this->physical_status === 'FOUND' ? 0.0 : 1.0) : null;
        return $this->physical_qty === null ? null : (float) $this->physical_qty - (float) $this->system_qty;
    }
}
