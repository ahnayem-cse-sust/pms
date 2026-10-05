<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'employee_id', 'department_id', 'designation_id',
        'location_id', 'whatsapp', 'is_active', 'is_department_head',
        'failed_logins', 'locked_until', 'last_login_at', 'last_login_ip', 'password_changed_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected ?array $permissionCache = null;

    /** e.g. "IT Admin, IT Team Member" – for display */
    public function getRoleNamesAttribute(): string
    {
        return $this->roles->pluck('name')->implode(', ');
    }

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

    public function roles() { return $this->belongsToMany(Role::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function designation() { return $this->belongsTo(Designation::class); }
    public function location() { return $this->belongsTo(Location::class); }

    public function hasPermission(string $permission): bool
    {
        // Union of the permissions of every role the user holds (cached per request)
        $this->permissionCache ??= $this->roles->pluck('permissions')->flatten()->unique()->all();
        return in_array($permission, $this->permissionCache, true);
    }

    public function isRole(string $slug): bool
    {
        return $this->roles->contains('slug', $slug);
    }

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function scopeWithRole($q, string $slug)
    {
        return $q->whereHas('roles', fn ($r) => $r->where('slug', $slug));
    }
}
