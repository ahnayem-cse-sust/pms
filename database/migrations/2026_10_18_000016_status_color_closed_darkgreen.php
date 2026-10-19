<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Closed is shown in dark green. */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('ticket_statuses')->where('code', 'CLOSED')->update(['color' => 'darkgreen']);
    }

    public function down(): void
    {
        DB::table('ticket_statuses')->where('code', 'CLOSED')->update(['color' => 'success']);
    }
};
