@extends('layouts.admin')

@section('title', 'Record Attendance')

@section('content')

<style>
    .attendance-form-page {
        padding: 25px;
    }

    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        max-width: 1000px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin: 0;
        color: #222;
    }

    .page-header p {
        color: #777;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        border-bottom: 1px solid #eee;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }

    .section-title i {
        color: #dcae16;
        margin-right: 7px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .full {
        grid-column: 1/-1;
    }

    label {
        font-weight: 600;
        margin-bottom: 7px;
        font-size: 14px;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        padding: 11px 13px;
        border: 1px solid #ddd;
        border-radius: 7px;
        outline: none;
    }

    .form-control:focus {
        border-color: #f4c430;
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
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
        border: none;
        border-radius: 7px;
        text-decoration: none;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-primary {
        background: #f4c430;
        color: #222;
    }

    .btn-secondary {
        background: #eee;
        color: #333;
    }

    @media(max-width:700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .full {
            grid-column: auto;
        }
    }
</style>

<div class="attendance-form-page">

    <div class="page-header">

        <h1>
            <i class="fa-solid fa-fingerprint"></i>
            Record Attendance
        </h1>

        <p>
            Record staff attendance for a specific date
        </p>

    </div>


    <div class="form-card">

        <form method="POST"
              action="{{ route('admin.attendance.store') }}">

            @csrf


            <div class="section-title">

                <i class="fa-solid fa-user-check"></i>

                Attendance Information

            </div>


            <div class="form-grid">


                <div class="form-group">

                    <label>
                        Staff Member
                        <span class="required">*</span>
                    </label>

                    <select name="user_id"
                            class="form-control"
                            required>

                        <option value="">
                            Select Staff
                        </option>

                        @foreach($staff as $member)

                            <option value="{{ $member->id }}"
                                {{ old('user_id') == $member->id ? 'selected' : '' }}>

                                {{ $member->name }}
                                -
                                {{ ucfirst($member->role) }}

                            </option>

                        @endforeach

                    </select>

                    @error('user_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Staff Shift
                    </label>

                    <select name="staff_shift_id"
                            class="form-control">

                        <option value="">
                            Select Shift
                        </option>

                        @foreach($shifts as $shift)

                            <option value="{{ $shift->id }}"
                                {{ old('staff_shift_id') == $shift->id ? 'selected' : '' }}>

                                {{ $shift->user->name ?? 'N/A' }}
                                -
                                {{ $shift->shiftType->name ?? 'Shift' }}
                                -
                                {{ $shift->shift_date
                                    ? $shift->shift_date->format('d M Y')
                                    : ''
                                }}

                            </option>

                        @endforeach

                    </select>

                    @error('staff_shift_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Attendance Date
                        <span class="required">*</span>
                    </label>

                    <input type="date"
                           name="attendance_date"
                           class="form-control"
                           value="{{ old('attendance_date', date('Y-m-d')) }}"
                           required>

                    @error('attendance_date')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Status
                        <span class="required">*</span>
                    </label>

                    <select name="status"
                            class="form-control"
                            required>

                        <option value="present"
                            {{ old('status','present') == 'present' ? 'selected' : '' }}>
                            Present
                        </option>

                        <option value="late"
                            {{ old('status') == 'late' ? 'selected' : '' }}>
                            Late
                        </option>

                        <option value="absent"
                            {{ old('status') == 'absent' ? 'selected' : '' }}>
                            Absent
                        </option>

                        <option value="leave"
                            {{ old('status') == 'leave' ? 'selected' : '' }}>
                            Leave
                        </option>

                        <option value="half_day"
                            {{ old('status') == 'half_day' ? 'selected' : '' }}>
                            Half Day
                        </option>

                    </select>

                    @error('status')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Check In
                    </label>

                    <input type="time"
                           name="check_in"
                           class="form-control"
                           value="{{ old('check_in') }}">

                </div>


                <div class="form-group">

                    <label>
                        Check Out
                    </label>

                    <input type="time"
                           name="check_out"
                           class="form-control"
                           value="{{ old('check_out') }}">

                </div>


                <div class="form-group full">

                    <label>
                        Notes
                    </label>

                    <textarea name="notes"
                              class="form-control"
                              placeholder="Enter attendance notes...">{{ old('notes') }}</textarea>

                </div>

            </div>


            <div class="form-actions">

                <a href="{{ route('admin.attendance.index') }}"
                   class="btn btn-secondary">

                    <i class="fa-solid fa-arrow-left"></i>
                    Cancel

                </a>


                <button type="submit"
                        class="btn btn-primary">

                    <i class="fa-solid fa-save"></i>
                    Save Attendance

                </button>

            </div>

        </form>

    </div>

</div>

@endsection