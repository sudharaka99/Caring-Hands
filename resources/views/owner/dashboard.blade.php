@extends('layouts.admin')

@section('title', 'Owner Dashboard | Caring Hands')

@section('content')
<div class="dashboard-page">

    {{-- Page Header --}}
    <div class="dashboard-heading">
        <div>
            <p class="dashboard-welcome">Welcome back,</p>
            <h1>{{ auth()->user()->name }}</h1>
            <p class="dashboard-subtitle">
                Your loved one's care overview
            </p>
        </div>
        <div class="dashboard-date">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->format('F d, Y') }}
        </div>
    </div>


    {{-- Stat Cards --}}
    <div class="stats-cards">

        <div class="dashboard-stat-card">
            <div class="stat-card-icon pink">
                <i class="fa-solid fa-person-cane"></i>
            </div>
            <div class="stat-card-content">
                <span>My Residents</span>
                <h2>{{ $totalElders }}</h2>
                <p><i class="fa-solid fa-circle-check"></i> Linked to me</p>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <div class="stat-card-icon teal">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
            <div class="stat-card-content">
                <span>Active Care Plans</span>
                <h2>{{ $activeCarePlans }}</h2>
                <p><i class="fa-solid fa-clipboard-check"></i> In progress</p>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <div class="stat-card-icon purple">
                <i class="fa-solid fa-pills"></i>
            </div>
            <div class="stat-card-content">
                <span>Medications</span>
                <h2>{{ $activeMedications }}</h2>
                <p><i class="fa-solid fa-capsules"></i> Active</p>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <div class="stat-card-icon orange">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-card-content">
                <span>Upcoming Appointments</span>
                <h2>{{ $upcomingAppointments }}</h2>
                <p><i class="fa-solid fa-stethoscope"></i> Scheduled</p>
            </div>
        </div>

    </div>


    {{-- Grid: My Residents + Upcoming Appointments --}}
    <div class="dashboard-grid">

        {{-- My Residents --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h3>My Residents</h3>
                    <p>Elders linked to your account</p>
                </div>
                <a href="{{ route('owner.elders.index') }}" class="card-link">
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
                        @forelse($elders as $elder)
                            <tr>
                                <td>
                                    <div class="resident-user">
                                        <div class="resident-avatar">
                                            @if($elder->photo)
                                                <img src="{{ asset('storage/' . $elder->photo) }}" alt="{{ $elder->name }}">
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
                                <td><span class="table-status active">{{ ucfirst($elder->status) }}</span></td>
                                <td>
                                    <a href="{{ route('owner.elders.show', $elder->id) }}" class="table-action">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-table">
                                        <i class="fa-solid fa-person-cane"></i>
                                        <strong>No residents linked</strong>
                                        <span>Contact admin to link your elder.</span>
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
                    <h3>Recent Appointments</h3>
                    <p>Latest scheduled visits</p>
                </div>
                <a href="{{ route('owner.appointments.index') }}" class="card-link">
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
                        @forelse($recentAppointments as $appt)
                            <tr>
                                <td><strong>{{ $appt->title }}</strong></td>
                                <td>{{ $appt->appointment_date }}</td>
                                <td><span class="table-status active">{{ ucfirst($appt->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-table">
                                        <i class="fa-solid fa-calendar-check"></i>
                                        <strong>No appointments</strong>
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