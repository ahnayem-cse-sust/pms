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

class UserController extends Controller
{
    public function index(Request $r)
    {
        $users = User::with(['role', 'department'])
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('name', 'like', "%$s%")
                ->orWhere('email', 'like', "%$s%")->orWhere('employee_id', 'like', "%$s%")))
            ->when($r->role_id, fn ($q, $v) => $q->where('role_id', $v))
            ->orderBy('name')->paginate(25)->withQueryString();
        return view('admin.users.index', ['users' => $users, 'roles' => Role::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('admin.users.form', $this->lookups() + ['user' => new User(['is_active' => true])]);
    }

    public function store(Request $r)
    {
        $d = $r->validate($this->rules() + [
            'password' => array_merge(['required', 'confirmed'], $this->passwordRule()),
        ]);
        $d['password_changed_at'] = now();
        $user = User::create($d + ['is_active' => $r->boolean('is_active'), 'is_department_head' => $r->boolean('is_department_head')]);
        AuditLog::record('user.created', $user, null, collect($d)->except('password')->all());
        return redirect()->route('admin.users.index')->with('ok', 'User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', $this->lookups() + ['user' => $user]);
    }

    public function update(Request $r, User $user)
    {
        $d = $r->validate($this->rules($user) + [
            'password' => array_merge(['nullable', 'confirmed'], $this->passwordRule()),
        ]);
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
            $d['role_id'] = $user->role_id;
        }

        $old = $user->only(array_keys(collect($d)->except('password', 'password_changed_at')->all()));
        $user->update($d);
        if ($r->boolean('unlock')) {
            $user->update(['locked_until' => null, 'failed_logins' => 0]);
        }
        AuditLog::record('user.updated', $user, $old, collect($d)->except('password', 'password_changed_at')->all());
        return redirect()->route('admin.users.index')->with('ok', 'User updated.');
    }

    protected function rules(?User $user = null): array
    {
        return [
            'name' => 'required|string|max:150',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user?->id)],
            'employee_id' => ['nullable', 'string', 'max:30', Rule::unique('users', 'employee_id')->ignore($user?->id)],
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'location_id' => 'nullable|exists:locations,id',
            'phone' => 'nullable|string|max:30',
        ];
    }

    /** No complexity or length rules: any non-empty password is accepted. */
    protected function passwordRule(): array
    {
        return ['string', 'max:255'];
    }

    protected function lookups(): array
    {
        return [
            'roles' => Role::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
            'designations' => Designation::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
        ];
    }
}
