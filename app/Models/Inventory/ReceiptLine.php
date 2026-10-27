<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ReceiptLine extends Model
{
    protected $table = 'inv_receipt_lines';
    protected $guarded = [];

    public $timestamps = false;
    public function item() { return $this->belongsTo(Item::class); }
}
