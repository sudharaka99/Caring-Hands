<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SriLankanDataSeeder extends Seeder
{
    public function run()
    {
        $password = Hash::make('12345678');
        $this->command->info('🇱🇰 Seeding Sri Lankan test data...');

        // ==========================================
        // 1. USERS
        // ==========================================
        $users = [
            ['name' => 'Kamal Wickramasinghe',   'email' => 'admin@caringhands.test',      'role' => 'admin'],
            ['name' => 'Nimal Perera',           'email' => 'manager@caringhands.test',    'role' => 'manager'],
            ['name' => 'Sita Kumari',            'email' => 'caregiver@caringhands.test',  'role' => 'caregiver'],
            ['name' => 'Kamala Silva',           'email' => 'caregiver2@caringhands.test', 'role' => 'caregiver'],
            ['name' => 'Ruwan Fernando',         'email' => 'caregiver3@caringhands.test', 'role' => 'caregiver'],
            ['name' => 'Dr. Chaminda Jayasuriya','email' => 'healthcare@caringhands.test', 'role' => 'healthcare'],
            ['name' => 'Sunil Rathnayake',       'email' => 'owner@caringhands.test',      'role' => 'owner'],
            ['name' => 'Nimali Weerasinghe',     'email' => 'owner2@caringhands.test',     'role' => 'owner'],
        ];

        foreach ($users as $u) {
            DB::table('users')->updateOrInsert(
                ['email' => $u['email']],
                array_merge($u, [
                    'password'   => $password,
                    'status'     => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
        $this->command->info('  ✅ Users (Sri Lankan names)');

        $uid = fn($email) => DB::table('users')->where('email', $email)->value('id');

        // ==========================================
        // 2. MANAGER
        // ==========================================
        DB::table('manager')->updateOrInsert(
            ['user_id' => $uid('manager@caringhands.test')],
            [
                'staff_code'             => 'MG-001',
                'nic'                    => '197512345678',
                'date_of_birth'          => '1975-03-22',
                'gender'                 => 'male',
                'phone'                  => '0712345601',
                'address'                => 'No. 45/2, Temple Road, Nugegoda',
                'joining_date'           => '2020-01-15',
                'employment_type'        => 'Full-time',
                'emergency_contact_name' => 'Mrs. Chandrika Perera',
                'emergency_relationship' => 'Wife',
                'emergency_phone'        => '0712345602',
                'qualifications'         => 'MSc in Healthcare Management (University of Colombo), BSc in Nursing',
                'experience'             => '12 years in elderly care management',
                'notes'                  => 'Specialized in geriatric facility operations',
                'created_at'             => now(),
                'updated_at'             => now(),
            ]
        );
        $this->command->info('  ✅ Manager');

        // ==========================================
        // 3. CAREGIVERS
        // ==========================================
        $caregivers = [
            [
                'email' => 'caregiver@caringhands.test', 'code' => 'CG-101',
                'nic' => '198836712345', 'dob' => '1988-06-12', 'gender' => 'female',
                'phone' => '0773456701', 'address' => 'No. 128, Galle Road, Mount Lavinia',
                'emergency' => 'Mr. Sunil Kumari', 'relationship' => 'Husband', 'emergency_phone' => '0773456702',
                'qualifications' => 'Diploma in Nursing (SLIIT), Certificate in Elderly Care (Nawaloka)',
                'experience' => '5 years in elderly care at Nawaloka Elders Home',
                'notes' => 'Specialized in dementia and Alzheimer care',
            ],
            [
                'email' => 'caregiver2@caringhands.test', 'code' => 'CG-102',
                'nic' => '199234567890', 'dob' => '1992-11-25', 'gender' => 'female',
                'phone' => '0714567801', 'address' => 'No. 78/A, Kandy Road, Kelaniya',
                'emergency' => 'Mr. Chaminda Silva', 'relationship' => 'Husband', 'emergency_phone' => '0714567802',
                'qualifications' => 'BSc in Nursing (University of Peradeniya), Certificate in First Aid',
                'experience' => '8 years in elderly care, 3 years at Asiri Hospital',
                'notes' => 'Expert in post-surgery recovery and rehabilitation',
            ],
            [
                'email' => 'caregiver3@caringhands.test', 'code' => 'CG-103',
                'nic' => '199556789012', 'dob' => '1995-04-18', 'gender' => 'male',
                'phone' => '0765678901', 'address' => 'No. 22, Negombo Road, Ja-Ela',
                'emergency' => 'Mrs. Nilmini Fernando', 'relationship' => 'Mother', 'emergency_phone' => '0765678902',
                'qualifications' => 'Diploma in Healthcare (NAITA), Certificate in Geriatric Care',
                'experience' => '4 years in hospital care at Ragama Teaching Hospital',
                'notes' => 'Available for night shifts and emergency care',
            ],
        ];

        foreach ($caregivers as $c) {
            DB::table('caregiver')->updateOrInsert(
                ['user_id' => $uid($c['email'])],
                [
                    'staff_code'             => $c['code'],
                    'nic'                    => $c['nic'],
                    'date_of_birth'          => $c['dob'],
                    'gender'                 => $c['gender'],
                    'phone'                  => $c['phone'],
                    'address'                => $c['address'],
                    'joining_date'           => '2021-03-10',
                    'employment_type'        => 'full_time',
                    'emergency_contact_name' => $c['emergency'],
                    'emergency_relationship' => $c['relationship'],
                    'emergency_phone'        => $c['emergency_phone'],
                    'qualifications'         => $c['qualifications'],
                    'experience'             => $c['experience'],
                    'notes'                  => $c['notes'],
                    'created_at'             => now(),
                    'updated_at'             => now(),
                ]
            );
        }
        $this->command->info('  ✅ Caregivers');

        // ==========================================
        // 4. HEALTHCARE
        // ==========================================
        DB::table('healthcare')->updateOrInsert(
            ['user_id' => $uid('healthcare@caringhands.test')],
            [
                'staff_code'             => 'DR-101',
                'nic'                    => '197578901234',
                'date_of_birth'          => '1975-09-30',
                'gender'                 => 'male',
                'phone'                  => '0726789012',
                'address'                => 'No. 15/1, Rosmead Place, Colombo 07',
                'joining_date'           => '2019-06-20',
                'employment_type'        => 'full_time',
                'specialization'         => 'Geriatric Medicine',
                'qualifications'         => 'MBBS (University of Colombo), MD in Geriatric Medicine, MRCP (UK)',
                'experience'             => '15 years in geriatric care, 8 years at National Hospital Colombo',
                'emergency_contact_name' => 'Mrs. Anoma Jayasuriya',
                'emergency_relationship' => 'Wife',
                'emergency_phone'        => '0726789013',
                'notes'                  => "Specialized in dementia and Parkinson's disease",
                'created_at'             => now(),
                'updated_at'             => now(),
            ]
        );
        $this->command->info('  ✅ Healthcare (Dr. Chaminda Jayasuriya)');

        // ==========================================
        // 5. OWNERS
        // ==========================================
        foreach ([
            ['email' => 'owner@caringhands.test',  'name' => 'Sunil Rathnayake',   'nic' => '197545678901', 'phone' => '0717890123', 'addr' => 'No. 45, Lake Round, Kandy',              'rel' => 'Son'],
            ['email' => 'owner2@caringhands.test', 'name' => 'Nimali Weerasinghe', 'nic' => '198056789012', 'phone' => '0778901234', 'addr' => 'No. 88/2, Havelock Road, Colombo 05',    'rel' => 'Daughter'],
        ] as $o) {
            DB::table('owners')->updateOrInsert(
                ['email' => $o['email']],
                [
                    'user_id'      => $uid($o['email']),
                    'name'         => $o['name'],
                    'nic'          => $o['nic'],
                    'phone'        => $o['phone'],
                    'address'      => $o['addr'],
                    'relationship' => $o['rel'],
                    'status'       => 'active',
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
        }
        $this->command->info('  ✅ Owners');

        // ==========================================
        // 6. ELDERS
        // ==========================================
        $elders = [
            ['code' => 'ELD-1001', 'name' => 'Mr. Somapala Rathnayake',  'nic' => '194012345678', 'dob' => '1940-01-12', 'age' => 86, 'gender' => 'male',   'blood' => 'B+',  'room' => '101', 'caregiver' => 'Sita Kumari',    'phone' => '0711234001', 'email' => 'somapala.rathnayake@gmail.com', 'emerg' => 'Sunil Rathnayake',    'emerg_phone' => '0717890123', 'rel' => 'Son',      'address' => 'No. 45, Lake Round, Kandy',             'notes' => 'Arthritis in both knees, requires walking assistance.'],
            ['code' => 'ELD-1002', 'name' => 'Mrs. Kusuma Weerasinghe', 'nic' => '194505678901', 'dob' => '1945-05-23', 'age' => 81, 'gender' => 'female', 'blood' => 'AB+', 'room' => '102', 'caregiver' => 'Sita Kumari',    'phone' => '0711234002', 'email' => 'kusuma.weera@gmail.com',        'emerg' => 'Nimali Weerasinghe',  'emerg_phone' => '0778901234', 'rel' => 'Daughter', 'address' => 'No. 88/2, Havelock Road, Colombo 05',    'notes' => 'Type 2 Diabetes on insulin, mild hypertension.'],
            ['code' => 'ELD-1003', 'name' => 'Mr. Ananda Fernando',      'nic' => '193808345678', 'dob' => '1938-08-11', 'age' => 88, 'gender' => 'male',   'blood' => 'O+',  'room' => '103', 'caregiver' => 'Kamala Silva',   'phone' => '0711234003', 'email' => 'ananda.fernando@gmail.com',     'emerg' => 'Kamal Fernando',      'emerg_phone' => '0721234003', 'rel' => 'Son',      'address' => 'No. 10, Temple Road, Maharagama',       'notes' => 'Ischemic heart disease, on blood thinners.'],
            ['code' => 'ELD-1004', 'name' => 'Mrs. Somawathi Perera',    'nic' => '195010456789', 'dob' => '1950-10-05', 'age' => 76, 'gender' => 'female', 'blood' => 'A+',  'room' => '104', 'caregiver' => 'Kamala Silva',   'phone' => '0711234004', 'email' => 'somawathi.perera@gmail.com',    'emerg' => 'Sita Perera',         'emerg_phone' => '0731234004', 'rel' => 'Daughter', 'address' => 'No. 15, Negombo Road, Wattala',         'notes' => 'Mild dementia, needs supervision.'],
            ['code' => 'ELD-1005', 'name' => 'Mr. Karunaratne Banda',    'nic' => '194212567890', 'dob' => '1942-12-30', 'age' => 83, 'gender' => 'male',   'blood' => 'B-',  'room' => '105', 'caregiver' => 'Ruwan Fernando', 'phone' => '0711234005', 'email' => 'karu.banda@gmail.com',          'emerg' => 'Ruwan Banda',         'emerg_phone' => '0741234005', 'rel' => 'Son',      'address' => 'No. 20, Matara Road, Galle',            'notes' => 'Post knee replacement, physiotherapy ongoing.'],
        ];

        foreach ($elders as $e) {
            DB::table('elders')->updateOrInsert(
                ['elder_code' => $e['code']],
                [
                    'name'                            => $e['name'],
                    'nic'                             => $e['nic'],
                    'dob'                             => $e['dob'],
                    'age'                             => $e['age'],
                    'gender'                          => $e['gender'],
                    'blood_group'                     => $e['blood'],
                    'phone'                           => $e['phone'],
                    'email'                           => $e['email'],
                    'address'                         => $e['address'],
                    'emergency_contact_name'          => $e['emerg'],
                    'emergency_contact_phone'         => $e['emerg_phone'],
                    'emergency_contact_relationship'  => $e['rel'],
                    'room'                            => $e['room'],
                    'caregiver'                       => $e['caregiver'],
                    'admission_date'                  => now()->subMonths(rand(1, 12))->toDateString(),
                    'status'                          => 'active',
                    'medical_notes'                   => $e['notes'],
                    'created_at'                      => now(),
                    'updated_at'                      => now(),
                ]
            );
        }
        $this->command->info('  ✅ 5 Elders (Sri Lankan)');

        // ==========================================
        // 7. ELDER_OWNER PIVOT
        // ==========================================
        $ownerSunil  = DB::table('owners')->where('name', 'Sunil Rathnayake')->value('id');
        $ownerNimali = DB::table('owners')->where('name', 'Nimali Weerasinghe')->value('id');

        $links = [
            ['elder' => 'ELD-1001', 'owner' => $ownerSunil],
            ['elder' => 'ELD-1002', 'owner' => $ownerNimali],
            ['elder' => 'ELD-1003', 'owner' => $ownerSunil],
        ];

        foreach ($links as $link) {
            $elderId = DB::table('elders')->where('elder_code', $link['elder'])->value('id');
            DB::table('elder_owner')->updateOrInsert(
                ['elder_id' => $elderId, 'owner_id' => $link['owner']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
        $this->command->info('  ✅ Elder-Owner links');

        // ==========================================
        // 8. STAFF SHIFTS
        // ==========================================
        $morning = DB::table('shift_types')->where('name', 'Morning Shift')->value('id');
        $evening = DB::table('shift_types')->where('name', 'Evening Shift')->value('id');
        $night   = DB::table('shift_types')->where('name', 'Night Shift')->value('id');

        $shifts = [
            ['email' => 'caregiver@caringhands.test',  'shift' => $morning, 'date' => today(),                 'start' => '06:00:00', 'end' => '14:00:00'],
            ['email' => 'caregiver2@caringhands.test', 'shift' => $evening, 'date' => today(),                 'start' => '14:00:00', 'end' => '22:00:00'],
            ['email' => 'caregiver3@caringhands.test', 'shift' => $night,   'date' => today(),                 'start' => '22:00:00', 'end' => '06:00:00'],
            ['email' => 'caregiver@caringhands.test',  'shift' => $morning, 'date' => today()->addDay(),       'start' => '06:00:00', 'end' => '14:00:00'],
            ['email' => 'caregiver2@caringhands.test', 'shift' => $evening, 'date' => today()->addDay(),       'start' => '14:00:00', 'end' => '22:00:00'],
        ];

        foreach ($shifts as $s) {
            DB::table('staff_shifts')->insertOrIgnore([
                'user_id'       => $uid($s['email']),
                'shift_type_id' => $s['shift'],
                'shift_date'    => $s['date'],
                'start_time'    => $s['start'],
                'end_time'      => $s['end'],
                'status'        => 'scheduled',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
        $this->command->info('  ✅ Staff Shifts');

        // ==========================================
        // 9. CARE PLANS
        // ==========================================
        $c1 = DB::table('caregiver')->where('staff_code', 'CG-101')->value('id');
        $c2 = DB::table('caregiver')->where('staff_code', 'CG-102')->value('id');

        $plans = [
            ['elder' => 'ELD-1001', 'cg' => $c1, 'title' => 'Daily Mobility & Arthritis Support', 'needs' => 'Walking assistance, arthritis pain management', 'goals' => 'Maintain mobility, reduce pain', 'priority' => 'high',     'status' => 'active'],
            ['elder' => 'ELD-1002', 'cg' => $c1, 'title' => 'Diabetes Management Plan',           'needs' => 'Blood sugar monitoring, insulin, diet control',  'goals' => 'Keep sugar 90-140 mg/dL',       'priority' => 'critical', 'status' => 'active'],
            ['elder' => 'ELD-1003', 'cg' => $c2, 'title' => 'Cardiac Care & BP Control',           'needs' => 'BP monitoring, cardiac medication, low-sodium',  'goals' => 'BP below 140/90',                'priority' => 'high',     'status' => 'active'],
            ['elder' => 'ELD-1004', 'cg' => $c2, 'title' => 'Dementia Care & Cognitive Support',  'needs' => 'Memory support, orientation, safety',            'goals' => 'Slow cognitive decline',         'priority' => 'medium',   'status' => 'active'],
        ];

        foreach ($plans as $p) {
            DB::table('care_plans')->insert([
                'elder_id'    => DB::table('elders')->where('elder_code', $p['elder'])->value('id'),
                'caregiver_id'=> $p['cg'],
                'title'       => $p['title'],
                'care_needs'  => $p['needs'],
                'goals'       => $p['goals'],
                'activities'  => 'Morning walk, medication, exercise',
                'start_date'  => today(),
                'review_date' => today()->addDays(30),
                'priority'    => $p['priority'],
                'status'      => $p['status'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
        $this->command->info('  ✅ Care Plans');

        // ==========================================
        // 10. MEDICATIONS
        // ==========================================
        $meds = [
            ['elder' => 'ELD-1001', 'name' => 'Panadol',    'generic' => 'Paracetamol',   'dosage' => '500', 'unit' => 'mg',    'freq' => 'twice_daily', 'time' => '08:00:00', 'route' => 'oral',      'purpose' => 'Pain relief for arthritis'],
            ['elder' => 'ELD-1002', 'name' => 'Glucophage', 'generic' => 'Metformin HCl', 'dosage' => '500', 'unit' => 'mg',    'freq' => 'twice_daily', 'time' => '08:00:00', 'route' => 'oral',      'purpose' => 'Type 2 Diabetes control'],
            ['elder' => 'ELD-1002', 'name' => 'Humulin',    'generic' => 'Human Insulin', 'dosage' => '10',  'unit' => 'units', 'freq' => 'twice_daily', 'time' => '07:30:00', 'route' => 'injection', 'purpose' => 'Blood sugar control'],
            ['elder' => 'ELD-1003', 'name' => 'Tenormin',   'generic' => 'Atenolol',      'dosage' => '50',  'unit' => 'mg',    'freq' => 'once_daily',  'time' => '08:00:00', 'route' => 'oral',      'purpose' => 'Blood pressure control'],
            ['elder' => 'ELD-1003', 'name' => 'Ecosprin',   'generic' => 'Aspirin',       'dosage' => '75',  'unit' => 'mg',    'freq' => 'once_daily',  'time' => '08:00:00', 'route' => 'oral',      'purpose' => 'Blood thinner'],
            ['elder' => 'ELD-1004', 'name' => 'Aricept',    'generic' => 'Donepezil',     'dosage' => '5',   'unit' => 'mg',    'freq' => 'once_daily',  'time' => '21:00:00', 'route' => 'oral',      'purpose' => 'Dementia management'],
        ];

        foreach ($meds as $m) {
            DB::table('medications')->insert([
                'elder_id'            => DB::table('elders')->where('elder_code', $m['elder'])->value('id'),
                'medication_name'     => $m['name'],
                'generic_name'        => $m['generic'],
                'dosage'              => $m['dosage'],
                'dosage_unit'         => $m['unit'],
                'frequency'           => $m['freq'],
                'administration_time' => $m['time'],
                'route'               => $m['route'],
                'start_date'          => today(),
                'end_date'            => today()->addDays(90),
                'prescribed_by'       => 'Dr. Chaminda Jayasuriya',
                'purpose'             => $m['purpose'],
                'status'              => 'active',
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }
        $this->command->info('  ✅ Medications');

        // ==========================================
        // 11. APPOINTMENTS
        // ==========================================
        $appts = [
            ['elder' => 'ELD-1002', 'type' => 'doctor',  'title' => 'Diabetes Follow-up',       'doctor' => 'Dr. Chaminda Jayasuriya', 'hospital' => 'National Hospital of Sri Lanka', 'loc' => 'Colombo 10', 'date' => today()->addDays(7),  'time' => '10:00:00', 'reason' => 'Routine diabetes checkup and HbA1c test'],
            ['elder' => 'ELD-1003', 'type' => 'checkup', 'title' => 'Cardiac Evaluation',        'doctor' => 'Dr. Chaminda Jayasuriya', 'hospital' => 'Kandy General Hospital',         'loc' => 'Kandy',      'date' => today()->addDays(14), 'time' => '14:00:00', 'reason' => 'ECG and echocardiogram'],
            ['elder' => 'ELD-1001', 'type' => 'therapy', 'title' => 'Physiotherapy Session',     'doctor' => 'Dr. Nimal Ratnayake',     'hospital' => 'Asiri Central Hospital',        'loc' => 'Colombo 10', 'date' => today()->addDays(3),  'time' => '11:00:00', 'reason' => 'Knee physiotherapy'],
            ['elder' => 'ELD-1004', 'type' => 'doctor',  'title' => 'Neurology Consultation',    'doctor' => 'Dr. Chaminda Jayasuriya', 'hospital' => 'Nawaloka Hospital',              'loc' => 'Colombo 02', 'date' => today()->addDays(10), 'time' => '09:30:00', 'reason' => 'Dementia assessment'],
        ];

        foreach ($appts as $a) {
            DB::table('appointments')->insert([
                'elder_id'          => DB::table('elders')->where('elder_code', $a['elder'])->value('id'),
                'appointment_type'  => $a['type'],
                'title'             => $a['title'],
                'doctor_name'       => $a['doctor'],
                'hospital_name'     => $a['hospital'],
                'location'          => $a['loc'],
                'appointment_date'  => $a['date'],
                'appointment_time'  => $a['time'],
                'duration_minutes'  => 30,
                'reason'            => $a['reason'],
                'status'            => 'scheduled',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
        $this->command->info('  ✅ Appointments');

        // ==========================================
        // SUMMARY
        // ==========================================
        $this->command->info('');
        $this->command->info('══════════════════════════════════════════════════');
        $this->command->info('  🇱🇰 ALL LOGINS — password: 12345678');
        $this->command->info('══════════════════════════════════════════════════');
        $this->command->info('  admin@caringhands.test      → Kamal Wickramasinghe (admin)');
        $this->command->info('  manager@caringhands.test    → Nimal Perera (manager)');
        $this->command->info('  caregiver@caringhands.test  → Sita Kumari (caregiver)');
        $this->command->info('  caregiver2@caringhands.test → Kamala Silva (caregiver)');
        $this->command->info('  caregiver3@caringhands.test → Ruwan Fernando (caregiver)');
        $this->command->info('  healthcare@caringhands.test → Dr. Chaminda Jayasuriya (healthcare)');
        $this->command->info('  owner@caringhands.test      → Sunil Rathnayake (owner)');
        $this->command->info('  owner2@caringhands.test     → Nimali Weerasinghe (owner)');
        $this->command->info('══════════════════════════════════════════════════');
    }
}