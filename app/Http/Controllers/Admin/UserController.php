<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $r)
    {
        $users = User::with(['roles', 'department'])
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('name', 'like', "%$s%")
                ->orWhere('email', 'like', "%$s%")->orWhere('employee_id', 'like', "%$s%")))
            ->when($r->role_id, fn ($q, $v) => $q->whereHas('roles', fn ($x) => $x->where('roles.id', $v)))
            // Only a System Administrator can see System Administrator accounts
            ->when(! $this->actorIsAdmin(), fn ($q) => $q->whereDoesntHave('roles', fn ($x) => $x->whereIn('roles.id', $this->privilegedRoleIds())))
            ->orderBy('name')->paginate(25)->withQueryString();
        return view('admin.users.index', ['users' => $users, 'roles' => $this->assignableRoles()]);
    }

    public function create()
    {
        return view('admin.users.form', $this->lookups() + ['user' => new User(['is_active' => true])]);
    }

    public function store(Request $r)
    {
        $d = $r->validate($this->rules() + [
            'password' => array_merge(['required', 'confirmed'], $this->passwordRule()),
        ], $this->messages());
        $this->guardRoleIds($d['role_ids']);
        $d['password_changed_at'] = now();
        $roleIds = $d['role_ids'];
        unset($d['role_ids']);
        $user = User::create($d + ['is_active' => $r->boolean('is_active'), 'is_department_head' => $r->boolean('is_department_head'), 'show_in_attendance' => $r->boolean('show_in_attendance')]);
        $user->roles()->sync($roleIds);
        $this->saveOverrides($r, $user);
        AuditLog::record('user.created', $user, null, collect($d)->except('password')->all() + ['role_ids' => $roleIds]);
        return redirect()->route('admin.users.index')->with('ok', 'User created.');
    }

    public function show(User $user)
    {
        $this->guardTarget($user);
        $user->load(['roles', 'department', 'designation', 'location']);

        return view('admin.users.show', [
            'user' => $user,
            'blockers' => auth()->user()->can('user.delete') ? $this->deleteBlockers($user) : [],
        ]);
    }

    public function edit(User $user)
    {
        $this->guardTarget($user);
        return view('admin.users.form', $this->lookups() + ['user' => $user]);
    }

    public function update(Request $r, User $user)
    {
        $this->guardTarget($user);
        $self = $user->id === auth()->id();
        if ($self && $this->actorIsAdmin()) {
            // A System Administrator may change their other roles, but can never drop the System Administrator role.
            $adminId = Role::where('slug', 'admin')->value('id');
            $r->merge(['role_ids' => array_values(array_unique(array_merge((array) $r->input('role_ids', []), [$adminId])))]);
        } elseif ($self) {
            // Everyone else keeps their own roles as they are.
            $r->merge(['role_ids' => $user->roles->pluck('id')->all()]);
        }
        $d = $r->validate($this->rules($user) + [
            'password' => array_merge(['nullable', 'confirmed'], $this->passwordRule()),
        ], $this->messages());
        $this->guardRoleIds($d['role_ids']);
        if (blank($d['password'] ?? null)) {
            unset($d['password']);
        } else {
            $d['password_changed_at'] = now();
        }
        $d['is_active'] = $r->boolean('is_active');
        $d['is_department_head'] = $r->boolean('is_department_head');
        $d['show_in_attendance'] = $r->boolean('show_in_attendance');

        // Nobody can deactivate their own account.
        if ($self) {
            $d['is_active'] = true;
        }
        $roleIds = array_map('intval', $d['role_ids']);
        unset($d['role_ids']);
        $oldRoleIds = $user->roles->pluck('id')->all();

        $old = $user->only(array_keys(collect($d)->except('password', 'password_changed_at')->all()));
        $user->update($d);
        $user->roles()->sync($roleIds);
        $oldOverrides = ['extra_permissions' => $user->extra_permissions, 'denied_permissions' => $user->denied_permissions];
        $changed = $this->saveOverrides($r, $user, $self);
        if ($r->boolean('unlock')) {
            $user->update(['locked_until' => null, 'failed_logins' => 0]);
        }
        AuditLog::record('user.updated', $user, $old + ['role_ids' => $oldRoleIds] + ($changed ? $oldOverrides : []), collect($d)->except('password', 'password_changed_at')->all() + ['role_ids' => $roleIds] + ($changed ? ['extra_permissions' => $user->extra_permissions, 'denied_permissions' => $user->denied_permissions] : []));
        return redirect()->route('admin.users.show', $user)->with('ok', 'User updated.');
    }

    /** Delete a user (System Administrator only). Refused for yourself and for anyone who already has records. */
    public function destroy(User $user)
    {
        $this->guardTarget($user);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $blockers = $this->deleteBlockers($user);
        if ($blockers) {
            return back()->with('error', $user->name.' has '.implode(', ', $blockers).' and cannot be deleted. Disable the account instead (untick Active).');
        }

        $snapshot = $user->only(['name', 'email', 'employee_id', 'department_id', 'designation_id', 'location_id', 'is_active']) + ['role_ids' => $user->roles->pluck('id')->all()];
        try {
            DB::transaction(function () use ($user, $snapshot) {
                DB::table('notifications')->where('notifiable_type', $user->getMorphClass())->where('notifiable_id', $user->id)->delete();
                AuditLog::record('user.deleted', $user, $snapshot, null);
                $user->roles()->detach();
                $user->delete();
            });
        } catch (QueryException $e) {
            // Something we do not know about still points at this user.
            return back()->with('error', $user->name.' is still referenced by other records and cannot be deleted. Disable the account instead (untick Active).');
        }
        if ($user->avatar_path) {
            Storage::disk('local')->delete($user->avatar_path);
        }

        return redirect()->route('admin.users.index')->with('ok', $user->name.' was deleted.');
    }

    /**
     * What stops this user from being deleted: any history that would be left without its person.
     * Login history, the audit log and request history keep their rows (the user link is simply cleared).
     *
     * @return string[]  e.g. ['requests', 'inventory records']
     */
    protected function deleteBlockers(User $user): array
    {
        $uses = [
            'requests' => [['tickets', ['requester_id', 'created_by', 'assigned_to', 'closed_by', 'updated_by']]],
            'request assignments' => [['ticket_assignments', ['employee_id', 'assigned_by']], ['ticket_assignment_log', ['assigned_to', 'assigned_from', 'assigned_by']]],
            'work updates' => [['ticket_work_updates', ['user_id']]],
            'comments or notes' => [['ticket_comments', ['user_id']], ['ticket_internal_notes', ['user_id']]],
            'attachments' => [['ticket_attachments', ['uploaded_by']]],
            'inventory records' => [['inv_movements', ['holder_user_id', 'created_by']]],
        ];
        $found = [];
        foreach ($uses as $label => $tables) {
            foreach ($tables as [$table, $columns]) {
                if (! Schema::hasTable($table)) continue;
                $columns = array_values(array_filter($columns, fn ($c) => Schema::hasColumn($table, $c)));
                if (! $columns) continue;
                $q = DB::table($table)->where(function ($w) use ($columns, $user) {
                    foreach ($columns as $c) $w->orWhere($c, $user->id);
                });
                if ($q->exists()) {
                    $found[] = $label;
                    break;
                }
            }
        }

        return $found;
    }

    /** Individual permissions (Inherit / Allow / Deny per permission). Only users who can manage roles may change them. */
    protected function saveOverrides(Request $r, User $user, bool $self = false): bool
    {
        if (! auth()->user()->can('role.update') || $self || $user->isRole('admin') || ! $r->has('perm_form')) {
            return false;
        }
        $valid = collect(config('itsm.permission_catalog'))->map(fn ($g) => array_keys($g))->flatten()->all();
        $input = (array) $r->input('perm', []);
        $allow = [];
        $deny = [];
        foreach ($valid as $key) {
            $v = $input[$key] ?? '';
            // Only a System Administrator may hand out role/settings/audit management to a single user
            if ($v === 'allow' && ! $this->actorIsAdmin() && in_array($key, config('itsm.privileged_permissions', []), true)) continue;
            if ($v === 'allow') $allow[] = $key;
            if ($v === 'deny') $deny[] = $key;
        }
        // Allowing a sidebar menu (or anything with prerequisites) also allows what it needs, unless that was denied on purpose.
        $requires = config('itsm.permission_requires', []);
        for ($i = 0; $i < count($allow); $i++) {
            foreach ($requires[$allow[$i]] ?? [] as $dep) {
                if (! in_array($dep, $allow, true) && ! in_array($dep, $deny, true)) $allow[] = $dep;
            }
        }
        $user->forceFill(['extra_permissions' => $allow ?: null, 'denied_permissions' => $deny ?: null])->save();

        return true;
    }

    /** Every field is mandatory when creating a user; when editing, older users may have blanks. */
    protected function rules(?User $user = null): array
    {
        $req = $user ? 'nullable' : 'required';

        return [
            'name' => 'required|string|max:150',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user?->id)],
            'employee_id' => [$req, 'string', 'max:30', Rule::unique('users', 'employee_id')->ignore($user?->id)],
            'whatsapp' => [$req, 'string', 'max:30', 'regex:/^\+?[0-9][0-9\s\-]{6,19}$/'],
            'role_ids' => 'required|array|min:1',
            'role_ids.*' => 'exists:roles,id',
            'department_id' => [$req, 'exists:departments,id'],
            'designation_id' => [$req, 'exists:designations,id'],
            'location_id' => [$req, 'exists:locations,id'],
        ];
    }

    protected function messages(): array
    {
        return [
            'whatsapp.regex' => 'Enter a valid WhatsApp number, e.g. +8801XXXXXXXXX.',
            'role_ids.required' => 'Select at least one role.',
            'role_ids.min' => 'Select at least one role.',
        ];
    }

    // ---- System Administrator protection (IT Admin can manage users, but not System Administrators) ----

    protected function actorIsAdmin(): bool
    {
        return auth()->user()->isRole('admin');
    }

    /** Roles the current user may hand out (System Administrator is hidden from everyone else). */
    protected function assignableRoles()
    {
        return Role::orderBy('name')->get()
            ->when(! $this->actorIsAdmin(), fn ($c) => $c->reject(fn ($role) => $this->isPrivileged($role)))->values();
    }

    /** The System Administrator role, or any role carrying a privileged permission (role/settings/audit management). */
    protected function isPrivileged(Role $role): bool
    {
        return $role->slug === 'admin'
            || count(array_intersect($role->permissions ?? [], config('itsm.privileged_permissions', []))) > 0;
    }

    protected function privilegedRoleIds(): array
    {
        return Role::get()->filter(fn ($r) => $this->isPrivileged($r))->pluck('id')->all();
    }

    protected function guardTarget(User $user): void
    {
        abort_if(! $this->actorIsAdmin() && $user->roles->contains(fn ($r) => $this->isPrivileged($r)), 403, 'Only a System Administrator can manage this account.');
    }

    protected function guardRoleIds(array $ids): void
    {
        $blocked = Role::whereIn('id', $ids)->get()->contains(fn ($role) => $this->isPrivileged($role));
        if (! $this->actorIsAdmin() && $blocked) {
            throw ValidationException::withMessages(['role_ids' => 'You are not allowed to assign that role.']);
        }
    }

    protected function passwordRule(): array
    {
        return ['string', 'max:255'];
    }

    protected function lookups(): array
    {
        return [
            'roles' => $this->assignableRoles(),
            'departments' => Department::orderBy('name')->get(),
            'designations' => Designation::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
        ];
    }
}
