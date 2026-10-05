<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function editPassword()
    {
        return view('profile.password', ['user' => auth()->user()->load(['roles', 'department'])]);
    }

    public function updatePassword(Request $r)
    {
        $d = $r->validate([
            'current_password' => ['required', 'current_password'],
            // Policy: any password is accepted (no length/complexity rules), matching the admin screen.
            'password' => ['required', 'confirmed', 'string', 'max:255'],
        ]);

        $user = $r->user();
        $user->update(['password' => $d['password'], 'password_changed_at' => now()]);
        AuditLog::record('user.password_changed', $user);

        return redirect()->route('profile.password')->with('ok', 'Your password has been changed.');
    }
}
