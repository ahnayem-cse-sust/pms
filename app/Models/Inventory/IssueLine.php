<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class IssueLine extends Model
{
    protected $table = 'inv_issue_lines';
    protected $guarded = [];

    public $timestamps = false;
    public function item() { return $this->belongsTo(Item::class); }
    public function asset() { return $this->belongsTo(Asset::class); }
}
