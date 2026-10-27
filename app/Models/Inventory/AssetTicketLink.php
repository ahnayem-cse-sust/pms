<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class AssetTicketLink extends Model
{
    protected $table = 'inv_asset_ticket_links';
    protected $guarded = [];
    protected $casts = ['created_at' => 'datetime'];

    public $timestamps = false;
    public function ticket() { return $this->belongsTo(\App\Models\Ticket::class); }
    public function asset() { return $this->belongsTo(Asset::class); }
}
