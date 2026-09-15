@extends('layouts.admin')

@section('title', 'Attendance Details')

@section('content')

<style>
    .attendance-show-page {
        padding: 25px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .header h1 {
        margin: 0;
        color: #222;
    }

    .header p {
        color: #777;
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 7px;
        text-decoration: none;
        font-weight: 600;
    }

    .back {
        background: #eee;
        color: #333;
    }

    .edit {
        background: #f4c430;
        color: #222;
    }

    .details-card {
        background: #fff;
        max-width: 1000px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        overflow: hidden;
    }

    .details-top {
        background: #fff9df;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 18px;
        border-bottom: 1px solid #eee;
    }

    .icon {
        width: 65px;
        height: 65px;
        border-radius: 12px;
        background: #f4c430;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 28px;
    }

    .details-top h2 {
        margin: 0;
    }

    .details-top p {
        margin: 5px 0 0;
        color: #777;
    }

    .details-body {
        padding: 25px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 20px;
    }

    .item {
        border-bottom: 1px solid #eee;
        padding-bottom: 14px;
    }

    .label {
        display: block;
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .value {
        font-weight: 600;
        color: #222;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
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

    .notes {
        margin-top: 25px;
        background: #fafafa;
        padding: 18px;
        border-radius: 8px;
    }

    .notes h4 {
        margin-top: 0;
    }

    @media(max-width:700px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="attendance-show-page">

    <div class="header">

        <div>

            <h1>
                <i class="fa-solid fa-fingerprint"></i>
                Attendance Details
            </h1>

            <p>
                View attendance information
            </p>

        </div>


        <div class="actions">

            <a href="{{ route('admin.attendance.index') }}"
               class="btn back">

                <i class="fa-solid fa-arrow-left"></i>
                Back

            </a>


            <a href="{{ route('admin.attendance.edit', $attendance->id) }}"
               class="btn edit">

                <i class="fa-solid fa-pen"></i>
                Edit

            </a>

        </div>

    </div>


    <div class="details-card">

        <div class="details-top">

            <div class="icon">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div>

                <h2>
                    {{ $attendance->user->name ?? 'N/A' }}
                </h2>

                <p>
                    {{ ucfirst($attendance->user->role ?? 'N/A') }}
                </p>

            </div>

        </div>


        <div class="details-body">

            <div class="grid">


                <div class="item">

                    <span class="label">
                        Staff Member
                    </span>

                    <span class="value">
                        {{ $attendance->user->name ?? 'N/A' }}
                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Staff Role
                    </span>

                    <span class="value">
                        {{ ucfirst($attendance->user->role ?? 'N/A') }}
                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Attendance Date
                    </span>

                    <span class="value">

                        {{ $attendance->attendance_date
                            ? $attendance->attendance_date->format('d F Y')
                            : 'N/A'
                        }}

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Shift
                    </span>

                    <span class="value">
                        {{ $attendance->staffShift->shiftType->name ?? 'N/A' }}
                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Check In
                    </span>

                    <span class="value">

                        {{ $attendance->check_in
                            ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A')
                            : 'Not recorded'
                        }}

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Check Out
                    </span>

                    <span class="value">

                        {{ $attendance->check_out
                            ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A')
                            : 'Not recorded'
                        }}

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Working Hours
                    </span>

                    <span class="value">

                        {{ $attendance->working_hours
                            ? number_format($attendance->working_hours,2) . ' hours'
                            : 'Not calculated'
                        }}

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Status
                    </span>

                    <span class="value">

                        <span class="badge {{ $attendance->status }}">
                            {{ ucwords(str_replace('_',' ', $attendance->status)) }}
                        </span>

                    </span>

                </div>

            </div>


            <div class="notes">

                <h4>
                    <i class="fa-solid fa-note-sticky"></i>
                    Notes
                </h4>

                <p>
                    {{ $attendance->notes ?: 'No notes available.' }}
                </p>

            </div>

        </div>

    </div>

</div>

@endsection