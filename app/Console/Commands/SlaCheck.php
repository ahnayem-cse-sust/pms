<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Console\Command;

class SlaCheck extends Command
{
    protected $signature = 'itsm:sla-check';
    protected $description = 'Update SLA status (on_track / warning at 75% / breached) and alert the IT Admin';

    public function handle(TicketService $svc): int
    {
        $tickets = Ticket::with('assignee', 'status')
            ->whereNotNull('sla_resolution_due_at')
            ->whereHas('status', fn ($s) => $s->whereNotIn('code', ['RESOLVED', 'USER_CONFIRMATION', 'CLOSED', 'CANCELLED']))
            ->get();

        $changed = 0;
        foreach ($tickets as $t) {
            $total = max(1, $t->created_at->diffInSeconds($t->sla_resolution_due_at, true));
            $elapsed = $t->created_at->diffInSeconds(now(), true);
            $new = now()->gt($t->sla_resolution_due_at) ? 'breached' : ($elapsed / $total >= 0.75 ? 'warning' : 'on_track');

            if ($new !== $t->sla_status) {
                $t->update(['sla_status' => $new]);
                $changed++;
                if ($new !== 'on_track') {
                    $label = $new === 'breached' ? 'SLA BREACHED' : 'SLA approaching (75%)';
                    $svc->notify(array_merge($svc->officers()->all(), [$t->assignee]), $t, "{$label}: {$t->ticket_no} {$t->subject}");
                }
            }
        }
        $this->info("SLA status updated on {$changed} ticket(s).");
        return self::SUCCESS;
    }
}
