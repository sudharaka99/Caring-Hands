@extends('layouts.admin')

@section('title', 'Edit Care Plan | Caring Hands')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>Edit Care Plan</h1>
            <p class="dashboard-subtitle">{{ $carePlan->title }}</p>
        </div>
        <a href="{{ route('healthcare.care-plans.index') }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="dashboard-card">

        <form method="POST" action="{{ route('healthcare.care-plans.update', $carePlan->id) }}" class="admin-form">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Resident <span class="required">*</span></label>
                    <select name="elder_id" required>
                        @foreach($elders as $elder)
                            <option value="{{ $elder->id }}" @selected(old('elder_id', $carePlan->elder_id) == $elder->id)>
                                {{ $elder->name }} ({{ $elder->elder_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Assign Caregiver</label>
                    <select name="caregiver_id">
                        <option value="">None</option>
                        @foreach($caregivers as $cg)
                            <option value="{{ $cg->id }}" @selected(old('caregiver_id', $carePlan->caregiver_id) == $cg->id)>
                                {{ $cg->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Title <span class="required">*</span></label>
                    <input type="text" name="title"
                           value="{{ old('title', $carePlan->title) }}" required>
                </div>
                <div class="form-group">
                    <label>Priority <span class="required">*</span></label>
                    <select name="priority" required>
                        @foreach(['low','medium','high','critical'] as $p)
                            <option value="{{ $p }}" @selected(old('priority', $carePlan->priority) === $p)>
                                {{ ucfirst($p) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Start Date <span class="required">*</span></label>
                    <input type="date" name="start_date"
                           value="{{ old('start_date', $carePlan->start_date) }}" required>
                </div>
                <div class="form-group">
                    <label>Review Date</label>
                    <input type="date" name="review_date"
                           value="{{ old('review_date', $carePlan->review_date) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <select name="status" required>
                        @foreach(['draft','active','completed','cancelled'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $carePlan->status) === $s)>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Care Needs</label>
                    <textarea name="care_needs" rows="3">{{ old('care_needs', $carePlan->care_needs) }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Goals</label>
                    <textarea name="goals" rows="3">{{ old('goals', $carePlan->goals) }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Activities</label>
                    <textarea name="activities" rows="3">{{ old('activities', $carePlan->activities) }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Notes</label>
                    <textarea name="notes" rows="2">{{ old('notes', $carePlan->notes) }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('healthcare.care-plans.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check"></i> Update Care Plan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection