<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'inv_locations';
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];


}
