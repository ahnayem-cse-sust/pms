<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Adds the four inventory permissions to existing roles (additive) and removes anything left by earlier inventory drafts. */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        foreach (['inv_officer', 'inv_auditor'] as $slug) {
            $r = DB::table('roles')->where('slug', $slug)->first();
            if ($r && ! DB::table('role_user')->where('role_id', $r->id)->exists()) DB::table('roles')->where('id', $r->id)->delete();
        }
        $clean = fn ($json) => json_encode(array_values(array_filter(json_decode($json, true) ?: [], fn ($p) => ! str_starts_with($p, 'inv.'))));

        foreach (DB::table('roles')->get() as $row) {
            $keep = json_decode($clean($row->permissions), true);
            $add = array_values(array_filter(config("itsm.permissions.{$row->slug}", []), fn ($p) => str_starts_with($p, 'inv.')));
            DB::table('roles')->where('id', $row->id)->update(['permissions' => json_encode(array_values(array_unique(array_merge($keep, $add)))), 'updated_at' => $now]);
        }
        foreach (DB::table('users')->get(['id', 'extra_permissions', 'denied_permissions']) as $u) {
            DB::table('users')->where('id', $u->id)->update(['extra_permissions' => $u->extra_permissions === null ? null : $clean($u->extra_permissions),
                'denied_permissions' => $u->denied_permissions === null ? null : $clean($u->denied_permissions)]);
        }
        DB::table('system_settings')->where('group', 'inventory')->delete();
    }

    public function down(): void
    {
        foreach (DB::table('roles')->get() as $row) {
            $left = array_values(array_filter(json_decode($row->permissions, true) ?: [], fn ($p) => ! str_starts_with($p, 'inv.')));
            DB::table('roles')->where('id', $row->id)->update(['permissions' => json_encode($left)]);
        }
    }
};
