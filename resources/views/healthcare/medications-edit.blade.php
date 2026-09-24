@extends('layouts.admin')

@section('title', 'Edit Medication | Caring Hands')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>Edit Medication</h1>
            <p class="dashboard-subtitle">{{ $medication->medication_name }}</p>
        </div>
        <a href="{{ route('healthcare.medication.index') }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="dashboard-card">

        <form method="POST" action="{{ route('healthcare.medication.update', $medication->id) }}" class="admin-form">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Resident <span class="required">*</span></label>
                    <select name="elder_id" required>
                        @foreach($elders as $elder)
                            <option value="{{ $elder->id }}" @selected(old('elder_id', $medication->elder_id) == $elder->id)>
                                {{ $elder->name }} ({{ $elder->elder_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Medication Name <span class="required">*</span></label>
                    <input type="text" name="medication_name"
                           value="{{ old('medication_name', $medication->medication_name) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Generic Name</label>
                    <input type="text" name="generic_name"
                           value="{{ old('generic_name', $medication->generic_name) }}">
                </div>
                <div class="form-group">
                    <label>Prescribed By</label>
                    <input type="text" name="prescribed_by"
                           value="{{ old('prescribed_by', $medication->prescribed_by) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Dosage <span class="required">*</span></label>
                    <input type="text" name="dosage"
                           value="{{ old('dosage', $medication->dosage) }}" required>
                </div>
                <div class="form-group">
                    <label>Dosage Unit</label>
                    <input type="text" name="dosage_unit"
                           value="{{ old('dosage_unit', $medication->dosage_unit) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Frequency <span class="required">*</span></label>
                    <select name="frequency" required>
                        @foreach([
                            'once_daily' => 'Once Daily',
                            'twice_daily' => 'Twice Daily',
                            'three_times_daily' => 'Three Times Daily',
                            'four_times_daily' => 'Four Times Daily',
                            'as_needed' => 'As Needed',
                            'weekly' => 'Weekly',
                            'custom' => 'Custom',
                        ] as $value => $label)
                            <option value="{{ $value }}" @selected(old('frequency', $medication->frequency) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Administration Time</label>
                    <input type="time" name="administration_time"
                           value="{{ old('administration_time', $medication->administration_time) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Route <span class="required">*</span></label>
                    <select name="route" required>
                        @foreach(['oral','injection','topical','inhalation','eye','ear','other'] as $r)
                            <option value="{{ $r }}" @selected(old('route', $medication->route) === $r)>
                                {{ ucfirst($r) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <select name="status" required>
                        @foreach(['active','completed','stopped','cancelled'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $medication->status) === $s)>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Start Date <span class="required">*</span></label>
                    <input type="date" name="start_date"
                           value="{{ old('start_date', $medication->start_date) }}" required>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date"
                           value="{{ old('end_date', $medication->end_date) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Purpose</label>
                    <textarea name="purpose" rows="2">{{ old('purpose', $medication->purpose) }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Instructions</label>
                    <textarea name="instructions" rows="2">{{ old('instructions', $medication->instructions) }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Notes</label>
                    <textarea name="notes" rows="2">{{ old('notes', $medication->notes) }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('healthcare.medication.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check"></i> Update Medication
                </button>
            </div>

        </form>

    </div>
</div>
@endsection