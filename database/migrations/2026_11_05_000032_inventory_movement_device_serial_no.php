<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Optional manufacturer serial number of the unit an allocation line hands over (serialisable equipment only). Separate from the system-generated Asset ID. */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('inv_movements') && ! Schema::hasColumn('inv_movements', 'device_serial_no')) {
            Schema::table('inv_movements', function (Blueprint $t) { $t->string('device_serial_no', 120)->nullable()->after('serial_no'); });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('inv_movements', 'device_serial_no')) {
            Schema::table('inv_movements', function (Blueprint $t) { $t->dropColumn('device_serial_no'); });
        }
    }
};
