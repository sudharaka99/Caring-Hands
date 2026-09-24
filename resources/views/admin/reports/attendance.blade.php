@extends('layouts.admin')

@section('content')

<style>
    .report-page {
        max-width:1450px;
        margin:auto;
        padding:20px;
    }

    .header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        flex-wrap:wrap;
        gap:10px;
    }

    .header h1 {
        margin:0;
        font-size:25px;
        font-weight:800;
    }

    .actions a,
    .actions button {
        padding:9px 14px;
        border:0;
        border-radius:7px;
        background:#111;
        color:#fff;
        text-decoration:none;
        font-size:12px;
        font-weight:700;
        cursor:pointer;
    }

    .actions button {
        background:#f4c400;
        color:#111;
    }

    .summary {
        display:grid;
        grid-template-columns:repeat(5,1fr);
        gap:10px;
        margin-bottom:18px;
    }

    .summary-box {
        background:#fff;
        border:1px solid #eee;
        border-top:4px solid #f4c400;
        border-radius:8px;
        padding:14px;
        text-align:center;
    }

    .summary-box strong {
        display:block;
        font-size:22px;
    }

    .summary-box span {
        font-size:11px;
        color:#777;
    }

    .filter-card {
        background:#fff;
        border:1px solid #eee;
        border-radius:9px;
        padding:15px;
        margin-bottom:18px;
    }

    .filter-grid {
        display:grid;
        grid-template-columns:1fr 1fr 1fr auto auto;
        gap:10px;
        align-items:end;
    }

    label {
        display:block;
        font-size:11px;
        font-weight:700;
        margin-bottom:5px;
    }

    input,
    select {
        width:100%;
        padding:9px;
        border:1px solid #ddd;
        border-radius:6px;
        font-size:12px;
    }

    .filter-btn {
        background:#f4c400;
        border:0;
        padding:10px 15px;
        border-radius:6px;
        font-weight:800;
        cursor:pointer;
    }

    .clear-btn {
        background:#eee;
        color:#111;
        padding:10px 15px;
        border-radius:6px;
        text-decoration:none;
        font-size:12px;
        font-weight:700;
    }

    .table-card {
        background:#fff;
        border:1px solid #eee;
        border-radius:9px;
        overflow:hidden;
    }

    .table-responsive {
        overflow-x:auto;
    }

    table {
        width:100%;
        min-width:850px;
        border-collapse:collapse;
    }

    th {
        background:#111;
        color:#fff;
        padding:11px;
        font-size:11px;
        text-align:left;
    }

    td {
        padding:10px;
        border-bottom:1px solid #eee;
        font-size:12px;
    }

    .badge {
        background:#f4c400;
        color:#111;
        padding:4px 8px;
        border-radius:15px;
        font-size:10px;
        font-weight:800;
    }

    .pagination {
        padding:15px;
    }

    @media(max-width:900px) {
        .summary {
            grid-template-columns:repeat(3,1fr);
        }

        .filter-grid {
            grid-template-columns:1fr 1fr;
        }
    }

    @media(max-width:550px) {
        .summary {
            grid-template-columns:repeat(2,1fr);
        }

        .filter-grid {
            grid-template-columns:1fr;
        }
    }

    @media print {
        .filter-card,
        .actions,
        .sidebar,
        .navbar,
        .pagination {
            display:none !important;
        }

        .report-page {
            max-width:100%;
            padding:0;
        }
    }
</style>

<div class="report-page">

    <div class="header">

        <h1>
            <i class="fa-solid fa-fingerprint"></i>
            Attendance Report
        </h1>

        <div class="actions">

            <a href="{{ route('admin.reports.index') }}">
                <i class="fa-solid fa-arrow-left"></i>
                Reports
            </a>

            <button onclick="window.print()">
                <i class="fa-solid fa-print"></i>
                Print
            </button>

        </div>

    </div>


    <div class="summary">

        <div class="summary-box">
            <strong>{{ $present }}</strong>
            <span>Present</span>
        </div>

        <div class="summary-box">
            <strong>{{ $late }}</strong>
            <span>Late</span>
        </div>

        <div class="summary-box">
            <strong>{{ $absent }}</strong>
            <span>Absent</span>
        </div>

        <div class="summary-box">
            <strong>{{ $leave }}</strong>
            <span>Leave</span>
        </div>

        <div class="summary-box">
            <strong>{{ $halfDay }}</strong>
            <span>Half Day</span>
        </div>

    </div>


    <div class="filter-card">

        <form method="GET">

            <div class="filter-grid">

                <div>
                    <label>From Date</label>
                    <input
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                    >
                </div>

                <div>
                    <label>To Date</label>
                    <input
                        type="date"
                        name="to_date"
                        value="{{ request('to_date') }}"
                    >
                </div>

                <div>
                    <label>Staff</label>

                    <select name="user_id">

                        <option value="">
                            All Staff
                        </option>

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ request('user_id') == $user->id ? 'selected' : '' }}
                            >
                                {{ $user->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div>
                    <label>Status</label>

                    <select name="status">

                        <option value="">All</option>

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

                </div>

                <div>

                    <button class="filter-btn">
                        <i class="fa-solid fa-filter"></i>
                        Filter
                    </button>

                    <a
                        href="{{ route('admin.reports.attendance') }}"
                        class="clear-btn"
                    >
                        Clear
                    </a>

                </div>

            </div>

        </form>

    </div>


    <div class="table-card">

        <div class="table-responsive">

            <table>

                <thead>

                    <tr>
                        <th>Date</th>
                        <th>Staff</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Working Hours</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($attendance as $record)

                        <tr>

                            <td>
                                {{ $record->attendance_date
                                    ? \Carbon\Carbon::parse($record->attendance_date)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $record->user->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $record->check_in
                                    ? \Carbon\Carbon::parse($record->check_in)->format('h:i A')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $record->check_out
                                    ? \Carbon\Carbon::parse($record->check_out)->format('h:i A')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $record->working_hours !== null
                                    ? number_format($record->working_hours, 2) . ' hrs'
                                    : '-' }}
                            </td>

                            <td>
                                <span class="badge">
                                    {{ ucfirst(str_replace('_', ' ', $record->status)) }}
                                </span>
                            </td>

                            <td>
                                {{ $record->notes ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" style="text-align:center;">
                                No attendance records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="pagination">
            {{ $attendance->links() }}
        </div>

    </div>

</div>

@endsection