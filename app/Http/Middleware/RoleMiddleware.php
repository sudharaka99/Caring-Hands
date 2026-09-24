<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage in routes:
     *   ->middleware('role:admin')
     *   ->middleware('role:admin,manager')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Must be logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role ?? null;

        // Allow if user's role matches any of the allowed roles
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}