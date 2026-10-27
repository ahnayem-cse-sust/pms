<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockBalance extends Model
{
    protected $table = 'inv_stock_balances';
    protected $guarded = [];

    public function item() { return $this->belongsTo(Item::class); }
    public function location() { return $this->belongsTo(Location::class); }
}
