<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OptimizedResponse
{
    public function handle(Request $request, Closure $next, $duration = 300)
    {
        if ($request->method() !== 'GET') {
            return $next($request);
        }

        $key = 'response:' . md5($request->fullUrl() . ':' . auth()->id());
        
        if (Cache::has($key)) {
            $cachedResponse = Cache::get($key);
            return response($cachedResponse['content'])
                ->withHeaders($cachedResponse['headers'])
                ->header('X-Cache', 'HIT');
        }

        $response = $next($request);

        if ($response->getStatusCode() === 200) {
            Cache::put($key, [
                'content' => $response->getContent(),
                'headers' => $response->headers->all()
            ], (int)$duration);
        }

        return $response->header('X-Cache', 'MISS');
    }
}
