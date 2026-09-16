@extends('layouts.admin')

@section('content')

<style>
    .med-form-page {
        padding: 25px;
        background: #f7f7f7;
        min-height: 100vh;
    }

    .form-header {
        margin-bottom: 25px;
    }

    .form-header h1 {
        margin: 0;
        color: #111;
    }

    .form-header p {
        color: #777;
        margin-top: 6px;
    }

    .form-card {
        background: #fff;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 4px 18px rgba(0,0,0,.07);
        max-width: 1100px;
        margin: auto;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        border-bottom: 2px solid #f4c400;
        padding-bottom: 10px;
        margin: 25px 0 20px;
        color: #111;
    }

    .section-title:first-child {
        margin-top: 0;
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

    label {
        font-weight: 600;
        margin-bottom: 7px;
        color: #333;
    }

    .form-control {
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
        outline: none;
    }

    .form-control:focus {
        border-color: #f4c400;
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .error {
        color: #c00;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        border-top: 1px solid #eee;
        padding-top: 20px;
    }

    .btn {
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-weight: 700;
    }

    .btn-save {
        background: #f4c400;
        color: #111;
    }

    .btn-save:hover {
        background: #111;
        color: #fff;
    }

    .btn-cancel {
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

        .form-card {
            padding: 20px;
        }
    }
</style>

<div class="med-form-page">

    <div class="form-header">
        <h1>
            <i class="fa-solid fa-pills"></i>
            Add Medication
        </h1>

        <p>Create a new medication record for an elder.</p>
    </div>

    <div class="form-card">

        <form method="POST"
              action="{{ route('admin.medication.store') }}">

            @csrf

            <div class="section-title">
                <i class="fa-solid fa-user"></i>
                Elder Information
            </div>

            <div class="form-grid">

                <div class="form-group full">

                    <label>
                        Elder <span style="color:red;">*</span>
                    </label>

                    <select name="elder_id" class="form-control" required>

                        <option value="">Select Elder</option>

                        @foreach($elders as $elder)

                            <option value="{{ $elder->id }}"
                                {{ old('elder_id') == $elder->id ? 'selected' : '' }}>

                                {{ $elder->name }}

                                @if($elder->elder_code)
                                    - {{ $elder->elder_code }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                    @error('elder_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>

            </div>

            <div class="section-title">
                <i class="fa-solid fa-capsules"></i>
                Medication Details
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Medication Name *
                    </label>

                    <input type="text"
                           name="medication_name"
                           class="form-control"
                           value="{{ old('medication_name') }}"
                           placeholder="e.g. Paracetamol"
                           required>

                    @error('medication_name')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Generic Name</label>

                    <input type="text"
                           name="generic_name"
                           class="form-control"
                           value="{{ old('generic_name') }}"
                           placeholder="e.g. Acetaminophen">

                </div>

                <div class="form-group">

                    <label>Dosage *</label>

                    <input type="text"
                           name="dosage"
                           class="form-control"
                           value="{{ old('dosage') }}"
                           placeholder="e.g. 500"
                           required>

                </div>

                <div class="form-group">

                    <label>Dosage Unit</label>

                    <input type="text"
                           name="dosage_unit"
                           class="form-control"
                           value="{{ old('dosage_unit') }}"
                           placeholder="mg / ml / tablet">

                </div>

                <div class="form-group">

                    <label>Frequency *</label>

                    <select name="frequency" class="form-control" required>

                        <option value="">Select Frequency</option>

                        <option value="once_daily">
                            Once Daily
                        </option>

                        <option value="twice_daily">
                            Twice Daily
                        </option>

                        <option value="three_times_daily">
                            Three Times Daily
                        </option>

                        <option value="four_times_daily">
                            Four Times Daily
                        </option>

                        <option value="as_needed">
                            As Needed
                        </option>

                        <option value="weekly">
                            Weekly
                        </option>

                        <option value="custom">
                            Custom
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Administration Time</label>

                    <input type="time"
                           name="administration_time"
                           class="form-control"
                           value="{{ old('administration_time') }}">

                </div>

                <div class="form-group">

                    <label>Route *</label>

                    <select name="route" class="form-control" required>

                        <option value="oral">Oral</option>
                        <option value="injection">Injection</option>
                        <option value="topical">Topical</option>
                        <option value="inhalation">Inhalation</option>
                        <option value="eye">Eye</option>
                        <option value="ear">Ear</option>
                        <option value="other">Other</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Start Date *</label>

                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="{{ old('start_date', date('Y-m-d')) }}"
                           required>

                </div>

                <div class="form-group">

                    <label>End Date</label>

                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="{{ old('end_date') }}">

                </div>

                <div class="form-group">

                    <label>Status *</label>

                    <select name="status" class="form-control" required>

                        <option value="active"
                            {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                        <option value="stopped">
                            Stopped
                        </option>

                        <option value="cancelled">
                            Cancelled
                        </option>

                    </select>

                </div>

            </div>

            <div class="section-title">
                <i class="fa-solid fa-user-doctor"></i>
                Prescription Information
            </div>

            <div class="form-grid">

                <div class="form-group full">

                    <label>Prescribed By</label>

                    <input type="text"
                           name="prescribed_by"
                           class="form-control"
                           value="{{ old('prescribed_by') }}"
                           placeholder="Doctor / Healthcare professional">

                </div>

                <div class="form-group full">

                    <label>Purpose</label>

                    <textarea name="purpose"
                              class="form-control"
                              placeholder="What is this medication for?">{{ old('purpose') }}</textarea>

                </div>

                <div class="form-group full">

                    <label>Instructions</label>

                    <textarea name="instructions"
                              class="form-control"
                              placeholder="Special instructions, before/after food, etc.">{{ old('instructions') }}</textarea>

                </div>

                <div class="form-group full">

                    <label>Notes</label>

                    <textarea name="notes"
                              class="form-control">{{ old('notes') }}</textarea>

                </div>

            </div>

            <div class="form-actions">

                <a href="{{ route('admin.medication.index') }}"
                   class="btn btn-cancel">
                    Cancel
                </a>

                <button type="submit"
                        class="btn btn-save">

                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Medication

                </button>

            </div>

        </form>

    </div>

</div>

@endsection