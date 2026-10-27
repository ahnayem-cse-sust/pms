<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * One receive / one allocation = one entry (RC-000001 / AL-000001) that holds all its equipment lines.
 * Older records become entries of one line each (entry no. = their record no.).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('inv_movements') && ! Schema::hasColumn('inv_movements', 'entry_no')) {
            Schema::table('inv_movements', function (Blueprint $t) { $t->string('entry_no', 30)->nullable()->after('ref')->index(); });
        }
        DB::table('inv_movements')->whereNull('entry_no')->update(['entry_no' => DB::raw('ref')]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('inv_movements', 'entry_no')) {
            Schema::table('inv_movements', function (Blueprint $t) { $t->dropIndex(['entry_no']); $t->dropColumn('entry_no'); });
        }
    }
};
