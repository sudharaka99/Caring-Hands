@extends('layouts.admin')

@section('title', 'Healthcare Dashboard | Caring Hands')

@section('content')

<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <p class="dashboard-welcome">Welcome back,</p>
            <h1>{{ auth()->user()->name ?? 'Healthcare Staff' }}</h1>
            <p class="dashboard-subtitle">
                Here's your medical overview for today.
            </p>
        </div>
        <div class="dashboard-date">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->format('F d, Y') }}
        </div>
    </div>


    {{-- Today's Shift --}}
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


    {{-- Stat Cards --}}
    <div class="stats-cards">

        <div class="dashboard-stat-card">
            <div class="stat-card-icon pink">
                <i class="fa-solid fa-person-cane"></i>
            </div>
            <div class="stat-card-content">
                <span>Active Residents</span>
                <h2>{{ $totalElders }}</h2>
                <p><i class="fa-solid fa-circle-check"></i> Under care</p>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <div class="stat-card-icon teal">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
            <div class="stat-card-content">
                <span>Care Plans</span>
                <h2>{{ $activeCarePlans }}</h2>
                <p><i class="fa-solid fa-clipboard-check"></i> Active plans</p>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <div class="stat-card-icon purple">
                <i class="fa-solid fa-pills"></i>
            </div>
            <div class="stat-card-content">
                <span>Medications</span>
                <h2>{{ $activeMedications }}</h2>
                <p><i class="fa-solid fa-capsules"></i> Active meds</p>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <div class="stat-card-icon orange">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-card-content">
                <span>Today's Appointments</span>
                <h2>{{ $todayAppointments }}</h2>
                <p><i class="fa-solid fa-stethoscope"></i> Scheduled today</p>
            </div>
        </div>

    </div>


    {{-- Recent + Appointments --}}
    <div class="dashboard-grid">

        {{-- Recent Residents --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>Recent Residents</h3>
                    <p>Recently admitted elders</p>
                </div>
                <a href="{{ route('healthcare.elders.index') }}" class="card-link">
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentElders as $elder)
                            <tr>
                                <td>
                                    <div class="resident-user">
                                        <div class="resident-avatar">
                                            {{ strtoupper(substr($elder->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $elder->name }}</strong>
                                            <span>{{ $elder->elder_code }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $elder->room }}</td>
                                <td>{{ $elder->age }}</td>
                                <td><span class="table-status active">{{ ucfirst($elder->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-table">
                                        <strong>No residents yet</strong>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        {{-- Upcoming Appointments --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>Upcoming Appointments</h3>
                    <p>Next scheduled visits</p>
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
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingAppointments as $appt)
                            <tr>
                                <td><strong>{{ $appt->title }}</strong></td>
                                <td>{{ $appt->appointment_date }} · {{ $appt->appointment_time }}</td>
                                <td><span class="table-status active">{{ ucfirst($appt->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-table">
                                        <strong>No upcoming appointments</strong>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@endsection