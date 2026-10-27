<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'inv_maintenance';
    protected $guarded = [];
    protected $casts = ['reported_date' => 'date', 'completed_date' => 'date', 'warranty_claim' => 'boolean'];

    public function asset() { return $this->belongsTo(Asset::class); }
    public function creator() { return $this->belongsTo(\App\Models\User::class, 'created_by'); }
    public function getIsOpenAttribute(): bool { return ! in_array($this->status, config('inventory.maintenance_final'), true); }
}
