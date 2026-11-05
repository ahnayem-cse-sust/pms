<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Equipment can be allocated to an office (Configuration > Offices, stored in the sections table): the holder is recorded in holder_section_id. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inv_movements', function (Blueprint $t) {
            $t->foreignId('holder_section_id')->nullable()->after('holder_department_id')->constrained('sections')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inv_movements', fn (Blueprint $t) => $t->dropConstrainedForeignId('holder_section_id'));
    }
};
