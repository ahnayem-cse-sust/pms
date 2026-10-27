<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'inv_assignments';
    protected $guarded = [];
    protected $casts = ['assigned_at' => 'datetime', 'returned_at' => 'datetime', 'acknowledged_at' => 'datetime', 'ack_required' => 'boolean'];

    public function asset() { return $this->belongsTo(Asset::class); }
    public function user() { return $this->belongsTo(\App\Models\User::class, 'custodian_user_id'); }
    public function department() { return $this->belongsTo(\App\Models\Department::class, 'custodian_department_id'); }
    public function location() { return $this->belongsTo(Location::class); }
    public function condition() { return $this->belongsTo(Lookup::class, 'condition_id'); }
    public function releasedBy() { return $this->belongsTo(\App\Models\User::class, 'released_by'); }
    public function getHolderAttribute(): string
    {
        return match ($this->custodian_type) { 'EMPLOYEE' => $this->user?->name ?? '—', 'DEPARTMENT' => ($this->department?->name ?? '—').' (dept)', default => $this->location?->name ?? '—' };
    }
}
