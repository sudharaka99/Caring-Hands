@extends('layouts.admin')

@section('title', 'Edit Shift')

@section('content')

<style>
    .shift-form-page {
        padding: 25px;
    }

    .form-header {
        margin-bottom: 25px;
    }

    .form-header h1 {
        margin: 0;
        font-size: 28px;
        color: #222;
    }

    .form-header p {
        color: #777;
        margin-top: 6px;
    }

    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        max-width: 1000px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        border-bottom: 1px solid #eee;
        padding-bottom: 12px;
        margin-bottom: 20px;
        color: #222;
    }

    .section-title i {
        color: #dcae16;
        margin-right: 7px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        margin-bottom: 7px;
        font-weight: 600;
        color: #444;
        font-size: 14px;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #ddd;
        border-radius: 7px;
        outline: none;
        background: #fff;
    }

    .form-control:focus {
        border-color: #f4c430;
        box-shadow: 0 0 0 2px rgba(244,196,48,.15);
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

    .current-info {
        background: #fff9df;
        border: 1px solid #f4c430;
        border-radius: 8px;
        padding: 14px;
        margin-bottom: 25px;
    }

    .current-info strong {
        color: #856404;
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
        border-radius: 7px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-primary {
        background: #f4c430;
        color: #222;
    }

    .btn-primary:hover {
        background: #dcae16;
    }

    .btn-secondary {
        background: #eee;
        color: #333;
    }

    @media(max-width:700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .shift-form-page {
            padding: 15px;
        }
    }
</style>

<div class="shift-form-page">

    <div class="form-header">

        <h1>
            <i class="fa-solid fa-pen-to-square"></i>
            Edit Shift
        </h1>

        <p>
            Update staff shift information
        </p>

    </div>


    <div class="form-card">

        <div class="current-info">

            <strong>
                <i class="fa-solid fa-circle-info"></i>
                Editing:
            </strong>

            {{ $shift->shiftType->name ?? 'Shift' }}

            -
            {{ $shift->user->name ?? 'N/A' }}

        </div>


        <form action="{{ route('admin.shifts.update', $shift->id) }}"
              method="POST">

            @csrf
            @method('PUT')


            <div class="section-title">

                <i class="fa-solid fa-user"></i>

                Staff & Shift Information

            </div>


            <div class="form-grid">


                {{-- Staff --}}

                <div class="form-group">

                    <label>
                        Staff Member <span class="required">*</span>
                    </label>

                    <select name="user_id"
                            class="form-control"
                            required>

                        <option value="">
                            Select Staff Member
                        </option>

                        @foreach($staff as $member)

                            <option value="{{ $member->id }}"
                                {{ old('user_id', $shift->user_id) == $member->id ? 'selected' : '' }}>

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


                {{-- Shift Type --}}

                <div class="form-group">

                    <label>
                        Shift Type <span class="required">*</span>
                    </label>

                    <select name="shift_type_id"
                            class="form-control"
                            required>

                        <option value="">
                            Select Shift Type
                        </option>

                        @foreach($shiftTypes as $type)

                            <option value="{{ $type->id }}"
                                {{ old('shift_type_id', $shift->shift_type_id) == $type->id ? 'selected' : '' }}>

                                {{ $type->name }}

                                ({{ \Carbon\Carbon::parse($type->start_time)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($type->end_time)->format('h:i A') }})

                            </option>

                        @endforeach

                    </select>

                    @error('shift_type_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Date --}}

                <div class="form-group">

                    <label>
                        Shift Date <span class="required">*</span>
                    </label>

                    <input type="date"
                           name="shift_date"
                           class="form-control"
                           value="{{ old('shift_date',
                                $shift->shift_date
                                    ? \Carbon\Carbon::parse($shift->shift_date)->format('Y-m-d')
                                    : ''
                           ) }}"
                           required>

                    @error('shift_date')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Status --}}

                <div class="form-group">

                    <label>
                        Status <span class="required">*</span>
                    </label>

                    <select name="status"
                            class="form-control"
                            required>

                        <option value="scheduled"
                            {{ old('status', $shift->status) == 'scheduled' ? 'selected' : '' }}>
                            Scheduled
                        </option>

                        <option value="active"
                            {{ old('status', $shift->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="completed"
                            {{ old('status', $shift->status) == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="cancelled"
                            {{ old('status', $shift->status) == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                        <option value="absent"
                            {{ old('status', $shift->status) == 'absent' ? 'selected' : '' }}>
                            Absent
                        </option>

                    </select>

                    @error('status')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Start Time --}}

                <div class="form-group">

                    <label>
                        Start Time
                    </label>

                    <input type="time"
                           name="start_time"
                           class="form-control"
                           value="{{ old('start_time',
                                $shift->start_time
                                    ? \Carbon\Carbon::parse($shift->start_time)->format('H:i')
                                    : ''
                           ) }}">

                    @error('start_time')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- End Time --}}

                <div class="form-group">

                    <label>
                        End Time
                    </label>

                    <input type="time"
                           name="end_time"
                           class="form-control"
                           value="{{ old('end_time',
                                $shift->end_time
                                    ? \Carbon\Carbon::parse($shift->end_time)->format('H:i')
                                    : ''
                           ) }}">

                    @error('end_time')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Notes --}}

                <div class="form-group full">

                    <label>
                        Notes
                    </label>

                    <textarea name="notes"
                              class="form-control"
                              placeholder="Enter notes...">{{ old('notes', $shift->notes) }}</textarea>

                    @error('notes')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>

            </div>


            <div class="form-actions">

                <a href="{{ route('admin.shifts.index') }}"
                   class="btn btn-secondary">

                    <i class="fa-solid fa-arrow-left"></i>
                    Cancel

                </a>


                <button type="submit"
                        class="btn btn-primary">

                    <i class="fa-solid fa-save"></i>
                    Update Shift

                </button>

            </div>

        </form>

    </div>

</div>

@endsection