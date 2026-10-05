<?php

namespace App\Console\Commands;

use App\Models\SystemSetting;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Console\Command;

class AutoCloseTickets extends Command
{
    protected $signature = 'itsm:auto-close';
    protected $description = 'Close tickets awaiting user confirmation longer than ticket.auto_close_days';

    public function handle(TicketService $svc): int
    {
        $days = (int) SystemSetting::get('ticket.auto_close_days', 3);
        $actor = User::withRole('admin')->first();
        if (! $actor) {
            $this->warn('No admin user found; nothing done.');
            return self::FAILURE;
        }

        $tickets = Ticket::whereHas('status', fn ($s) => $s->where('code', 'USER_CONFIRMATION'))
            ->where('resolved_at', '<', now()->subDays($days))->get();

        foreach ($tickets as $t) {
            $svc->changeStatus($t, 'CLOSED', $actor, null, true);
            $svc->log($t, $actor, 'auto_closed', null, null, null, "No response from requester for {$days} days");
        }
        $this->info("Auto-closed {$tickets->count()} ticket(s).");
        return self::SUCCESS;
    }
}
