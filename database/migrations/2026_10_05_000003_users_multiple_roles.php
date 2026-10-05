<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/** A user can hold several roles; effective permissions are the union of all of them. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $t) {
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('role_id')->constrained()->cascadeOnDelete();
            $t->primary(['user_id', 'role_id']);
        });

        // Keep everyone's existing role
        foreach (DB::table('users')->whereNotNull('role_id')->get(['id', 'role_id']) as $u) {
            DB::table('role_user')->insertOrIgnore(['user_id' => $u->id, 'role_id' => $u->role_id]);
        }

        Schema::table('users', function (Blueprint $t) {
            $t->dropConstrainedForeignId('role_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
        });
        foreach (DB::table('role_user')->orderBy('role_id')->get() as $row) {
            DB::table('users')->where('id', $row->user_id)->update(['role_id' => $row->role_id]);
        }
        Schema::dropIfExists('role_user');
    }
};
