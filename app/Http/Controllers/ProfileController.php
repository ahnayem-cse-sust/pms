<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function editPassword()
    {
        return view('profile.password', ['user' => auth()->user()->load(['roles', 'department'])]);
    }

    /** Upload or replace the signed-in user's profile picture (private storage, served through avatar()). */
    public function updatePhoto(Request $r)
    {
        $r->validate([
            'photo' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'photo.image' => 'Please choose a JPG, PNG or WEBP image.',
            'photo.mimes' => 'Please choose a JPG, PNG or WEBP image.',
            'photo.max' => 'The picture must be 2 MB or smaller.',
        ]);

        $user = $r->user();
        $old = $user->avatar_path;
        $file = $r->file('photo');
        $path = $file->storeAs('avatars', $user->id . '-' . bin2hex(random_bytes(8)) . '.' . $file->extension(), 'local');
        $user->update(['avatar_path' => $path]);
        if ($old) {
            Storage::disk('local')->delete($old);
        }
        AuditLog::record('user.avatar_changed', $user);

        return redirect()->route('profile.password')->with('ok', 'Your profile picture has been updated.');
    }

    public function removePhoto(Request $r)
    {
        $user = $r->user();
        if ($user->avatar_path) {
            Storage::disk('local')->delete($user->avatar_path);
            $user->update(['avatar_path' => null]);
            AuditLog::record('user.avatar_removed', $user);
        }

        return redirect()->route('profile.password')->with('ok', 'Your profile picture has been removed.');
    }

    /** Any signed-in user may view another user's picture (it appears next to names across the system). */
    public function avatar(User $user)
    {
        abort_unless($user->avatar_path && Storage::disk('local')->exists($user->avatar_path), 404);

        return Storage::disk('local')->response($user->avatar_path, null, [
            'Cache-Control' => 'private, max-age=86400',
            'X-Content-Type-Options' => 'nosniff',
        ]);
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
