<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Stocktake extends Model
{
    protected $table = 'inv_stocktakes';
    protected $guarded = [];
    protected $casts = ['count_date' => 'date', 'approved_at' => 'datetime'];

    public function lines() { return $this->hasMany(StocktakeLine::class); }
    public function location() { return $this->belongsTo(Location::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function creator() { return $this->belongsTo(\App\Models\User::class, 'created_by'); }
    public function approver() { return $this->belongsTo(\App\Models\User::class, 'approved_by'); }
}
