<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Classification becomes Asset type (level 1) → Category (level 2) → Sub category (level 3).
 * Existing data is kept: what used to be "sub categories" become categories, and equipment moves from
 * (category = type, subcategory = child) to (asset_type = type, category = child).
 *
 * Each step is guarded on its own, so a half-applied state can never skip the other step.
 */
return new class extends Migration
{
    public function up(): void
    {
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
        if (Schema::hasColumn('inv_equipment', 'asset_type_id')) {
            foreach (DB::table('inv_equipment')->get(['id', 'asset_type_id', 'category_id']) as $e) {
                DB::table('inv_equipment')->where('id', $e->id)->update(['category_id' => $e->asset_type_id, 'subcategory_id' => $e->category_id]);
            }
            Schema::table('inv_equipment', function (Blueprint $t) { $t->dropColumn('asset_type_id'); });
        }
        if (Schema::hasColumn('inv_categories', 'level')) {
            DB::table('inv_categories')->where('level', 3)->delete();
            Schema::table('inv_categories', function (Blueprint $t) { $t->dropColumn('level'); });
        }
    }
};
