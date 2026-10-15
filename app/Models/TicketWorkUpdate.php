<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** An individual employee's progress note on a request (IT staff only). */
class TicketWorkUpdate extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['created_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
}
