<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Re-sync stored role permissions from config/itsm.php (adds attendance.view). */
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
    }

    public function down(): void
    {
        //
    }
};
