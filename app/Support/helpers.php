<?php

use App\Models\Menu;
use App\Models\MenuAccess;

if (! function_exists('canAccess')) {
    function canAccess(int|string $menu, string $permission = 'can_view'): bool
    {
        $user = auth()->user();

        if (! $user || ! in_array($permission, ['can_view', 'can_create', 'can_edit', 'can_delete'], true)) {
            return false;
        }

        $menuId = is_numeric($menu)
            ? (int) $menu
            : Menu::query()->where('route', $menu)->value('id');

        if (! $menuId) {
            return false;
        }

        return (bool) MenuAccess::query()
            ->where('menu_id', $menuId)
            ->where('role', $user->role)
            ->value($permission);
    }
}
