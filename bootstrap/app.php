<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureActiveUser::class);
        $middleware->appendToGroup('web', \App\Http\Middleware\InactivityTimeout::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return null; // default handling
            }

            // "403 Forbidden" (a page the user may not open): send the signed-in user to a page they can use, with an alert.
            // Request pages go to the request list, everything else to the dashboard. A page is never redirected to itself,
            // so a user who cannot open the dashboard still gets the plain 403 page instead of a redirect loop.
            if ($e->getStatusCode() === 403 && $request->user()) {
                $target = $request->routeIs('tickets.*', 'attachments.*') ? 'tickets.index' : 'dashboard';
                if ($request->routeIs($target)) {
                    return null;
                }
                return redirect()->route($target)->with('denied', 'That page is not accessible to you.');
            }

            // "419 Page Expired" (stale CSRF token, e.g. a login page left open for hours): send the user
            // back with a clear message instead of an error page.
            if ($e->getStatusCode() !== 419) {
                return null;
            }
            if (! $request->user()) {
                return redirect()->route('login')
                    ->withErrors(['email' => 'Your page had expired. Please sign in again.']);
            }
            return redirect()->back()
                ->withInput($request->except(['password', 'password_confirmation', 'current_password', '_token']))
                ->withErrors(['session' => 'Your page had expired. Please try again.']);
        });
    })->create();
