<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Every sidebar menu gets its own permission (menu.*), so each can be given to a role or to a single employee.
 * Existing roles and individually-granted users receive the menus whose access they already have, so nobody's sidebar changes.
 */
return new class extends Migration
{
    private function menus(): array
    {
        $out = [];
        foreach (config('itsm.sidebar_menus') as $items) {
            foreach ($items as $key => [$label, $needs]) $out[$key] = $needs;
        }

        return $out;
    }

    public function up(): void
    {
        $menus = $this->menus();
        $now = now();
        $grant = function (array $have, array $base) use ($menus) {
            foreach ($menus as $key => $needs) {
                if (! in_array($key, $base, true) && ! array_diff($needs, array_merge($base, $have))) $have[] = $key;
            }

            return array_values(array_unique($have));
        };

        $rolePerms = [];
        foreach (DB::table('roles')->get() as $role) {
            $perms = json_decode($role->permissions, true) ?: [];
            $new = $grant($perms, []);
            $rolePerms[$role->id] = $new;
            DB::table('roles')->where('id', $role->id)->update(['permissions' => json_encode($new), 'updated_at' => $now]);
        }

        // Users who were given extra permissions of their own: add the menus those extras open.
        foreach (DB::table('users')->whereNotNull('extra_permissions')->get(['id', 'extra_permissions']) as $u) {
            $extra = json_decode($u->extra_permissions, true) ?: [];
            if (! $extra) continue;
            $fromRoles = [];
            foreach (DB::table('role_user')->where('user_id', $u->id)->pluck('role_id') as $rid) $fromRoles = array_merge($fromRoles, $rolePerms[$rid] ?? []);
            $new = $grant($extra, $fromRoles);
            if ($new !== $extra) DB::table('users')->where('id', $u->id)->update(['extra_permissions' => json_encode($new)]);
        }
    }

    public function down(): void
    {
        $strip = fn ($json) => json_encode(array_values(array_filter(json_decode($json, true) ?: [], fn ($p) => ! str_starts_with($p, 'menu.'))));
        foreach (DB::table('roles')->get() as $r) DB::table('roles')->where('id', $r->id)->update(['permissions' => $strip($r->permissions)]);
        foreach (DB::table('users')->whereNotNull('extra_permissions')->get(['id', 'extra_permissions']) as $u) DB::table('users')->where('id', $u->id)->update(['extra_permissions' => $strip($u->extra_permissions)]);
    }
};
