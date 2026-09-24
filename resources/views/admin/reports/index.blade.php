@extends('layouts.admin')

@section('content')

<style>
    .report-page {
        width: 100%;
        max-width: 1450px;
        margin: 0 auto;
        padding: 20px;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
        gap: 15px;
        flex-wrap: wrap;
    }

    .report-title h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #111;
    }

    .report-title p {
        margin: 5px 0 0;
        color: #777;
        font-size: 14px;
    }

    .print-btn {
        background: #111;
        color: #fff;
        border: 0;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .print-btn:hover {
        background: #333;
        color: #fff;
    }

    /* SUMMARY */

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 3px 12px rgba(0,0,0,.05);
    }

    .summary-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #f4c400;
        color: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .summary-card h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
        color: #111;
    }

    .summary-card span {
        color: #777;
        font-size: 12px;
    }

    /* REPORT LINKS */

    .section-title {
        font-size: 18px;
        font-weight: 800;
        margin: 25px 0 14px;
        color: #111;
    }

    .report-links {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .report-link {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 20px;
        text-decoration: none;
        color: #111;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: .2s;
    }

    .report-link:hover {
        transform: translateY(-3px);
        border-color: #f4c400;
        box-shadow: 0 6px 18px rgba(0,0,0,.08);
        color: #111;
    }

    .report-link-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: #111;
        color: #f4c400;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .report-link h3 {
        margin: 0 0 5px;
        font-size: 15px;
        font-weight: 800;
    }

    .report-link p {
        margin: 0;
        color: #777;
        font-size: 12px;
    }

    /* STAT BOX */

    .stat-section {
        margin-top: 25px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .stat-box {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #eee;
        padding: 16px;
        text-align: center;
    }

    .stat-box strong {
        display: block;
        font-size: 23px;
        font-weight: 800;
        color: #111;
    }

    .stat-box span {
        font-size: 12px;
        color: #777;
    }

    .yellow {
        border-top: 4px solid #f4c400;
    }

    .black {
        border-top: 4px solid #111;
    }

    /* TABLE */

    .table-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        margin-top: 25px;
        overflow: hidden;
    }

    .table-header {
        padding: 15px 18px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
    }

    .view-btn {
        color: #111;
        background: #f4c400;
        padding: 7px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    th {
        background: #111;
        color: #fff;
        padding: 11px 14px;
        text-align: left;
        font-size: 12px;
    }

    td {
        padding: 11px 14px;
        border-bottom: 1px solid #eee;
        font-size: 12px;
    }

    tr:last-child td {
        border-bottom: 0;
    }

    .badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        background: #f4c400;
        color: #111;
        font-size: 10px;
        font-weight: 800;
    }

    @media(max-width:1100px) {
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .report-links {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width:650px) {
        .report-page {
            padding: 12px;
        }

        .summary-grid,
        .report-links,
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .report-title h1 {
            font-size: 23px;
        }
    }

    @media print {
        .print-btn,
        .report-links,
        .sidebar,
        .navbar {
            display: none !important;
        }

        .report-page {
            max-width: 100%;
            padding: 0;
        }

        .table-card {
            box-shadow: none;
        }
    }
</style>

<div class="report-page">

    <div class="report-header">

        <div class="report-title">
            <h1>
                <i class="fa-solid fa-chart-column"></i>
                Reports
            </h1>

            <p>
                Caring Hands management and operational reports
            </p>
        </div>

        <button onclick="window.print()" class="print-btn">
            <i class="fa-solid fa-print"></i>
            Print Report
        </button>

    </div>


    {{-- SUMMARY CARDS --}}

    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-icon">
                <i class="fa-solid fa-person-cane"></i>
            </div>

            <div>
                <h3>{{ $totalElders }}</h3>
                <span>Total Elders</span>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">
                <i class="fa-solid fa-user-nurse"></i>
            </div>

            <div>
                <h3>{{ $totalCaregivers }}</h3>
                <span>Caregivers</span>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">
                <i class="fa-solid fa-user-doctor"></i>
            </div>

            <div>
                <h3>{{ $totalHealthcare }}</h3>
                <span>Healthcare Staff</span>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">
                <i class="fa-solid fa-user-tie"></i>
            </div>

            <div>
                <h3>{{ $totalManagers }}</h3>
                <span>Managers</span>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <div>
                <h3>{{ $totalAppointments }}</h3>
                <span>Appointments</span>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">
                <i class="fa-solid fa-pills"></i>
            </div>

            <div>
                <h3>{{ $totalMedications }}</h3>
                <span>Medications</span>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">
                <i class="fa-solid fa-notes-medical"></i>
            </div>

            <div>
                <h3>{{ $totalCarePlans }}</h3>
                <span>Care Plans</span>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div>
                <h3>{{ $attendancePresent }}</h3>
                <span>Present Attendance</span>
            </div>
        </div>

    </div>


    {{-- REPORT TYPES --}}

    <div class="section-title">
        Detailed Reports
    </div>

    <div class="report-links">

        <a href="{{ route('admin.reports.elders') }}" class="report-link">

            <div class="report-link-icon">
                <i class="fa-solid fa-person-cane"></i>
            </div>

            <div>
                <h3>Elder Report</h3>
                <p>View elder registration and admission information.</p>
            </div>

        </a>


        <a href="{{ route('admin.reports.staff') }}" class="report-link">

            <div class="report-link-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>
                <h3>Staff Report</h3>
                <p>View caregivers, healthcare staff and managers.</p>
            </div>

        </a>


        <a href="{{ route('admin.reports.attendance') }}" class="report-link">

            <div class="report-link-icon">
                <i class="fa-solid fa-fingerprint"></i>
            </div>

            <div>
                <h3>Attendance Report</h3>
                <p>Review staff attendance and working hours.</p>
            </div>

        </a>


        <a href="{{ route('admin.reports.care-plans') }}" class="report-link">

            <div class="report-link-icon">
                <i class="fa-solid fa-notes-medical"></i>
            </div>

            <div>
                <h3>Care Plan Report</h3>
                <p>Review care plans, priorities and statuses.</p>
            </div>

        </a>


        <a href="{{ route('admin.reports.medication') }}" class="report-link">

            <div class="report-link-icon">
                <i class="fa-solid fa-pills"></i>
            </div>

            <div>
                <h3>Medication Report</h3>
                <p>Review medication and administration records.</p>
            </div>

        </a>


        <a href="{{ route('admin.reports.appointments') }}" class="report-link">

            <div class="report-link-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <div>
                <h3>Appointment Report</h3>
                <p>Review healthcare appointments and statuses.</p>
            </div>

        </a>

    </div>


    {{-- ATTENDANCE --}}

    <div class="stat-section">

        <div class="section-title">
            Attendance Summary
        </div>

        <div class="stat-grid">

            <div class="stat-box yellow">
                <strong>{{ $attendancePresent }}</strong>
                <span>Present</span>
            </div>

            <div class="stat-box yellow">
                <strong>{{ $attendanceLate }}</strong>
                <span>Late</span>
            </div>

            <div class="stat-box black">
                <strong>{{ $attendanceAbsent }}</strong>
                <span>Absent</span>
            </div>

            <div class="stat-box black">
                <strong>{{ $attendanceLeave }}</strong>
                <span>Leave</span>
            </div>

        </div>

    </div>


    {{-- APPOINTMENTS --}}

    <div class="stat-section">

        <div class="section-title">
            Appointment Summary
        </div>

        <div class="stat-grid">

            <div class="stat-box yellow">
                <strong>{{ $scheduledAppointments }}</strong>
                <span>Scheduled</span>
            </div>

            <div class="stat-box yellow">
                <strong>{{ $confirmedAppointments }}</strong>
                <span>Confirmed</span>
            </div>

            <div class="stat-box black">
                <strong>{{ $completedAppointments }}</strong>
                <span>Completed</span>
            </div>

            <div class="stat-box black">
                <strong>{{ $cancelledAppointments }}</strong>
                <span>Cancelled</span>
            </div>

        </div>

    </div>


    {{-- RECENT APPOINTMENTS --}}

    <div class="table-card">

        <div class="table-header">

            <h3>
                Recent Appointments
            </h3>

            <a href="{{ route('admin.reports.appointments') }}"
               class="view-btn">
                View All
            </a>

        </div>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>Elder</th>
                        <th>Appointment</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($recentAppointments as $appointment)

                        <tr>

                            <td>
                                {{ $appointment->elder->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $appointment->title }}
                            </td>

                            <td>
                                {{ optional($appointment->appointment_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ $appointment->appointment_time
                                    ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')
                                    : '-' }}
                            </td>

                            <td>
                                <span class="badge">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" style="text-align:center;">
                                No appointments found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- RECENT ELDERS --}}

    <div class="table-card">

        <div class="table-header">

            <h3>
                Recently Added Elders
            </h3>

            <a href="{{ route('admin.reports.elders') }}"
               class="view-btn">
                View All
            </a>

        </div>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Admission Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($recentElders as $elder)

                        <tr>

                            <td>
                                {{ $elder->elder_code ?? '-' }}
                            </td>

                            <td>
                                {{ $elder->name }}
                            </td>

                            <td>
                                {{ ucfirst($elder->gender ?? '-') }}
                            </td>

                            <td>
                                {{ $elder->admission_date
                                    ? \Carbon\Carbon::parse($elder->admission_date)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>
                                <span class="badge">
                                    {{ ucfirst($elder->status ?? '-') }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" style="text-align:center;">
                                No elders found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection