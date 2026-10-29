<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** user.delete (delete a user) belongs to the System Administrator role only. */
return new class extends Migration
{
    public function up(): void
    {
        foreach (DB::table('roles')->where('slug', 'admin')->get() as $role) {
            $perms = json_decode($role->permissions, true) ?: [];
            if (! in_array('user.delete', $perms, true)) {
                $perms[] = 'user.delete';
                DB::table('roles')->where('id', $role->id)->update(['permissions' => json_encode(array_values($perms)), 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        foreach (DB::table('roles')->get() as $role) {
            $perms = array_values(array_diff(json_decode($role->permissions, true) ?: [], ['user.delete']));
            DB::table('roles')->where('id', $role->id)->update(['permissions' => json_encode($perms)]);
        }
    }
};
