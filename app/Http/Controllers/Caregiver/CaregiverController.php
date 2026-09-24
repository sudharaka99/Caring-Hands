<?php

namespace App\Http\Controllers\Caregiver;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Caregiver;
use App\Models\CarePlan;
use App\Models\Medication;
use App\Models\MedicationLog;
use App\Models\Menu;
use App\Models\StaffShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CaregiverController extends Controller
{
    // ==========================================
    // HELPERS
    // ==========================================

    /**
     * Get the current caregiver's name (used to filter elders).
     */
    protected function currentCaregiverName()
    {
        return trim(Auth::user()->name ?? '');
    }

    /**
     * Get the caregiver profile row for the logged-in user.
     */
    protected function caregiverProfile()
    {
        return Caregiver::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Get IDs of elders assigned to this caregiver.
     *
     * Uses caregiver_id when available (best), falls back to
     * name matching with TRIM() for safety.
     */
    protected function assignedElderIds()
    {
        $caregiver = Caregiver::where('user_id', Auth::id())->first();
        $userName  = $this->currentCaregiverName();

        // ==========================================
        // PREFERRED: Match by caregiver_id (foreign key)
        // ==========================================
        if ($caregiver && Schema::hasColumn('elders', 'caregiver_id')) {
            $ids = DB::table('elders')
                ->where('caregiver_id', $caregiver->id)
                ->pluck('id');

            if ($ids->isNotEmpty()) {
                return $ids;
            }
        }

        // ==========================================
        // FALLBACK: Match by caregiver name (TRIM-safe)
        // ==========================================
        return DB::table('elders')
            ->whereRaw('TRIM(caregiver) = ?', [$userName])
            ->pluck('id');
    }

    /**
     * Shared sidebar data (menus + userRole) for all views.
     */
    protected function menus()
    {
        $userRole = Auth::user()->role ?? 'guest';

        $menus = Menu::with(['children.accesses', 'accesses'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->whereHas('accesses', function ($query) use ($userRole) {
                $query->where('role', $userRole)
                      ->where('can_view', 1);
            })
            ->orderBy('sort_order')
            ->get();

        return [
            'menus'    => $menus,
            'userRole' => $userRole,
        ];
    }


    // ==========================================
    // ELDERS — Scoped to this caregiver
    // ==========================================

    /**
     * List only THIS caregiver's assigned elders.
     */
    public function eldersIndex()
    {
        $caregiverName = $this->currentCaregiverName();
        $caregiver     = Caregiver::where('user_id', Auth::id())->first();

        // Build query — prefer caregiver_id, fall back to name
        $query = DB::table('elders')->where('status', 'active');

        if ($caregiver && Schema::hasColumn('elders', 'caregiver_id')) {
            $query->where(function ($q) use ($caregiver, $caregiverName) {
                $q->where('caregiver_id', $caregiver->id)
                  ->orWhereRaw('TRIM(caregiver) = ?', [$caregiverName]);
            });
        } else {
            $query->whereRaw('TRIM(caregiver) = ?', [$caregiverName]);
        }

        $elders = $query->orderBy('name')->paginate(10);

        return view('caregiver.elders.index', array_merge(
            ['elders' => $elders],
            $this->menus()
        ));
    }


    /**
     * Show one elder — only if assigned to this caregiver.
     */
    public function eldersShow($id)
    {
        $caregiverName = $this->currentCaregiverName();
        $caregiver     = Caregiver::where('user_id', Auth::id())->first();

        // Build query — prefer caregiver_id, fall back to name
        $query = DB::table('elders')->where('id', $id);

        if ($caregiver && Schema::hasColumn('elders', 'caregiver_id')) {
            $query->where(function ($q) use ($caregiver, $caregiverName) {
                $q->where('caregiver_id', $caregiver->id)
                  ->orWhereRaw('TRIM(caregiver) = ?', [$caregiverName]);
            });
        } else {
            $query->whereRaw('TRIM(caregiver) = ?', [$caregiverName]);
        }

        $elder = $query->first();

        if (!$elder) {
            abort(403, 'This resident is not assigned to you.');
        }

        $carePlans = DB::table('care_plans')
            ->where('elder_id', $id)
            ->get();

        $medications = DB::table('medications')
            ->where('elder_id', $id)
            ->where('status', 'active')
            ->get();

        $appointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->where('elder_id', $id)
                ->orderBy('appointment_date', 'desc')
                ->get()
            : collect();

        return view('caregiver.elders.show', array_merge([
            'title'        => 'Resident Details',
            'item'         => $elder,
            'elder'        => $elder,
            'type'         => 'elder',
            'carePlans'    => $carePlans,
            'medications'  => $medications,
            'appointments' => $appointments,
        ], $this->menus()));
    }


    // ==========================================
    // CARE PLANS
    // ==========================================

    public function carePlansIndex()
    {
        $elderIds = $this->assignedElderIds();

        $carePlans = CarePlan::with('elder')
            ->whereIn('elder_id', $elderIds)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('caregiver.list', array_merge([
            'title'    => 'My Care Plans',
            'subtitle' => 'Care plans for your assigned residents',
            'items'    => $carePlans,
            'type'     => 'care-plans',
        ], $this->menus()));
    }


    public function carePlansShow($id)
    {
        $elderIds = $this->assignedElderIds();

        $carePlan = CarePlan::with('elder')
            ->whereIn('elder_id', $elderIds)
            ->findOrFail($id);

        return view('caregiver.show', array_merge([
            'title' => 'Care Plan',
            'item'  => $carePlan,
            'type'  => 'care-plan',
        ], $this->menus()));
    }


    public function carePlansUpdate(Request $request, $id)
    {
        $elderIds = $this->assignedElderIds();

        $carePlan = CarePlan::whereIn('elder_id', $elderIds)
            ->findOrFail($id);

        $carePlan->update($request->validate([
            'status' => 'required|in:draft,active,completed,cancelled',
            'notes'  => 'nullable|string',
        ]));

        return redirect()
            ->route('caregiver.care-plans.show', $carePlan->id)
            ->with('success', 'Care plan updated successfully.');
    }


    // ==========================================
    // MEDICATIONS
    // ==========================================

    public function medicationsIndex()
    {
        $elderIds = $this->assignedElderIds();

        $medications = Medication::with('elder')
            ->whereIn('elder_id', $elderIds)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('caregiver.list', array_merge([
            'title'    => 'Medications',
            'subtitle' => 'Medication schedules for your assigned residents',
            'items'    => $medications,
            'type'     => 'medications',
        ], $this->menus()));
    }


    public function medicationLog($id)
    {
        $elderIds = $this->assignedElderIds();

        $medication = Medication::whereIn('elder_id', $elderIds)
            ->findOrFail($id);

        $caregiver = $this->caregiverProfile();

        MedicationLog::create([
            'medication_id'   => $medication->id,
            'elder_id'        => $medication->elder_id,
            'caregiver_id'    => $caregiver->id,
            'scheduled_date'  => today(),
            'administered_at' => now(),
            'status'          => 'given',
        ]);

        return back()->with('success', 'Medication logged successfully.');
    }


    // ==========================================
    // APPOINTMENTS
    // ==========================================

    public function appointmentsIndex()
    {
        $elderIds = $this->assignedElderIds();

        $appointments = Schema::hasTable('appointments')
            ? DB::table('appointments')
                ->whereIn('elder_id', $elderIds)
                ->orderByDesc('appointment_date')
                ->paginate(10)
                ->withQueryString()
            : collect();

        return view('caregiver.list', array_merge([
            'title'    => 'Appointments',
            'subtitle' => 'Appointments for your assigned residents',
            'items'    => $appointments,
            'type'     => 'appointments',
        ], $this->menus()));
    }


    // ==========================================
    // SHIFTS — Own shifts only
    // ==========================================

    public function shiftsIndex()
    {
        $shifts = StaffShift::with('shiftType')
            ->where('user_id', Auth::id())
            ->latest('shift_date')
            ->paginate(10)
            ->withQueryString();

        return view('caregiver.list', array_merge([
            'title'    => 'My Shifts',
            'subtitle' => 'Your scheduled shifts',
            'items'    => $shifts,
            'type'     => 'shifts',
        ], $this->menus()));
    }


    // ==========================================
    // ATTENDANCE — Own records only
    // ==========================================

    public function attendanceIndex()
    {
        $attendance = Attendance::with('staffShift.shiftType')
            ->where('user_id', Auth::id())
            ->latest('attendance_date')
            ->paginate(10)
            ->withQueryString();

        return view('caregiver.list', array_merge([
            'title'    => 'My Attendance',
            'subtitle' => 'Your attendance records',
            'items'    => $attendance,
            'type'     => 'attendance',
        ], $this->menus()));
    }


    // ==========================================
    // MESSAGES
    // ==========================================

    public function messagesIndex()
    {
        $messages = Schema::hasTable('messages')
            ? DB::table('messages')
                ->where(function ($query) {
                    $query->where('user_id', Auth::id())
                          ->orWhere('recipient_id', Auth::id());
                })
                ->latest()
                ->paginate(10)
                ->withQueryString()
            : collect();

        return view('caregiver.list', array_merge([
            'title'    => 'Messages',
            'subtitle' => 'Team communication',
            'items'    => $messages,
            'type'     => 'messages',
        ], $this->menus()));
    }
}