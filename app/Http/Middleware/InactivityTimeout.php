<?php

namespace App\Http\Middleware;

use App\Services\SessionTracker;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** Signs a user out after itsm.inactivity_minutes (default 15) without any request. */
class InactivityTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $minutes = (int) config('itsm.inactivity_minutes', 15);
            $last = $request->session()->get('last_activity_at');

            if ($last && (now()->timestamp - $last) > $minutes * 60) {
                // The real "exit" is the last activity, not the moment this stale session is noticed
                SessionTracker::recordLogout(
                    $user, SessionTracker::fromTimestamp((int) $last), 'timeout',
                    $request->session()->get('last_activity_ip', $request->ip())
                );
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Signed out due to inactivity.'], 401);
                }
                return redirect()->route('login')
                    ->withErrors(['email' => "You were signed out after {$minutes} minutes of inactivity. Please sign in again."]);
            }

            // the background notification poll is not user activity: it must not keep an idle session alive
            if (! $request->routeIs('notifications.poll')) {
                $request->session()->put('last_activity_at', now()->timestamp);
                $request->session()->put('last_activity_ip', $request->ip());
                SessionTracker::touch($user, $request->ip());
            }
        }

        return $next($request);
    }
}
