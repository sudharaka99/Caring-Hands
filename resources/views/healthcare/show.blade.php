@extends('layouts.admin')

@section('title', $title . ' | Caring Hands')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>{{ $title }}</h1>
            <p class="dashboard-subtitle">{{ $item->name ?? $item->title ?? '' }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="dashboard-card">

        @if($type === 'medication')
            <div class="overview-details">
                <div class="overview-row"><div class="overview-label">Resident</div><strong>{{ $item->elder->name ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Medication</div><strong>{{ $item->medication_name }}</strong></div>
                <div class="overview-row"><div class="overview-label">Generic Name</div><strong>{{ $item->generic_name ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Dosage</div><strong>{{ $item->dosage }} {{ $item->dosage_unit }}</strong></div>
                <div class="overview-row"><div class="overview-label">Frequency</div><strong>{{ str_replace('_', ' ', ucfirst($item->frequency)) }}</strong></div>
                <div class="overview-row"><div class="overview-label">Route</div><strong>{{ ucfirst($item->route) }}</strong></div>
                <div class="overview-row"><div class="overview-label">Purpose</div><strong>{{ $item->purpose ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Status</div><span class="table-status active">{{ ucfirst($item->status) }}</span></div>
            </div>
        @elseif($type === 'appointment')
            <div class="overview-details">
                <div class="overview-row"><div class="overview-label">Resident</div><strong>{{ $item->elder_name ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Title</div><strong>{{ $item->title }}</strong></div>
                <div class="overview-row"><div class="overview-label">Doctor</div><strong>{{ $item->doctor_name ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Hospital</div><strong>{{ $item->hospital_name ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Date</div><strong>{{ $item->appointment_date }}</strong></div>
                <div class="overview-row"><div class="overview-label">Time</div><strong>{{ $item->appointment_time }}</strong></div>
                <div class="overview-row"><div class="overview-label">Status</div><span class="table-status active">{{ ucfirst($item->status) }}</span></div>
            </div>
        @else
            <p style="color: #4b5563; padding: 12px 0;">
                {{ $item->care_needs ?? 'No details available.' }}
            </p>
        @endif

    </div>
</div>
@endsection