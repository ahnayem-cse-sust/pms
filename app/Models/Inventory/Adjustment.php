<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    protected $table = 'inv_adjustments';
    protected $guarded = [];
    protected $casts = ['posting_date' => 'date', 'approved_at' => 'datetime'];

    public function item() { return $this->belongsTo(Item::class); }
    public function location() { return $this->belongsTo(Location::class); }
    public function preparer() { return $this->belongsTo(\App\Models\User::class, 'prepared_by'); }
    public function approver() { return $this->belongsTo(\App\Models\User::class, 'approved_by'); }
}
