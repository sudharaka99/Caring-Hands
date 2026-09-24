<?php

namespace App\Http\Controllers\Healthcare;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // ==========================================
        // STATS
        // ==========================================

        $totalElders = DB::table('elders')->where('status', 'active')->count();

        $activeCarePlans = DB::table('care_plans')
            ->where('status', 'active')
            ->count();

        $activeMedications = DB::table('medications')
            ->where('status', 'active')
            ->count();

        $todayAppointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->whereDate('appointment_date', today())
                ->count()
            : 0;

        // ==========================================
        // RECENT
        // ==========================================

        $recentElders = DB::table('elders')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $upcomingAppointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->whereDate('appointment_date', '>=', today())
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->limit(5)
                ->get()
            : collect();

        // Today's shift
        $todayShift = DB::table('staff_shifts')
            ->join('shift_types', 'shift_types.id', '=', 'staff_shifts.shift_type_id')
            ->where('staff_shifts.user_id', Auth::id())
            ->whereDate('staff_shifts.shift_date', today())
            ->select(
                'staff_shifts.*',
                'shift_types.name as shift_name',
                'shift_types.start_time',
                'shift_types.end_time'
            )
            ->first();

        // ==========================================
        // MENUS
        // ==========================================

        $userRole = Auth::user()->role ?? 'guest';

        $menus = Menu::with(['children.accesses', 'accesses'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->whereHas('accesses', function ($query) use ($userRole) {
                $query->where('role', $userRole)->where('can_view', 1);
            })
            ->orderBy('sort_order')
            ->get();

        return view('healthcare.dashboard', compact(
            'totalElders',
            'activeCarePlans',
            'activeMedications',
            'todayAppointments',
            'recentElders',
            'upcomingAppointments',
            'todayShift',
            'menus',
            'userRole'
        ));
    }
}