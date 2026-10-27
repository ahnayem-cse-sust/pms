<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $table = 'inv_stock_transactions';
    protected $guarded = [];
    protected $casts = ['posting_date' => 'date', 'created_at' => 'datetime'];

    public $timestamps = false;
    public function item() { return $this->belongsTo(Item::class); }
    public function location() { return $this->belongsTo(Location::class); }
    public function creator() { return $this->belongsTo(\App\Models\User::class, 'created_by'); }
}
