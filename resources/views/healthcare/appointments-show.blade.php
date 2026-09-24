@extends('layouts.admin')

@section('title', 'Appointment Details | Caring Hands')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>{{ $item->title }}</h1>
            <p class="dashboard-subtitle">{{ $item->elder_name ?? 'Appointment Details' }}</p>
        </div>
        <a href="{{ route('healthcare.appointments.index') }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>
    </div>

    <div class="dashboard-card">
        <div class="overview-details">
            <div class="overview-row"><div class="overview-label">Resident</div><strong>{{ $item->elder_name ?? '-' }}</strong></div>
            <div class="overview-row"><div class="overview-label">Type</div><strong>{{ ucfirst($item->appointment_type) }}</strong></div>
            <div class="overview-row"><div class="overview-label">Doctor</div><strong>{{ $item->doctor_name ?? '-' }}</strong></div>
            <div class="overview-row"><div class="overview-label">Hospital</div><strong>{{ $item->hospital_name ?? '-' }}</strong></div>
            <div class="overview-row"><div class="overview-label">Location</div><strong>{{ $item->location ?? '-' }}</strong></div>
            <div class="overview-row"><div class="overview-label">Date</div><strong>{{ $item->appointment_date }}</strong></div>
            <div class="overview-row"><div class="overview-label">Time</div><strong>{{ $item->appointment_time }}</strong></div>
            <div class="overview-row"><div class="overview-label">Duration</div><strong>{{ $item->duration_minutes ?? '-' }} mins</strong></div>
            <div class="overview-row"><div class="overview-label">Status</div><span class="table-status active">{{ ucfirst($item->status) }}</span></div>
            <div class="overview-row"><div class="overview-label">Reason</div><strong>{{ $item->reason ?? '-' }}</strong></div>
            <div class="overview-row"><div class="overview-label">Instructions</div><strong>{{ $item->instructions ?? '-' }}</strong></div>
        </div>

        <div class="form-actions" style="margin-top: 24px;">
            <a href="{{ route('healthcare.appointments.edit', $item->id) }}" class="btn-primary">
                <i class="fa-solid fa-pen"></i> Edit Appointment
            </a>
        </div>
    </div>

</div>
@endsection