<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAssignment extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $casts = ['created_at' => 'datetime'];
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
    public function assigner() { return $this->belongsTo(User::class, 'assigned_by'); }
}
