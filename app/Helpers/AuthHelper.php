<?php

if (!function_exists('auth_user')) {
    /**
     * Get the currently authenticated user
     */
    function auth_user()
    {
        return \App\Http\Controllers\AuthController::user();
    }
}

if (!function_exists('auth_id')) {
    /**
     * Get the currently authenticated user ID
     */
    function auth_id()
    {
        $user = auth_user();
        if (is_object($user) && isset($user->id)) {
            return $user->id;
        }
        return session('user_id');
    }
}

if (!function_exists('auth_check')) {
    /**
     * Check if user is authenticated
     */
    function auth_check()
    {
        return \App\Http\Controllers\AuthController::isAuthenticated();
    }
}
