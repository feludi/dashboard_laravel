<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (Session::has('authenticated')) {
            return redirect()->route('dashboard.index');
        }
        
        return view('login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // First try to authenticate with database users
        $user = User::where('email', $username)->first();
        
        if ($user && Hash::check($password, $user->password)) {
            // Database user authentication successful
            Session::put('authenticated', true);
            Session::put('username', $user->name);
            Session::put('user_id', $user->id);
            Session::put('login_time', now());

            if ($request->has('remember')) {
                Session::put('remember_login', true);
            }

            return redirect()->route('dashboard.index')->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        // Fallback to hardcoded users for backward compatibility
        $validCredentials = [
            'admin' => 'password',
            'user' => 'password',
            'guest' => 'guest123'
        ];

        if (isset($validCredentials[$username]) && $validCredentials[$username] === $password) {
            // Set session
            Session::put('authenticated', true);
            Session::put('username', $username);
            Session::put('user_id', null); // No database user
            Session::put('login_time', now());
            
            // Remember me functionality
            if ($request->has('remember')) {
                Session::put('remember_login', true);
            }

            return redirect()->route('dashboard.index')->with('success', 'Welcome back, ' . ucfirst($username) . '!');
        }

        return back()->with('error', 'Invalid username or password.')->withInput($request->only('username'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Session::forget(['authenticated', 'username', 'user_id', 'login_time', 'remember_login']);
        Session::flush();
        
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated()
    {
        return Session::has('authenticated') && Session::get('authenticated') === true;
    }

    /**
     * Get current user info
     */
    public static function user()
    {
        if (self::isAuthenticated()) {
            $userId = Session::get('user_id');
            
            // If we have a user_id, get from database
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    return $user;
                }
            }
            
            // Fallback to session data for backward compatibility
            return [
                'username' => Session::get('username'),
                'login_time' => Session::get('login_time'),
                'is_remembered' => Session::get('remember_login', false)
            ];
        }
        
        return null;
    }
}
