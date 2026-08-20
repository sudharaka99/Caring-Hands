<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
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

        $Getmenus = Menu::with('parent')
            ->orderBy('sort_order')
            ->get();

        return view('admin.menus.index', compact('Getmenus', 'menus', 'userRole'));
    }



    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        return view('admin.menus.create', compact('parentMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        Menu::create([
            'name' => $request->name,
            'route' => $request->route,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'sort_order' => $request->sort_order,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('sort_order')
            ->get();

        return view(
            'admin.menus.edit',
            compact('menu', 'parentMenus')
        );
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->parent_id == $menu->id) {
            return back()
                ->withInput()
                ->with('error', 'A menu cannot be its own parent.');
        }

        $menu->update([
            'name' => $request->name,
            'route' => $request->route,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'sort_order' => $request->sort_order,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }
}