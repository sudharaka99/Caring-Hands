<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OwnerController extends Controller
{
    // ==========================================
    // HELPERS
    // ==========================================

    protected function ownerId()
    {
        return DB::table('owners')
            ->where('user_id', Auth::id())
            ->value('id');
    }

    protected function assignedElderIds()
    {
        $ownerId = $this->ownerId();
        if (!$ownerId) return collect();

        return DB::table('elder_owner')
            ->where('owner_id', $ownerId)
            ->pluck('elder_id');
    }

    protected function menus()
    {
        $userRole = Auth::user()->role ?? 'guest';

        $menus = Menu::with(['children.accesses', 'accesses'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->whereHas('accesses', function ($query) use ($userRole) {
                $query->where('role', $userRole)->where('can_view', 1);
            })
            ->orderBy('sort_order')
            ->get();

        return [
            'menus'    => $menus,
            'userRole' => $userRole,
        ];
    }


    // ==========================================
    // ELDERS — Owner's own only
    // ==========================================

    public function eldersIndex()
    {
        $elderIds = $this->assignedElderIds();

        $elders = DB::table('elders')
            ->whereIn('id', $elderIds)
            ->paginate(10);

        return view('owner.elders.index', array_merge(
            ['elders' => $elders],
            $this->menus()
        ));
    }


    public function eldersShow($id)
    {
        $elderIds = $this->assignedElderIds();

        $elder = DB::table('elders')
            ->where('id', $id)
            ->whereIn('id', $elderIds)
            ->first();

        if (!$elder) {
            abort(403, 'This resident is not linked to your account.');
        }

        $carePlans = DB::table('care_plans')->where('elder_id', $id)->get();
        $medications = DB::table('medications')->where('elder_id', $id)->get();
        $appointments = Schema::hasTable('appointments')
            ? DB::table('appointments')->where('elder_id', $id)->orderByDesc('appointment_date')->get()
            : collect();

        return view('owner.elders.show', array_merge([
            'title'        => 'Resident Details',
            'elder'        => $elder,
            'item'         => $elder,
            'type'         => 'elder',
            'carePlans'    => $carePlans,
            'medications'  => $medications,
            'appointments' => $appointments,
        ], $this->menus()));
    }


    // ==========================================
    // CARE PLANS — Owner's elder's only
    // ==========================================

    public function carePlansIndex()
    {
        $elderIds = $this->assignedElderIds();

        $carePlans = DB::table('care_plans')
            ->leftJoin('elders', 'elders.id', '=', 'care_plans.elder_id')
            ->select('care_plans.*', 'elders.name as elder_name')
            ->whereIn('care_plans.elder_id', $elderIds)
            ->orderByDesc('care_plans.created_at')
            ->paginate(10);

        return view('owner.list', array_merge([
            'title'    => 'Care Plans',
            'subtitle' => 'Care plans for your loved ones',
            'items'    => $carePlans,
            'type'     => 'care-plans',
        ], $this->menus()));
    }


    public function carePlansShow($id)
    {
        $elderIds = $this->assignedElderIds();

        $carePlan = DB::table('care_plans')
            ->where('id', $id)
            ->whereIn('elder_id', $elderIds)
            ->first();

        if (!$carePlan) abort(403);

        return view('owner.show', array_merge([
            'title' => 'Care Plan',
            'item'  => $carePlan,
            'type'  => 'care-plan',
        ], $this->menus()));
    }


    // ==========================================
    // MEDICATIONS — Owner's elder's only
    // ==========================================

    public function medicationsIndex()
    {
        $elderIds = $this->assignedElderIds();

        $medications = DB::table('medications')
            ->leftJoin('elders', 'elders.id', '=', 'medications.elder_id')
            ->select('medications.*', 'elders.name as elder_name')
            ->whereIn('medications.elder_id', $elderIds)
            ->orderByDesc('medications.created_at')
            ->get();

        return view('owner.list', array_merge([
            'title'    => 'Medications',
            'subtitle' => 'Medications for your loved ones',
            'items'    => $medications,
            'type'     => 'medications',
        ], $this->menus()));
    }


    // ==========================================
    // APPOINTMENTS — Owner's elder's only
    // ==========================================

    public function appointmentsIndex()
    {
        $elderIds = $this->assignedElderIds();

        $appointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->leftJoin('elders', 'elders.id', '=', 'appointments.elder_id')
                ->select('appointments.*', 'elders.name as elder_name')
                ->whereIn('appointments.elder_id', $elderIds)
                ->orderByDesc('appointments.appointment_date')
                ->paginate(10)
            : collect();

        return view('owner.list', array_merge([
            'title'    => 'Appointments',
            'subtitle' => 'Appointments for your loved ones',
            'items'    => $appointments,
            'type'     => 'appointments',
        ], $this->menus()));
    }


    // ==========================================
    // REPORTS
    // ==========================================

    public function reportsIndex()
    {
        $elderIds = $this->assignedElderIds();

        $elders = DB::table('elders')->whereIn('id', $elderIds)->get();

        return view('owner.reports', array_merge([
            'title'  => 'Reports',
            'elders' => $elders,
        ], $this->menus()));
    }


    // ==========================================
    // MESSAGES
    // ==========================================

    public function messagesIndex()
    {
        $messages = Schema::hasTable('messages')
            ? DB::table('messages')
                ->where(function ($q) {
                    $q->where('user_id', Auth::id())
                      ->orWhere('recipient_id', Auth::id());
                })
                ->latest()
                ->paginate(10)
            : collect();

        return view('owner.list', array_merge([
            'title'    => 'Messages',
            'subtitle' => 'Communicate with the care team',
            'items'    => $messages,
            'type'     => 'messages',
        ], $this->menus()));
    }
}