<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class AssetEvent extends Model
{
    protected $table = 'inv_asset_events';
    protected $guarded = [];
    protected $casts = ['details' => 'array', 'created_at' => 'datetime'];

    public $timestamps = false;
    public function user() { return $this->belongsTo(\App\Models\User::class); }
}
