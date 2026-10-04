<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
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
