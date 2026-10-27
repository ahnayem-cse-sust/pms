<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = [];

    protected $table = 'inv_stock';
    public function product() { return $this->belongsTo(Product::class); }
    public function location() { return $this->belongsTo(Location::class); }
}
