@extends('layouts.admin')

@section('title', 'Shift Details')

@section('content')

<style>
    .shift-show-page {
        padding: 25px;
    }

    .show-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .show-header h1 {
        margin: 0;
        font-size: 28px;
        color: #222;
    }

    .show-header p {
        margin-top: 6px;
        color: #777;
    }

    .header-actions {
        display: flex;
        gap: 8px;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 7px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        gap: 7px;
        align-items: center;
    }

    .btn-edit {
        background: #f4c430;
        color: #222;
    }

    .btn-back {
        background: #eee;
        color: #333;
    }

    .details-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        max-width: 1000px;
        overflow: hidden;
    }

    .details-header {
        padding: 25px;
        background: #fff9df;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .shift-icon {
        width: 65px;
        height: 65px;
        background: #f4c430;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #222;
    }

    .details-header h2 {
        margin: 0;
        font-size: 22px;
    }

    .details-header p {
        margin: 5px 0 0;
        color: #777;
    }

    .details-body {
        padding: 25px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .detail-item {
        border-bottom: 1px solid #eee;
        padding-bottom: 14px;
    }

    .detail-label {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .detail-value {
        font-size: 15px;
        color: #222;
        font-weight: 600;
    }

    .notes-box {
        margin-top: 25px;
        padding: 18px;
        background: #fafafa;
        border-radius: 8px;
    }

    .notes-box h4 {
        margin: 0 0 10px;
    }

    .notes-box p {
        margin: 0;
        color: #555;
        line-height: 1.6;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-scheduled {
        background: #fff3cd;
        color: #856404;
    }

    .badge-active {
        background: #d4edda;
        color: #155724;
    }

    .badge-completed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-absent {
        background: #e2e3e5;
        color: #383d41;
    }

    @media(max-width:700px) {
        .show-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .shift-show-page {
            padding: 15px;
        }
    }
</style>

<div class="shift-show-page">

    <div class="show-header">

        <div>
            <h1>
                <i class="fa-solid fa-calendar-day"></i>
                Shift Details
            </h1>

            <p>
                View complete shift information
            </p>
        </div>

        <div class="header-actions">

            <a href="{{ route('admin.shifts.index') }}"
               class="btn btn-back">

                <i class="fa-solid fa-arrow-left"></i>
                Back

            </a>

                @if(canAccess('admin.shifts.index', 'can_edit'))
                     <a href="{{ route('admin.shifts.edit', $shift->id) }}"
                         class="btn btn-edit">

                <i class="fa-solid fa-pen"></i>
                Edit

                </a>
            @endif

        </div>

    </div>


    <div class="details-card">

        <div class="details-header">

            <div class="shift-icon">
                <i class="fa-solid fa-calendar-days"></i>
            </div>

            <div>

                <h2>
                    {{ $shift->shiftType->name ?? 'Shift' }}
                </h2>

                <p>
                    {{ $shift->user->name ?? 'N/A' }}
                </p>

            </div>

        </div>


        <div class="details-body">

            <div class="detail-grid">

                <div class="detail-item">

                    <span class="detail-label">
                        Staff Member
                    </span>

                    <span class="detail-value">
                        {{ $shift->user->name ?? 'N/A' }}
                    </span>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Staff Role
                    </span>

                    <span class="detail-value">
                        {{ ucfirst($shift->user->role ?? 'N/A') }}
                    </span>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Shift Type
                    </span>

                    <span class="detail-value">
                        {{ $shift->shiftType->name ?? 'N/A' }}
                    </span>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Shift Date
                    </span>

                    <span class="detail-value">

                        {{ $shift->shift_date
                            ? \Carbon\Carbon::parse($shift->shift_date)->format('d F Y')
                            : 'N/A'
                        }}

                    </span>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Start Time
                    </span>

                    <span class="detail-value">

                        {{ $shift->start_time
                            ? \Carbon\Carbon::parse($shift->start_time)->format('h:i A')
                            : 'N/A'
                        }}

                    </span>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        End Time
                    </span>

                    <span class="detail-value">

                        {{ $shift->end_time
                            ? \Carbon\Carbon::parse($shift->end_time)->format('h:i A')
                            : 'N/A'
                        }}

                    </span>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Status
                    </span>

                    <span class="detail-value">

                        @php
                            $statusClass = match($shift->status) {
                                'scheduled' => 'badge-scheduled',
                                'active' => 'badge-active',
                                'completed' => 'badge-completed',
                                'cancelled' => 'badge-cancelled',
                                'absent' => 'badge-absent',
                                default => 'badge-scheduled'
                            };
                        @endphp

                        <span class="badge {{ $statusClass }}">
                            {{ ucfirst($shift->status) }}
                        </span>

                    </span>

                </div>


                <div class="detail-item">

                    <span class="detail-label">
                        Created
                    </span>

                    <span class="detail-value">

                        {{ $shift->created_at
                            ? $shift->created_at->format('d M Y h:i A')
                            : 'N/A'
                        }}

                    </span>

                </div>

            </div>


            <div class="notes-box">

                <h4>
                    <i class="fa-solid fa-note-sticky"></i>
                    Notes
                </h4>

                <p>
                    {{ $shift->notes ?: 'No notes available for this shift.' }}
                </p>

            </div>

        </div>

    </div>

</div>

@endsection