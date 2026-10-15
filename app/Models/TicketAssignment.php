<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** One IT employee on one request: PRIMARY (accountable) or SUPPORT. */
class TicketAssignment extends Model
{
    public const PRIMARY = 'PRIMARY';
    public const SUPPORT = 'SUPPORT';

    protected $guarded = [];
    protected $casts = ['assigned_at' => 'datetime'];

    protected static function booted(): void
    {
        // keeps the "one primary per request" unique index in step with the role
        static::saving(function (self $m) {
            $m->primary_marker = $m->role === self::PRIMARY ? 1 : null;
        });
    }

    public function ticket() { return $this->belongsTo(Ticket::class); }
    public function employee() { return $this->belongsTo(User::class, 'employee_id'); }
    public function assigner() { return $this->belongsTo(User::class, 'assigned_by'); }
    public function isPrimary(): bool { return $this->role === self::PRIMARY; }
}
