@extends('layouts.admin')

@section('title', 'Appointment Details')

@section('content')

<style>
    .appointment-show-page {
        padding: 25px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #111;
        text-decoration: none;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .back-link:hover {
        color: #c09b00;
    }

    .show-header {
        background: #111;
        color: #fff;
        border-radius: 14px;
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 22px;
    }

    .show-header h1 {
        margin: 0;
        font-size: 27px;
        font-weight: 800;
    }

    .show-header p {
        margin: 7px 0 0;
        color: #ddd;
    }

    .header-icon {
        width: 55px;
        height: 55px;
        background: #f4c400;
        color: #111;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 12px;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 800;
        text-transform: capitalize;
        margin-top: 10px;
    }

    .status-scheduled {
        background: #fff0a8;
        color: #6f5900;
    }

    .status-confirmed {
        background: #d9f5df;
        color: #17682e;
    }

    .status-completed {
        background: #d8ebff;
        color: #18568e;
    }

    .status-cancelled {
        background: #ffdede;
        color: #9c2222;
    }

    .status-rescheduled {
        background: #eadcff;
        color: #66389a;
    }

    .status-missed {
        background: #ffd9d9;
        color: #9b1b1b;
    }

    .header-actions {
        display: flex;
        gap: 9px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #f4c400;
        color: #111;
    }

    .btn-delete {
        background: #ffe0e0;
        color: #a12020;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .card {
        background: #fff;
        border-radius: 13px;
        padding: 22px;
        box-shadow: 0 3px 13px rgba(0,0,0,.07);
        margin-bottom: 20px;
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 9px;
        border-bottom: 2px solid #f4c400;
        padding-bottom: 11px;
        margin-bottom: 18px;
    }

    .card-title h3 {
        margin: 0;
        font-size: 18px;
    }

    .card-title i {
        color: #c19b00;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .detail-item {
        background: #fafafa;
        border-radius: 8px;
        padding: 13px;
    }

    .detail-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
        text-transform: uppercase;
        font-weight: 700;
    }

    .detail-value {
        color: #111;
        font-size: 15px;
        font-weight: 600;
        word-break: break-word;
    }

    .full {
        grid-column: 1 / -1;
    }

    .elder-card {
        background: linear-gradient(135deg, #fff8d8, #fff);
        border: 1px solid #f4c400;
    }

    .elder-avatar {
        width: 65px;
        height: 65px;
        background: #f4c400;
        color: #111;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        margin-bottom: 12px;
    }

    .elder-name {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .elder-code {
        color: #777;
        font-size: 13px;
    }

    .elder-info {
        margin-top: 18px;
    }

    .info-row {
        display: flex;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid rgba(0,0,0,.07);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row i {
        width: 20px;
        color: #c09b00;
        margin-top: 2px;
    }

    .info-row span {
        color: #555;
        font-size: 14px;
    }

    .text-section {
        background: #fafafa;
        padding: 15px;
        border-radius: 8px;
        line-height: 1.6;
        color: #444;
        white-space: pre-line;
    }

    .summary-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .summary-list li {
        display: flex;
        justify-content: space-between;
        padding: 11px 0;
        border-bottom: 1px solid #eee;
        gap: 15px;
    }

    .summary-list li:last-child {
        border-bottom: none;
    }

    .summary-list span:first-child {
        color: #777;
    }

    .summary-list span:last-child {
        font-weight: 700;
        text-align: right;
    }

    .danger-zone {
        border: 1px solid #ffcaca;
        background: #fff7f7;
    }

    .danger-zone h3 {
        color: #a32020;
    }

    .danger-zone p {
        color: #777;
        font-size: 13px;
    }

    @media(max-width: 900px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 600px) {
        .appointment-show-page {
            padding: 15px;
        }

        .show-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .full {
            grid-column: auto;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="appointment-show-page">

    <a href="{{ route('admin.appointments.index') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Appointments
    </a>

    {{-- Header --}}
    <div class="show-header">

        <div>

            <div class="header-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <h1>{{ $appointment->title }}</h1>

            <p>
                Appointment for
                <strong>{{ $appointment->elder->name ?? 'N/A' }}</strong>
            </p>

            <span class="status-badge status-{{ $appointment->status }}">
                {{ str_replace('_', ' ', $appointment->status) }}
            </span>

        </div>

        <div class="header-actions">

            @if(canAccess('admin.appointments.index', 'can_edit'))
                <a
                    href="{{ route('admin.appointments.edit', $appointment->id) }}"
                    class="btn btn-edit"
                >
                    <i class="fa-solid fa-pen"></i>
                    Edit
                </a>
            @endif

        </div>

    </div>

    <div class="content-grid">

        {{-- Main --}}
        <div>

            {{-- Appointment Information --}}
            <div class="card">

                <div class="card-title">
                    <i class="fa-solid fa-calendar-days"></i>
                    <h3>Appointment Information</h3>
                </div>

                <div class="details-grid">

                    <div class="detail-item">
                        <div class="detail-label">Appointment Type</div>

                        <div class="detail-value">
                            {{ ucfirst(str_replace('_', ' ', $appointment->appointment_type)) }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Status</div>

                        <div class="detail-value">
                            {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Date</div>

                        <div class="detail-value">
                            {{ optional($appointment->appointment_date)->format('d F Y') }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Time</div>

                        <div class="detail-value">
                            @if($appointment->appointment_time)
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Duration</div>

                        <div class="detail-value">
                            @if($appointment->duration_minutes)
                                {{ $appointment->duration_minutes }} minutes
                            @else
                                Not specified
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Location</div>

                        <div class="detail-value">
                            {{ $appointment->location ?: 'Not specified' }}
                        </div>
                    </div>

                </div>

            </div>

            {{-- Doctor Information --}}
            <div class="card">

                <div class="card-title">
                    <i class="fa-solid fa-user-doctor"></i>
                    <h3>Doctor & Healthcare Information</h3>
                </div>

                <div class="details-grid">

                    <div class="detail-item">
                        <div class="detail-label">Doctor</div>

                        <div class="detail-value">
                            {{ $appointment->doctor_name ?: 'Not specified' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Hospital / Clinic</div>

                        <div class="detail-value">
                            {{ $appointment->hospital_name ?: 'Not specified' }}
                        </div>
                    </div>

                </div>

            </div>

            {{-- Reason --}}
            @if($appointment->reason)

                <div class="card">

                    <div class="card-title">
                        <i class="fa-solid fa-circle-question"></i>
                        <h3>Reason</h3>
                    </div>

                    <div class="text-section">
                        {{ $appointment->reason }}
                    </div>

                </div>

            @endif

            {{-- Instructions --}}
            @if($appointment->instructions)

                <div class="card">

                    <div class="card-title">
                        <i class="fa-solid fa-notes-medical"></i>
                        <h3>Instructions</h3>
                    </div>

                    <div class="text-section">
                        {{ $appointment->instructions }}
                    </div>

                </div>

            @endif

            {{-- Notes --}}
            @if($appointment->notes)

                <div class="card">

                    <div class="card-title">
                        <i class="fa-solid fa-note-sticky"></i>
                        <h3>Notes</h3>
                    </div>

                    <div class="text-section">
                        {{ $appointment->notes }}
                    </div>

                </div>

            @endif

        </div>

        {{-- Sidebar --}}
        <div>

            {{-- Elder --}}
            <div class="card elder-card">

                <div class="card-title">
                    <i class="fa-solid fa-person-cane"></i>
                    <h3>Elder Information</h3>
                </div>

                <div class="elder-avatar">
                    <i class="fa-solid fa-person-cane"></i>
                </div>

                <div class="elder-name">
                    {{ $appointment->elder->name ?? 'N/A' }}
                </div>

                <div class="elder-code">
                    Elder Code:
                    {{ $appointment->elder->elder_code ?? 'N/A' }}
                </div>

                @if($appointment->elder)

                    <div class="elder-info">

                        @if($appointment->elder->phone)

                            <div class="info-row">
                                <i class="fa-solid fa-phone"></i>
                                <span>{{ $appointment->elder->phone }}</span>
                            </div>

                        @endif

                        @if($appointment->elder->room)

                            <div class="info-row">
                                <i class="fa-solid fa-door-open"></i>
                                <span>Room {{ $appointment->elder->room }}</span>
                            </div>

                        @endif

                        @if($appointment->elder->gender)

                            <div class="info-row">
                                <i class="fa-solid fa-venus-mars"></i>
                                <span>{{ ucfirst($appointment->elder->gender) }}</span>
                            </div>

                        @endif

                        @if($appointment->elder->blood_group)

                            <div class="info-row">
                                <i class="fa-solid fa-droplet"></i>
                                <span>
                                    Blood Group:
                                    {{ $appointment->elder->blood_group }}
                                </span>
                            </div>

                        @endif

                    </div>

                @endif

            </div>

            {{-- Quick Summary --}}
            <div class="card">

                <div class="card-title">
                    <i class="fa-solid fa-list-check"></i>
                    <h3>Quick Summary</h3>
                </div>

                <ul class="summary-list">

                    <li>
                        <span>Type</span>
                        <span>
                            {{ ucfirst(str_replace('_', ' ', $appointment->appointment_type)) }}
                        </span>
                    </li>

                    <li>
                        <span>Date</span>
                        <span>
                            {{ optional($appointment->appointment_date)->format('d M Y') }}
                        </span>
                    </li>

                    <li>
                        <span>Time</span>
                        <span>
                            {{ $appointment->appointment_time
                                ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')
                                : '-' }}
                        </span>
                    </li>

                    <li>
                        <span>Status</span>
                        <span>
                            {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                        </span>
                    </li>

                </ul>

            </div>

            {{-- Record Information --}}
            <div class="card">

                <div class="card-title">
                    <i class="fa-solid fa-circle-info"></i>
                    <h3>Record Information</h3>
                </div>

                <ul class="summary-list">

                    <li>
                        <span>Created</span>

                        <span>
                            {{ $appointment->created_at
                                ? $appointment->created_at->format('d M Y h:i A')
                                : '-' }}
                        </span>
                    </li>

                    <li>
                        <span>Updated</span>

                        <span>
                            {{ $appointment->updated_at
                                ? $appointment->updated_at->format('d M Y h:i A')
                                : '-' }}
                        </span>
                    </li>

                </ul>

            </div>

            {{-- Delete --}}
            <div class="card danger-zone">

                <div class="card-title">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <h3>Delete Appointment</h3>
                </div>

                <p>
                    Deleting this appointment cannot be undone.
                </p>

                @if(canAccess('admin.appointments.index', 'can_delete'))
                    <form
                        action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to permanently delete this appointment?');"
                    >

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-delete">
                        <i class="fa-solid fa-trash"></i>
                        Delete Appointment
                    </button>

                    </form>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection