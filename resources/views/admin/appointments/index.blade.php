@extends('layouts.admin')

@section('title', 'Appointments')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    .appointment-page {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* =========================
       HEADER
    ========================= */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .page-title h1 {
        margin: 0;
        font-size: 25px;
        font-weight: 800;
        color: #111;
    }

    .page-title p {
        margin: 5px 0 0;
        color: #777;
        font-size: 13px;
    }

    .btn-primary {
        background: #f4c400;
        color: #111;
        padding: 9px 15px;
        border-radius: 7px;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        border: none;
        transition: .2s;
    }

    .btn-primary:hover {
        background: #dcae00;
        color: #111;
    }

    /* =========================
       STATISTICS
    ========================= */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }

    .stat-card {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        border-left: 4px solid #f4c400;
        min-height: 105px;
    }

    .stat-card .icon {
        width: 36px;
        height: 36px;
        background: #fff5c7;
        color: #111;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        font-size: 16px;
    }

    .stat-card h3 {
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        color: #111;
    }

    .stat-card p {
        margin: 3px 0 0;
        color: #777;
        font-size: 12px;
    }

    /* =========================
       FILTER
    ========================= */

    .filter-card {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        margin-bottom: 18px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 10px;
        align-items: end;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 700;
        font-size: 12px;
        color: #333;
    }

    .form-control {
        width: 100%;
        height: 38px;
        padding: 7px 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        outline: none;
        background: #fff;
        font-size: 13px;
    }

    .form-control:focus {
        border-color: #f4c400;
        box-shadow: 0 0 0 2px rgba(244,196,0,.12);
    }

    .btn-filter {
        height: 38px;
        background: #111;
        color: #fff;
        border: none;
        padding: 0 14px;
        border-radius: 6px;
        font-weight: 700;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-reset {
        height: 38px;
        background: #eee;
        color: #111;
        padding: 0 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        font-size: 12px;
        margin-left: 4px;
    }

    /* =========================
       TABLE
    ========================= */

    .table-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .table-header {
        min-height: 52px;
        padding: 12px 15px;
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

    .table-header span {
        color: #777;
        font-size: 12px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .appointments-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .appointments-table th {
        background: #111;
        color: #fff;
        padding: 10px 8px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .appointments-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #eee;
        font-size: 12px;
        vertical-align: middle;
        color: #333;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .appointments-table tr:hover {
        background: #fffdf2;
    }

    /* Column widths */

    .appointments-table th:nth-child(1),
    .appointments-table td:nth-child(1) {
        width: 4%;
        text-align: center;
    }

    .appointments-table th:nth-child(2),
    .appointments-table td:nth-child(2) {
        width: 15%;
    }

    .appointments-table th:nth-child(3),
    .appointments-table td:nth-child(3) {
        width: 18%;
    }

    .appointments-table th:nth-child(4),
    .appointments-table td:nth-child(4) {
        width: 10%;
    }

    .appointments-table th:nth-child(5),
    .appointments-table td:nth-child(5) {
        width: 14%;
    }

    .appointments-table th:nth-child(6),
    .appointments-table td:nth-child(6) {
        width: 17%;
    }

    .appointments-table th:nth-child(7),
    .appointments-table td:nth-child(7) {
        width: 10%;
    }

    .appointments-table th:nth-child(8),
    .appointments-table td:nth-child(8) {
        width: 12%;
    }

    .elder-name {
        font-weight: 700;
        color: #111;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .small-text {
        color: #777;
        font-size: 10px;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* =========================
       BADGES
    ========================= */

    .type-badge {
        display: inline-block;
        padding: 4px 7px;
        border-radius: 15px;
        background: #fff4bd;
        color: #725d00;
        font-size: 10px;
        font-weight: 700;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 7px;
        border-radius: 15px;
        font-size: 10px;
        font-weight: 700;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status-scheduled {
        background: #fff4bd;
        color: #765e00;
    }

    .status-confirmed {
        background: #dff5e5;
        color: #176b32;
    }

    .status-completed {
        background: #dcecff;
        color: #18558c;
    }

    .status-cancelled {
        background: #ffe0e0;
        color: #a12626;
    }

    .status-rescheduled {
        background: #eee1ff;
        color: #6938a0;
    }

    .status-missed {
        background: #ffdede;
        color: #9b1c1c;
    }

    /* =========================
       ACTION BUTTONS
    ========================= */

    .action-buttons {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .action-btn {
        width: 29px;
        height: 29px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 11px;
    }

    .view-btn {
        background: #e9f3ff;
        color: #1765a0;
    }

    .edit-btn {
        background: #fff4bd;
        color: #705900;
    }

    .delete-btn {
        background: #ffe4e4;
        color: #b32929;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    /* =========================
       EMPTY
    ========================= */

    .empty-state {
        text-align: center;
        padding: 45px 20px;
        color: #777;
    }

    .empty-state i {
        font-size: 38px;
        color: #ccc;
        margin-bottom: 10px;
    }

    .empty-state h3 {
        margin: 5px 0;
        color: #333;
        font-size: 17px;
    }

    .empty-state p {
        font-size: 13px;
        margin-bottom: 15px;
    }

    /* =========================
       PAGINATION
    ========================= */

    .pagination-wrapper {
        padding: 12px 15px;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media(max-width: 1200px) {

        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .filter-form {
            grid-template-columns: repeat(2, 1fr);
        }

        .table-card {
            overflow: hidden;
        }

        .appointments-table {
            min-width: 900px;
            table-layout: auto;
        }
    }

    @media(max-width: 700px) {

        .appointment-page {
            padding: 12px;
        }

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }

    @media(max-width: 450px) {

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="appointment-page">

    {{-- ================= HEADER ================= --}}
    <div class="page-header">

        <div class="page-title">

            <h1>
                <i class="fa-solid fa-calendar-check"></i>
                Appointments
            </h1>

            <p>
                Manage elder appointments and healthcare visits.
            </p>

        </div>

        @if(canAccess('admin.appointments.index', 'can_create'))
            <a
                href="{{ route('admin.appointments.create') }}"
                class="btn-primary"
            >
                <i class="fa-solid fa-plus"></i>
                Add Appointment
            </a>
        @endif

    </div>


    {{-- ================= STATISTICS ================= --}}
    <div class="stats-grid">

        <div class="stat-card">

            <div class="icon">
                <i class="fa-solid fa-calendar"></i>
            </div>

            <h3>{{ $totalAppointments ?? 0 }}</h3>
            <small>All appointments</small>

            <p>Total Appointments</p>

        </div>


        <div class="stat-card">

            <div class="icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <h3>{{ $scheduledAppointments ?? 0 }}</h3>
            <small>Upcoming visits</small>

            <p>Scheduled</p>

        </div>


        <div class="stat-card">

            <div class="icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <h3>{{ $confirmedAppointments ?? 0 }}</h3>
            <small>Confirmed visits</small>

            <p>Confirmed</p>

        </div>


        <div class="stat-card">

            <div class="icon">
                <i class="fa-solid fa-check-double"></i>
            </div>

            <h3>{{ $completedAppointments ?? 0 }}</h3>
            <small>Finished visits</small>

            <p>Completed</p>

        </div>


        <div class="stat-card">

            <div class="icon">
                <i class="fa-solid fa-ban"></i>
            </div>

            <h3>{{ $cancelledAppointments ?? 0 }}</h3>
            <small>Cancelled visits</small>

            <p>Cancelled</p>

        </div>

    </div>


    {{-- ================= FILTER ================= --}}
    <div class="filter-card">

        <form
            method="GET"
            action="{{ route('admin.appointments.index') }}"
            class="filter-form"
        >

            <div class="form-group">

                <label>Search</label>

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Elder, doctor, hospital..."
                    value="{{ request('search') }}"
                >

            </div>


            <div class="form-group">

                <label>Type</label>

                <select
                    name="appointment_type"
                    class="form-control"
                >

                    <option value="">All Types</option>

                    <option
                        value="doctor"
                        {{ request('appointment_type') == 'doctor' ? 'selected' : '' }}
                    >
                        Doctor
                    </option>

                    <option
                        value="healthcare"
                        {{ request('appointment_type') == 'healthcare' ? 'selected' : '' }}
                    >
                        Healthcare
                    </option>

                    <option
                        value="hospital"
                        {{ request('appointment_type') == 'hospital' ? 'selected' : '' }}
                    >
                        Hospital
                    </option>

                    <option
                        value="clinic"
                        {{ request('appointment_type') == 'clinic' ? 'selected' : '' }}
                    >
                        Clinic
                    </option>

                    <option
                        value="therapy"
                        {{ request('appointment_type') == 'therapy' ? 'selected' : '' }}
                    >
                        Therapy
                    </option>

                    <option
                        value="checkup"
                        {{ request('appointment_type') == 'checkup' ? 'selected' : '' }}
                    >
                        Checkup
                    </option>

                    <option
                        value="other"
                        {{ request('appointment_type') == 'other' ? 'selected' : '' }}
                    >
                        Other
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control"
                >

                    <option value="">All Status</option>

                    <option
                        value="scheduled"
                        {{ request('status') == 'scheduled' ? 'selected' : '' }}
                    >
                        Scheduled
                    </option>

                    <option
                        value="confirmed"
                        {{ request('status') == 'confirmed' ? 'selected' : '' }}
                    >
                        Confirmed
                    </option>

                    <option
                        value="completed"
                        {{ request('status') == 'completed' ? 'selected' : '' }}
                    >
                        Completed
                    </option>

                    <option
                        value="cancelled"
                        {{ request('status') == 'cancelled' ? 'selected' : '' }}
                    >
                        Cancelled
                    </option>

                    <option
                        value="rescheduled"
                        {{ request('status') == 'rescheduled' ? 'selected' : '' }}
                    >
                        Rescheduled
                    </option>

                    <option
                        value="missed"
                        {{ request('status') == 'missed' ? 'selected' : '' }}
                    >
                        Missed
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Date</label>

                <input
                    type="date"
                    name="appointment_date"
                    class="form-control"
                    value="{{ request('appointment_date') }}"
                >

            </div>


            <div>

                <button
                    type="submit"
                    class="btn-filter"
                >
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>

                <a
                    href="{{ route('admin.appointments.index') }}"
                    class="btn-reset"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="table-card">

        <div class="table-header">

            <h3>
                <i class="fa-solid fa-list"></i>
                Appointment List
            </h3>

            <span>
                {{ $appointments->total() ?? 0 }} records
            </span>

        </div>


        <div class="table-responsive">

            @if($appointments->count() > 0)

                <table class="appointments-table">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Elder</th>

                            <th>Appointment</th>

                            <th>Type</th>

                            <th>Date / Time</th>

                            <th>Doctor / Hospital</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($appointments as $appointment)

                            <tr>

                                {{-- Number --}}
                                <td>
                                    {{ $loop->iteration + (($appointments->currentPage() - 1) * $appointments->perPage()) }}
                                </td>


                                {{-- Elder --}}
                                <td>

                                    <div class="elder-name">

                                        {{ $appointment->elder->name ?? 'N/A' }}

                                    </div>

                                    @if($appointment->elder && $appointment->elder->elder_code)

                                        <div class="small-text">

                                            {{ $appointment->elder->elder_code }}

                                        </div>

                                    @endif

                                </td>


                                {{-- Appointment --}}
                                <td>

                                    <strong>
                                        {{ $appointment->title }}
                                    </strong>

                                    @if($appointment->location)

                                        <div class="small-text">

                                            <i class="fa-solid fa-location-dot"></i>

                                            {{ $appointment->location }}

                                        </div>

                                    @endif

                                </td>


                                {{-- Type --}}
                                <td>

                                    <span class="type-badge">

                                        {{ str_replace('_', ' ', $appointment->appointment_type) }}

                                    </span>

                                </td>


                                {{-- Date / Time --}}
                                <td>

                                    <strong>
                                        {{ optional($appointment->appointment_date)->format('d M Y') }}
                                    </strong>

                                    <div class="small-text">

                                        <i class="fa-regular fa-clock"></i>

                                        {{ $appointment->appointment_time
                                            ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')
                                            : '-' }}

                                    </div>

                                </td>


                                {{-- Doctor / Hospital --}}
                                <td>

                                    @if($appointment->doctor_name)

                                        <div>
                                            <i class="fa-solid fa-user-doctor"></i>
                                            {{ $appointment->doctor_name }}
                                        </div>

                                    @endif


                                    @if($appointment->hospital_name)

                                        <div class="small-text">

                                            <i class="fa-solid fa-hospital"></i>

                                            {{ $appointment->hospital_name }}

                                        </div>

                                    @endif


                                    @if(!$appointment->doctor_name && !$appointment->hospital_name)

                                        -

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    <span class="status-badge status-{{ $appointment->status }}">

                                        {{ str_replace('_', ' ', $appointment->status) }}

                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="action-buttons">

                                        @if(canAccess('admin.appointments.index', 'can_view'))
                                            <a
                                                href="{{ route('admin.appointments.show', $appointment->id) }}"
                                                class="action-btn view-btn"
                                                title="View"
                                            >
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endif


                                        @if(canAccess('admin.appointments.index', 'can_edit'))
                                            <a
                                                href="{{ route('admin.appointments.edit', $appointment->id) }}"
                                                class="action-btn edit-btn"
                                                title="Edit"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        @endif


                                        @if(canAccess('admin.appointments.index', 'can_delete'))
                                            <form
                                                action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this appointment?');"
                                            >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete-btn"
                                                title="Delete"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty-state">

                    <i class="fa-solid fa-calendar-xmark"></i>

                    <h3>No Appointments Found</h3>

                    <p>
                        There are no appointments matching your search.
                    </p>

                    @if(canAccess('admin.appointments.index', 'can_create'))
                        <a
                            href="{{ route('admin.appointments.create') }}"
                            class="btn-primary"
                        >
                            <i class="fa-solid fa-plus"></i>
                            Add Appointment
                        </a>
                    @endif

                </div>

            @endif

        </div>


        {{-- Pagination --}}
        @if($appointments->hasPages())

            <div class="pagination-wrapper">

                {{ $appointments->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection