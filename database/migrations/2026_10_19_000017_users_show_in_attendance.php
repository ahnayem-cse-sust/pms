<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/** Per-employee checkmark: should this person appear on the IT attendance page? */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->boolean('show_in_attendance')->default(false)->after('is_department_head');
        });

        // Keep today's behaviour: employees who currently appear on the page stay ticked.
        $slugs = config('itsm.attendance.roles', ['it_member']);
        $ids = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->whereIn('roles.slug', $slugs)
            ->pluck('users.id');
        DB::table('users')->whereIn('id', $ids)->update(['show_in_attendance' => true]);
    }

    public function down(): void
    {
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('show_in_attendance'));
    }
};
