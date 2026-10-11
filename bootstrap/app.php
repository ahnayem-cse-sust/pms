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
        // "419 Page Expired" (stale CSRF token, e.g. a login page left open for hours): send the user
        // back with a clear message instead of an error page.
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($e->getStatusCode() !== 419 || $request->expectsJson()) {
                return null; // default handling
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
