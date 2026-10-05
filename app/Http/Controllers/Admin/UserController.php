<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
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
            ->when(! $this->actorIsAdmin(), fn ($q) => $q->whereDoesntHave('roles', fn ($x) => $x->where('slug', 'admin')))
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
        $user = User::create($d + ['is_active' => $r->boolean('is_active'), 'is_department_head' => $r->boolean('is_department_head')]);
        $user->roles()->sync($roleIds);
        AuditLog::record('user.created', $user, null, collect($d)->except('password')->all() + ['role_ids' => $roleIds]);
        return redirect()->route('admin.users.index')->with('ok', 'User created.');
    }

    public function edit(User $user)
    {
        $this->guardTarget($user);
        return view('admin.users.form', $this->lookups() + ['user' => $user]);
    }

    public function update(Request $r, User $user)
    {
        $this->guardTarget($user);
        // Admins cannot change their own roles (the form disables those boxes), so keep them as they are.
        if ($user->id === auth()->id()) {
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

        // An admin must not lock themselves out.
        if ($user->id === auth()->id()) {
            $d['is_active'] = true;
            $d['role_ids'] = $user->roles->pluck('id')->all();
        }
        $roleIds = array_map('intval', $d['role_ids']);
        unset($d['role_ids']);
        $oldRoleIds = $user->roles->pluck('id')->all();

        $old = $user->only(array_keys(collect($d)->except('password', 'password_changed_at')->all()));
        $user->update($d);
        $user->roles()->sync($roleIds);
        if ($r->boolean('unlock')) {
            $user->update(['locked_until' => null, 'failed_logins' => 0]);
        }
        AuditLog::record('user.updated', $user, $old + ['role_ids' => $oldRoleIds], collect($d)->except('password', 'password_changed_at')->all() + ['role_ids' => $roleIds]);
        return redirect()->route('admin.users.index')->with('ok', 'User updated.');
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
        return Role::orderBy('name')
            ->when(! $this->actorIsAdmin(), fn ($q) => $q->where('slug', '!=', 'admin'))->get();
    }

    protected function guardTarget(User $user): void
    {
        abort_if(! $this->actorIsAdmin() && $user->isRole('admin'), 403, 'Only a System Administrator can manage this account.');
    }

    protected function guardRoleIds(array $ids): void
    {
        $adminId = Role::where('slug', 'admin')->value('id');
        if (! $this->actorIsAdmin() && in_array((int) $adminId, array_map('intval', $ids), true)) {
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
