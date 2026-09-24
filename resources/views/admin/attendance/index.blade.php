@extends('layouts.admin')

@section('title', 'Attendance Management')

@section('content')

<style>
    .attendance-page {
        padding: 25px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 28px;
        color: #222;
    }

    .page-header p {
        margin: 6px 0 0;
        color: #777;
    }

    .btn-add {
        background: #f4c430;
        color: #222;
        padding: 11px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-add:hover {
        background: #dcae16;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 9px;
        background: #fff3c4;
        color: #b48a00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-info h3 {
        margin: 0;
        font-size: 22px;
    }

    .stat-info span {
        font-size: 12px;
        color: #777;
    }

    .filter-card,
    .table-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        margin-bottom: 25px;
    }

    .filter-card {
        padding: 20px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 12px;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 11px;
        border: 1px solid #ddd;
        border-radius: 7px;
        outline: none;
    }

    .form-control:focus {
        border-color: #f4c430;
    }

    .btn-filter {
        background: #222;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 7px;
        cursor: pointer;
    }

    .table-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
    }

    .table-header h3 {
        margin: 0;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
    }

    .attendance-table th,
    .attendance-table td {
        padding: 14px;
        border-bottom: 1px solid #eee;
        text-align: left;
        white-space: nowrap;
    }

    .attendance-table th {
        background: #fafafa;
        font-size: 12px;
        color: #555;
        text-transform: uppercase;
    }

    .attendance-table tbody tr:hover {
        background: #fffdf3;
    }

    .staff-name {
        font-weight: 600;
    }

    .staff-role {
        font-size: 12px;
        color: #888;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .present {
        background: #d4edda;
        color: #155724;
    }

    .late {
        background: #fff3cd;
        color: #856404;
    }

    .absent {
        background: #f8d7da;
        color: #721c24;
    }

    .leave {
        background: #d1ecf1;
        color: #0c5460;
    }

    .half_day {
        background: #e2e3e5;
        color: #383d41;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }

    .view {
        background: #e8f1ff;
        color: #2563eb;
    }

    .edit {
        background: #fff3cd;
        color: #856404;
    }

    .delete {
        background: #f8d7da;
        color: #dc3545;
    }

    .alert-success,
    .alert-danger {
        padding: 12px 15px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }

    @media(max-width:1100px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .filter-form {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width:700px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>

<div class="attendance-page">

    <div class="page-header">

        <div>
            <h1>
                <i class="fa-solid fa-fingerprint"></i>
                Attendance Management
            </h1>

            <p>
                Manage staff attendance and working hours
            </p>
        </div>

          @if(canAccess('admin.attendance.index', 'can_create'))
                <a href="{{ route('admin.attendance.create') }}"
                    class="btn-add">

            <i class="fa-solid fa-plus"></i>
            Record Attendance

            </a>
        @endif

    </div>


    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif


    {{-- Statistics --}}

    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-list"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $totalAttendance }}</h3>
                <span>Total</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $presentAttendance }}</h3>
                <span>Present</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $lateAttendance }}</h3>
                <span>Late</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-xmark"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $absentAttendance }}</h3>
                <span>Absent</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-person-walking-arrow-right"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $leaveAttendance }}</h3>
                <span>Leave</span>
            </div>
        </div>

    </div>


    {{-- Filters --}}

    <div class="filter-card">

        <form method="GET"
              action="{{ route('admin.attendance.index') }}"
              class="filter-form">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search staff..."
                   value="{{ request('search') }}">


            <input type="date"
                   name="attendance_date"
                   class="form-control"
                   value="{{ request('attendance_date') }}">


            <select name="status"
                    class="form-control">

                <option value="">
                    All Status
                </option>

                <option value="present"
                    {{ request('status') == 'present' ? 'selected' : '' }}>
                    Present
                </option>

                <option value="late"
                    {{ request('status') == 'late' ? 'selected' : '' }}>
                    Late
                </option>

                <option value="absent"
                    {{ request('status') == 'absent' ? 'selected' : '' }}>
                    Absent
                </option>

                <option value="leave"
                    {{ request('status') == 'leave' ? 'selected' : '' }}>
                    Leave
                </option>

                <option value="half_day"
                    {{ request('status') == 'half_day' ? 'selected' : '' }}>
                    Half Day
                </option>

            </select>


            <button type="submit"
                    class="btn-filter">

                <i class="fa-solid fa-filter"></i>
                Filter

            </button>

        </form>

    </div>


    {{-- Table --}}

    <div class="table-card">

        <div class="table-header">

            <h3>
                <i class="fa-solid fa-list-check"></i>
                Attendance Records
            </h3>

            <span>
                {{ $attendances->total() }} records
            </span>

        </div>


        <div class="table-responsive">

            <table class="attendance-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff</th>
                        <th>Shift</th>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Hours</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($attendances as $attendance)

                        <tr>

                            <td>
                                {{ $attendances->firstItem() + $loop->index }}
                            </td>


                            <td>

                                <div class="staff-name">
                                    {{ $attendance->user->name ?? 'N/A' }}
                                </div>

                                <div class="staff-role">
                                    {{ ucfirst($attendance->user->role ?? '') }}
                                </div>

                            </td>


                            <td>
                                {{ $attendance->staffShift->shiftType->name ?? 'N/A' }}
                            </td>


                            <td>
                                {{ $attendance->attendance_date
                                    ? $attendance->attendance_date->format('d M Y')
                                    : 'N/A'
                                }}
                            </td>


                            <td>

                                @if($attendance->check_in)

                                    {{ \Carbon\Carbon::parse(
                                        $attendance->check_in
                                    )->format('h:i A') }}

                                @else
                                    --
                                @endif

                            </td>


                            <td>

                                @if($attendance->check_out)

                                    {{ \Carbon\Carbon::parse(
                                        $attendance->check_out
                                    )->format('h:i A') }}

                                @else
                                    --
                                @endif

                            </td>


                            <td>
                                {{ $attendance->working_hours
                                    ? number_format($attendance->working_hours, 2) . ' hrs'
                                    : '--'
                                }}
                            </td>


                            <td>

                                <span class="badge {{ $attendance->status }}">
                                    {{ ucwords(str_replace('_', ' ', $attendance->status)) }}
                                </span>

                            </td>


                            <td>

                                <div class="action-buttons">

                                                @if(canAccess('admin.attendance.index', 'can_view'))
                                                     <a href="{{ route('admin.attendance.show', $attendance->id) }}"
                                                         class="action-btn view"
                                                         title="View">

                                        <i class="fa-solid fa-eye"></i>

                                        </a>
                                    @endif


                                                @if(canAccess('admin.attendance.index', 'can_edit'))
                                                     <a href="{{ route('admin.attendance.edit', $attendance->id) }}"
                                                         class="action-btn edit"
                                                         title="Edit">

                                        <i class="fa-solid fa-pen"></i>

                                        </a>
                                    @endif


                                    @if(canAccess('admin.attendance.index', 'can_delete'))
                                        <form action="{{ route('admin.attendance.destroy', $attendance->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this attendance record?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn delete">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                        </form>
                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                style="text-align:center;padding:40px;color:#888;">

                                <i class="fa-solid fa-calendar-xmark"
                                   style="font-size:35px;"></i>

                                <br><br>

                                No attendance records found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div style="padding:18px;">
            {{ $attendances->links() }}
        </div>

    </div>

</div>

@endsection