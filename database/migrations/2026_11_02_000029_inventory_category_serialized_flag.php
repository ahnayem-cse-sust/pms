<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Marks a category as "serialisable" (each unit of its equipment carries a serial number). */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('inv_categories') && ! Schema::hasColumn('inv_categories', 'is_serialized')) {
            Schema::table('inv_categories', function (Blueprint $t) { $t->boolean('is_serialized')->default(false)->after('is_active'); });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('inv_categories', 'is_serialized')) {
            Schema::table('inv_categories', function (Blueprint $t) { $t->dropColumn('is_serialized'); });
        }
    }
};
