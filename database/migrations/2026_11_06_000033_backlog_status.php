<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * "Backlog" status: a request parked for later. It appears in the Unassigned Queue until it is assigned (or cancelled).
 * A fresh install gets it from ItsmLookupSeeder; this adds it to a database that already has statuses.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! DB::table('ticket_statuses')->exists() || DB::table('ticket_statuses')->where('code', 'BACKLOG')->exists()) {
            return;
        }
        $hold = (int) DB::table('ticket_statuses')->where('code', 'ON_HOLD')->value('sort_order');
        if ($hold) {
            DB::table('ticket_statuses')->where('sort_order', '>', $hold)->increment('sort_order');
        }
        DB::table('ticket_statuses')->insert(['code' => 'BACKLOG', 'name' => 'Backlog', 'is_open' => 1, 'is_final' => 0, 'color' => 'dark',
            'sort_order' => $hold ? $hold + 1 : (int) DB::table('ticket_statuses')->max('sort_order') + 1, 'created_at' => now(), 'updated_at' => now()]);
        $id = DB::table('ticket_statuses')->pluck('id', 'code');

        $rows = [];
        foreach (['NEW', 'ACKNOWLEDGED', 'REOPENED', 'ESCALATED'] as $from) {
            if (isset($id[$from])) $rows[] = ['from_status_id' => $id[$from], 'to_status_id' => $id['BACKLOG'], 'permission' => 'ticket.work', 'requires_comment' => 0];
        }
        $rows[] = ['from_status_id' => $id['BACKLOG'], 'to_status_id' => $id['ASSIGNED'], 'permission' => 'ticket.assign', 'requires_comment' => 0];
        $rows[] = ['from_status_id' => $id['BACKLOG'], 'to_status_id' => $id['CANCELLED'], 'permission' => 'ticket.cancel', 'requires_comment' => 1];
        $rows[] = ['from_status_id' => $id['BACKLOG'], 'to_status_id' => $id['ESCALATED'], 'permission' => 'ticket.escalate', 'requires_comment' => 1];
        DB::table('ticket_status_transitions')->insert($rows);
    }

    public function down(): void
    {
        $b = DB::table('ticket_statuses')->where('code', 'BACKLOG')->value('id');
        if ($b) {
            DB::table('ticket_status_transitions')->where('from_status_id', $b)->orWhere('to_status_id', $b)->delete();
            DB::table('ticket_statuses')->where('id', $b)->delete();
        }
    }
};
