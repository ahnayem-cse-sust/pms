<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Old one-row-per-assignment-change trail (kept for history; the team now lives in ticket_assignments). */
class TicketAssignmentLog extends Model
{
    protected $table = 'ticket_assignment_log';
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['created_at' => 'datetime'];
}
