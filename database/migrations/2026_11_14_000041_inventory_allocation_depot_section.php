<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Allocations to a department also record the Depot / Section (a location) the equipment goes to. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inv_movements', function (Blueprint $t) {
            $t->foreignId('location_id')->nullable()->after('holder_department_id')->constrained('locations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inv_movements', fn (Blueprint $t) => $t->dropConstrainedForeignId('location_id'));
    }
};
