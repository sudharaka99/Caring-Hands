@extends('layouts.admin')

@section('title', 'Edit Appointment | Caring Hands')

@section('content')
<div class="dashboard-page">

    {{-- Page Header --}}
    <div class="dashboard-heading">
        <div>
            <h1>Edit Appointment</h1>
            <p class="dashboard-subtitle">
                Update appointment for {{ $appointment->title }}
            </p>
        </div>
        <a href="{{ route('healthcare.appointments.index') }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Appointments
        </a>
    </div>


    {{-- Form Card --}}
    <div class="dashboard-card">

        <form method="POST"
              action="{{ route('healthcare.appointments.update', $appointment->id) }}"
              class="admin-form">

            @csrf
            @method('PUT')

            {{-- Row 1: Resident + Type --}}
            <div class="form-row">

                <div class="form-group">
                    <label>Resident <span class="required">*</span></label>
                    <select name="elder_id" required>
                        <option value="">Select Resident</option>
                        @foreach($elders as $elder)
                            <option value="{{ $elder->id }}"
                                @selected(old('elder_id', $appointment->elder_id) == $elder->id)>
                                {{ $elder->name }} ({{ $elder->elder_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('elder_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
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
                            <option value="{{ $value }}"
                                @selected(old('appointment_type', $appointment->appointment_type) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('appointment_type')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>


            {{-- Row 2: Title + Doctor --}}
            <div class="form-row">

                <div class="form-group">
                    <label>Title <span class="required">*</span></label>
                    <input type="text"
                           name="title"
                           value="{{ old('title', $appointment->title) }}"
                           placeholder="e.g., Diabetes Follow-up"
                           required>
                    @error('title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Doctor Name</label>
                    <input type="text"
                           name="doctor_name"
                           value="{{ old('doctor_name', $appointment->doctor_name) }}"
                           placeholder="e.g., Dr. Chaminda Jayasuriya">
                    @error('doctor_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>


            {{-- Row 3: Hospital + Location --}}
            <div class="form-row">

                <div class="form-group">
                    <label>Hospital / Clinic</label>
                    <input type="text"
                           name="hospital_name"
                           value="{{ old('hospital_name', $appointment->hospital_name) }}"
                           placeholder="e.g., National Hospital">
                    @error('hospital_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text"
                           name="location"
                           value="{{ old('location', $appointment->location) }}"
                           placeholder="e.g., Colombo 10">
                    @error('location')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>


            {{-- Row 4: Date + Time --}}
            <div class="form-row">

                <div class="form-group">
                    <label>Date <span class="required">*</span></label>
                    <input type="date"
                           name="appointment_date"
                           value="{{ old('appointment_date', $appointment->appointment_date) }}"
                           required>
                    @error('appointment_date')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Time <span class="required">*</span></label>
                    <input type="time"
                           name="appointment_time"
                           value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}"
                           required>
                    @error('appointment_time')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>


            {{-- Row 5: Duration + Status --}}
            <div class="form-row">

                <div class="form-group">
                    <label>Duration (minutes)</label>
                    <input type="number"
                           name="duration_minutes"
                           value="{{ old('duration_minutes', $appointment->duration_minutes) }}"
                           min="1"
                           placeholder="30">
                    @error('duration_minutes')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
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
                            <option value="{{ $value }}"
                                @selected(old('status', $appointment->status) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>


            {{-- Reason --}}
            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Reason</label>
                    <textarea name="reason" rows="3" placeholder="Reason for appointment">{{ old('reason', $appointment->reason) }}</textarea>
                    @error('reason')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            {{-- Instructions --}}
            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Instructions</label>
                    <textarea name="instructions" rows="3" placeholder="Special instructions for the visit">{{ old('instructions', $appointment->instructions) }}</textarea>
                    @error('instructions')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            {{-- Actions --}}
            <div class="form-actions">
                <a href="{{ route('healthcare.appointments.index') }}" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check"></i>
                    Update Appointment
                </button>
            </div>

        </form>

    </div>

</div>
@endsection