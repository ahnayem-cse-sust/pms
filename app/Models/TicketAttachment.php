<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $guarded = [];
    protected $casts = ['is_internal' => 'boolean'];
    public function uploader() { return $this->belongsTo(User::class, 'uploaded_by'); }
    public function ticket() { return $this->belongsTo(Ticket::class); }
}
