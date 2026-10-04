<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'employee_id', 'department_id', 'designation_id',
        'location_id', 'phone', 'is_active', 'is_department_head', 'role_id',
        'failed_logins', 'locked_until', 'last_login_at', 'last_login_ip', 'password_changed_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_department_head' => 'boolean',
            'locked_until' => 'datetime',
            'last_login_at' => 'datetime',
            'password_changed_at' => 'datetime',
        ];
    }

    public function role() { return $this->belongsTo(Role::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function designation() { return $this->belongsTo(Designation::class); }
    public function location() { return $this->belongsTo(Location::class); }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->role?->permissions ?? [], true);
    }

    public function isRole(string $slug): bool
    {
        return $this->role?->slug === $slug;
    }

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function scopeWithRole($q, string $slug)
    {
        return $q->whereHas('role', fn ($r) => $r->where('slug', $slug));
    }
}
