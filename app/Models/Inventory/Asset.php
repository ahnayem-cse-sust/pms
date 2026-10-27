<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'inv_assets';
    protected $guarded = [];
    protected $casts = ['purchase_date' => 'date', 'warranty_end' => 'date', 'allocated_at' => 'datetime', 'cost' => 'decimal:2'];

    public function product() { return $this->belongsTo(Product::class); }
    public function location() { return $this->belongsTo(Location::class); }
    public function holderUser() { return $this->belongsTo(\App\Models\User::class, 'holder_user_id'); }
    public function holderDepartment() { return $this->belongsTo(\App\Models\Department::class, 'holder_department_id'); }
    public function movements() { return $this->hasMany(Movement::class)->latest('id'); }
    public function getHolderNameAttribute(): string
    {
        return match ($this->holder_type) {
            'EMPLOYEE' => $this->holderUser?->name ?? '—',
            'DEPARTMENT' => ($this->holderDepartment?->name ?? '—').' (dept)',
            default => '—',
        };
    }
    /** Full access sees everything; people with "own" access see items held by them or their department. */
    public function scopeVisibleTo($q, \App\Models\User $u)
    {
        if ($u->hasPermission('inv.view')) return $q;
        if (! $u->hasPermission('inv.view.own')) return $q->whereRaw('1 = 0');
        return $q->where(fn ($w) => $w->where('holder_user_id', $u->id)
            ->orWhere(fn ($d) => $d->where('holder_type', 'DEPARTMENT')->where('holder_department_id', $u->department_id)));
    }
}
