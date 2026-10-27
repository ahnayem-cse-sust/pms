<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'inv_transfers';
    protected $guarded = [];
    protected $casts = ['effective_date' => 'date', 'approved_at' => 'datetime', 'posted_at' => 'datetime', 'acknowledged_at' => 'datetime'];

    public function asset() { return $this->belongsTo(Asset::class); }
    public function item() { return $this->belongsTo(Item::class); }
    public function requester() { return $this->belongsTo(\App\Models\User::class, 'requested_by'); }
    public function approver() { return $this->belongsTo(\App\Models\User::class, 'approved_by'); }
    public function fromUser() { return $this->belongsTo(\App\Models\User::class, 'from_user_id'); }
    public function toUser() { return $this->belongsTo(\App\Models\User::class, 'to_user_id'); }
    public function fromDepartment() { return $this->belongsTo(\App\Models\Department::class, 'from_department_id'); }
    public function toDepartment() { return $this->belongsTo(\App\Models\Department::class, 'to_department_id'); }
    public function fromLocation() { return $this->belongsTo(Location::class, 'from_location_id'); }
    public function toLocation() { return $this->belongsTo(Location::class, 'to_location_id'); }
    public function condition() { return $this->belongsTo(Lookup::class, 'condition_id'); }
    public function party(string $side): string
    {
        return match ($this->{$side.'_type'}) {
            'EMPLOYEE' => $this->{$side.'User'}?->name ?? '—',
            'DEPARTMENT' => ($this->{$side.'Department'}?->name ?? '—').' (dept)',
            'LOCATION' => $this->{$side.'Location'}?->name ?? '—',
            default => '—',
        };
    }
}
