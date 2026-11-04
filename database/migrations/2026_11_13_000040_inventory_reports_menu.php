<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** New sidebar menu IT Inventory > Reports (menu.inv_reports): given to everyone who can already view the inventory. */
return new class extends Migration
{
    public function up(): void
    {
        $add = function (string $json, bool $needsView) {
            $perms = json_decode($json, true) ?: [];

            return in_array('inv.view', $perms, true) && ! in_array('menu.inv_reports', $perms, true) ? json_encode(array_merge($perms, ['menu.inv_reports'])) : null;
        };
        foreach (DB::table('roles')->get() as $r) {
            if ($new = $add($r->permissions, true)) DB::table('roles')->where('id', $r->id)->update(['permissions' => $new, 'updated_at' => now()]);
        }
        foreach (DB::table('users')->whereNotNull('extra_permissions')->get(['id', 'extra_permissions']) as $u) {
            if ($new = $add($u->extra_permissions, true)) DB::table('users')->where('id', $u->id)->update(['extra_permissions' => $new]);
        }
    }

    public function down(): void
    {
        $strip = fn ($json) => json_encode(array_values(array_filter(json_decode($json, true) ?: [], fn ($p) => $p !== 'menu.inv_reports')));
        foreach (DB::table('roles')->get() as $r) DB::table('roles')->where('id', $r->id)->update(['permissions' => $strip($r->permissions)]);
        foreach (DB::table('users')->whereNotNull('extra_permissions')->get(['id', 'extra_permissions']) as $u) DB::table('users')->where('id', $u->id)->update(['extra_permissions' => $strip($u->extra_permissions)]);
    }
};
