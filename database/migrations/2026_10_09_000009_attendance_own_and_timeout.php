<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Adds attendance.own (IT Team Member) and drops the unused session setting (timeout is now 15 min, fixed in config). */
return new class extends Migration
{
    public function up(): void
    {
        foreach (config('itsm.roles') as $slug => $name) {
            DB::table('roles')->where('slug', $slug)->update([
                'name' => $name,
                'permissions' => json_encode(config("itsm.permissions.$slug", [])),
                'updated_at' => now(),
            ]);
        }
        DB::table('system_settings')->where('key', 'security.session_minutes')->delete();
    }

    public function down(): void
    {
        //
    }
};
