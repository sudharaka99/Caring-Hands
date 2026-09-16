@extends('layouts.admin')

@section('title', 'Create Care Plan')

@section('content')

<style>
    .care-plan-form-page {
        padding: 25px;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin: 0;
        color: #222;
        font-size: 28px;
    }

    .page-header p {
        color: #777;
    }

    .form-card {
        background: #fff;
        max-width: 1000px;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
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

    .form-group label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 7px;
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
    }

    .form-control:focus {
        border-color: #f4c430;
        box-shadow: 0 0 0 2px rgba(244,196,48,.15);
    }

    textarea.form-control {
        min-height: 110px;
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
        border-radius: 7px;
        border: none;
        text-decoration: none;
        cursor: pointer;
        font-weight: 600;
    }

    .primary {
        background: #f4c430;
        color: #222;
    }

    .secondary {
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

<div class="care-plan-form-page">

    <div class="page-header">

        <h1>
            <i class="fa-solid fa-notes-medical"></i>
            Create Care Plan
        </h1>

        <p>
            Create a personalized care plan for an elder
        </p>

    </div>


    <div class="form-card">

        <form method="POST"
              action="{{ route('admin.care-plans.store') }}">

            @csrf


            <div class="section-title">

                <i class="fa-solid fa-heart-pulse"></i>

                Care Plan Information

            </div>


            <div class="form-grid">


                {{-- Elder --}}

                <div class="form-group">

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


                {{-- Caregiver --}}

                <div class="form-group">

                    <label>
                        Assigned Caregiver
                    </label>

                    <select name="caregiver_id"
                            class="form-control">

                        <option value="">
                            Not Assigned
                        </option>

                        @foreach($caregivers as $caregiver)

                            <option value="{{ $caregiver->id }}"
                                {{ old('caregiver_id') == $caregiver->id ? 'selected' : '' }}>

                                {{ $caregiver->user->name ?? 'N/A' }}

                            </option>

                        @endforeach

                    </select>

                    @error('caregiver_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Title --}}

                <div class="form-group full">

                    <label>
                        Care Plan Title
                        <span class="required">*</span>
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title') }}"
                           placeholder="Example: Daily Personal Care Plan"
                           required>

                    @error('title')
                        <span class="error">{{ $message }}</span>
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
                           value="{{ old('start_date', date('Y-m-d')) }}"
                           required>

                    @error('start_date')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Review Date --}}

                <div class="form-group">

                    <label>
                        Review Date
                    </label>

                    <input type="date"
                           name="review_date"
                           class="form-control"
                           value="{{ old('review_date') }}">

                    @error('review_date')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Priority --}}

                <div class="form-group">

                    <label>
                        Priority
                        <span class="required">*</span>
                    </label>

                    <select name="priority"
                            class="form-control"
                            required>

                        <option value="low">Low</option>

                        <option value="medium"
                            {{ old('priority','medium') == 'medium' ? 'selected' : '' }}>
                            Medium
                        </option>

                        <option value="high"
                            {{ old('priority') == 'high' ? 'selected' : '' }}>
                            High
                        </option>

                        <option value="critical"
                            {{ old('priority') == 'critical' ? 'selected' : '' }}>
                            Critical
                        </option>

                    </select>

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

                        <option value="draft"
                            {{ old('status','draft') == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="active"
                            {{ old('status') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="completed"
                            {{ old('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="cancelled"
                            {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                </div>


                {{-- Care Needs --}}

                <div class="form-group full">

                    <label>
                        Care Needs
                    </label>

                    <textarea name="care_needs"
                              class="form-control"
                              placeholder="Describe the elder's care needs...">{{ old('care_needs') }}</textarea>

                    @error('care_needs')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Goals --}}

                <div class="form-group full">

                    <label>
                        Care Goals
                    </label>

                    <textarea name="goals"
                              class="form-control"
                              placeholder="Describe the goals of this care plan...">{{ old('goals') }}</textarea>

                    @error('goals')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Activities --}}

                <div class="form-group full">

                    <label>
                        Care Activities
                    </label>

                    <textarea name="activities"
                              class="form-control"
                              placeholder="List the activities and care tasks...">{{ old('activities') }}</textarea>

                    @error('activities')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- Notes --}}

                <div class="form-group full">

                    <label>
                        Additional Notes
                    </label>

                    <textarea name="notes"
                              class="form-control"
                              placeholder="Additional information...">{{ old('notes') }}</textarea>

                </div>

            </div>


            <div class="form-actions">

                <a href="{{ route('admin.care-plans.index') }}"
                   class="btn secondary">

                    <i class="fa-solid fa-arrow-left"></i>
                    Cancel

                </a>


                <button type="submit"
                        class="btn primary">

                    <i class="fa-solid fa-save"></i>
                    Save Care Plan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection