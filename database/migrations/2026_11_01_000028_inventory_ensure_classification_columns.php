<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Safety net for databases where 000027 is recorded as run but its columns are missing
 * (e.g. 000025 was executed again afterwards and recreated the inv_* tables).
 * Does nothing when the columns already exist.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('inv_categories') || ! Schema::hasTable('inv_equipment')) return;

        if (! Schema::hasColumn('inv_categories', 'level')) {
            Schema::table('inv_categories', function (Blueprint $t) { $t->unsignedTinyInteger('level')->default(1)->after('parent_id'); });
            DB::table('inv_categories')->whereNotNull('parent_id')->update(['level' => 2]);
        }

        if (! Schema::hasColumn('inv_equipment', 'asset_type_id')) {
            Schema::table('inv_equipment', function (Blueprint $t) { $t->foreignId('asset_type_id')->nullable()->after('name'); });
            foreach (DB::table('inv_equipment')->get(['id', 'category_id', 'subcategory_id']) as $e) {
                DB::table('inv_equipment')->where('id', $e->id)->update(['asset_type_id' => $e->category_id, 'category_id' => $e->subcategory_id, 'subcategory_id' => null]);
            }
        }
    }

    public function down(): void
    {
        // Intentionally empty: 000027 owns the rollback of these columns.
    }
};
