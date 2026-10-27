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
    public function getHolderNameAttribute(): string
    {
        return match ($this->holder_type) { 'EMPLOYEE' => $this->holderUser?->name ?? '—', 'DEPARTMENT' => ($this->holderDepartment?->name ?? '—').' (dept)', default => '' };
    }
}
