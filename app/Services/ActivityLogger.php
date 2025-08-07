<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($action, $model = null, $details = [])
    {
        $logData = [
            'action' => $action,
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
            'url' => request()->fullUrl(),
        ];

        if ($model) {
            $logData['model'] = get_class($model);
            $logData['model_id'] = $model->id ?? null;
        }

        if (!empty($details)) {
            $logData['details'] = $details;
        }

        Log::channel('activity')->info('User Activity', $logData);
    }

    public static function logSecurity($event, $details = [])
    {
        $logData = [
            'event' => $event,
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
            'details' => $details
        ];

        Log::channel('security')->warning('Security Event', $logData);
    }

    public static function logError($error, $context = [])
    {
        $logData = [
            'error' => $error,
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'url' => request()->fullUrl(),
            'timestamp' => now()->toISOString(),
            'context' => $context
        ];

        Log::channel('application')->error('Application Error', $logData);
    }
}
