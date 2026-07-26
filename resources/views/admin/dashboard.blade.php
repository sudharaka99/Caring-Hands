@extends('layouts.admin')

@section('title', 'Admin Dashboard | Caring Hands')

@section('content')

<div class="dashboard-page">

    <!-- Page Header -->
    <div class="dashboard-heading">

        <div>
            <p class="dashboard-welcome">
                Welcome back,
            </p>

            <h1>
                {{ auth()->user()->name ?? 'Administrator' }}
            </h1>

            <p class="dashboard-subtitle">
                Here's an overview of Caring Hands today.
            </p>
        </div>

        <div class="dashboard-date">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->format('F d, Y') }}
        </div>

    </div>


    <!-- ==========================================
         STAT CARDS
    =========================================== -->

    <div class="stats-cards">

        <div class="dashboard-stat-card">

            <div class="stat-card-icon pink">
                <i class="fa-solid fa-person-cane"></i>
            </div>

            <div class="stat-card-content">
                <span>Total Elders</span>

                <h2>
                    {{ $totalElders ?? 0 }}
                </h2>

                <p>
                    <i class="fa-solid fa-circle-check"></i>
                    Registered residents
                </p>
            </div>

        </div>


        <div class="dashboard-stat-card">

            <div class="stat-card-icon teal">
                <i class="fa-solid fa-user-nurse"></i>
            </div>

            <div class="stat-card-content">
                <span>Caregivers</span>

                <h2>
                    {{ $totalCaregivers ?? 0 }}
                </h2>

                <p>
                    <i class="fa-solid fa-users"></i>
                    Care team members
                </p>
            </div>

        </div>


        <div class="dashboard-stat-card">

            <div class="stat-card-icon purple">
                <i class="fa-solid fa-user-doctor"></i>
            </div>

            <div class="stat-card-content">
                <span>Healthcare Staff</span>

                <h2>
                    {{ $totalHealthcare ?? 0 }}
                </h2>

                <p>
                    <i class="fa-solid fa-stethoscope"></i>
                    Medical professionals
                </p>
            </div>

        </div>


        <div class="dashboard-stat-card">

            <div class="stat-card-icon orange">
                <i class="fa-solid fa-users-gear"></i>
            </div>

            <div class="stat-card-content">
                <span>Managers</span>

                <h2>
                    {{ $totalManagers ?? 0 }}
                </h2>

                <p>
                    <i class="fa-solid fa-user-check"></i>
                    Management staff
                </p>
            </div>

        </div>

    </div>


    <!-- ==========================================
         MAIN DASHBOARD GRID
    =========================================== -->

    <div class="dashboard-grid">

        <!-- Resident Overview -->
        <div class="dashboard-card resident-overview">

            <div class="dashboard-card-header">

                <div>
                    <h3>Resident Overview</h3>
                    <p>Current elder care summary</p>
                </div>

                <a href="#" class="card-link">
                    View All
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>


            <div class="overview-content">

                <div class="overview-circle">

                    <div class="overview-circle-inner">
                        <strong>{{ $totalElders ?? 0 }}</strong>
                        <span>Residents</span>
                    </div>

                </div>


                <div class="overview-details">

                    <div class="overview-row">

                        <div class="overview-label">
                            <span class="status-dot active"></span>
                            Active Residents
                        </div>

                        <strong>
                            {{ $activeElders ?? 0 }}
                        </strong>

                    </div>


                    <div class="overview-row">

                        <div class="overview-label">
                            <span class="status-dot care"></span>
                            Care Plans
                        </div>

                        <strong>
                            {{ $carePlans ?? 0 }}
                        </strong>

                    </div>


                    <div class="overview-row">

                        <div class="overview-label">
                            <span class="status-dot medication"></span>
                            On Medication
                        </div>

                        <strong>
                            {{ $medicationCount ?? 0 }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <!-- Quick Actions -->
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div>
                    <h3>Quick Actions</h3>
                    <p>Common management tasks</p>
                </div>

            </div>


            <div class="quick-actions">

                <a href="#" class="quick-action">

                    <div class="quick-action-icon pink">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>

                    <div>
                        <strong>Add Elder</strong>
                        <span>Register resident</span>
                    </div>

                    <i class="fa-solid fa-chevron-right action-arrow"></i>

                </a>


                <a href="#" class="quick-action">

                    <div class="quick-action-icon teal">
                        <i class="fa-solid fa-user-nurse"></i>
                    </div>

                    <div>
                        <strong>Add Caregiver</strong>
                        <span>Create staff account</span>
                    </div>

                    <i class="fa-solid fa-chevron-right action-arrow"></i>

                </a>


                <a href="#" class="quick-action">

                    <div class="quick-action-icon purple">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>

                    <div>
                        <strong>Care Plans</strong>
                        <span>Manage resident care</span>
                    </div>

                    <i class="fa-solid fa-chevron-right action-arrow"></i>

                </a>


                <a href="#" class="quick-action">

                    <div class="quick-action-icon orange">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>

                    <div>
                        <strong>Reports</strong>
                        <span>View system reports</span>
                    </div>

                    <i class="fa-solid fa-chevron-right action-arrow"></i>

                </a>

            </div>

        </div>

    </div>


    <!-- ==========================================
         RECENT + TASKS
    =========================================== -->

    <div class="dashboard-bottom-grid">

        <!-- Recent Residents -->
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div>
                    <h3>Recent Residents</h3>
                    <p>Recently registered elders</p>
                </div>

                <a href="#" class="card-link">
                    View All
                </a>

            </div>


            <div class="dashboard-table-wrapper">

                <table class="dashboard-table">

                    <thead>
                        <tr>
                            <th>Resident</th>
                            <th>Age</th>
                            <th>Caregiver</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentElders ?? [] as $elder)

                            <tr>

                                <td>

                                    <div class="resident-user">

                                        <div class="resident-avatar">

                                            @if(!empty($elder->image))

                                                <img
                                                    src="{{ asset('storage/' . $elder->image) }}"
                                                    alt="{{ $elder->name }}">

                                            @else

                                                {{ strtoupper(substr($elder->name, 0, 1)) }}

                                            @endif

                                        </div>

                                        <div>
                                            <strong>
                                                {{ $elder->name }}
                                            </strong>

                                            <span>
                                                ID #{{ $elder->id }}
                                            </span>
                                        </div>

                                    </div>

                                </td>


                                <td>
                                    {{ $elder->age ?? '-' }}
                                </td>


                                <td>
                                    {{ $elder->caregiver_name ?? 'Not Assigned' }}
                                </td>


                                <td>
                                    <span class="table-status active">
                                        Active
                                    </span>
                                </td>


                                <td>
                                    <a href="#" class="table-action">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5">

                                    <div class="empty-table">

                                        <i class="fa-solid fa-person-cane"></i>

                                        <strong>No residents yet</strong>

                                        <span>
                                            Registered residents will appear here.
                                        </span>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        <!-- Today's Tasks -->
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div>
                    <h3>Today's Care</h3>
                    <p>Important activities for today</p>
                </div>

                <button class="dashboard-more-btn">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>

            </div>


            <div class="care-tasks">

                <div class="care-task">

                    <div class="task-time">
                        08:00
                        <span>AM</span>
                    </div>

                    <div class="task-line"></div>

                    <div class="task-content">
                        <strong>Morning Medication</strong>
                        <span>Medication schedule</span>
                    </div>

                    <div class="task-icon pink">
                        <i class="fa-solid fa-pills"></i>
                    </div>

                </div>


                <div class="care-task">

                    <div class="task-time">
                        10:30
                        <span>AM</span>
                    </div>

                    <div class="task-line"></div>

                    <div class="task-content">
                        <strong>Health Checkups</strong>
                        <span>Routine resident check</span>
                    </div>

                    <div class="task-icon teal">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>

                </div>


                <div class="care-task">

                    <div class="task-time">
                        02:00
                        <span>PM</span>
                    </div>

                    <div class="task-line"></div>

                    <div class="task-content">
                        <strong>Care Activities</strong>
                        <span>Resident activities</span>
                    </div>

                    <div class="task-icon purple">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                </div>


                <div class="care-task">

                    <div class="task-time">
                        06:00
                        <span>PM</span>
                    </div>

                    <div class="task-line"></div>

                    <div class="task-content">
                        <strong>Evening Medication</strong>
                        <span>Medication schedule</span>
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