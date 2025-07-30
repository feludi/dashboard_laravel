<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $minutes = 60): Response
    {
        // Only cache GET requests for authenticated users
        if ($request->method() !== 'GET' || !$request->user()) {
            return $next($request);
        }

        // Create cache key based on URL and user
        $cacheKey = 'response_cache:' . md5($request->fullUrl() . $request->user()->id);

        // Return cached response if exists
        if (Cache::has($cacheKey)) {
            $cachedResponse = Cache::get($cacheKey);
            return response($cachedResponse['content'], 200, $cachedResponse['headers']);
        }

        // Process request
        $response = $next($request);

        // Cache successful responses
        if ($response->getStatusCode() === 200) {
            $cacheData = [
                'content' => $response->getContent(),
                'headers' => $response->headers->all()
            ];
            
            Cache::put($cacheKey, $cacheData, now()->addMinutes($minutes));
        }

        return $response;
    }
}
