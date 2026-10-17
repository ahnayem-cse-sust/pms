<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Escalate button: a request can be escalated from any open working state (including New and Acknowledged),
 * by the IT Admin or by the primary responsible IT employee (IT Team Members now hold ticket.escalate).
 */
return new class extends Migration
{
    public function up(): void
    {
        $id = DB::table('ticket_statuses')->pluck('id', 'code');
        if (isset($id['ESCALATED'])) {
            foreach (['NEW', 'ACKNOWLEDGED'] as $from) {
                if (isset($id[$from])) {
                    DB::table('ticket_status_transitions')->updateOrInsert(
                        ['from_status_id' => $id[$from], 'to_status_id' => $id['ESCALATED'], 'permission' => 'ticket.escalate'],
                        ['requires_comment' => 1]
                    );
                }
            }
        }

        foreach (config('itsm.roles') as $slug => $name) {
            DB::table('roles')->where('slug', $slug)->update([
                'name' => $name,
                'permissions' => json_encode(config("itsm.permissions.$slug", [])),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        //
    }
};
