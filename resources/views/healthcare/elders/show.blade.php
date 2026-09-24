@extends('layouts.admin')

@section('title', $elder->name . ' | Caring Hands')

@section('content')
<div class="dashboard-page">

    {{-- Page Header --}}
    <div class="dashboard-heading">
        <div>
            <h1>{{ $elder->name }}</h1>
            <p class="dashboard-subtitle">
                {{ $elder->elder_code }} · Room {{ $elder->room ?? '-' }}
            </p>
        </div>
        <a href="{{ route('healthcare.elders.index') }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Residents
        </a>
    </div>


    {{-- Main Grid --}}
    <div class="dashboard-grid">

        {{-- Personal Info --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>Personal Information</h3>
                    <p>Basic resident details</p>
                </div>
            </div>

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

            <div class="overview-details">

                <div class="overview-row">
                    <div class="overview-label">
                        <i class="fa-solid fa-door-open" style="color: #ec4899; margin-right: 6px;"></i>
                        Room
                    </div>
                    <strong>{{ $elder->room ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">
                        <i class="fa-solid fa-cake-candles" style="color: #ec4899; margin-right: 6px;"></i>
                        Age
                    </div>
                    <strong>{{ $elder->age ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">
                        <i class="fa-solid fa-venus-mars" style="color: #ec4899; margin-right: 6px;"></i>
                        Gender
                    </div>
                    <strong>{{ ucfirst($elder->gender ?? '-') }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">
                        <i class="fa-solid fa-droplet" style="color: #ec4899; margin-right: 6px;"></i>
                        Blood Group
                    </div>
                    <strong>{{ $elder->blood_group ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">
                        <i class="fa-solid fa-phone" style="color: #ec4899; margin-right: 6px;"></i>
                        Phone
                    </div>
                    <strong>{{ $elder->phone ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">
                        <i class="fa-solid fa-calendar" style="color: #ec4899; margin-right: 6px;"></i>
                        Admitted
                    </div>
                    <strong>{{ $elder->admission_date ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">
                        <i class="fa-solid fa-circle-check" style="color: #10b981; margin-right: 6px;"></i>
                        Status
                    </div>
                    <span class="table-status active">
                        {{ ucfirst($elder->status ?? 'active') }}
                    </span>
                </div>

            </div>
        </div>


        {{-- Emergency Contact --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>Emergency Contact</h3>
                    <p>Who to reach in an emergency</p>
                </div>
            </div>

            <div class="overview-details">

                <div class="overview-row">
                    <div class="overview-label">Name</div>
                    <strong>{{ $elder->emergency_contact_name ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Relationship</div>
                    <strong>{{ $elder->emergency_contact_relationship ?? '-' }}</strong>
                </div>

                <div class="overview-row">
                    <div class="overview-label">Phone</div>
                    <strong>{{ $elder->emergency_contact_phone ?? '-' }}</strong>
                </div>

            </div>
        </div>

    </div>


    {{-- Medical Notes --}}
    @if(!empty($elder->medical_notes))
        <div class="dashboard-card" style="margin-top: 24px;">
            <div class="dashboard-card-header">
                <div>
                    <h3>
                        <i class="fa-solid fa-notes-medical" style="color: #ec4899; margin-right: 6px;"></i>
                        Medical Notes
                    </h3>
                    <p>Important health information</p>
                </div>
            </div>

            <p style="color: #4b5563; line-height: 1.7; padding: 8px 0;">
                {{ $elder->medical_notes }}
            </p>
        </div>
    @endif


    {{-- Care Summary Grid --}}
    <div class="dashboard-grid" style="margin-top: 24px;">

        {{-- Care Plans --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>Care Plans</h3>
                    <p>{{ $carePlans->count() }} active plan(s)</p>
                </div>
                <a href="{{ route('healthcare.care-plans.index') }}" class="card-link">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @if($carePlans->count() > 0)
                <div class="overview-details">
                    @foreach($carePlans->take(3) as $plan)
                        <div class="overview-row">
                            <div class="overview-label">
                                <span class="status-dot active"></span>
                                {{ $plan->title }}
                            </div>
                            <strong>{{ ucfirst($plan->status) }}</strong>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-table">
                    <i class="fa-solid fa-notes-medical"></i>
                    <strong>No care plans</strong>
                </div>
            @endif
        </div>


        {{-- Medications --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>Medications</h3>
                    <p>{{ $medications->count() }} medication(s)</p>
                </div>
                <a href="{{ route('healthcare.medication.index') }}" class="card-link">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @if($medications->count() > 0)
                <div class="overview-details">
                    @foreach($medications->take(3) as $med)
                        <div class="overview-row">
                            <div class="overview-label">
                                <span class="status-dot medication"></span>
                                {{ $med->medication_name }}
                            </div>
                            <strong>{{ $med->dosage }} {{ $med->dosage_unit }}</strong>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-table">
                    <i class="fa-solid fa-pills"></i>
                    <strong>No medications</strong>
                </div>
            @endif
        </div>

    </div>


    {{-- Upcoming Appointments --}}
    @if($appointments->count() > 0)
        <div class="dashboard-card" style="margin-top: 24px;">
            <div class="dashboard-card-header">
                <div>
                    <h3>Appointments</h3>
                    <p>{{ $appointments->count() }} scheduled visit(s)</p>
                </div>
                <a href="{{ route('healthcare.appointments.index') }}" class="card-link">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="dashboard-table-wrapper">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Doctor</th>
                            <th>Hospital</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                            <tr>
                                <td><strong>{{ $appt->title }}</strong></td>
                                <td>{{ $appt->doctor_name ?? '-' }}</td>
                                <td>{{ $appt->hospital_name ?? '-' }}</td>
                                <td>
                                    {{ $appt->appointment_date }}
                                    @if(!empty($appt->appointment_time))
                                        · {{ $appt->appointment_time }}
                                    @endif
                                </td>
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