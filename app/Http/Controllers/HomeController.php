<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get statistics from database
        $stats = $this->getStatistics();
        
        // Get services from database
        $services = $this->getServices();
        
        // Get features from database
        $features = $this->getFeatures();
        
        return view('home', compact('stats', 'services', 'features'));
    }

    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        // Get team members from database
        $team = DB::table('team_members')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();
        
        return view('about', compact('team'));
    }

    /**
     * Display the services page.
     *
     * @return \Illuminate\View\View
     */
    public function services()
    {
        // Get all services from database
        $services = DB::table('services')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();
        
        return view('services', compact('services'));
    }

    /**
     * Display the features page.
     *
     * @return \Illuminate\View\View
     */
    public function features()
    {
        // Get all features from database
        $features = DB::table('features')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();
        
        // Get statistics for features page
        $stats = $this->getStatistics();
        
        return view('features', compact('features', 'stats'));
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        // Get contact information from settings table
        $contactInfo = DB::table('settings')
            ->whereIn('key', ['contact_email', 'contact_phone', 'contact_address'])
            ->pluck('value', 'key')
            ->toArray();
        
        return view('contact', compact('contactInfo'));
    }

    /**
     * Handle contact form submission with transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Start transaction
        DB::beginTransaction();

        try {
            // Insert contact message into database
            $messageId = DB::table('contact_messages')->insertGetId([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'] ?? 'General Inquiry',
                'message' => $validated['message'],
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Log the submission
            Log::info('New contact message submitted', [
                'message_id' => $messageId,
                'email' => $validated['email']
            ]);

            // Send email notification (if configured)
            // Mail::to('info@caringhands.com')->send(new ContactFormSubmission($validated));

            // Commit transaction
            DB::commit();

            // Flash success message to session
            return redirect()
                ->route('contact')
                ->with('success', 'Thank you! Your message has been submitted successfully. We will get back to you soon.');

        } catch (\Throwable $e) {
            // Rollback transaction on failure
            DB::rollBack();

            // Log the error
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            // Redirect back with error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Sorry, there was an error submitting your message. Please try again.');
        }
    }

    /**
     * Display the dashboard for authenticated users.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get dashboard statistics using DB queries
        $residentCount = DB::table('residents')->where('status', 'active')->count();
        $staffCount = DB::table('staff')->where('status', 'active')->count();
        $activeCarePlans = DB::table('care_plans')->where('status', 'active')->count();
        
        // Get recent residents (last 5)
        $recentResidents = DB::table('residents')
            ->select('id', 'name', 'room_number', 'admission_date')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get upcoming tasks
        $upcomingTasks = DB::table('tasks')
            ->select('id', 'title', 'priority', 'due_date', 'assigned_to')
            ->where('status', 'pending')
            ->whereDate('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();
        
        // Get recent activities
        $recentActivities = DB::table('activity_logs')
            ->select('id', 'user_id', 'action', 'description', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'residentCount',
            'staffCount',
            'activeCarePlans',
            'recentResidents',
            'upcomingTasks',
            'recentActivities'
        ));
    }

    /**
     * Get statistics from database.
     *
     * @return array
     */
    private function getStatistics()
    {
        $residents = DB::table('residents')->where('status', 'active')->count();
        $caregivers = DB::table('staff')->where('role', 'caregiver')->where('status', 'active')->count();
        $healthcareStaff = DB::table('staff')->where('role', 'healthcare')->where('status', 'active')->count();
        
        return [
            'residents' => $residents > 0 ? $residents : 100,
            'caregivers' => $caregivers > 0 ? $caregivers : 50,
            'healthcare_staff' => $healthcareStaff > 0 ? $healthcareStaff : 20,
            'availability' => '24/7'
        ];
    }

    /**
     * Get services from database with fallback data.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getServices()
    {
        $services = DB::table('services')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        // If no services in database, return default data
        if ($services->isEmpty()) {
            return collect([
                (object) [
                    'icon' => 'fa-solid fa-person-cane',
                    'title' => 'Elder Management',
                    'description' => 'Securely manage resident profiles, personal information, health records and important care information.'
                ],
                (object) [
                    'icon' => 'fa-solid fa-user-nurse',
                    'title' => 'Caregiver Management',
                    'description' => 'Organize caregivers, assign duties, manage workloads and ensure every resident receives proper attention.'
                ],
                (object) [
                    'icon' => 'fa-solid fa-user-doctor',
                    'title' => 'Healthcare Professionals',
                    'description' => 'Manage healthcare professional profiles and improve collaboration between medical staff and caregivers.'
                ],
                (object) [
                    'icon' => 'fa-solid fa-notes-medical',
                    'title' => 'Care Plans',
                    'description' => 'Create personalized care plans based on each resident\'s individual health, lifestyle and support requirements.'
                ],
                (object) [
                    'icon' => 'fa-solid fa-pills',
                    'title' => 'Medication Tracking',
                    'description' => 'Keep medication information organized and help caregivers provide medication according to resident care plans.'
                ],
                (object) [
                    'icon' => 'fa-solid fa-comments',
                    'title' => 'Communication',
                    'description' => 'Improve communication between caregivers, administrators, healthcare professionals and families.'
                ]
            ]);
        }

        return $services;
    }

    /**
     * Get features from database with fallback data.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getFeatures()
    {
        $features = DB::table('features')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        // If no features in database, return default data
        if ($features->isEmpty()) {
            return collect([
                (object) [
                    'number' => '01',
                    'title' => 'Resident Information',
                    'description' => 'Access important resident information from one centralized and secure system.'
                ],
                (object) [
                    'number' => '02',
                    'title' => 'Staff & Shift Management',
                    'description' => 'Organize employee shifts and distribute caregiver responsibilities efficiently.'
                ],
                (object) [
                    'number' => '03',
                    'title' => 'Attendance Management',
                    'description' => 'Maintain staff attendance records and improve workforce management.'
                ],
                (object) [
                    'number' => '04',
                    'title' => 'Real-Time Communication',
                    'description' => 'Connect administrators, caregivers and healthcare professionals quickly.'
                ],
                (object) [
                    'number' => '05',
                    'title' => 'Healthcare Records',
                    'description' => 'Maintain organized health and care information for elderly residents.'
                ],
                (object) [
                    'number' => '06',
                    'title' => 'Reports & Monitoring',
                    'description' => 'Generate useful reports to support better management and decision making.'
                ]
            ]);
        }

        return $features;
    }

    /**
     * Get contact information from settings table.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getContactInfo()
    {
        return DB::table('settings')
            ->whereIn('key', ['contact_email', 'contact_phone', 'contact_address', 'facebook_url', 'instagram_url', 'linkedin_url'])
            ->pluck('value', 'key');
    }

    /**
     * Update statistics using transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatistics(Request $request)
    {
        $validated = $request->validate([
            'residents' => 'required|integer|min:0',
            'caregivers' => 'required|integer|min:0',
            'healthcare_staff' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Update statistics in database
            DB::table('statistics')->updateOrInsert(
                ['id' => 1],
                [
                    'residents' => $validated['residents'],
                    'caregivers' => $validated['caregivers'],
                    'healthcare_staff' => $validated['healthcare_staff'],
                    'updated_at' => now()
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Statistics updated successfully'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Failed to update statistics', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update statistics'
            ], 500);
        }
    }

    /**
     * Get residents with pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function getResidents(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search');

        $query = DB::table('residents')
            ->select('id', 'name', 'room_number', 'status', 'admission_date', 'emergency_contact');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('room_number', 'like', "%{$search}%");
        }

        $residents = $query->paginate($perPage);

        return view('residents.index', compact('residents'));
    }

    /**
     * Get caregivers with their assigned residents.
     *
     * @return \Illuminate\View\View
     */
    public function getCaregivers()
    {
        $caregivers = DB::table('staff')
            ->leftJoin('resident_assignments', 'staff.id', '=', 'resident_assignments.staff_id')
            ->leftJoin('residents', 'resident_assignments.resident_id', '=', 'residents.id')
            ->where('staff.role', 'caregiver')
            ->where('staff.status', 'active')
            ->select(
                'staff.id',
                'staff.name',
                'staff.email',
                'staff.phone',
                DB::raw('COUNT(residents.id) as assigned_residents'),
                DB::raw('GROUP_CONCAT(residents.name) as resident_names')
            )
            ->groupBy('staff.id', 'staff.name', 'staff.email', 'staff.phone')
            ->get();

        return view('caregivers.index', compact('caregivers'));
    }

    /**
     * Get care plans with resident details.
     *
     * @return \Illuminate\View\View
     */
    public function getCarePlans()
    {
        $carePlans = DB::table('care_plans')
            ->join('residents', 'care_plans.resident_id', '=', 'residents.id')
            ->leftJoin('staff', 'care_plans.created_by', '=', 'staff.id')
            ->where('care_plans.status', 'active')
            ->select(
                'care_plans.id',
                'care_plans.title',
                'care_plans.type',
                'care_plans.start_date',
                'care_plans.end_date',
                'residents.name as resident_name',
                'staff.name as created_by_name'
            )
            ->orderBy('care_plans.created_at', 'desc')
            ->get();

        return view('care-plans.index', compact('carePlans'));
    }
}