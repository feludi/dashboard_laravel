<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        $user = AuthController::user();
        
        // If user is not a database user, create a temporary profile
        if (!$user || !is_object($user)) {
            $sessionUser = $user; // Keep session data
            $user = new User([
                'name' => $sessionUser['username'] ?? 'Unknown User',
                'email' => 'session@user.local',
                'created_at' => now(),
            ]);
            $user->id = 0; // Indicate this is a session user
        }
        
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = AuthController::user();
        
        // If user is not a database user, redirect to show with message
        if (!$user || !is_object($user)) {
            return redirect()->route('profile.show')
                ->with('error', 'Profil hanya tersedia untuk user database. Silakan login dengan akun database.');
        }
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = AuthController::user();
        
        // Only allow database users to update profile
        if (!$user || !is_object($user)) {
            return redirect()->route('profile.show')
                ->with('error', 'Hanya user database yang dapat mengupdate profil.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'avatar' => $user->avatar,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = AuthController::user();
        
        // Only allow database users to update password
        if (!$user || !is_object($user)) {
            return redirect()->route('profile.show')
                ->with('error', 'Hanya user database yang dapat mengupdate password.');
        }

        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password saat ini tidak benar.');
                }
            }],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('password_success', 'Password berhasil diperbarui!');
    }

    /**
     * Delete the user's avatar.
     */
    public function deleteAvatar()
    {
        $user = AuthController::user();
        
        // Only allow database users to delete avatar
        if (!$user || !is_object($user)) {
            return redirect()->route('profile.show')
                ->with('error', 'Hanya user database yang dapat menghapus avatar.');
        }

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return back()->with('success', 'Avatar berhasil dihapus!');
    }
}
