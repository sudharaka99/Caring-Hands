@extends('layouts.admin')

@section('title', ($elder->name ?? 'Resident') . ' | Caring Hands')

@section('content')

<div class="dashboard-page">

    <!-- ==========================================
         PAGE HEADER
    =========================================== -->
    <div class="dashboard-heading">

        <div>
            <h1>{{ $elder->name }}</h1>
            <p class="dashboard-subtitle">
                Resident Details · {{ $elder->elder_code }}
            </p>
        </div>

        <a href="{{ route('caregiver.elders.index') }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Residents
        </a>

    </div>


    <!-- ==========================================
         MAIN GRID
    =========================================== -->
    <div class="dashboard-grid">

        <!-- Personal Info Card -->
        <div class="dashboard-card">

            <div class="dashboard-card-header">
                <div>
                    <h3>Personal Information</h3>
                    <p>Basic resident details</p>
                </div>
            </div>

            <!-- Avatar + Name -->
            <div class="resident-user" style="margin-bottom: 20px;">
                <div class="resident-avatar" style="width: 80px; height: 80px; font-size: 32px;">
                    @if(!empty($elder->photo))
                        <img src="{{ asset('storage/' . $elder->photo) }}"
                             alt="{{ $elder->name }}">
                    @else
                        {{ strtoupper(substr($elder->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <strong style="font-size: 18px;">{{ $elder->name }}</strong>
                    <span>{{ $elder->elder_code }}</span>
                </div>
            </div>

            <!-- Details -->
            <div class="overview-details">

                <div class="overview-row">
                    <div class="overview-label">Room</div>
                    <strong>{{ $elder->room ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Age</div>
                    <strong>{{ $elder->age ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Gender</div>
                    <strong>{{ ucfirst($elder->gender ?? '-') }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Blood Group</div>
                    <strong>{{ $elder->blood_group ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Phone</div>
                    <strong>{{ $elder->phone ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Emergency Contact</div>
                    <strong>{{ $elder->emergency_contact_name ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Emergency Phone</div>
                    <strong>{{ $elder->emergency_contact_phone ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Status</div>
                    <span class="table-status active">
                        {{ ucfirst($elder->status ?? 'active') }}
                    </span>
                </div>

            </div>

        </div>


        <!-- Care Summary Card -->
        <div class="dashboard-card">

            <div class="dashboard-card-header">
                <div>
                    <h3>Care Summary</h3>
                    <p>Current treatment overview</p>
                </div>
            </div>

            <div class="quick-actions">

                <a href="{{ route('caregiver.care-plans.index') }}" class="quick-action">
                    <div class="quick-action-icon pink">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>
                    <div>
                        <strong>{{ $carePlans->count() ?? 0 }} Care Plans</strong>
                        <span>Active plans</span>
                    </div>
                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

                <a href="{{ route('caregiver.medications.index') }}" class="quick-action">
                    <div class="quick-action-icon teal">
                        <i class="fa-solid fa-pills"></i>
                    </div>
                    <div>
                        <strong>{{ $medications->count() ?? 0 }} Medications</strong>
                        <span>Current meds</span>
                    </div>
                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

                <a href="{{ route('caregiver.appointments.index') }}" class="quick-action">
                    <div class="quick-action-icon purple">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <strong>{{ $appointments->count() ?? 0 }} Appointments</strong>
                        <span>Scheduled visits</span>
                    </div>
                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

            </div>

        </div>

    </div>


    <!-- ==========================================
         MEDICAL NOTES
    =========================================== -->
    @if(!empty($elder->medical_notes))
        <div class="dashboard-card" style="margin-top: 24px;">

            <div class="dashboard-card-header">
                <div>
                    <h3>Medical Notes</h3>
                    <p>Important health information</p>
                </div>
            </div>

            <div style="padding: 16px 0; color: #4b5563; line-height: 1.6;">
                {{ $elder->medical_notes }}
            </div>

        </div>
    @endif


    <!-- ==========================================
         CARE PLANS LIST
    =========================================== -->
    @if(!empty($carePlans) && $carePlans->count() > 0)

        <div class="dashboard-card" style="margin-top: 24px;">

            <div class="dashboard-card-header">
                <div>
                    <h3>Active Care Plans</h3>
                    <p>Treatment plans for this resident</p>
                </div>
            </div>

            <div class="dashboard-table-wrapper">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Review Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carePlans as $plan)
                            <tr>
                                <td><strong>{{ $plan->title }}</strong></td>
                                <td>
                                    <span class="table-status {{ $plan->priority === 'critical' ? 'danger' : ($plan->priority === 'high' ? 'warning' : 'active') }}">
                                        {{ ucfirst($plan->priority) }}
                                    </span>
                                </td>
                                <td>{{ ucfirst($plan->status) }}</td>
                                <td>{{ $plan->review_date ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    @endif


    <!-- ==========================================
         MEDICATIONS LIST
    =========================================== -->
    @if(!empty($medications) && $medications->count() > 0)

        <div class="dashboard-card" style="margin-top: 24px;">

            <div class="dashboard-card-header">
                <div>
                    <h3>Current Medications</h3>
                    <p>Active medication schedule</p>
                </div>
            </div>

            <div class="dashboard-table-wrapper">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Medication</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medications as $med)
                            <tr>
                                <td>
                                    <strong>{{ $med->medication_name }}</strong>
                                    <span style="display:block; font-size:12px; color:#6b7280;">
                                        {{ $med->generic_name }}
                                    </span>
                                </td>
                                <td>{{ $med->dosage }} {{ $med->dosage_unit }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($med->frequency)) }}</td>
                                <td>
                                    <span class="table-status active">
                                        {{ ucfirst($med->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    @endif


    <!-- ==========================================
         APPOINTMENTS LIST
    =========================================== -->
    @if(!empty($appointments) && $appointments->count() > 0)

        <div class="dashboard-card" style="margin-top: 24px;">

            <div class="dashboard-card-header">
                <div>
                    <h3>Upcoming Appointments</h3>
                    <p>Scheduled visits</p>
                </div>
            </div>

            <div class="dashboard-table-wrapper">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                            <tr>
                                <td><strong>{{ $appt->title }}</strong></td>
                                <td>{{ $appt->doctor_name ?? '-' }}</td>
                                <td>{{ $appt->appointment_date }}</td>
                                <td>{{ $appt->appointment_time }}</td>
                                <td>
                                    <span class="table-status active">
                                        {{ ucfirst($appt->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    @endif


</div>

@endsection