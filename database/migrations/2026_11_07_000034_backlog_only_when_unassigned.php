<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Backlog is only for requests nobody is assigned to: drop the Backlog transitions from states that always have an assignee. */
return new class extends Migration
{
    public function up(): void
    {
        $id = DB::table('ticket_statuses')->pluck('id', 'code');
        if (! isset($id['BACKLOG'])) return;
        $from = collect(['ASSIGNED', 'IN_PROGRESS', 'WAITING_USER', 'ON_HOLD'])->map(fn ($c) => $id[$c] ?? null)->filter()->all();
        DB::table('ticket_status_transitions')->where('to_status_id', $id['BACKLOG'])->whereIn('from_status_id', $from)->delete();
    }

    public function down(): void
    {
        //
    }
};
