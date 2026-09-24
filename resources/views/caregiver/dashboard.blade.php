@extends('layouts.admin')

@section('title', 'Caregiver Dashboard | Caring Hands')

@section('content')

<div class="dashboard-page">

    <!-- Page Header -->
    <div class="dashboard-heading">
        <div>
            <p class="dashboard-welcome">Good day,</p>
            <h1>{{ auth()->user()->name }}</h1>
            <p class="dashboard-subtitle">
                Here are your tasks and residents for today.
            </p>
        </div>

        <div class="dashboard-date">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->format('F d, Y') }}
        </div>
    </div>


    <!-- ==========================================
         TODAY'S SHIFT BANNER
    =========================================== -->

    @if($todayShift)
        <div class="shift-banner">
            <div class="shift-banner-icon">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="shift-banner-content">
                <strong>{{ $todayShift->shift_name }}</strong>
                <span>
                    {{ \Carbon\Carbon::parse($todayShift->start_time)->format('g:i A') }}
                    –
                    {{ \Carbon\Carbon::parse($todayShift->end_time)->format('g:i A') }}
                </span>
            </div>
            <span class="shift-banner-status active">
                {{ ucfirst($todayShift->status) }}
            </span>
        </div>
    @endif


    <!-- ==========================================
         STAT CARDS — Scoped To Caregiver
    =========================================== -->

    <div class="stats-cards">

        <div class="dashboard-stat-card">
            <div class="stat-card-icon pink">
                <i class="fa-solid fa-person-cane"></i>
            </div>
            <div class="stat-card-content">
                <span>My Residents</span>
                <h2>{{ $totalAssigned }}</h2>
                <p>
                    <i class="fa-solid fa-circle-check"></i>
                    Assigned to me
                </p>
            </div>
        </div>


        <div class="dashboard-stat-card">
            <div class="stat-card-icon teal">
                <i class="fa-solid fa-pills"></i>
            </div>
            <div class="stat-card-content">
                <span>Today's Medications</span>
                <h2>{{ $todayMedications }}</h2>
                <p>
                    <i class="fa-solid fa-clock"></i>
                    Pending doses
                </p>
            </div>
        </div>


        <div class="dashboard-stat-card">
            <div class="stat-card-icon purple">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-card-content">
                <span>Today's Appointments</span>
                <h2>{{ $todayAppointments }}</h2>
                <p>
                    <i class="fa-solid fa-stethoscope"></i>
                    Scheduled visits
                </p>
            </div>
        </div>


        <div class="dashboard-stat-card">
            <div class="stat-card-icon orange">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
            <div class="stat-card-content">
                <span>Active Care Plans</span>
                <h2>{{ $activeCarePlans }}</h2>
                <p>
                    <i class="fa-solid fa-clipboard-check"></i>
                    In progress
                </p>
            </div>
        </div>

    </div>


    <!-- ==========================================
         MY RESIDENTS + QUICK ACTIONS
    =========================================== -->

    <div class="dashboard-grid">

        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>My Residents</h3>
                    <p>Elders assigned to you</p>
                </div>
                <a href="{{ route('caregiver.elders.index') }}" class="card-link">
                    View All <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="dashboard-table-wrapper">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Resident</th>
                            <th>Room</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentElders as $elder)
                            <tr>
                                <td>
                                    <div class="resident-user">
                                        <div class="resident-avatar">
                                            @if($elder->photo)
                                                <img src="{{ asset('storage/' . $elder->photo) }}"
                                                     alt="{{ $elder->name }}">
                                            @else
                                                {{ strtoupper(substr($elder->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ $elder->name }}</strong>
                                            <span>{{ $elder->elder_code }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $elder->room }}</td>
                                <td>{{ $elder->age }}</td>
                                <td>
                                    <span class="table-status active">Active</span>
                                </td>
                                <td>
                                    <a href="{{ route('caregiver.elders.show', $elder->id) }}"
                                       class="table-action">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-table">
                                        <i class="fa-solid fa-person-cane"></i>
                                        <strong>No residents assigned</strong>
                                        <span>Contact your manager to get assigned.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>Quick Actions</h3>
                    <p>Daily tasks</p>
                </div>
            </div>

            <div class="quick-actions">
                <a href="{{ route('caregiver.medication.index') }}" class="quick-action">
                    <div class="quick-action-icon pink">
                        <i class="fa-solid fa-pills"></i>
                    </div>
                    <div>
                        <strong>Log Medication</strong>
                        <span>Record doses given</span>
                    </div>
                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

                <a href="{{ route('caregiver.care-plans.index') }}" class="quick-action">
                    <div class="quick-action-icon teal">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>
                    <div>
                        <strong>Update Care Plan</strong>
                        <span>Mark tasks done</span>
                    </div>
                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

                <a href="{{ route('caregiver.appointments.index') }}" class="quick-action">
                    <div class="quick-action-icon purple">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <strong>Appointments</strong>
                        <span>Today's schedule</span>
                    </div>
                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>

                <a href="{{ route('caregiver.messages.index') }}" class="quick-action">
                    <div class="quick-action-icon orange">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div>
                        <strong>Messages</strong>
                        <span>Team communication</span>
                    </div>
                    <i class="fa-solid fa-chevron-right action-arrow"></i>
                </a>
            </div>
        </div>

    </div>


    <!-- ==========================================
         TODAY'S TASKS
    =========================================== -->

    <div class="dashboard-bottom-grid">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>Today's Care Tasks</h3>
                    <p>Your schedule for today</p>
                </div>
            </div>

            <div class="care-tasks">
                <div class="care-task">
                    <div class="task-time">08:00<span>AM</span></div>
                    <div class="task-line"></div>
                    <div class="task-content">
                        <strong>Morning Medication</strong>
                        <span>Check all residents</span>
                    </div>
                    <div class="task-icon pink">
                        <i class="fa-solid fa-pills"></i>
                    </div>
                </div>
                <div class="care-task">
                    <div class="task-time">10:30<span>AM</span></div>
                    <div class="task-line"></div>
                    <div class="task-content">
                        <strong>Health Checkups</strong>
                        <span>Vitals & wellness</span>
                    </div>
                    <div class="task-icon teal">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                </div>
                <div class="care-task">
                    <div class="task-time">02:00<span>PM</span></div>
                    <div class="task-line"></div>
                    <div class="task-content">
                        <strong>Care Activities</strong>
                        <span>Daily routines</span>
                    </div>
                    <div class="task-icon purple">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                </div>
                <div class="care-task">
                    <div class="task-time">06:00<span>PM</span></div>
                    <div class="task-line"></div>
                    <div class="task-content">
                        <strong>Evening Medication</strong>
                        <span>Record doses</span>
                    </div>
                    <div class="task-icon orange">
                        <i class="fa-solid fa-capsules"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection