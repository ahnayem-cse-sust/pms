<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** Signs a user out after itsm.inactivity_minutes (default 15) without any request. */
class InactivityTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $minutes = (int) config('itsm.inactivity_minutes', 15);
            $last = $request->session()->get('last_activity_at');

            if ($last && (now()->timestamp - $last) > $minutes * 60) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Signed out due to inactivity.'], 401);
                }
                return redirect()->route('login')
                    ->withErrors(['email' => "You were signed out after {$minutes} minutes of inactivity. Please sign in again."]);
            }
            $request->session()->put('last_activity_at', now()->timestamp);
        }

        return $next($request);
    }
}
