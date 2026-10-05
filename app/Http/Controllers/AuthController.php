<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\LoginHistory;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $cred = $request->validate(['email' => 'required|email', 'password' => 'required']);
        $user = User::where('email', $cred['email'])->first();
        $maxFails = (int) SystemSetting::get('security.max_failed_logins', 5);
        $lockMin = (int) SystemSetting::get('security.lockout_minutes', 15);

        if ($user && $user->locked_until && $user->locked_until->isFuture()) {
            $this->record($user, $cred['email'], false, $request);
            return back()->withErrors(['email' => "Account locked. Try again after {$user->locked_until->format('H:i')}."])->onlyInput('email');
        }

        if ($user && $user->is_active && Auth::attempt($cred)) {
            $request->session()->regenerate();
            $user->update(['failed_logins' => 0, 'locked_until' => null, 'last_login_at' => now(), 'last_login_ip' => $request->ip()]);
            $this->record($user, $cred['email'], true, $request);
            return redirect()->intended('/');
        }

        if ($user) {
            $fails = $user->failed_logins + 1;
            $user->update([
                'failed_logins' => $fails >= $maxFails ? 0 : $fails,
                'locked_until' => $fails >= $maxFails ? now()->addMinutes($lockMin) : null,
            ]);
        }
        $this->record($user, $cred['email'], false, $request);
        return back()->withErrors(['email' => 'Invalid credentials or disabled account.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        AuditLog::record('logout');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    protected function record(?User $user, string $email, bool $ok, Request $r): void
    {
        LoginHistory::create([
            'user_id' => $user?->id, 'email_tried' => $email, 'successful' => $ok,
            'ip_address' => $r->ip(), 'user_agent' => substr((string) $r->userAgent(), 0, 255),
            'created_at' => now(),
        ]);
    }
}
