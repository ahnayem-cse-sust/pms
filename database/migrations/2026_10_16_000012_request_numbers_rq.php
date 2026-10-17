<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Request numbers change from IT-2026-000001 to RQ-1: existing requests are renumbered in creation order. */
return new class extends Migration
{
    public function up(): void
    {
        $n = 0;
        foreach (DB::table('tickets')->orderBy('id')->get(['id']) as $t) {   // includes soft-deleted requests
            $n++;
            DB::table('tickets')->where('id', $t->id)->update(['ticket_no' => config('itsm.ticket_prefix', 'RQ') . '-' . $n]);
        }

        // single running counter (replaces the per-year counters)
        DB::table('ticket_sequences')->delete();
        DB::table('ticket_sequences')->insert(['year' => 0, 'last_number' => $n]);
    }

    public function down(): void
    {
        // Old numbers cannot be restored; the new ones simply keep working.
    }
};
