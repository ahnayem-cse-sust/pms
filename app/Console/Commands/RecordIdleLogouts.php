<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\SessionTracker;
use Illuminate\Console\Command;

class RecordIdleLogouts extends Command
{
    protected $signature = 'itsm:record-logouts';
    protected $description = 'Record a logout (at the last activity time) for users idle longer than the inactivity limit';

    public function handle(): int
    {
        $minutes = (int) config('itsm.inactivity_minutes', 15);
        $count = 0;

        User::where('session_open', true)
            ->where(fn ($q) => $q->whereNull('last_activity_at')->orWhere('last_activity_at', '<', now()->subMinutes($minutes)))
            ->get()
            ->each(function (User $u) use (&$count) {
                SessionTracker::recordLogout($u, $u->last_activity_at, 'timeout', $u->last_activity_ip);
                $count++;
            });

        $this->info("Recorded {$count} idle logout(s).");
        return self::SUCCESS;
    }
}
