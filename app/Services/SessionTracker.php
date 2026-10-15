<?php

namespace App\Services;

use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * Tracks when a user is in a session so a logout can be recorded for the attendance exit time:
 *  - manual logout        -> logged at the moment of logout
 *  - inactivity timeout   -> logged at the user's last activity (when they actually left),
 *                            whether the timeout is noticed by the browser, on their next request,
 *                            or by the scheduled sweep (itsm:record-logouts).
 */
class SessionTracker
{
    /** Mark the user as active (throttled to one database write a minute). */
    public static function touch(User $user, ?string $ip, bool $force = false): void
    {
        if (! $force && $user->session_open && $user->last_activity_at && $user->last_activity_at->gt(now()->subSeconds(60))) {
            return;
        }
        $user->forceFill(['session_open' => true, 'last_activity_at' => now(), 'last_activity_ip' => $ip])->saveQuietly();
    }

    /**
     * Epoch seconds -> Carbon in the application time zone (GMT+6).
     * (Carbon::createFromTimestamp() returns UTC on Carbon 3; Eloquent stores a Carbon's own wall-clock time,
     * so a UTC instance would be saved 6 hours early.)
     */
    public static function fromTimestamp(int $timestamp): Carbon
    {
        return Carbon::createFromTimestamp($timestamp)->setTimezone(config('app.timezone'));
    }

    /** Record one logout event (only if a session was open, so it is never recorded twice). */
    public static function recordLogout(User $user, ?Carbon $at = null, string $reason = 'manual', ?string $ip = null): void
    {
        if (! $user->session_open) {
            return;
        }
        // Whatever the caller passes, store the time as GMT+6 wall-clock time like every other timestamp
        $at = ($at ?? now())->copy()->setTimezone(config('app.timezone'));

        LoginHistory::create([
            'user_id' => $user->id,
            'email_tried' => $user->email,
            'successful' => true,
            'event' => 'logout',
            'reason' => $reason,
            'ip_address' => $ip,
            'user_agent' => $reason === 'manual' ? substr((string) request()?->userAgent(), 0, 255) : null,
            'created_at' => $at,
        ]);
        $user->forceFill(['session_open' => false])->saveQuietly();
    }
}
