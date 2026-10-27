<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Adds the inventory permissions to the existing roles (additive – nothing is removed), the two new inventory roles and the inventory settings. */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        foreach (config('itsm.roles') as $slug => $name) {
            $inv = array_values(array_filter(config("itsm.permissions.$slug", []), fn ($p) => str_starts_with($p, 'inv.')));
            $row = DB::table('roles')->where('slug', $slug)->first();
            if (! $row) {
                // only the two new inventory roles are created here; the other built-in roles come from RoleSeeder on a fresh install
                if ($inv && in_array($slug, ['inv_officer', 'inv_auditor'], true)) {
                    DB::table('roles')->insert(['slug' => $slug, 'name' => $name, 'permissions' => json_encode($inv), 'created_at' => $now, 'updated_at' => $now]);
                }
                continue;
            }
            $have = json_decode($row->permissions, true) ?: [];
            $merged = array_values(array_unique(array_merge($have, $inv)));
            if ($merged !== $have) {
                DB::table('roles')->where('id', $row->id)->update(['permissions' => json_encode($merged), 'updated_at' => $now]);
            }
        }
        foreach (config('inventory.settings') as [$key, $value]) {
            if (! DB::table('system_settings')->where('key', $key)->exists()) {
                DB::table('system_settings')->insert(['key' => $key, 'value' => $value, 'group' => 'inventory', 'created_at' => $now, 'updated_at' => $now]);
            }
        }
    }

    public function down(): void
    {
        foreach (DB::table('roles')->get() as $row) {
            $left = array_values(array_filter(json_decode($row->permissions, true) ?: [], fn ($p) => ! str_starts_with($p, 'inv.')));
            DB::table('roles')->where('id', $row->id)->update(['permissions' => json_encode($left)]);
        }
        DB::table('system_settings')->where('group', 'inventory')->delete();
    }
};
