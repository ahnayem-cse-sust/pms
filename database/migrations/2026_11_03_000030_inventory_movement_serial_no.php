<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Serial number of the single unit an allocation / return line is about (serialisable categories only). */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('inv_movements') && ! Schema::hasColumn('inv_movements', 'serial_no')) {
            Schema::table('inv_movements', function (Blueprint $t) { $t->string('serial_no', 60)->nullable()->after('reference_no'); $t->index(['equipment_id', 'serial_no']); });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('inv_movements', 'serial_no')) {
            Schema::table('inv_movements', function (Blueprint $t) { $t->dropIndex(['equipment_id', 'serial_no']); $t->dropColumn('serial_no'); });
        }
    }
};
