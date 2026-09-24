@extends('layouts.admin')

@section('title', $title . ' | Caring Hands')

@section('content')

<div class="dashboard-page">

    <!-- ==========================================
         PAGE HEADER
    =========================================== -->
    <div class="dashboard-heading">
        <div>
            <p class="dashboard-welcome">
                {{ $type === 'elder' ? 'Resident Details' : 'Care Plan' }}
            </p>
            <h1>{{ $title }}</h1>
            <p class="dashboard-subtitle">
                {{ $item->name ?? $item->title ?? 'Details' }}
            </p>
        </div>

        <a href="{{ url()->previous() }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>
    </div>


    @if($type === 'elder')

        <!-- ==========================================
             ELDER DETAIL VIEW
        =========================================== -->
        <div class="dashboard-grid">

            <!-- Personal Info -->
            <div class="dashboard-card">

                <div class="dashboard-card-header">
                    <div>
                        <h3>Personal Information</h3>
                        <p>Basic resident details</p>
                    </div>
                </div>

                <div class="resident-user" style="margin-bottom: 24px;">
                    <div class="resident-avatar" style="width: 80px; height: 80px; font-size: 32px;">
                        @if(!empty($item->photo))
                            <img src="{{ asset('storage/' . $item->photo) }}"
                                 alt="{{ $item->name }}">
                        @else
                            {{ strtoupper(substr($item->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <strong style="font-size: 18px;">{{ $item->name }}</strong>
                        <span>{{ $item->elder_code ?? 'Resident' }}</span>
                    </div>
                </div>

                <div class="overview-details">

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-door-open" style="margin-right: 6px; color: #ec4899;"></i>
                            Room
                        </div>
                        <strong>{{ $item->room ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-cake-candles" style="margin-right: 6px; color: #ec4899;"></i>
                            Age
                        </div>
                        <strong>{{ $item->age ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-droplet" style="margin-right: 6px; color: #ec4899;"></i>
                            Blood Group
                        </div>
                        <strong>{{ $item->blood_group ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-venus-mars" style="margin-right: 6px; color: #ec4899;"></i>
                            Gender
                        </div>
                        <strong>{{ ucfirst($item->gender ?? '-') }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-phone" style="margin-right: 6px; color: #ec4899;"></i>
                            Phone
                        </div>
                        <strong>{{ $item->phone ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-circle-check" style="margin-right: 6px; color: #10b981;"></i>
                            Status
                        </div>
                        <span class="table-status active">
                            {{ ucfirst($item->status ?? 'active') }}
                        </span>
                    </div>

                </div>

            </div>


            <!-- Emergency Contact -->
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
                        <strong>{{ $item->emergency_contact_name ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">Relationship</div>
                        <strong>{{ $item->emergency_contact_relationship ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">Phone</div>
                        <strong>{{ $item->emergency_contact_phone ?? '-' }}</strong>
                    </div>

                </div>

            </div>

        </div>


        <!-- Medical Notes -->
        @if(!empty($item->medical_notes))
            <div class="dashboard-card" style="margin-top: 24px;">

                <div class="dashboard-card-header">
                    <div>
                        <h3>Medical Notes</h3>
                        <p>Important health information</p>
                    </div>
                </div>

                <div style="padding: 8px 0; color: #4b5563; line-height: 1.7;">
                    {{ $item->medical_notes }}
                </div>

            </div>
        @endif


        <!-- Care Summary -->
        <div class="dashboard-grid" style="margin-top: 24px;">

            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <h3>Care Plans</h3>
                        <p>Treatment plans for this resident</p>
                    </div>
                    <a href="{{ route('caregiver.care-plans.index') }}" class="card-link">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                @if(!empty($carePlans) && $carePlans->count() > 0)
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
                        <span>No plans assigned yet</span>
                    </div>
                @endif
            </div>


            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <h3>Medications</h3>
                        <p>Active medication schedule</p>
                    </div>
                    <a href="{{ route('caregiver.medications.index') }}" class="card-link">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                @if(!empty($medications) && $medications->count() > 0)
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
                        <span>No active medications</span>
                    </div>
                @endif
            </div>

        </div>


        <!-- Upcoming Appointments -->
        @if(!empty($appointments) && $appointments->count() > 0)
            <div class="dashboard-card" style="margin-top: 24px;">

                <div class="dashboard-card-header">
                    <div>
                        <h3>Upcoming Appointments</h3>
                        <p>Scheduled visits</p>
                    </div>
                    <a href="{{ route('caregiver.appointments.index') }}" class="card-link">
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
                                    <td>{{ $appt->appointment_date }} · {{ $appt->appointment_time }}</td>
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


    @else

        <!-- ==========================================
             CARE PLAN DETAIL VIEW
        =========================================== -->
        <div class="dashboard-grid">

            <!-- Care Plan Info -->
            <div class="dashboard-card">

                <div class="dashboard-card-header">
                    <div>
                        <h3>{{ $item->title ?? 'Care Plan' }}</h3>
                        <p>Care plan details</p>
                    </div>
                    <span class="table-status {{ $item->priority === 'critical' ? 'danger' : ($item->priority === 'high' ? 'warning' : 'active') }}">
                        {{ ucfirst($item->priority ?? 'medium') }} Priority
                    </span>
                </div>

                <div class="overview-details">

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-person-cane" style="margin-right: 6px; color: #ec4899;"></i>
                            Resident
                        </div>
                        <strong>{{ $item->elder->name ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-user-nurse" style="margin-right: 6px; color: #ec4899;"></i>
                            Caregiver
                        </div>
                        <strong>{{ $item->caregiver->user->name ?? 'Unassigned' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-calendar" style="margin-right: 6px; color: #ec4899;"></i>
                            Start Date
                        </div>
                        <strong>{{ $item->start_date ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-calendar-check" style="margin-right: 6px; color: #ec4899;"></i>
                            Review Date
                        </div>
                        <strong>{{ $item->review_date ?? '-' }}</strong>
                    </div>

                    <div class="overview-row">
                        <div class="overview-label">
                            <i class="fa-solid fa-flag" style="margin-right: 6px; color: #ec4899;"></i>
                            Status
                        </div>
                        <span class="table-status active">
                            {{ ucfirst($item->status ?? 'draft') }}
                        </span>
                    </div>

                </div>

            </div>


            <!-- Description Cards -->
            <div class="dashboard-card">

                <div class="dashboard-card-header">
                    <div>
                        <h3>Care Summary</h3>
                        <p>Needs, goals & activities</p>
                    </div>
                </div>

                <div class="overview-details">

                    @if(!empty($item->care_needs))
                        <div class="overview-row" style="flex-direction: column; align-items: flex-start; gap: 6px;">
                            <div class="overview-label">
                                <i class="fa-solid fa-heart-pulse" style="margin-right: 6px; color: #ec4899;"></i>
                                Care Needs
                            </div>
                            <p style="color: #4b5563; line-height: 1.6; margin: 0;">
                                {{ $item->care_needs }}
                            </p>
                        </div>
                    @endif

                    @if(!empty($item->goals))
                        <div class="overview-row" style="flex-direction: column; align-items: flex-start; gap: 6px; margin-top: 16px;">
                            <div class="overview-label">
                                <i class="fa-solid fa-bullseye" style="margin-right: 6px; color: #ec4899;"></i>
                                Goals
                            </div>
                            <p style="color: #4b5563; line-height: 1.6; margin: 0;">
                                {{ $item->goals }}
                            </p>
                        </div>
                    @endif

                    @if(!empty($item->activities))
                        <div class="overview-row" style="flex-direction: column; align-items: flex-start; gap: 6px; margin-top: 16px;">
                            <div class="overview-label">
                                <i class="fa-solid fa-list-check" style="margin-right: 6px; color: #ec4899;"></i>
                                Activities
                            </div>
                            <p style="color: #4b5563; line-height: 1.6; margin: 0;">
                                {{ $item->activities }}
                            </p>
                        </div>
                    @endif

                </div>

            </div>

        </div>


        <!-- ==========================================
             UPDATE FORM
        =========================================== -->
        <div class="dashboard-card" style="margin-top: 24px;">

            <div class="dashboard-card-header">
                <div>
                    <h3>Update Care Plan</h3>
                    <p>Mark progress and add notes</p>
                </div>
            </div>

            <form method="POST"
                  action="{{ route('caregiver.care-plans.update', $item->id) }}"
                  class="admin-form">

                @csrf
                @method('PUT')

                <div class="form-row">

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required>
                            @foreach(['draft' => 'Draft', 'active' => 'Active', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                                <option value="{{ $value }}" @selected($item->status === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Progress Notes</label>
                        <textarea name="notes"
                                  rows="4"
                                  placeholder="Add notes about today's progress, observations, or anything important..."
                                  style="width: 100%; resize: vertical;">{{ $item->notes }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ url()->previous() }}" class="btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-check"></i>
                        Update Care Plan
                    </button>
                </div>

            </form>

        </div>

    @endif

</div>

@endsection