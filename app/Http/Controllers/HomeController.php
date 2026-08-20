<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    public function index()
    {

        return view('home', );
    }


    public function about()
    {
        // Get team members from database
        $team = DB::table('team_members')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();
        
        return view('about', compact('team'));
    }


    public function services()
    {
        // Get all services from database
        $services = DB::table('services')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();
        
        return view('services', compact('services'));
    }

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


    public function contact()
    {
        // Get contact information from settings table
        $contactInfo = DB::table('settings')
            ->whereIn('key', ['contact_email', 'contact_phone', 'contact_address'])
            ->pluck('value', 'key')
            ->toArray();
        
        return view('contact', compact('contactInfo'));
    }


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


    private function getStatistics()
    {
        $elders = DB::table('elders')
            ->where('status', 'active')
            ->count();

        $caregivers = DB::table('users')
            ->where('role', 'caregiver')
            ->count();

        $healthcareStaff = DB::table('users')
            ->where('role', 'healthcare')
            ->count();

        return [
            'elders' => $elders > 0 ? $elders : 100,
            'caregivers' => $caregivers > 0 ? $caregivers : 50,
            'healthcare_staff' => $healthcareStaff > 0 ? $healthcareStaff : 20,
            'availability' => '24/7'
        ];
    }

   
}