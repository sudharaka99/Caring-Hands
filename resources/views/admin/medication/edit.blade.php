@extends('layouts.admin')

@section('content')

<style>
    .med-edit-page {
        padding: 25px;
        background: #f7f7f7;
        min-height: 100vh;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
        flex-wrap: wrap;
    }

    .page-header h1 {
        margin: 0;
        color: #111;
        font-size: 28px;
        font-weight: 700;
    }

    .page-header p {
        margin: 6px 0 0;
        color: #777;
    }

    .back-btn {
        background: #111;
        color: #fff;
        padding: 11px 17px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .back-btn:hover {
        background: #f4c400;
        color: #111;
    }

    .form-card {
        background: #fff;
        max-width: 1100px;
        margin: auto;
        padding: 30px;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0,0,0,.07);
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #111;
        border-bottom: 2px solid #f4c400;
        padding-bottom: 10px;
        margin: 25px 0 20px;
    }

    .section-title:first-child {
        margin-top: 0;
    }

    .section-title i {
        margin-right: 8px;
        color: #111;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 7px;
    }

    .required {
        color: #d00000;
    }

    .form-control {
        width: 100%;
        padding: 12px 13px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
        outline: none;
        background: #fff;
        color: #333;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #f4c400;
        box-shadow: 0 0 0 2px rgba(244,196,0,.12);
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .error-message {
        color: #c00000;
        font-size: 12px;
        margin-top: 5px;
    }

    .current-elder {
        background: #fff9d9;
        border: 1px solid #f4c400;
        padding: 10px 13px;
        border-radius: 8px;
        margin-top: 8px;
        font-size: 13px;
        color: #555;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 12px 20px;
        border-radius: 8px;
        border: none;
        text-decoration: none;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel {
        background: #eee;
        color: #333;
    }

    .btn-cancel:hover {
        background: #ddd;
    }

    .btn-update {
        background: #f4c400;
        color: #111;
    }

    .btn-update:hover {
        background: #111;
        color: #fff;
    }

    .alert-error {
        background: #ffe1e1;
        border: 1px solid #ffb8b8;
        color: #9b0000;
        padding: 14px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .medicine-preview {
        background: #111;
        color: #fff;
        padding: 18px;
        border-radius: 10px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .medicine-preview-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: #f4c400;
        color: #111;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
    }

    .medicine-preview h3 {
        margin: 0;
        font-size: 20px;
    }

    .medicine-preview p {
        margin: 4px 0 0;
        color: #ddd;
        font-size: 13px;
    }

    @media(max-width: 750px) {

        .med-edit-page {
            padding: 15px;
        }

        .form-card {
            padding: 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn {
            justify-content: center;
        }
    }
</style>


<div class="med-edit-page">

    {{-- Page Header --}}
    <div class="page-header">

        <div>
            <h1>
                <i class="fa-solid fa-pills"></i>
                Edit Medication
            </h1>

            <p>
                Update medication and prescription information.
            </p>
        </div>

        <a href="{{ route('admin.medication.index') }}"
           class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>
            Back to Medications

        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert-error">

            <strong>
                <i class="fa-solid fa-triangle-exclamation"></i>
                Please correct the following errors:
            </strong>

            <ul style="margin:8px 0 0 20px;">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Medicine Preview --}}
    <div class="medicine-preview">

        <div class="medicine-preview-icon">
            <i class="fa-solid fa-pills"></i>
        </div>

        <div>

            <h3>
                {{ $medication->medication_name }}
            </h3>

            <p>
                Medication ID: #{{ $medication->id }}
                @if($medication->elder)
                    | Elder: {{ $medication->elder->name }}
                @endif
            </p>

        </div>

    </div>


    <div class="form-card">

        <form method="POST"
              action="{{ route('admin.medication.update', $medication->id) }}">

            @csrf
            @method('PUT')


            {{-- Elder Information --}}
            <div class="section-title">

                <i class="fa-solid fa-user"></i>
                Elder Information

            </div>


            <div class="form-grid">

                <div class="form-group full">

                    <label>
                        Elder
                        <span class="required">*</span>
                    </label>

                    <select name="elder_id"
                            class="form-control"
                            required>

                        <option value="">
                            Select Elder
                        </option>

                        @foreach($elders as $elder)

                            <option value="{{ $elder->id }}"
                                {{ old('elder_id', $medication->elder_id) == $elder->id ? 'selected' : '' }}>

                                {{ $elder->name }}

                                @if($elder->elder_code)
                                    - {{ $elder->elder_code }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                    @error('elder_id')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                    @if($medication->elder)

                        <div class="current-elder">

                            <i class="fa-solid fa-circle-info"></i>

                            Current elder:
                            <strong>
                                {{ $medication->elder->name }}
                            </strong>

                            @if($medication->elder->elder_code)
                                ({{ $medication->elder->elder_code }})
                            @endif

                        </div>

                    @endif

                </div>

            </div>


            {{-- Medication Details --}}
            <div class="section-title">

                <i class="fa-solid fa-capsules"></i>
                Medication Details

            </div>


            <div class="form-grid">


                {{-- Medication Name --}}
                <div class="form-group">

                    <label>
                        Medication Name
                        <span class="required">*</span>
                    </label>

                    <input type="text"
                           name="medication_name"
                           class="form-control"
                           value="{{ old('medication_name', $medication->medication_name) }}"
                           placeholder="e.g. Paracetamol"
                           required>

                    @error('medication_name')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Generic Name --}}
                <div class="form-group">

                    <label>
                        Generic Name
                    </label>

                    <input type="text"
                           name="generic_name"
                           class="form-control"
                           value="{{ old('generic_name', $medication->generic_name) }}"
                           placeholder="e.g. Acetaminophen">

                    @error('generic_name')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Dosage --}}
                <div class="form-group">

                    <label>
                        Dosage
                        <span class="required">*</span>
                    </label>

                    <input type="text"
                           name="dosage"
                           class="form-control"
                           value="{{ old('dosage', $medication->dosage) }}"
                           placeholder="e.g. 500"
                           required>

                    @error('dosage')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Dosage Unit --}}
                <div class="form-group">

                    <label>
                        Dosage Unit
                    </label>

                    <input type="text"
                           name="dosage_unit"
                           class="form-control"
                           value="{{ old('dosage_unit', $medication->dosage_unit) }}"
                           placeholder="mg / ml / tablet">

                    @error('dosage_unit')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Frequency --}}
                <div class="form-group">

                    <label>
                        Frequency
                        <span class="required">*</span>
                    </label>

                    <select name="frequency"
                            class="form-control"
                            required>

                        <option value="once_daily"
                            {{ old('frequency', $medication->frequency) == 'once_daily' ? 'selected' : '' }}>
                            Once Daily
                        </option>

                        <option value="twice_daily"
                            {{ old('frequency', $medication->frequency) == 'twice_daily' ? 'selected' : '' }}>
                            Twice Daily
                        </option>

                        <option value="three_times_daily"
                            {{ old('frequency', $medication->frequency) == 'three_times_daily' ? 'selected' : '' }}>
                            Three Times Daily
                        </option>

                        <option value="four_times_daily"
                            {{ old('frequency', $medication->frequency) == 'four_times_daily' ? 'selected' : '' }}>
                            Four Times Daily
                        </option>

                        <option value="as_needed"
                            {{ old('frequency', $medication->frequency) == 'as_needed' ? 'selected' : '' }}>
                            As Needed
                        </option>

                        <option value="weekly"
                            {{ old('frequency', $medication->frequency) == 'weekly' ? 'selected' : '' }}>
                            Weekly
                        </option>

                        <option value="custom"
                            {{ old('frequency', $medication->frequency) == 'custom' ? 'selected' : '' }}>
                            Custom
                        </option>

                    </select>

                    @error('frequency')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Administration Time --}}
                <div class="form-group">

                    <label>
                        Administration Time
                    </label>

                    <input type="time"
                           name="administration_time"
                           class="form-control"
                           value="{{ old(
                               'administration_time',
                               $medication->administration_time
                                   ? \Carbon\Carbon::parse($medication->administration_time)->format('H:i')
                                   : ''
                           ) }}">

                    @error('administration_time')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Route --}}
                <div class="form-group">

                    <label>
                        Route
                        <span class="required">*</span>
                    </label>

                    <select name="route"
                            class="form-control"
                            required>

                        <option value="oral"
                            {{ old('route', $medication->route) == 'oral' ? 'selected' : '' }}>
                            Oral
                        </option>

                        <option value="injection"
                            {{ old('route', $medication->route) == 'injection' ? 'selected' : '' }}>
                            Injection
                        </option>

                        <option value="topical"
                            {{ old('route', $medication->route) == 'topical' ? 'selected' : '' }}>
                            Topical
                        </option>

                        <option value="inhalation"
                            {{ old('route', $medication->route) == 'inhalation' ? 'selected' : '' }}>
                            Inhalation
                        </option>

                        <option value="eye"
                            {{ old('route', $medication->route) == 'eye' ? 'selected' : '' }}>
                            Eye
                        </option>

                        <option value="ear"
                            {{ old('route', $medication->route) == 'ear' ? 'selected' : '' }}>
                            Ear
                        </option>

                        <option value="other"
                            {{ old('route', $medication->route) == 'other' ? 'selected' : '' }}>
                            Other
                        </option>

                    </select>

                    @error('route')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Start Date --}}
                <div class="form-group">

                    <label>
                        Start Date
                        <span class="required">*</span>
                    </label>

                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="{{ old(
                               'start_date',
                               $medication->start_date
                                   ? $medication->start_date->format('Y-m-d')
                                   : ''
                           ) }}"
                           required>

                    @error('start_date')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- End Date --}}
                <div class="form-group">

                    <label>
                        End Date
                    </label>

                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="{{ old(
                               'end_date',
                               $medication->end_date
                                   ? $medication->end_date->format('Y-m-d')
                                   : ''
                           ) }}">

                    @error('end_date')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Status --}}
                <div class="form-group">

                    <label>
                        Status
                        <span class="required">*</span>
                    </label>

                    <select name="status"
                            class="form-control"
                            required>

                        <option value="active"
                            {{ old('status', $medication->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="completed"
                            {{ old('status', $medication->status) == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="stopped"
                            {{ old('status', $medication->status) == 'stopped' ? 'selected' : '' }}>
                            Stopped
                        </option>

                        <option value="cancelled"
                            {{ old('status', $medication->status) == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                    @error('status')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>


            {{-- Prescription Information --}}
            <div class="section-title">

                <i class="fa-solid fa-user-doctor"></i>
                Prescription Information

            </div>


            <div class="form-grid">


                {{-- Prescribed By --}}
                <div class="form-group full">

                    <label>
                        Prescribed By
                    </label>

                    <input type="text"
                           name="prescribed_by"
                           class="form-control"
                           value="{{ old('prescribed_by', $medication->prescribed_by) }}"
                           placeholder="Doctor / Healthcare professional">

                    @error('prescribed_by')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Purpose --}}
                <div class="form-group full">

                    <label>
                        Purpose
                    </label>

                    <textarea name="purpose"
                              class="form-control"
                              placeholder="What is this medication for?">{{ old('purpose', $medication->purpose) }}</textarea>

                    @error('purpose')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Instructions --}}
                <div class="form-group full">

                    <label>
                        Instructions
                    </label>

                    <textarea name="instructions"
                              class="form-control"
                              placeholder="Special instructions, before/after food, etc.">{{ old('instructions', $medication->instructions) }}</textarea>

                    @error('instructions')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Notes --}}
                <div class="form-group full">

                    <label>
                        Notes
                    </label>

                    <textarea name="notes"
                              class="form-control"
                              placeholder="Additional notes">{{ old('notes', $medication->notes) }}</textarea>

                    @error('notes')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>


            {{-- Buttons --}}
            <div class="form-actions">

                <a href="{{ route('admin.medication.index') }}"
                   class="btn btn-cancel">

                    <i class="fa-solid fa-xmark"></i>
                    Cancel

                </a>

                <button type="submit"
                        class="btn btn-update">

                    <i class="fa-solid fa-floppy-disk"></i>
                    Update Medication

                </button>

            </div>

        </form>

    </div>

</div>

@endsection