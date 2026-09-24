@extends('layouts.admin')

@section('title', 'Add Appointment')

@section('content')

<style>
    .appointment-form-page {
        padding: 25px;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #111;
    }

    .page-header p {
        margin: 5px 0 0;
        color: #777;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #111;
        text-decoration: none;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .back-link:hover {
        color: #d3a900;
    }

    .form-card {
        background: #fff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 3px 15px rgba(0,0,0,.08);
        max-width: 1100px;
        margin: auto;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 2px solid #f4c400;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .section-title h3 {
        margin: 0;
        font-size: 18px;
    }

    .section-title i {
        color: #c29d00;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 7px;
        color: #333;
        font-size: 14px;
    }

    .required {
        color: #d00000;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fff;
        outline: none;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #f4c400;
        box-shadow: 0 0 0 3px rgba(244,196,0,.12);
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .error {
        color: #d00000;
        font-size: 12px;
        margin-top: 5px;
    }

    .alert {
        background: #ffe5e5;
        border: 1px solid #ffbaba;
        color: #9d2222;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid #eee;
        padding-top: 20px;
    }

    .btn {
        padding: 11px 20px;
        border-radius: 8px;
        border: none;
        text-decoration: none;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #f4c400;
        color: #111;
    }

    .btn-primary:hover {
        background: #dcae00;
    }

    .btn-secondary {
        background: #eee;
        color: #111;
    }

    .btn-secondary:hover {
        background: #ddd;
    }

    .info-box {
        background: #fff9dc;
        border-left: 4px solid #f4c400;
        padding: 12px 15px;
        margin-bottom: 22px;
        border-radius: 6px;
        color: #5f5000;
        font-size: 13px;
    }

    @media(max-width: 700px) {
        .appointment-form-page {
            padding: 15px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .full-width {
            grid-column: auto;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }
    }
</style>

<div class="appointment-form-page">

    <a href="{{ route('admin.appointments.index') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Appointments
    </a>

    <div class="page-header">
        <h1>
            <i class="fa-solid fa-calendar-plus"></i>
            Add Appointment
        </h1>

        <p>Create a new appointment for an elder.</p>
    </div>

    <div class="form-card">

        @if($errors->any())

            <div class="alert">
                <strong>Please fix the following errors:</strong>

                <ul style="margin:8px 0 0 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        <div class="info-box">
            <i class="fa-solid fa-circle-info"></i>
            Fields marked with <span class="required">*</span> are required.
        </div>

        <form action="{{ route('admin.appointments.store') }}" method="POST">

            @csrf

            {{-- Basic Information --}}
            <div class="section-title">
                <i class="fa-solid fa-calendar-check"></i>
                <h3>Appointment Information</h3>
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>
                        Elder <span class="required">*</span>
                    </label>

                    <select name="elder_id" class="form-control" required>

                        <option value="">Select Elder</option>

                        @foreach($elders as $elder)

                            <option
                                value="{{ $elder->id }}"
                                {{ old('elder_id') == $elder->id ? 'selected' : '' }}
                            >
                                {{ $elder->name }}

                                @if($elder->elder_code)
                                    - {{ $elder->elder_code }}
                                @endif
                            </option>

                        @endforeach

                    </select>

                    @error('elder_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        Appointment Type <span class="required">*</span>
                    </label>

                    <select name="appointment_type" class="form-control" required>

                        <option value="doctor" {{ old('appointment_type', 'doctor') == 'doctor' ? 'selected' : '' }}>
                            Doctor
                        </option>

                        <option value="healthcare" {{ old('appointment_type') == 'healthcare' ? 'selected' : '' }}>
                            Healthcare
                        </option>

                        <option value="hospital" {{ old('appointment_type') == 'hospital' ? 'selected' : '' }}>
                            Hospital
                        </option>

                        <option value="clinic" {{ old('appointment_type') == 'clinic' ? 'selected' : '' }}>
                            Clinic
                        </option>

                        <option value="therapy" {{ old('appointment_type') == 'therapy' ? 'selected' : '' }}>
                            Therapy
                        </option>

                        <option value="checkup" {{ old('appointment_type') == 'checkup' ? 'selected' : '' }}>
                            Checkup
                        </option>

                        <option value="other" {{ old('appointment_type') == 'other' ? 'selected' : '' }}>
                            Other
                        </option>

                    </select>

                    @error('appointment_type')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label>
                        Appointment Title <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title') }}"
                        placeholder="Example: Monthly Medical Checkup"
                        required
                    >

                    @error('title')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            {{-- Date & Time --}}
            <div class="section-title">
                <i class="fa-regular fa-clock"></i>
                <h3>Date & Time</h3>
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>
                        Appointment Date <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        name="appointment_date"
                        class="form-control"
                        value="{{ old('appointment_date') }}"
                        required
                    >

                    @error('appointment_date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        Appointment Time <span class="required">*</span>
                    </label>

                    <input
                        type="time"
                        name="appointment_time"
                        class="form-control"
                        value="{{ old('appointment_time') }}"
                        required
                    >

                    @error('appointment_time')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Duration (Minutes)</label>

                    <input
                        type="number"
                        name="duration_minutes"
                        class="form-control"
                        value="{{ old('duration_minutes') }}"
                        min="1"
                        placeholder="Example: 30"
                    >

                    @error('duration_minutes')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status</label>

                    <select name="status" class="form-control">

                        <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>
                            Scheduled
                        </option>

                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>
                            Confirmed
                        </option>

                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                        <option value="rescheduled" {{ old('status') == 'rescheduled' ? 'selected' : '' }}>
                            Rescheduled
                        </option>

                        <option value="missed" {{ old('status') == 'missed' ? 'selected' : '' }}>
                            Missed
                        </option>

                    </select>

                    @error('status')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            {{-- Doctor / Hospital --}}
            <div class="section-title">
                <i class="fa-solid fa-hospital"></i>
                <h3>Doctor & Location</h3>
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>Doctor Name</label>

                    <input
                        type="text"
                        name="doctor_name"
                        class="form-control"
                        value="{{ old('doctor_name') }}"
                        placeholder="Doctor's name"
                    >

                    @error('doctor_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Hospital / Clinic Name</label>

                    <input
                        type="text"
                        name="hospital_name"
                        class="form-control"
                        value="{{ old('hospital_name') }}"
                        placeholder="Hospital or clinic"
                    >

                    @error('hospital_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label>Location</label>

                    <input
                        type="text"
                        name="location"
                        class="form-control"
                        value="{{ old('location') }}"
                        placeholder="Appointment location"
                    >

                    @error('location')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            {{-- Details --}}
            <div class="section-title">
                <i class="fa-solid fa-notes-medical"></i>
                <h3>Appointment Details</h3>
            </div>

            <div class="form-grid">

                <div class="form-group full-width">
                    <label>Reason</label>

                    <textarea
                        name="reason"
                        class="form-control"
                        placeholder="Reason for the appointment..."
                    >{{ old('reason') }}</textarea>

                    @error('reason')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label>Instructions</label>

                    <textarea
                        name="instructions"
                        class="form-control"
                        placeholder="Instructions before or after the appointment..."
                    >{{ old('instructions') }}</textarea>

                    @error('instructions')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label>Notes</label>

                    <textarea
                        name="notes"
                        class="form-control"
                        placeholder="Additional notes..."
                    >{{ old('notes') }}</textarea>

                    @error('notes')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="form-actions">

                <a
                    href="{{ route('admin.appointments.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="fa-solid fa-xmark"></i>
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Save Appointment
                </button>

            </div>

        </form>

    </div>

</div>

@endsection