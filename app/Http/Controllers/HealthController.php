<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HealthController extends Controller
{
    public function index()
    {
        $checks = [
            'app' => $this->checkApplication(),
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
        ];

        $overall = collect($checks)->every(fn($check) => $check['status'] === 'ok');

        return response()->json([
            'status' => $overall ? 'healthy' : 'unhealthy',
            'timestamp' => now()->toISOString(),
            'version' => '1.0.0',
            'environment' => config('app.env'),
            'checks' => $checks,
            'uptime' => $this->getUptime(),
        ], $overall ? 200 : 503);
    }

    public function simple()
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toISOString()
        ]);
    }

    private function checkApplication()
    {
        try {
            $key = config('app.key');
            return [
                'status' => $key ? 'ok' : 'error',
                'message' => $key ? 'Application key configured' : 'Application key missing',
                'details' => [
                    'environment' => config('app.env'),
                    'debug' => config('app.debug'),
                    'timezone' => config('app.timezone'),
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Application check failed',
                'error' => $e->getMessage()
            ];
        }
    }

    private function checkDatabase()
    {
        try {
            $start = microtime(true);
            DB::select('SELECT 1');
            $duration = round((microtime(true) - $start) * 1000, 2);

            return [
                'status' => 'ok',
                'message' => 'Database connection successful',
                'details' => [
                    'connection' => config('database.default'),
                    'response_time_ms' => $duration
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed',
                'error' => $e->getMessage()
            ];
        }
    }

    private function checkCache()
    {
        try {
            $key = 'health_check_' . time();
            $value = 'test_value';
            
            Cache::put($key, $value, 60);
            $retrieved = Cache::get($key);
            Cache::forget($key);

            return [
                'status' => $retrieved === $value ? 'ok' : 'error',
                'message' => $retrieved === $value ? 'Cache working' : 'Cache not working',
                'details' => [
                    'driver' => config('cache.default')
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Cache check failed',
                'error' => $e->getMessage()
            ];
        }
    }

    private function checkStorage()
    {
        try {
            $filename = 'health_check_' . time() . '.txt';
            $content = 'health check test';
            
            Storage::disk('local')->put($filename, $content);
            $retrieved = Storage::disk('local')->get($filename);
            Storage::disk('local')->delete($filename);

            return [
                'status' => $retrieved === $content ? 'ok' : 'error',
                'message' => $retrieved === $content ? 'Storage working' : 'Storage not working',
                'details' => [
                    'disk' => 'local',
                    'writable' => is_writable(storage_path('app'))
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Storage check failed',
                'error' => $e->getMessage()
            ];
        }
    }

    private function getUptime()
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return [
                'load_average' => $load,
                'memory_usage' => [
                    'used' => memory_get_usage(true),
                    'peak' => memory_get_peak_usage(true)
                ]
            ];
        }

        return null;
    }
}
