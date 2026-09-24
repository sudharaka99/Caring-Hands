<?php

namespace App\Http\Controllers\Owner;

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
        // GET OWNER'S LINKED ELDERS
        // ==========================================

        $ownerId = $this->currentOwnerId();

        $elderIds = DB::table('elder_owner')
            ->where('owner_id', $ownerId)
            ->pluck('elder_id');

        // ==========================================
        // STATS FOR OWNER'S ELDERS ONLY
        // ==========================================

        $totalElders = $elderIds->count();

        $activeCarePlans = DB::table('care_plans')
            ->whereIn('elder_id', $elderIds)
            ->where('status', 'active')
            ->count();

        $activeMedications = DB::table('medications')
            ->whereIn('elder_id', $elderIds)
            ->where('status', 'active')
            ->count();

        $upcomingAppointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->whereIn('elder_id', $elderIds)
                ->whereDate('appointment_date', '>=', today())
                ->count()
            : 0;

        // ==========================================
        // RECENT DATA
        // ==========================================

        $elders = DB::table('elders')
            ->whereIn('id', $elderIds)
            ->get();

        $recentAppointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->whereIn('elder_id', $elderIds)
                ->orderByDesc('appointment_date')
                ->limit(5)
                ->get()
            : collect();

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

        return view('owner.dashboard', compact(
            'totalElders',
            'activeCarePlans',
            'activeMedications',
            'upcomingAppointments',
            'elders',
            'recentAppointments',
            'menus',
            'userRole'
        ));
    }


    /**
     * Get the owner record ID for the current user.
     */
    protected function currentOwnerId()
    {
        return DB::table('owners')
            ->where('user_id', Auth::id())
            ->value('id');
    }
}