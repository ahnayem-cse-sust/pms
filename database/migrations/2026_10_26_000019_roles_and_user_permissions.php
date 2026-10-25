<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/** Individual permissions per user + role.manage for the System Administrator (roles are edited on the Roles screen). */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->json('extra_permissions')->nullable();   // granted to this user on top of their roles
            $t->json('denied_permissions')->nullable();  // taken away from this user although a role grants them
        });

        $admin = DB::table('roles')->where('slug', 'admin')->first();
        if ($admin) {
            $perms = json_decode($admin->permissions, true) ?: [];
            if (! in_array('role.manage', $perms, true)) {
                $perms[] = 'role.manage';
                DB::table('roles')->where('id', $admin->id)->update(['permissions' => json_encode($perms), 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['extra_permissions', 'denied_permissions']);
        });
    }
};
