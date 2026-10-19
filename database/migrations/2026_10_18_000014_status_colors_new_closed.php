<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Status colours: New is shown in red, Closed in green. */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('ticket_statuses')->where('code', 'NEW')->update(['color' => 'danger']);
        DB::table('ticket_statuses')->where('code', 'CLOSED')->update(['color' => 'success']);
    }

    public function down(): void
    {
        DB::table('ticket_statuses')->where('code', 'NEW')->update(['color' => 'primary']);
        DB::table('ticket_statuses')->where('code', 'CLOSED')->update(['color' => 'dark']);
    }
};
