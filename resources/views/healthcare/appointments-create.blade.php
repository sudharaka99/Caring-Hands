@extends('layouts.admin')

@section('title', 'New Appointment | Caring Hands')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>New Appointment</h1>
            <p class="dashboard-subtitle">Schedule a new appointment</p>
        </div>
        <a href="{{ route('healthcare.appointments.index') }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Appointments
        </a>
    </div>

    <div class="dashboard-card">

        <form method="POST"
              action="{{ route('healthcare.appointments.store') }}"
              class="admin-form">

            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>Resident <span class="required">*</span></label>
                    <select name="elder_id" required>
                        <option value="">Select Resident</option>
                        @foreach($elders as $elder)
                            <option value="{{ $elder->id }}" @selected(old('elder_id') == $elder->id)>
                                {{ $elder->name }} ({{ $elder->elder_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('elder_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Appointment Type <span class="required">*</span></label>
                    <select name="appointment_type" required>
                        @foreach([
                            'doctor' => 'Doctor',
                            'healthcare' => 'Healthcare',
                            'hospital' => 'Hospital',
                            'clinic' => 'Clinic',
                            'therapy' => 'Therapy',
                            'checkup' => 'Checkup',
                            'other' => 'Other',
                        ] as $value => $label)
                            <option value="{{ $value }}" @selected(old('appointment_type') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Title <span class="required">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="e.g., Diabetes Follow-up" required>
                    @error('title') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Doctor Name</label>
                    <input type="text" name="doctor_name" value="{{ old('doctor_name') }}"
                           placeholder="e.g., Dr. Chaminda Jayasuriya">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Hospital / Clinic</label>
                    <input type="text" name="hospital_name" value="{{ old('hospital_name') }}">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" value="{{ old('location') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date <span class="required">*</span></label>
                    <input type="date" name="appointment_date"
                           value="{{ old('appointment_date', now()->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label>Time <span class="required">*</span></label>
                    <input type="time" name="appointment_time"
                           value="{{ old('appointment_time', '09:00') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Duration (minutes)</label>
                    <input type="number" name="duration_minutes"
                           value="{{ old('duration_minutes', 30) }}" min="1">
                </div>
                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <select name="status" required>
                        @foreach([
                            'scheduled' => 'Scheduled',
                            'confirmed' => 'Confirmed',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                            'rescheduled' => 'Rescheduled',
                            'missed' => 'Missed',
                        ] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', 'scheduled') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Reason</label>
                    <textarea name="reason" rows="3">{{ old('reason') }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Instructions</label>
                    <textarea name="instructions" rows="3">{{ old('instructions') }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('healthcare.appointments.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check"></i>
                    Create Appointment
                </button>
            </div>

        </form>

    </div>

</div>
@endsection