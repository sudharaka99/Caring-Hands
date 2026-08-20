<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuAccess;
use Illuminate\Http\Request;

class MenuAccessController extends Controller
{
    private array $roles = [
        'admin',
        'manager',
        'caregiver',
        'healthcare',
    ];

    public function index()
    {

        $userRole = auth()->user()->role ?? 'guest';

        $menus = Menu::with(['children.accesses','accesses'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->whereHas('accesses', function ($query) use ($userRole) {
                $query->where('role', $userRole)
                    ->where('can_view', 1);})
            ->orderBy('sort_order')
            ->get();

        $Getmenus = Menu::with([
            'accesses' => function ($query) {
                $query->orderBy('role');
            }
        ])
        ->orderBy('sort_order')
        ->get();

        $roles = $this->roles;

        return view(
            'admin.menu-access.index',
            compact('Getmenus', 'roles', 'menus', 'userRole')
        );
    }

    

    public function update(Request $request)
    {
        $request->validate([
            'access' => 'nullable|array',
        ]);

        $menus = Menu::all();

        foreach ($menus as $menu) {

            foreach ($this->roles as $role) {

                $permissions =
                    $request->input(
                        "access.{$menu->id}.{$role}",
                        []
                    );

                MenuAccess::updateOrCreate(
                    [
                        'menu_id' => $menu->id,
                        'role' => $role,
                    ],
                    [
                        'can_view' =>
                            isset($permissions['view']),

                        'can_create' =>
                            isset($permissions['create']),

                        'can_edit' =>
                            isset($permissions['edit']),

                        'can_delete' =>
                            isset($permissions['delete']),
                    ]
                );
            }
        }

        return redirect()
            ->route('admin.menu-access.index')
            ->with(
                'success',
                'Menu access permissions updated successfully.'
            );
    }
}