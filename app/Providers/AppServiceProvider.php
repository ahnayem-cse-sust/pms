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

        // Session lifetime is long on purpose (a 15-minute one expires the login page and causes 419 on sign-in);
        // idle sign-out after 15 minutes is enforced by the InactivityTimeout middleware, the browser timer and the sweep.
        config(['session.lifetime' => (int) config('itsm.session_lifetime_minutes', 480)]);
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Every permission name becomes a Gate: @can('ticket.assign'), middleware('can:ticket.assign')
        $all = collect(config('itsm.permissions'))->flatten()
            ->merge(collect(config('itsm.permission_catalog'))->map(fn ($g) => array_keys($g))->flatten())->unique();
        foreach ($all as $permission) {
            Gate::define($permission, fn ($user) => $user->hasPermission($permission));
        }

        // A sidebar menu shows only when the user holds the menu permission and the access the menu opens.
        foreach (config('itsm.sidebar_menus', []) as $items) {
            foreach ($items as $key => [$label, $needs]) {
                Gate::define($key, fn ($user) => $user->hasPermission($key) && collect($needs)->every(fn ($p) => $user->hasPermission($p)));
            }
        }
    }
}
