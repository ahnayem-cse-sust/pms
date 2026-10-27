<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'inv_receipts';
    protected $guarded = [];
    protected $casts = ['receipt_date' => 'date', 'approved_at' => 'datetime', 'posted_at' => 'datetime'];

    public function lines() { return $this->hasMany(ReceiptLine::class); }
    public function supplier() { return $this->belongsTo(Lookup::class, 'supplier_id'); }
    public function location() { return $this->belongsTo(Location::class); }
    public function preparer() { return $this->belongsTo(\App\Models\User::class, 'prepared_by'); }
    public function approver() { return $this->belongsTo(\App\Models\User::class, 'approved_by'); }
    public function receiver() { return $this->belongsTo(\App\Models\User::class, 'received_by'); }
}
