<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Resolved gets its own colour (indigo) so it no longer looks like User Confirmation or Closed (green). */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('ticket_statuses')->where('code', 'RESOLVED')->update(['color' => 'primary']);
    }

    public function down(): void
    {
        DB::table('ticket_statuses')->where('code', 'RESOLVED')->update(['color' => 'success']);
    }
};
