<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Menu;
use App\Models\User;
use App\Models\Caregiver;
use App\Models\Elder;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    // ==========================================
    // DASHBOARD
    // ==========================================

    public function dashboard()
    {
        // ==========================================
        // ELDER STATISTICS
        // ==========================================

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
        // MENU ACCESS
        // ==========================================

        $userRole = auth()->user()->role ?? 'guest';

        $menus = Menu::with(['children.accesses','accesses'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->whereHas('accesses', function ($query) use ($userRole) {
                $query->where('role', $userRole)
                    ->where('can_view', 1);})
            ->orderBy('sort_order')
            ->get();


        // ==========================================
        // RETURN VIEW
        // ==========================================

        return view('admin.dashboard', compact(
            'totalElders',
            'activeElders',
            'newAdmissions',
            'recentElders',
            'menus',
            'userRole'
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

        $userRole = auth()->user()->role ?? 'guest';

        $menus = Menu::with(['children.accesses','accesses'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->whereHas('accesses', function ($query) use ($userRole) {
                $query->where('role', $userRole)
                    ->where('can_view', 1);})
            ->orderBy('sort_order')
            ->get();

        return view('admin.elders.index', compact(
            'elders',
            'totalElders',
            'activeElders',
            'maleElders',
            'femaleElders',
            'menus',
            'userRole'
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

    public function ownersIndex(Request $request)
    {
        $query = Owner::with('user', 'elders');

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
        $totalOwners = Owner::count();
        $activeOwners = Owner::where('status', 'active')->count();
        $inactiveOwners = Owner::where('status', 'inactive')->count();
        $guardianCount = Owner::where('relationship', 'guardian')->count();

        // Count linked owners (owners with at least one elder)
        $linkedOwners = DB::table('elder_owner')
            ->distinct('owner_id')
            ->count('owner_id');

        // Menu Access
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

        return view('admin.owners.index', compact(
            'owners',
            'totalOwners',
            'activeOwners',
            'inactiveOwners',
            'guardianCount',
            'linkedOwners',
            'menus',
            'userRole'
        ));
    }

    public function ownersCreate()
    {
        $elders = Elder::where('status', 'active')->get();
        $users = User::where('role', 'owner')->get();
        
        // Menu Access
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

        return view('admin.owners.create', compact('elders', 'users', 'menus', 'userRole'));
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
            
            // User account fields
            'create_user_account' => 'nullable|boolean',
            'user_id' => 'nullable|exists:users,id',
            'user_email' => 'nullable|email|unique:users,email',
            'user_password' => 'nullable|string|min:6',
        ]);

        DB::beginTransaction();

        try {
            $user = null;

            // Create user account if requested
            if ($request->has('create_user_account') && $request->create_user_account) {
                if ($request->filled('user_id')) {
                    // Use existing user
                    $user = User::find($request->user_id);
                } elseif ($request->filled('user_email') && $request->filled('user_password')) {
                    // Create new user
                    $user = User::create([
                        'name' => $validated['name'],
                        'email' => $request->user_email,
                        'password' => Hash::make($request->user_password),
                        'role' => 'owner',
                        'status' => $validated['status'],
                    ]);
                }
            }

            // Prepare owner data
            $data = [
                'user_id' => $user ? $user->id : null,
                'name' => $validated['name'],
                'nic' => $validated['nic'] ?? null,
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'relationship' => $validated['relationship'] ?? null,
                'status' => $validated['status'],
            ];

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('owner-photos', 'public');
                $data['photo'] = $photoPath;
            }

            // Create owner
            $owner = Owner::create($data);

            // Attach elders
            if ($request->filled('elder_ids')) {
                $owner->elders()->attach($request->elder_ids);
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
        $owner = Owner::with('user', 'elders')->findOrFail($id);
        
        // Menu Access
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

        return view('admin.owners.show', compact('owner', 'menus', 'userRole'));
    }

    public function ownersEdit($id)
    {
        $owner = Owner::with('user')->findOrFail($id);
        $elders = Elder::where('status', 'active')->get();
        $ownerElderIds = $owner->elders()->pluck('elders.id')->toArray();
        $users = User::where('role', 'owner')->get();
        
        // Menu Access
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

        return view('admin.owners.edit', compact('owner', 'elders', 'ownerElderIds', 'users', 'menus', 'userRole'));
    }

    public function ownersUpdate(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);

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
            
            // User account fields
            'create_user_account' => 'nullable|boolean',
            'user_id' => 'nullable|exists:users,id',
            'user_email' => 'nullable|email|unique:users,email,' . ($owner->user_id ?? 'NULL'),
            'user_password' => 'nullable|string|min:6',
        ]);

        DB::beginTransaction();

        try {
            // Handle user account
            if ($request->has('create_user_account') && $request->create_user_account) {
                if ($request->filled('user_id')) {
                    // Use existing user
                    $user = User::find($request->user_id);
                    if ($user) {
                        // Update user name if changed
                        if ($user->name !== $request->name) {
                            $user->name = $request->name;
                            $user->save();
                        }
                        $owner->user_id = $user->id;
                    }
                } elseif ($request->filled('user_email')) {
                    // Check if user already exists
                    $existingUser = User::where('email', $request->user_email)->first();
                    if ($existingUser) {
                        $owner->user_id = $existingUser->id;
                    } else {
                        // Create new user
                        $user = User::create([
                            'name' => $request->name,
                            'email' => $request->user_email,
                            'password' => Hash::make($request->user_password ?? 'password123'),
                            'role' => 'owner',
                            'status' => $validated['status'],
                        ]);
                        $owner->user_id = $user->id;
                    }
                }
            } else {
                // If user account is not being created, remove user_id
                $owner->user_id = null;
            }

            // Update owner data
            $data = [
                'name' => $validated['name'],
                'nic' => $validated['nic'] ?? null,
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'relationship' => $validated['relationship'] ?? null,
                'status' => $validated['status'],
                'user_id' => $owner->user_id,
            ];

            // Handle photo upload
            if ($request->hasFile('photo')) {
                if ($owner->photo && Storage::disk('public')->exists($owner->photo)) {
                    Storage::disk('public')->delete($owner->photo);
                }
                $photoPath = $request->file('photo')->store('owner-photos', 'public');
                $data['photo'] = $photoPath;
            }

            // Update owner
            $owner->update($data);

            // Sync elders
            if ($request->filled('elder_ids')) {
                $owner->elders()->sync($request->elder_ids);
            } else {
                $owner->elders()->detach();
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
            $owner = Owner::findOrFail($id);

            // Delete user account if exists
            if ($owner->user_id) {
                $user = User::find($owner->user_id);
                if ($user) {
                    $user->delete();
                }
            }

            // Delete photo
            if ($owner->photo && Storage::disk('public')->exists($owner->photo)) {
                Storage::disk('public')->delete($owner->photo);
            }

            // Delete relationships
            $owner->elders()->detach();

            // Delete owner
            $owner->delete();

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

    // ==========================================
    // CAREGIVER MANAGEMENT
    // ==========================================

    public function caregiversIndex(Request $request)
    {
        $query = Caregiver::with('user');

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('staff_code', 'LIKE', "%{$search}%")
                ->orWhere('nic', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")

                ->orWhereHas('user', function ($userQuery) use ($search) {

                    $userQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");

                });

            });
        }

        // Status filter from users table
        if ($request->filled('status')) {

            $status = $request->status;

            $query->whereHas('user', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $caregivers = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();


        // ==========================================
        // STATISTICS
        // ==========================================

        $totalCaregivers = Caregiver::count();

        $activeCaregivers = Caregiver::whereHas('user', function ($q) {
            $q->where('status', 'active');
        })->count();

        $inactiveCaregivers = Caregiver::whereHas('user', function ($q) {
            $q->where('status', 'inactive');
        })->count();


        // ==========================================
        // MENU ACCESS
        // ==========================================

        $userRole = auth()->user()->role ?? 'guest';

        $menus = Menu::with([
            'children.accesses',
            'accesses'
        ])
        ->whereNull('parent_id')
        ->where('status', 'active')
        ->whereHas('accesses', function ($query) use ($userRole) {

            $query->where('role', $userRole)
                ->where('can_view', 1);

        })
        ->orderBy('sort_order')
        ->get();


        return view('admin.caregivers.index', compact(
            'caregivers',
            'totalCaregivers',
            'activeCaregivers',
            'inactiveCaregivers',
            'menus',
            'userRole'
        ));
    }

    public function caregiversCreate()
    {
        $userRole = auth()->user()->role ?? 'guest';

        $menus = Menu::with([
            'children.accesses',
            'accesses'
        ])
        ->whereNull('parent_id')
        ->where('status', 'active')
        ->whereHas('accesses', function ($query) use ($userRole) {

            $query->where('role', $userRole)
                ->where('can_view', 1);

        })
        ->orderBy('sort_order')
        ->get();


        return view(
            'admin.caregivers.create',
            compact('menus', 'userRole')
        );
    }

    public function caregiversStore(Request $request)
    {
        $request->validate([

            // User
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|in:active,inactive',

            // Caregiver
            'staff_code' => 'nullable|string|max:50',
            'nic' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'joining_date' => 'nullable|date',

            'employment_type' =>
                'nullable|in:full_time,part_time,contract,temporary',

            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_relationship' => 'nullable|string|max:100',
            'emergency_phone' => 'nullable|string|max:30',

            'qualifications' => 'nullable|string',
            'experience' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);


        DB::transaction(function () use ($request) {

            // ==========================================
            // CREATE USER
            // ==========================================

            $user = User::create([

                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password),

                'role' => 'caregiver',

                'status' => $request->status,

            ]);


            // ==========================================
            // CREATE CAREGIVER
            // ==========================================

            Caregiver::create([

                'user_id' => $user->id,

                'staff_code' => $request->staff_code,

                'nic' => $request->nic,

                'date_of_birth' => $request->date_of_birth,

                'gender' => $request->gender,

                'phone' => $request->phone,

                'address' => $request->address,

                'joining_date' => $request->joining_date,

                'employment_type' =>
                    $request->employment_type ?? 'full_time',

                'emergency_contact_name' =>
                    $request->emergency_contact_name,

                'emergency_relationship' =>
                    $request->emergency_relationship,

                'emergency_phone' =>
                    $request->emergency_phone,

                'qualifications' =>
                    $request->qualifications,

                'experience' =>
                    $request->experience,

                'notes' =>
                    $request->notes,

            ]);

        });


        return redirect()
            ->route('admin.caregivers.index')
            ->with('success', 'Caregiver created successfully.');
    }

    public function caregiversShow($id)
    {
        $caregiver = Caregiver::with('user')
            ->findOrFail($id);


        // MENU ACCESS

        $userRole = auth()->user()->role ?? 'guest';

        $menus = Menu::with([
            'children.accesses',
            'accesses'
        ])
        ->whereNull('parent_id')
        ->where('status', 'active')
        ->whereHas('accesses', function ($query) use ($userRole) {

            $query->where('role', $userRole)
                ->where('can_view', 1);

        })
        ->orderBy('sort_order')
        ->get();


        return view(
            'admin.caregivers.show',
            compact(
                'caregiver',
                'menus',
                'userRole'
            )
        );
    }

    public function caregiversEdit($id)
    {
        $caregiver = Caregiver::with('user')
            ->findOrFail($id);


        // MENU ACCESS

        $userRole = auth()->user()->role ?? 'guest';

        $menus = Menu::with([
            'children.accesses',
            'accesses'
        ])
        ->whereNull('parent_id')
        ->where('status', 'active')
        ->whereHas('accesses', function ($query) use ($userRole) {

            $query->where('role', $userRole)
                ->where('can_view', 1);

        })
        ->orderBy('sort_order')
        ->get();


        return view(
            'admin.caregivers.edit',
            compact(
                'caregiver',
                'menus',
                'userRole'
            )
        );
    }

    public function caregiversUpdate(Request $request, $id)
    {
        $caregiver = Caregiver::with('user')
            ->findOrFail($id);


        $request->validate([

            // User
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email,' .
                $caregiver->user_id,

            'password' => 'nullable|string|min:6|confirmed',

            'status' => 'required|in:active,inactive',


            // Caregiver
            'staff_code' => 'nullable|string|max:50',

            'nic' => 'nullable|string|max:20',

            'date_of_birth' => 'nullable|date',

            'gender' => 'nullable|in:male,female,other',

            'phone' => 'nullable|string|max:30',

            'address' => 'nullable|string',

            'joining_date' => 'nullable|date',

            'employment_type' =>
                'nullable|in:full_time,part_time,contract,temporary',

            'emergency_contact_name' =>
                'nullable|string|max:255',

            'emergency_relationship' =>
                'nullable|string|max:100',

            'emergency_phone' =>
                'nullable|string|max:30',

            'qualifications' => 'nullable|string',

            'experience' => 'nullable|string',

            'notes' => 'nullable|string',

        ]);


        DB::transaction(function () use ($request, $caregiver) {

            // ==========================================
            // UPDATE USER
            // ==========================================

            $user = $caregiver->user;

            $user->name = $request->name;

            $user->email = $request->email;

            $user->status = $request->status;


            if ($request->filled('password')) {

                $user->password =
                    Hash::make($request->password);

            }

            $user->save();


            // ==========================================
            // UPDATE CAREGIVER
            // ==========================================

            $caregiver->staff_code =
                $request->staff_code;

            $caregiver->nic =
                $request->nic;

            $caregiver->date_of_birth =
                $request->date_of_birth;

            $caregiver->gender =
                $request->gender;

            $caregiver->phone =
                $request->phone;

            $caregiver->address =
                $request->address;

            $caregiver->joining_date =
                $request->joining_date;

            $caregiver->employment_type =
                $request->employment_type;

            $caregiver->emergency_contact_name =
                $request->emergency_contact_name;

            $caregiver->emergency_relationship =
                $request->emergency_relationship;

            $caregiver->emergency_phone =
                $request->emergency_phone;

            $caregiver->qualifications =
                $request->qualifications;

            $caregiver->experience =
                $request->experience;

            $caregiver->notes =
                $request->notes;

            $caregiver->save();

        });


        return redirect()
            ->route('admin.caregivers.index')
            ->with('success', 'Caregiver updated successfully.');
    }

    public function caregiversDestroy($id)
    {
        $caregiver = Caregiver::findOrFail($id);

        DB::transaction(function () use ($caregiver) {

            // Get linked user
            $user = $caregiver->user;

            // Delete caregiver profile
            $caregiver->delete();

            // Delete caregiver login account
            if ($user) {
                $user->delete();
            }

        });


        return redirect()
            ->route('admin.caregivers.index')
            ->with('success', 'Caregiver deleted successfully.');
    }



}