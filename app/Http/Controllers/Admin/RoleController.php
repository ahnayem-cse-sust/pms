<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::withCount('users')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        // "Duplicate" opens the form pre-filled from an existing role: /admin/roles/create?from=ID
        $from = request('from') ? Role::find(request('from')) : null;
        $role = new Role(['permissions' => $from?->permissions ?? [], 'name' => $from ? $from->name.' (copy)' : '']);

        return view('admin.roles.form', ['role' => $role, 'copiedFrom' => $from] + $this->screen());
    }

    public function store(Request $r)
    {
        $d = $r->validate($this->rules());
        $this->guardPrivileged($d['permissions']);
        $slug = $this->uniqueSlug($d['name']);
        $role = Role::create(['slug' => $slug, 'name' => $d['name'], 'permissions' => $this->clean($d['permissions'])]);
        AuditLog::record('role.created', $role, null, ['name' => $role->name, 'permissions' => $role->permissions]);

        return redirect()->route('admin.roles.index')->with('ok', 'Role created.');
    }

    public function edit(Role $role)
    {
        $this->guardRole($role);

        return view('admin.roles.form', $this->screen() + ['role' => $role, 'locked' => $role->slug === 'admin' || ! auth()->user()->can('role.update'), 'users' => $role->users()->orderBy('name')->limit(8)->get(['users.id', 'users.name'])]);
    }

    public function update(Request $r, Role $role)
    {
        // The System Administrator role is fixed so nobody can lock the administrators out.
        abort_if($role->slug === 'admin', 403, 'The System Administrator role cannot be changed.');
        $this->guardRole($role);
        $d = $r->validate($this->rules($role));
        $this->guardPrivileged($d['permissions'], $role);
        $old = ['name' => $role->name, 'permissions' => $role->permissions];
        // Built-in role names are fixed (the app refers to them); only their permissions change.
        if (array_key_exists($role->slug, config('itsm.roles'))) {
            $d['name'] = $role->name;
        }
        $role->update(['name' => $d['name'], 'permissions' => $this->clean($d['permissions'])]);
        AuditLog::record('role.updated', $role, $old, ['name' => $role->name, 'permissions' => $role->permissions]);

        return redirect()->route('admin.roles.index')->with('ok', 'Role updated. Users with this role get the new permissions on their next page load.');
    }

    public function destroy(Role $role)
    {
        if (array_key_exists($role->slug, config('itsm.roles'))) {
            return back()->withErrors(['role' => 'Built-in roles cannot be deleted.']);
        }
        if ($role->users()->exists()) {
            return back()->withErrors(['role' => 'This role is still assigned to users. Remove it from them first.']);
        }
        AuditLog::record('role.deleted', $role, ['name' => $role->name, 'permissions' => $role->permissions], null);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('ok', 'Role deleted.');
    }

    protected function rules(?Role $role = null): array
    {
        $valid = collect(config('itsm.permission_catalog'))->map(fn ($g) => array_keys($g))->flatten()->all();

        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($role?->id)],
            'permissions' => 'required|array|min:1',
            'permissions.*' => ['string', Rule::in($valid)],
        ];
    }

    /** Unique permissions plus everything they depend on (config itsm.permission_requires). */
    protected function clean(array $permissions): array
    {
        $requires = config('itsm.permission_requires', []);
        $out = array_values(array_unique($permissions));
        for ($i = 0; $i < count($out); $i++) {
            foreach ($requires[$out[$i]] ?? [] as $dep) {
                if (! in_array($dep, $out, true)) {
                    $out[] = $dep;
                }
            }
        }
        // keep the catalog order so the stored list is stable
        $order = collect(config('itsm.permission_catalog'))->map(fn ($g) => array_keys($g))->flatten()->flip();

        return collect($out)->sortBy(fn ($p) => $order[$p] ?? 999)->values()->all();
    }

    protected function isAdmin(): bool
    {
        return auth()->user()->isRole('admin');
    }

    /** Matrix rows (Read/Add/Update/Delete per module) and the remaining workflow permissions, minus what the actor may not hand out. */
    protected function screen(): array
    {
        $hidden = $this->isAdmin() ? [] : config('itsm.privileged_permissions', []);
        $matrix = [];
        $inMatrix = [];
        foreach (config('itsm.permission_matrix') as $module => $rows) {
            foreach ($rows as $row) {
                foreach (['read', 'add', 'update', 'delete'] as $a) {
                    if ($row[$a]) $inMatrix[] = $row[$a];
                    if ($row[$a] && in_array($row[$a], $hidden, true)) $row[$a] = null;
                }
                if ($row['read'] || $row['add'] || $row['update'] || $row['delete']) $matrix[$module][] = $row;
            }
        }
        $catalog = $this->visibleCatalog();
        $others = collect($catalog)->reject(fn ($g, $name) => str_starts_with($name, 'Sidebar menu'))->map(fn ($g) => array_diff_key($g, array_flip($inMatrix)))->filter()->all();
        // Every sidebar menu, in sidebar order, minus the ones this actor may not hand out.
        $allowed = collect($catalog)->flatMap(fn ($g) => array_keys($g))->flip();
        $menus = collect(config('itsm.sidebar_menus'))->map(fn ($items) => collect($items)->filter(fn ($m, $key) => isset($allowed[$key]))->map(fn ($m) => $m[0])->all())->filter()->all();

        return ['matrix' => $matrix, 'others' => $others, 'catalog' => $catalog, 'menus' => $menus];
    }

    /** Only a System Administrator may see or hand out role/settings/audit management. */
    protected function visibleCatalog(): array
    {
        if ($this->isAdmin()) {
            return config('itsm.permission_catalog');
        }
        $hidden = config('itsm.privileged_permissions', []);

        return collect(config('itsm.permission_catalog'))
            ->map(fn ($g) => array_diff_key($g, array_flip($hidden)))->filter()->all();
    }

    /** A non-admin cannot edit a role that already carries a privileged permission. */
    protected function guardRole(Role $role): void
    {
        abort_if(! $this->isAdmin() && count(array_intersect($role->permissions ?? [], config('itsm.privileged_permissions', []))) > 0,
            403, 'Only a System Administrator can change this role.');
    }

    protected function guardPrivileged(array $permissions, ?Role $role = null): void
    {
        if ($this->isAdmin()) {
            return;
        }
        $blocked = array_intersect($permissions, config('itsm.privileged_permissions', []));
        if ($blocked) {
            abort(403, 'Only a System Administrator can grant: '.implode(', ', $blocked).'.');
        }
    }

    protected function uniqueSlug(string $name): string
    {
        $base = Str::slug($name, '_') ?: 'role';
        $slug = $base;
        $i = 2;
        while (Role::where('slug', $slug)->exists()) {
            $slug = $base.'_'.$i++;
        }

        return $slug;
    }
}
