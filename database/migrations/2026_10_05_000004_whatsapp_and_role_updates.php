<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Phone -> WhatsApp number
        if (Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $t) {
                $t->renameColumn('phone', 'whatsapp');
            });
        }

        // Role renames + permission changes (config/itsm.php is the source of truth):
        //  - "IT Officer / IT Manager" -> "IT Admin"
        //  - "Management / Viewer"     -> "Management"
        //  - Audit log / login history are System Administrator only
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
        if (Schema::hasColumn('users', 'whatsapp')) {
            Schema::table('users', function (Blueprint $t) {
                $t->renameColumn('whatsapp', 'phone');
            });
        }
    }
};
