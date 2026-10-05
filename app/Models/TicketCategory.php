<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $guarded = [];
    public function subcategories() { return $this->hasMany(TicketSubcategory::class, 'category_id'); }
}
