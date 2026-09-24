<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultDataSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Settings ----
        DB::table('settings')->insert([
            ['key' => 'contact_email',   'value' => 'info@caringhands.com',  'group' => 'contact', 'type' => 'email',    'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_phone',   'value' => '+94 11 234 5678',       'group' => 'contact', 'type' => 'phone',    'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_address', 'value' => 'Colombo, Sri Lanka',    'group' => 'contact', 'type' => 'text',     'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_name',       'value' => 'Caring Hands',          'group' => 'general', 'type' => 'text',     'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_tagline',    'value' => 'Care with Compassion',  'group' => 'general', 'type' => 'text',     'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- Services ----
        DB::table('services')->insert([
            ['title' => 'Elder Care',       'slug' => 'elder-care',       'description' => 'Professional care for elders at home.',       'icon' => 'bi-heart-pulse',   'sort_order' => 1, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Home Nursing',     'slug' => 'home-nursing',     'description' => 'Qualified nurses for home visits.',           'icon' => 'bi-hospital',      'sort_order' => 2, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Companion Care',   'slug' => 'companion-care',   'description' => 'Friendly companionship and support.',         'icon' => 'bi-people',        'sort_order' => 3, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Meal Preparation', 'slug' => 'meal-preparation', 'description' => 'Nutritious meals prepared with care.',        'icon' => 'bi-egg-fried',     'sort_order' => 4, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- Features ----
        DB::table('features')->insert([
            ['title' => '24/7 Support',        'description' => 'Round-the-clock care and assistance.',           'icon' => 'bi-clock-history', 'sort_order' => 1, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Qualified Caregivers','description' => 'Trained and certified professionals.',           'icon' => 'bi-patch-check',   'sort_order' => 2, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Personalized Plans',  'description' => 'Care plans tailored to each individual.',        'icon' => 'bi-clipboard-heart','sort_order'=> 3, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Family Communication','description' => 'Regular updates to keep families informed.',     'icon' => 'bi-chat-dots',     'sort_order' => 4, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- Team Members ----
        DB::table('team_members')->insert([
            ['name' => 'John Silva',    'position' => 'Founder & CEO',        'bio' => 'Leads Caring Hands with 15 years of healthcare experience.', 'email' => 'john@caringhands.com',    'sort_order' => 1, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mary Perera',   'position' => 'Head of Care',         'bio' => 'Oversees all care operations and caregiver training.',        'email' => 'mary@caringhands.com',    'sort_order' => 2, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dr. Anil Fernando','position' => 'Medical Advisor',   'bio' => 'Provides medical guidance and quality assurance.',            'email' => 'anil@caringhands.com',    'sort_order' => 3, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}