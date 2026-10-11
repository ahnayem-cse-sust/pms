<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Force the system time zone (GMT+6) for Carbon, now(), the scheduler and every displayed date/time
        $tz = config('itsm.timezone', 'Asia/Dhaka');
        config(['app.timezone' => $tz]);
        date_default_timezone_set($tz);

        // Idle sessions expire after the inactivity limit (the InactivityTimeout middleware enforces it too)
        config(['session.lifetime' => max(1, (int) config('itsm.inactivity_minutes', 15))]);
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Every permission name becomes a Gate: @can('ticket.assign'), middleware('can:ticket.assign')
        $all = collect(config('itsm.permissions'))->flatten()->unique();
        foreach ($all as $permission) {
            Gate::define($permission, fn ($user) => $user->hasPermission($permission));
        }
    }
}
