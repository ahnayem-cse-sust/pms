<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Disposal extends Model
{
    protected $table = 'inv_disposals';
    protected $guarded = [];
    protected $casts = ['proposed_date' => 'date', 'disposal_date' => 'date', 'approved_at' => 'datetime'];

    public function asset() { return $this->belongsTo(Asset::class); }
    public function proposer() { return $this->belongsTo(\App\Models\User::class, 'proposed_by'); }
    public function approver() { return $this->belongsTo(\App\Models\User::class, 'approved_by'); }
}
