<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // ==========================================
    // DASHBOARD
    // ==========================================

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

    // ==========================================
    // ELDER MANAGEMENT
    // ==========================================

    public function eldersIndex(Request $request)
    {
        $query = DB::table('elders');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('elder_code', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $elders = $query->orderBy('created_at', 'desc')->paginate(10);
        
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

    // ==========================================
    // OWNER MANAGEMENT
    // ==========================================

    public function ownersIndex(Request $request)
    {
        $query = DB::table('owners');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('nic', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $owners = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get stats
        $totalOwners = DB::table('owners')->count();
        $activeOwners = DB::table('owners')->where('status', 'active')->count();
        $guardianCount = DB::table('owners')->where('relationship', 'guardian')->count();

        // Count linked owners (owners with at least one elder)
        $linkedOwners = DB::table('elder_owner')
            ->distinct('owner_id')
            ->count('owner_id');

        // Load elders for each owner
        foreach ($owners as $owner) {
            $owner->elders = DB::table('elder_owner')
                ->join('elders', 'elder_owner.elder_id', '=', 'elders.id')
                ->where('elder_owner.owner_id', $owner->id)
                ->select('elders.*')
                ->get();
        }

        return view('admin.owners.index', compact(
            'owners',
            'totalOwners',
            'activeOwners',
            'guardianCount',
            'linkedOwners'
        ));
    }

    public function ownersCreate()
    {
        $elders = DB::table('elders')->where('status', 'active')->get();
        return view('admin.owners.create', compact('elders'));
    }

    public function ownersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic' => 'nullable|string|max:50|unique:owners,nic',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'relationship' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'elder_ids' => 'nullable|array',
            'elder_ids.*' => 'exists:elders,id',
        ]);

        DB::beginTransaction();

        try {
            // Prepare data
            $data = [
                'name' => $validated['name'],
                'nic' => $validated['nic'] ?? null,
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'relationship' => $validated['relationship'] ?? null,
                'status' => $validated['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('owner-photos', 'public');
                $data['photo'] = $photoPath;
            }

            $ownerId = DB::table('owners')->insertGetId($data);

            // Attach elders
            if ($request->filled('elder_ids')) {
                foreach ($request->elder_ids as $elderId) {
                    DB::table('elder_owner')->insert([
                        'elder_id' => $elderId,
                        'owner_id' => $ownerId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.owners.index')
                ->with('success', 'Owner added successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create owner: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to add owner. Please try again.');
        }
    }

    public function ownersShow($id)
    {
        $owner = DB::table('owners')->where('id', $id)->first();
        
        if (!$owner) {
            abort(404, 'Owner not found');
        }

        // Get owner's elders
        $owner->elders = DB::table('elder_owner')
            ->join('elders', 'elder_owner.elder_id', '=', 'elders.id')
            ->where('elder_owner.owner_id', $id)
            ->select('elders.*')
            ->get();

        return view('admin.owners.show', compact('owner'));
    }

    public function ownersEdit($id)
    {
        $owner = DB::table('owners')->where('id', $id)->first();
        
        if (!$owner) {
            abort(404, 'Owner not found');
        }

        // Get owner's elder IDs
        $ownerElderIds = DB::table('elder_owner')
            ->where('owner_id', $id)
            ->pluck('elder_id')
            ->toArray();

        $owner->elder_ids = $ownerElderIds;

        $elders = DB::table('elders')->where('status', 'active')->get();

        return view('admin.owners.edit', compact('owner', 'elders'));
    }

    public function ownersUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic' => 'nullable|string|max:50|unique:owners,nic,' . $id,
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'relationship' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'elder_ids' => 'nullable|array',
            'elder_ids.*' => 'exists:elders,id',
        ]);

        DB::beginTransaction();

        try {
            $owner = DB::table('owners')->where('id', $id)->first();
            
            if (!$owner) {
                throw new \Exception('Owner not found');
            }

            // Prepare data
            $data = [
                'name' => $validated['name'],
                'nic' => $validated['nic'] ?? null,
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'relationship' => $validated['relationship'] ?? null,
                'status' => $validated['status'],
                'updated_at' => now(),
            ];

            if ($request->hasFile('photo')) {
                if ($owner->photo && Storage::disk('public')->exists($owner->photo)) {
                    Storage::disk('public')->delete($owner->photo);
                }
                $photoPath = $request->file('photo')->store('owner-photos', 'public');
                $data['photo'] = $photoPath;
            }

            DB::table('owners')->where('id', $id)->update($data);

            // Sync elders - delete existing and insert new
            DB::table('elder_owner')->where('owner_id', $id)->delete();

            if ($request->filled('elder_ids')) {
                foreach ($request->elder_ids as $elderId) {
                    DB::table('elder_owner')->insert([
                        'elder_id' => $elderId,
                        'owner_id' => $id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.owners.index')
                ->with('success', 'Owner updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update owner: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update owner. Please try again.');
        }
    }

    public function ownersDestroy($id)
    {
        DB::beginTransaction();

        try {
            $owner = DB::table('owners')->where('id', $id)->first();
            
            if (!$owner) {
                throw new \Exception('Owner not found');
            }

            if ($owner->photo && Storage::disk('public')->exists($owner->photo)) {
                Storage::disk('public')->delete($owner->photo);
            }

            // Delete relationships
            DB::table('elder_owner')->where('owner_id', $id)->delete();

            // Delete owner
            DB::table('owners')->where('id', $id)->delete();

            DB::commit();

            return redirect()
                ->route('admin.owners.index')
                ->with('success', 'Owner deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete owner: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Failed to delete owner. Please try again.');
        }
    }
}