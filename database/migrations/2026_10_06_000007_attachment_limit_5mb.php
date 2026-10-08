<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Attachments: maximum 5 MB per file. */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('system_settings')->where('key', 'upload.max_kb')
            ->where(fn ($q) => $q->whereNull('value')->orWhereRaw('CAST(value AS UNSIGNED) > 5120'))
            ->update(['value' => '5120', 'updated_at' => now()]);
    }

    public function down(): void
    {
        //
    }
};
