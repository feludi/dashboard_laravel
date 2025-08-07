<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');
        
        // Content Security Policy - Enhanced for Leaflet maps and OSM APIs
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net cdnjs.cloudflare.com unpkg.com; " .
               "style-src 'self' 'unsafe-inline' cdn.jsdelivr.net cdnjs.cloudflare.com unpkg.com; " .
               "style-src-elem 'self' 'unsafe-inline' cdn.jsdelivr.net cdnjs.cloudflare.com unpkg.com; " .
               "img-src 'self' data: blob: *.tile.openstreetmap.org *.tile.osm.org unpkg.com; " .
               "font-src 'self' cdnjs.cloudflare.com unpkg.com; " .
               "connect-src 'self' *.tile.openstreetmap.org *.tile.osm.org https://nominatim.openstreetmap.org https://overpass-api.de https://tanahair.indonesia.go.id https://polygons.openstreetmap.fr; " .
               "child-src 'none'; " .
               "object-src 'none'";
        
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
