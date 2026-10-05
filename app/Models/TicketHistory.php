<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    protected $guarded = [];
    protected $table = 'ticket_history';
    public $timestamps = false;
    protected $casts = ['created_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
}
