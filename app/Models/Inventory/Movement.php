<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $table = 'inv_movements';
    protected $guarded = [];
    protected $casts = ['moved_on' => 'date', 'created_at' => 'datetime'];

    public $timestamps = false;
    public function equipment() { return $this->belongsTo(Equipment::class); }
    public function user() { return $this->belongsTo(\App\Models\User::class, 'created_by'); }
    public function holderUser() { return $this->belongsTo(\App\Models\User::class, 'holder_user_id'); }
    public function holderDepartment() { return $this->belongsTo(\App\Models\Department::class, 'holder_department_id'); }
    public function holderSection() { return $this->belongsTo(\App\Models\Section::class, 'holder_section_id'); }
    public function location() { return $this->belongsTo(\App\Models\Location::class, 'location_id'); }
    public function getHolderNameAttribute(): string
    {
        return match ($this->holder_type) {
            'EMPLOYEE' => $this->holderUser?->name ?? '—',
            'DEPARTMENT' => ($this->holderDepartment?->name ?? '—').' (dept)',
            'OFFICE' => ($this->holderSection?->name ?? '—').' (office)',
            default => '',
        };
    }

    /** Who holds it, as a short key: E:<user id>, D:<department id> or O:<office id> (used by the Return links and the holder page). */
    public function getHolderKeyAttribute(): string
    {
        return match ($this->holder_type) { 'EMPLOYEE' => 'E:'.$this->holder_user_id, 'OFFICE' => 'O:'.$this->holder_section_id, default => 'D:'.$this->holder_department_id };
    }

    /** The holder as the array the inventory service works with (type, user_id, department_id, section_id). */
    public function holderRef(): array
    {
        return ['type' => $this->holder_type, 'user_id' => $this->holder_user_id, 'department_id' => $this->holder_department_id, 'section_id' => $this->holder_section_id];
    }
}
