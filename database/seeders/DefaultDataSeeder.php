<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultDataSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // SETTINGS
        // ==========================================
        DB::table('settings')->insert([
            ['key' => 'contact_email',   'value' => 'info@caringhands.com',  'group' => 'contact', 'type' => 'email', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_phone',   'value' => '+94 11 234 5678',       'group' => 'contact', 'type' => 'phone', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_address', 'value' => 'Colombo, Sri Lanka',    'group' => 'contact', 'type' => 'text',  'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_name',       'value' => 'Caring Hands',          'group' => 'general', 'type' => 'text',  'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_tagline',    'value' => 'Care with Compassion',  'group' => 'general', 'type' => 'text',  'created_at' => now(), 'updated_at' => now()],
        ]);


        // ==========================================
        // SERVICES (6 services with Font Awesome icons)
        // ==========================================
        DB::table('services')->insert([
            [
                'title'       => 'Elder Management',
                'slug'        => 'elder-management',
                'description' => 'Securely manage resident profiles, personal information, health records and important care information.',
                'content'     => 'Store and organize every resident\'s complete profile including medical history, allergies, dietary needs, emergency contacts, and daily care preferences.',
                'icon'        => 'fa-solid fa-person-cane',
                'sort_order'  => 1,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Caregiver Management',
                'slug'        => 'caregiver-management',
                'description' => 'Organize caregivers, assign duties, manage workloads and ensure every resident receives proper attention.',
                'content'     => 'Assign caregivers based on skills, availability, and resident needs. Track workloads, monitor performance, and maintain fair scheduling.',
                'icon'        => 'fa-solid fa-user-nurse',
                'sort_order'  => 2,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Healthcare Professionals',
                'slug'        => 'healthcare-professionals',
                'description' => 'Manage healthcare professional profiles and improve collaboration between medical staff and caregivers.',
                'content'     => 'Maintain detailed profiles for doctors, nurses, and specialists. Enable seamless communication between medical teams and caregivers.',
                'icon'        => 'fa-solid fa-user-doctor',
                'sort_order'  => 3,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Care Plans',
                'slug'        => 'care-plans',
                'description' => 'Create personalized care plans based on each resident\'s individual health, lifestyle and support requirements.',
                'content'     => 'Design tailored care plans covering medication schedules, therapy routines, dietary needs, and daily activities.',
                'icon'        => 'fa-solid fa-notes-medical',
                'sort_order'  => 4,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Medication Tracking',
                'slug'        => 'medication-tracking',
                'description' => 'Keep medication information organized and help caregivers provide medication according to resident care plans.',
                'content'     => 'Track prescriptions, dosages, and administration times. Log every dose given, monitor compliance, and receive alerts.',
                'icon'        => 'fa-solid fa-pills',
                'sort_order'  => 5,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Communication',
                'slug'        => 'communication',
                'description' => 'Improve communication between caregivers, administrators, healthcare professionals and families.',
                'content'     => 'Keep everyone informed with built-in messaging, shared updates, and notifications.',
                'icon'        => 'fa-solid fa-comments',
                'sort_order'  => 6,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);


        // ==========================================
        // FEATURES (6 features with Font Awesome icons)
        // ==========================================
        DB::table('features')->insert([
            [
                'title'       => 'Resident Information',
                'description' => 'Access important resident information from one centralized and secure system.',
                'icon'        => 'fa-solid fa-user',
                'sort_order'  => 1,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Staff & Shift Management',
                'description' => 'Organize employee shifts and distribute caregiver responsibilities efficiently.',
                'icon'        => 'fa-solid fa-calendar-days',
                'sort_order'  => 2,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Attendance Management',
                'description' => 'Maintain staff attendance records and improve workforce management.',
                'icon'        => 'fa-solid fa-fingerprint',
                'sort_order'  => 3,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Real-Time Communication',
                'description' => 'Connect administrators, caregivers and healthcare professionals quickly.',
                'icon'        => 'fa-solid fa-comments',
                'sort_order'  => 4,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Healthcare Records',
                'description' => 'Maintain organized health and care information for elderly residents.',
                'icon'        => 'fa-solid fa-notes-medical',
                'sort_order'  => 5,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Reports & Monitoring',
                'description' => 'Generate useful reports to support better management and decision making.',
                'icon'        => 'fa-solid fa-chart-line',
                'sort_order'  => 6,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);


        // ==========================================
        // TEAM MEMBERS (Sri Lankan names)
        // ==========================================
        DB::table('team_members')->insert([
            [
                'name'       => 'Kamal Wickramasinghe',
                'position'   => 'Founder & CEO',
                'bio'        => 'Leads Caring Hands with 15 years of healthcare management experience.',
                'email'      => 'kamal@caringhands.com',
                'sort_order' => 1,
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Chandrika Perera',
                'position'   => 'Head of Care Operations',
                'bio'        => 'Oversees all care operations and caregiver training programs.',
                'email'      => 'chandrika@caringhands.com',
                'sort_order' => 2,
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Dr. Chaminda Jayasuriya',
                'position'   => 'Medical Advisor',
                'bio'        => 'Provides medical guidance and quality assurance across all facilities.',
                'email'      => 'chaminda@caringhands.com',
                'sort_order' => 3,
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Nimali Weerasinghe',
                'position'   => 'Customer Relations Manager',
                'bio'        => 'Ensures families stay informed and connected with their loved ones.',
                'email'      => 'nimali@caringhands.com',
                'sort_order' => 4,
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}