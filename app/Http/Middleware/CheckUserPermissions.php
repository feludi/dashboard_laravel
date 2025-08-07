<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->user();
        
        if (!$user) {
            abort(401, 'Unauthorized');
        }

        $allowed = match($permission) {
            'view-maps' => $user->canViewMaps(),
            'view-foreigner-list' => $user->canViewForeignerList(),
            'add-foreigners' => $user->canAddForeigners(),
            'edit-foreigners' => $user->canEditForeigners(),
            'delete-foreigners' => $user->canDeleteForeigners(),
            'import-foreigners' => $user->canImportForeigners(),
            default => false
        };

        if (!$allowed) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You do not have permission to access this resource.'], 403);
            }
            
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
