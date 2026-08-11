<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalElders = DB::table('elders')->count();
        $activeElders = DB::table('elders')->where('status', 'active')->count();
        $newAdmissions = DB::table('elders')
            ->whereMonth('admission_date', now()->month)
            ->count();
        $recentElders = DB::table('elders')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalElders',
            'activeElders',
            'newAdmissions',
            'recentElders'
        ));
    }

    public function eldersIndex()
    {
        $elders = DB::table('elders')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $totalElders = DB::table('elders')->count();
        $activeElders = DB::table('elders')->where('status', 'active')->count();
        $maleElders = DB::table('elders')->where('gender', 'male')->count();
        $femaleElders = DB::table('elders')->where('gender', 'female')->count();

        return view('admin.elders.index', compact(
            'elders',
            'totalElders',
            'activeElders',
            'maleElders',
            'femaleElders'
        ));
    }

    public function eldersCreate()
    {
        return view('admin.elders.create');
    }

    public function eldersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'elder_code' => 'nullable|string|unique:elders,elder_code|max:50',
            'nic' => 'nullable|string|max:50',
            'dob' => 'nullable|date',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',
            'room' => 'required|string|max:50',
            'caregiver' => 'nullable|string|max:255',
            'admission_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'medical_notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('elder-photos', 'public');
                $validated['photo'] = $photoPath;
            }

            if (empty($validated['elder_code'])) {
                $lastElder = DB::table('elders')->orderBy('id', 'desc')->first();
                $nextId = $lastElder ? $lastElder->id + 1 : 1;
                $validated['elder_code'] = 'ELD-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }

            DB::table('elders')->insertGetId($validated);

            DB::commit();

            return redirect()
                ->route('admin.elders.index')
                ->with('success', 'Elder registered successfully! Elder Code: ' . $validated['elder_code']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create elder: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to register elder. Please try again.');
        }
    }

    public function eldersShow($id)
    {
        $elder = DB::table('elders')->where('id', $id)->first();
        
        if (!$elder) {
            abort(404, 'Elder not found');
        }
        
        return view('admin.elders.show', compact('elder'));
    }

    public function eldersEdit($id)
    {
        $elder = DB::table('elders')->where('id', $id)->first();
        
        if (!$elder) {
            abort(404, 'Elder not found');
        }
        
        return view('admin.elders.edit', compact('elder'));
    }

    public function eldersUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'elder_code' => 'nullable|string|unique:elders,elder_code,' . $id . '|max:50',
            'nic' => 'nullable|string|max:50',
            'dob' => 'nullable|date',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',
            'room' => 'required|string|max:50',
            'caregiver' => 'nullable|string|max:255',
            'admission_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'medical_notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $elder = DB::table('elders')->where('id', $id)->first();
            
            if (!$elder) {
                throw new \Exception('Elder not found');
            }

            if ($request->hasFile('photo')) {
                if ($elder->photo && Storage::disk('public')->exists($elder->photo)) {
                    Storage::disk('public')->delete($elder->photo);
                }
                
                $photoPath = $request->file('photo')->store('elder-photos', 'public');
                $validated['photo'] = $photoPath;
            }

            DB::table('elders')->where('id', $id)->update($validated);

            DB::commit();

            return redirect()
                ->route('admin.elders.index')
                ->with('success', 'Elder updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update elder: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update elder. Please try again.');
        }
    }

    public function eldersDestroy($id)
    {
        DB::beginTransaction();

        try {
            $elder = DB::table('elders')->where('id', $id)->first();
            
            if (!$elder) {
                throw new \Exception('Elder not found');
            }

            if ($elder->photo && Storage::disk('public')->exists($elder->photo)) {
                Storage::disk('public')->delete($elder->photo);
            }

            DB::table('elders')->where('id', $id)->delete();

            DB::commit();

            return redirect()
                ->route('admin.elders.index')
                ->with('success', 'Elder deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete elder: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Failed to delete elder. Please try again.');
        }
    }

    public function eldersSearch(Request $request)
    {
        $query = $request->get('q');
        
        $elders = DB::table('elders')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('elder_code', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'elder_code', 'photo']);

        return response()->json([
            'status' => 'success',
            'data' => $elders
        ]);
    }

    public function eldersToggleStatus(Request $request, $id)
    {
        try {
            $elder = DB::table('elders')->where('id', $id)->first();
            
            if (!$elder) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Elder not found.'
                ], 404);
            }

            $newStatus = $elder->status === 'active' ? 'inactive' : 'active';
            
            DB::table('elders')
                ->where('id', $id)
                ->update(['status' => $newStatus]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully!',
                'data' => [
                    'status' => $newStatus
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    public function eldersExport()
    {
        $elders = DB::table('elders')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="elders_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($elders) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'ID', 'Name', 'Elder Code', 'NIC', 'Age', 'Gender', 
                'Blood Group', 'Phone', 'Email', 'Room', 'Caregiver', 
                'Status', 'Admission Date'
            ]);

            foreach ($elders as $elder) {
                fputcsv($file, [
                    $elder->id,
                    $elder->name,
                    $elder->elder_code,
                    $elder->nic,
                    $elder->age,
                    $elder->gender,
                    $elder->blood_group,
                    $elder->phone,
                    $elder->email,
                    $elder->room,
                    $elder->caregiver,
                    $elder->status,
                    $elder->admission_date
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function dashboardStats()
    {
        $stats = [
            'total' => DB::table('elders')->count(),
            'active' => DB::table('elders')->where('status', 'active')->count(),
            'inactive' => DB::table('elders')->where('status', 'inactive')->count(),
            'male' => DB::table('elders')->where('gender', 'male')->count(),
            'female' => DB::table('elders')->where('gender', 'female')->count(),
            'newThisMonth' => DB::table('elders')
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }
}