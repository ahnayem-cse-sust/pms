<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'employee_id', 'department_id', 'designation_id',
        'location_id', 'whatsapp', 'avatar_path', 'is_active', 'is_department_head', 'show_in_attendance',
        'extra_permissions', 'denied_permissions', 'failed_logins', 'locked_until', 'last_login_at', 'last_login_ip', 'password_changed_at',
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
            'extra_permissions' => 'array',
            'denied_permissions' => 'array',
            'is_active' => 'boolean',
            'is_department_head' => 'boolean',
            'show_in_attendance' => 'boolean',
            'locked_until' => 'datetime',
            'last_activity_at' => 'datetime',
            'session_open' => 'boolean',
            'last_login_at' => 'datetime',
            'password_changed_at' => 'datetime',
        ];
    }

    public function roles() { return $this->belongsToMany(Role::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function designation() { return $this->belongsTo(Designation::class); }
    public function location() { return $this->belongsTo(Location::class); }

    /** Permissions coming from the user's roles only. */
    public function rolePermissions(): array
    {
        return $this->roles->pluck('permissions')->flatten()->unique()->values()->all();
    }

    public function hasPermission(string $permission): bool
    {
        // Roles' permissions, plus permissions granted to this user, minus permissions denied to this user.
        // A System Administrator always keeps the full permissions of the role (individual denies are ignored).
        $this->permissionCache ??= (function () {
            $perms = $this->rolePermissions();
            if ($this->isRole('admin')) {
                return array_values(array_unique(array_merge($perms, (array) $this->extra_permissions)));
            }
            $perms = array_merge($perms, (array) $this->extra_permissions);
            return array_values(array_diff(array_unique($perms), (array) $this->denied_permissions));
        })();
        return in_array($permission, $this->permissionCache, true);
    }

    /** 'allow', 'deny' or '' (inherit from roles) – for the individual-permissions screen. */
    public function permissionOverride(string $permission): string
    {
        if (in_array($permission, (array) $this->denied_permissions, true)) return 'deny';
        if (in_array($permission, (array) $this->extra_permissions, true)) return 'allow';
        return '';
    }

    public function hasCustomPermissions(): bool
    {
        return ! empty($this->extra_permissions) || ! empty($this->denied_permissions);
    }

    public function isRole(string $slug): bool
    {
        return $this->roles->contains('slug', $slug);
    }

    public function scopeActive($q) { return $q->where('is_active', true); }

    /** Staff who can be assigned tickets: IT Team Members and IT Admins (config itsm.assignable_roles). */
    public function scopeAssignable($q)
    {
        return $q->whereHas('roles', fn ($r) => $r->whereIn('slug', config('itsm.assignable_roles', ['it_member']))
            ->orWhereJsonContains('roles.permissions', 'ticket.work'));
    }

    public function scopeWithRole($q, string $slug)
    {
        return $q->whereHas('roles', fn ($r) => $r->where('slug', $slug));
    }
}
