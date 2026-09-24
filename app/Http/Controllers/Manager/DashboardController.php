<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // ==========================================
        // ELDER STATISTICS (manager scope)
        // ==========================================

        $managerId = auth()->id();

        // If managers should only see their assigned elders,
        // uncomment and use these:
        //
        // $totalElders   = DB::table('elders')->where('manager_id', $managerId)->count();
        // $activeElders  = DB::table('elders')->where('manager_id', $managerId)->where('status', 'active')->count();

        $totalElders = DB::table('elders')->count();

        $activeElders = DB::table('elders')
            ->where('status', 'active')
            ->count();

        $newAdmissions = DB::table('elders')
            ->whereMonth('admission_date', now()->month)
            ->count();

        $recentElders = DB::table('elders')
            ->latest()
            ->limit(5)
            ->get();


        // ==========================================
        // STAFF COUNTS (manager view)
        // ==========================================

        $totalCaregivers = DB::table('users')
            ->where('role', 'caregiver')
            ->count();

        $totalHealthcare = DB::table('users')
            ->where('role', 'healthcare')
            ->count();

        $carePlans = DB::table('care_plans')
            ->where('status', 'active')
            ->count();

        $medicationCount = DB::table('medications')
            ->where('status', 'active')
            ->count();


        // ==========================================
        // MENU ACCESS (role-aware)
        // ==========================================

        $userRole = auth()->user()->role ?? 'guest';

        $menus = Menu::with(['children.accesses', 'accesses'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->whereHas('accesses', function ($query) use ($userRole) {
                $query->where('role', $userRole)
                      ->where('can_view', 1);
            })
            ->orderBy('sort_order')
            ->get();


        // ==========================================
        // RETURN VIEW
        // ==========================================

        return view('manager.dashboard', compact(
            'totalElders',
            'activeElders',
            'newAdmissions',
            'recentElders',
            'totalCaregivers',
            'totalHealthcare',
            'carePlans',
            'medicationCount',
            'menus',
            'userRole'
        ));
    }
}
