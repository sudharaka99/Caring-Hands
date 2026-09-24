<?php

namespace App\Http\Controllers\Caregiver;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        // ==========================================
        // GET CAREGIVER PROFILE
        // ==========================================

        $caregiverProfile = DB::table('caregiver')
            ->where('user_id', $userId)
            ->first();

        // ==========================================
        // SCOPED STATS — only THIS caregiver's elders
        // ==========================================

        // Elders assigned to this caregiver
        // (Adjust the column name — you may use caregiver_id or caregiver name)
        $caregiverName = DB::table('users')->where('id', $userId)->value('name');

        $assignedElders = DB::table('elders')
            ->where('caregiver', $caregiverName)   // ← adjust if you use caregiver_id
            ->where('status', 'active')
            ->get();

        $totalAssigned = $assignedElders->count();

        // Today's medication tasks
        $todayMedications = DB::table('medication_logs')
            ->where('caregiver_id', $caregiverProfile->id ?? 0)
            ->whereDate('scheduled_date', today())
            ->where('status', 'pending')
            ->count();

        // Today's appointments
        $todayAppointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->whereIn('elder_id', $assignedElders->pluck('id'))
                ->whereDate('appointment_date', today())
                ->count()
            : 0;

        // Active care plans for their elders
        $activeCarePlans = DB::table('care_plans')
            ->whereIn('elder_id', $assignedElders->pluck('id'))
            ->where('status', 'active')
            ->count();

        // Today's shift
        $todayShift = DB::table('staff_shifts')
            ->join('shift_types', 'shift_types.id', '=', 'staff_shifts.shift_type_id')
            ->where('staff_shifts.user_id', $userId)
            ->whereDate('staff_shifts.shift_date', today())
            ->select('staff_shifts.*', 'shift_types.name as shift_name',
                     'shift_types.start_time', 'shift_types.end_time')
            ->first();

        // Recent care tasks
        $recentElders = $assignedElders->take(5);


        // ==========================================
        // MENU ACCESS
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


        return view('caregiver.dashboard', compact(
            'caregiverProfile',
            'assignedElders',
            'totalAssigned',
            'todayMedications',
            'todayAppointments',
            'activeCarePlans',
            'todayShift',
            'recentElders',
            'menus',
            'userRole'
        ));
    }
}