<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MenuPermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()?->getName();

        if (! $routeName || ! str_starts_with($routeName, 'admin.')) {
            return $next($request);
        }

        if (in_array($routeName, [
            'admin.dashboard',
            'admin.dashboard.stats',
            'admin.menus.index',
            'admin.menus.create',
            'admin.menus.store',
            'admin.menus.show',
            'admin.menus.edit',
            'admin.menus.update',
            'admin.menus.destroy',
            'admin.menu-access.index',
            'admin.menu-access.update',
        ], true)) {
            return $next($request);
        }

        $permission = match (true) {
            $request->isMethod('GET') && str_ends_with($routeName, '.create') => 'can_create',
            $request->isMethod('GET') && str_ends_with($routeName, '.edit') => 'can_edit',
            $request->isMethod('POST') => 'can_create',
            $request->isMethod('PUT'), $request->isMethod('PATCH') => 'can_edit',
            $request->isMethod('DELETE') => 'can_delete',
            default => 'can_view',
        };

        $menuRoute = preg_replace('/\.(create|store|show|edit|update|destroy|search|export|toggle-status)$/', '.index', $routeName);

        if (str_starts_with($routeName, 'admin.reports.')) {
            $menuRoute = 'admin.reports.index';
        }

        abort_unless(canAccess($menuRoute, $permission), 403);

        return $next($request);
    }
}
