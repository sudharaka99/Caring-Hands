<?php

namespace App\Http\Controllers\Healthcare;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\CarePlan;
use App\Models\Medication;
use App\Models\Menu;
use App\Models\StaffShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HealthcareController extends Controller
{
    // ==========================================
    // HELPERS
    // ==========================================

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
    // ELDERS
    // ==========================================

    public function eldersIndex(Request $request)
    {
        $query = DB::table('elders')->where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('elder_code', 'like', "%{$search}%")
                  ->orWhere('room', 'like', "%{$search}%");
            });
        }

        $elders = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('healthcare.elders.index', array_merge(
            compact('elders'),
            $this->menus()
        ));
    }


    public function eldersShow($id)
    {
        $elder = DB::table('elders')->where('id', $id)->first();

        if (!$elder) {
            abort(404);
        }

        $carePlans = DB::table('care_plans')->where('elder_id', $id)->get();
        $medications = DB::table('medications')->where('elder_id', $id)->get();
        $appointments = Schema::hasTable('appointments')
            ? DB::table('appointments')->where('elder_id', $id)->orderByDesc('appointment_date')->get()
            : collect();

        return view('healthcare.elders.show', array_merge([
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
    // CARE PLANS
    // ==========================================

    public function carePlansIndex()
    {
        $carePlans = CarePlan::with('elder')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('healthcare.list', array_merge([
            'title'    => 'Care Plans',
            'subtitle' => 'All resident care plans',
            'items'    => $carePlans,
            'type'     => 'care-plans',
        ], $this->menus()));
    }


    public function carePlansShow($id)
    {
        $carePlan = CarePlan::with('elder', 'caregiver.user')->findOrFail($id);

        return view('healthcare.show', array_merge([
            'title' => 'Care Plan',
            'item'  => $carePlan,
            'type'  => 'care-plan',
        ], $this->menus()));
    }


    public function carePlansUpdate(Request $request, $id)
    {
        $carePlan = CarePlan::findOrFail($id);

        $carePlan->update($request->validate([
            'status' => 'required|in:draft,active,completed,cancelled',
            'notes'  => 'nullable|string',
        ]));

        return redirect()
            ->route('healthcare.care-plans.show', $carePlan->id)
            ->with('success', 'Care plan updated successfully.');
    }


    // ==========================================
    // MEDICATIONS
    // ==========================================

    public function medicationsIndex(Request $request)
    {
        $query = Medication::with('elder');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('medication_name', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%");
            });
        }

        $medications = $query->latest()->paginate(10)->withQueryString();

        return view('healthcare.list', array_merge([
            'title'    => 'Medications',
            'subtitle' => 'All resident medications',
            'items'    => $medications,
            'type'     => 'medications',
        ], $this->menus()));
    }


    public function medicationsShow($id)
    {
        $medication = Medication::with('elder', 'logs')->findOrFail($id);

        return view('healthcare.show', array_merge([
            'title' => 'Medication',
            'item'  => $medication,
            'type'  => 'medication',
        ], $this->menus()));
    }


    public function medicationsUpdate(Request $request, $id)
    {
        $medication = Medication::findOrFail($id);

        $medication->update($request->validate([
            'status'       => 'required|in:active,completed,stopped,cancelled',
            'instructions' => 'nullable|string',
            'notes'        => 'nullable|string',
        ]));

        return redirect()
            ->route('healthcare.medication.show', $medication->id)
            ->with('success', 'Medication updated successfully.');
    }


    // ==========================================
    // APPOINTMENTS
    // ==========================================

    public function appointmentsIndex(Request $request)
    {
        $query = DB::table('appointments')
            ->leftJoin('elders', 'elders.id', '=', 'appointments.elder_id')
            ->select('appointments.*', 'elders.name as elder_name', 'elders.elder_code');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('appointments.title', 'like', "%{$search}%")
                  ->orWhere('appointments.doctor_name', 'like', "%{$search}%")
                  ->orWhere('elders.name', 'like', "%{$search}%");
            });
        }

        $appointments = $query
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->paginate(10)
            ->withQueryString();

        return view('healthcare.list', array_merge([
            'title'    => 'Appointments',
            'subtitle' => 'All scheduled appointments',
            'items'    => $appointments,
            'type'     => 'appointments',
        ], $this->menus()));
    }


    public function appointmentsCreate()
    {
        $elders = DB::table('elders')->where('status', 'active')->orderBy('name')->get();

        return view('healthcare.appointments-create', array_merge([
            'title' => 'New Appointment',
            'elders' => $elders,
        ], $this->menus()));
    }


    public function appointmentsStore(Request $request)
    {
        $validated = $request->validate([
            'elder_id'          => 'required|exists:elders,id',
            'title'             => 'required|string|max:255',
            'appointment_type'  => 'required|in:doctor,healthcare,hospital,clinic,therapy,checkup,other',
            'doctor_name'       => 'nullable|string|max:255',
            'hospital_name'     => 'nullable|string|max:255',
            'location'          => 'nullable|string|max:255',
            'appointment_date'  => 'required|date',
            'appointment_time'  => 'required',
            'duration_minutes'  => 'nullable|integer|min:1',
            'reason'            => 'nullable|string',
            'instructions'      => 'nullable|string',
            'status'            => 'required|in:scheduled,confirmed,completed,cancelled,rescheduled,missed',
        ]);

        DB::table('appointments')->insert(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()
            ->route('healthcare.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }


    public function appointmentsShow($id)
    {
        $appointment = DB::table('appointments')
            ->leftJoin('elders', 'elders.id', '=', 'appointments.elder_id')
            ->select('appointments.*', 'elders.name as elder_name', 'elders.elder_code')
            ->where('appointments.id', $id)
            ->first();

        if (!$appointment) abort(404);

        return view('healthcare.show', array_merge([
            'title' => 'Appointment',
            'item'  => $appointment,
            'type'  => 'appointment',
        ], $this->menus()));
    }


    public function appointmentsEdit($id)
    {
        $appointment = DB::table('appointments')->where('id', $id)->first();

        if (!$appointment) abort(404);

        $elders = DB::table('elders')->where('status', 'active')->orderBy('name')->get();

        return view('healthcare.appointments-edit', array_merge([
            'title'       => 'Edit Appointment',
            'appointment' => $appointment,
            'elders'      => $elders,
        ], $this->menus()));
    }


    public function appointmentsUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'elder_id'          => 'required|exists:elders,id',
            'title'             => 'required|string|max:255',
            'appointment_type'  => 'required|in:doctor,healthcare,hospital,clinic,therapy,checkup,other',
            'doctor_name'       => 'nullable|string|max:255',
            'hospital_name'     => 'nullable|string|max:255',
            'location'          => 'nullable|string|max:255',
            'appointment_date'  => 'required|date',
            'appointment_time'  => 'required',
            'duration_minutes'  => 'nullable|integer|min:1',
            'reason'            => 'nullable|string',
            'instructions'      => 'nullable|string',
            'status'            => 'required|in:scheduled,confirmed,completed,cancelled,rescheduled,missed',
        ]);

        DB::table('appointments')
            ->where('id', $id)
            ->update(array_merge($validated, ['updated_at' => now()]));

        return redirect()
            ->route('healthcare.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }


    // ==========================================
    // SHIFTS — Own only
    // ==========================================

    public function shiftsIndex()
    {
        $shifts = StaffShift::with('shiftType')
            ->where('user_id', Auth::id())
            ->latest('shift_date')
            ->paginate(10)
            ->withQueryString();

        return view('healthcare.list', array_merge([
            'title'    => 'My Shifts',
            'subtitle' => 'Your scheduled shifts',
            'items'    => $shifts,
            'type'     => 'shifts',
        ], $this->menus()));
    }


    // ==========================================
    // ATTENDANCE — Own only
    // ==========================================

    public function attendanceIndex()
    {
        $attendance = Attendance::with('staffShift.shiftType')
            ->where('user_id', Auth::id())
            ->latest('attendance_date')
            ->paginate(10)
            ->withQueryString();

        return view('healthcare.list', array_merge([
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
                ->where(function ($q) {
                    $q->where('user_id', Auth::id())
                      ->orWhere('recipient_id', Auth::id());
                })
                ->latest()
                ->paginate(10)
                ->withQueryString()
            : collect();

        return view('healthcare.list', array_merge([
            'title'    => 'Messages',
            'subtitle' => 'Team communication',
            'items'    => $messages,
            'type'     => 'messages',
        ], $this->menus()));
    }

    // ==========================================
    // CARE PLANS — CREATE / STORE / EDIT
    // ==========================================

    public function carePlansCreate()
    {
        $elders = DB::table('elders')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $caregivers = DB::table('caregiver')
            ->join('users', 'users.id', '=', 'caregiver.user_id')
            ->select('caregiver.id', 'users.name')
            ->get();

        return view('healthcare.care-plans-create', array_merge([
            'title'      => 'New Care Plan',
            'elders'     => $elders,
            'caregivers' => $caregivers,
        ], $this->menus()));
    }


    public function carePlansStore(Request $request)
    {
        $validated = $request->validate([
            'elder_id'     => 'required|exists:elders,id',
            'caregiver_id' => 'nullable|exists:caregiver,id',
            'title'        => 'required|string|max:255',
            'care_needs'   => 'nullable|string',
            'goals'        => 'nullable|string',
            'activities'   => 'nullable|string',
            'start_date'   => 'required|date',
            'review_date'  => 'nullable|date|after_or_equal:start_date',
            'priority'     => 'required|in:low,medium,high,critical',
            'status'       => 'required|in:draft,active,completed,cancelled',
            'notes'        => 'nullable|string',
        ]);

        DB::table('care_plans')->insert(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()
            ->route('healthcare.care-plans.index')
            ->with('success', 'Care plan created successfully.');
    }


    public function carePlansEdit($id)
    {
        $carePlan = DB::table('care_plans')->where('id', $id)->first();
        if (!$carePlan) abort(404);

        $elders = DB::table('elders')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $caregivers = DB::table('caregiver')
            ->join('users', 'users.id', '=', 'caregiver.user_id')
            ->select('caregiver.id', 'users.name')
            ->get();

        return view('healthcare.care-plans-edit', array_merge([
            'title'      => 'Edit Care Plan',
            'carePlan'   => $carePlan,
            'elders'     => $elders,
            'caregivers' => $caregivers,
        ], $this->menus()));
    }


    // ==========================================
    // MEDICATIONS — CREATE / STORE / EDIT
    // ==========================================

    public function medicationsCreate()
    {
        $elders = DB::table('elders')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('healthcare.medications-create', array_merge([
            'title'  => 'New Medication',
            'elders' => $elders,
        ], $this->menus()));
    }


    public function medicationsStore(Request $request)
    {
        $validated = $request->validate([
            'elder_id'            => 'required|exists:elders,id',
            'medication_name'     => 'required|string|max:255',
            'generic_name'        => 'nullable|string|max:255',
            'dosage'              => 'required|string|max:100',
            'dosage_unit'         => 'nullable|string|max:50',
            'frequency'           => 'required|in:once_daily,twice_daily,three_times_daily,four_times_daily,as_needed,weekly,custom',
            'administration_time' => 'nullable|date_format:H:i',
            'route'               => 'required|in:oral,injection,topical,inhalation,eye,ear,other',
            'start_date'          => 'required|date',
            'end_date'            => 'nullable|date|after_or_equal:start_date',
            'prescribed_by'       => 'nullable|string|max:255',
            'purpose'             => 'nullable|string',
            'instructions'        => 'nullable|string',
            'status'              => 'required|in:active,completed,stopped,cancelled',
            'notes'               => 'nullable|string',
        ]);

        DB::table('medications')->insert(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()
            ->route('healthcare.medication.index')
            ->with('success', 'Medication created successfully.');
    }


    public function medicationsEdit($id)
    {
        $medication = DB::table('medications')->where('id', $id)->first();
        if (!$medication) abort(404);

        $elders = DB::table('elders')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('healthcare.medications-edit', array_merge([
            'title'      => 'Edit Medication',
            'medication' => $medication,
            'elders'     => $elders,
        ], $this->menus()));
    }
}