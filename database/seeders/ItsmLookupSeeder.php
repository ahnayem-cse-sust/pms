<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItsmLookupSeeder extends Seeder
{
    public function run(): void
    {
        // Already seeded (e.g. `php artisan db:seed` on an existing database): nothing to do.
        if (DB::table('ticket_statuses')->exists()) {
            return;
        }

        $now = now();

        // ---- Statuses ----
        $statuses = [
            // code, name, is_open, is_final, color
            ['NEW',               'New',               1, 0, 'primary'],
            ['ACKNOWLEDGED',      'Acknowledged',      1, 0, 'info'],
            ['ASSIGNED',          'Assigned',          1, 0, 'info'],
            ['IN_PROGRESS',       'In Progress',       1, 0, 'warning'],
            ['WAITING_USER',      'Waiting for User',  1, 0, 'secondary'],
            ['ON_HOLD',           'On Hold',           1, 0, 'secondary'],
            ['ESCALATED',         'Escalated',         1, 0, 'danger'],
            ['RESOLVED',          'Resolved',          1, 0, 'success'],
            ['USER_CONFIRMATION', 'User Confirmation', 1, 0, 'success'],
            ['REOPENED',          'Reopened',          1, 0, 'danger'],
            ['CLOSED',            'Closed',            0, 1, 'dark'],
            ['CANCELLED',         'Cancelled',         0, 1, 'dark'],
        ];
        foreach ($statuses as $i => [$code, $name, $open, $final, $color]) {
            DB::table('ticket_statuses')->insert([
                'code' => $code, 'name' => $name, 'is_open' => $open, 'is_final' => $final,
                'color' => $color, 'sort_order' => $i + 1, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }
        $id = fn (string $code) => DB::table('ticket_statuses')->where('code', $code)->value('id');

        // ---- Transitions: from, to, permission, requires_comment ----
        $transitions = [
            ['NEW',               'ACKNOWLEDGED',      'ticket.acknowledge', 0],
            ['NEW',               'ASSIGNED',          'ticket.assign',      0],
            ['ACKNOWLEDGED',      'ASSIGNED',          'ticket.assign',      0],
            ['ASSIGNED',          'IN_PROGRESS',       'ticket.work',        0],
            ['IN_PROGRESS',       'WAITING_USER',      'ticket.work',        1],
            ['WAITING_USER',      'IN_PROGRESS',       'ticket.work',        0], // also auto when requester replies
            ['IN_PROGRESS',       'ON_HOLD',           'ticket.work',        1],
            ['ON_HOLD',           'IN_PROGRESS',       'ticket.work',        0],
            ['IN_PROGRESS',       'RESOLVED',          'ticket.work',        1], // resolution text mandatory
            ['RESOLVED',          'USER_CONFIRMATION', 'system',             0], // automatic
            ['USER_CONFIRMATION', 'CLOSED',            'ticket.confirm',     0], // requester / dept head
            ['USER_CONFIRMATION', 'CLOSED',            'ticket.close',       0], // officer or auto-close job
            ['USER_CONFIRMATION', 'REOPENED',          'ticket.confirm',     1], // "problem still exists"
            ['CLOSED',            'REOPENED',          'ticket.reopen',      1],
            ['REOPENED',          'ASSIGNED',          'ticket.assign',      0],
            ['REOPENED',          'IN_PROGRESS',       'ticket.work',        0],
            ['ESCALATED',         'ASSIGNED',          'ticket.assign',      0],
            ['ESCALATED',         'IN_PROGRESS',       'ticket.work',        0],
            ['NEW',               'CANCELLED',         'ticket.cancel',      1],
            ['ACKNOWLEDGED',      'CANCELLED',         'ticket.cancel',      1],
            ['ASSIGNED',          'CANCELLED',         'ticket.cancel',      1],
        ];
        foreach ($transitions as [$from, $to, $perm, $comment]) {
            DB::table('ticket_status_transitions')->insert([
                'from_status_id' => $id($from), 'to_status_id' => $id($to),
                'permission' => $perm, 'requires_comment' => $comment,
            ]);
        }
        // Escalate from any active working state (officer / system SLA job)
        foreach (['ASSIGNED', 'IN_PROGRESS', 'WAITING_USER', 'ON_HOLD', 'REOPENED'] as $from) {
            DB::table('ticket_status_transitions')->insert([
                'from_status_id' => $id($from), 'to_status_id' => $id('ESCALATED'),
                'permission' => 'ticket.escalate', 'requires_comment' => 1,
            ]);
        }

        // ---- Priorities (SLA minutes; working-day values converted at 8h/day, tune in admin UI) ----
        $priorities = [
            ['Critical', 1, 'danger',    15,  240],
            ['High',     2, 'warning',   30,  480],
            ['Medium',   3, 'primary',  120,  960],
            ['Low',      4, 'secondary', 240, 2400],
        ];
        foreach ($priorities as [$name, $level, $color, $resp, $reso]) {
            DB::table('ticket_priorities')->insert([
                'name' => $name, 'level' => $level, 'color' => $color,
                'response_minutes' => $resp, 'resolution_minutes' => $reso,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ---- Ticket types ----
        foreach ([
            ['Incident', 'INC', 0], ['Service Request', 'SR', 0], ['Change Request', 'CHG', 1],
            ['Access Request', 'ACC', 1], ['IT Asset Request', 'AST', 1],
        ] as [$name, $code, $approval]) {
            DB::table('ticket_types')->insert([
                'name' => $name, 'code' => $code, 'requires_approval' => $approval,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ---- Categories / sub-categories ----
        $catalogue = [
            'Hardware' => ['Desktop', 'Laptop', 'Monitor', 'Printer', 'Scanner', 'UPS', 'Keyboard/Mouse', 'Network device', 'Server', 'Other'],
            'Software' => ['ERP', 'VAT Software', 'HRM', 'Payroll', 'Accounts', 'Windows', 'Office', 'Antivirus', 'Database', 'Application', 'Other'],
            'Network' => ['LAN', 'Wi-Fi', 'Internet', 'VPN', 'IP address', 'Network printer', 'Switch', 'Router', 'Firewall'],
            'User & Access' => ['New user', 'Password reset', 'Account locked', 'Application access', 'Folder access', 'Email access', 'ERP permission', 'Internet permission'],
            'IT Service' => ['Installation', 'Configuration', 'Data recovery', 'Backup', 'Training', 'Report request', 'New equipment', 'Maintenance'],
            'Security' => ['Malware', 'Suspicious email', 'Unauthorized access', 'Security incident', 'Password/security issue'],
        ];
        $order = 1;
        foreach ($catalogue as $cat => $subs) {
            $catId = DB::table('ticket_categories')->insertGetId([
                'name' => $cat, 'sort_order' => $order++, 'created_at' => $now, 'updated_at' => $now,
            ]);
            foreach ($subs as $sub) {
                DB::table('ticket_subcategories')->insert([
                    'category_id' => $catId, 'name' => $sub, 'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        // ---- Settings ----
        foreach ([
            ['upload.max_kb',          '5120',                                          'upload'],
            ['upload.allowed_ext',     'jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,log,zip', 'upload'],
            ['ticket.auto_close_days', '3',                                             'workflow'],
            ['ticket.reopen_window_days', '7',                                          'workflow'],
            ['security.session_minutes', '30',                                          'security'],
            ['security.max_failed_logins', '5',                                         'security'],
            ['security.lockout_minutes', '15',                                          'security'],
        ] as [$key, $value, $group]) {
            DB::table('system_settings')->insert([
                'key' => $key, 'value' => $value, 'group' => $group,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }
}
