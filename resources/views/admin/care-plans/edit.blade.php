@extends('layouts.admin')

@section('title', 'Edit Care Plan')

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

    .current-info {
        background: #fff9df;
        border: 1px solid #f4c430;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 25px;
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
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 7px;
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
            <i class="fa-solid fa-pen-to-square"></i>
            Edit Care Plan
        </h1>

        <p>
            Update care plan information
        </p>

    </div>


    <div class="form-card">

        <div class="current-info">

            <strong>
                <i class="fa-solid fa-circle-info"></i>
                Editing:
            </strong>

            {{ $carePlan->title }}

        </div>


        <form method="POST"
              action="{{ route('admin.care-plans.update', $carePlan->id) }}">

            @csrf
            @method('PUT')


            <div class="section-title">

                <i class="fa-solid fa-heart-pulse"></i>

                Care Plan Information

            </div>


            <div class="form-grid">


                <div class="form-group">

                    <label>
                        Elder *
                    </label>

                    <select name="elder_id"
                            class="form-control"
                            required>

                        @foreach($elders as $elder)

                            <option value="{{ $elder->id }}"
                                {{ old(
                                    'elder_id',
                                    $carePlan->elder_id
                                ) == $elder->id ? 'selected' : '' }}>

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
                                {{ old(
                                    'caregiver_id',
                                    $carePlan->caregiver_id
                                ) == $caregiver->id ? 'selected' : '' }}>

                                {{ $caregiver->user->name ?? 'N/A' }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group full">

                    <label>
                        Care Plan Title *
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old(
                                'title',
                                $carePlan->title
                           ) }}"
                           required>

                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Start Date *
                    </label>

                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="{{ old(
                                'start_date',
                                $carePlan->start_date
                                    ? $carePlan->start_date->format('Y-m-d')
                                    : ''
                           ) }}"
                           required>

                </div>


                <div class="form-group">

                    <label>
                        Review Date
                    </label>

                    <input type="date"
                           name="review_date"
                           class="form-control"
                           value="{{ old(
                                'review_date',
                                $carePlan->review_date
                                    ? $carePlan->review_date->format('Y-m-d')
                                    : ''
                           ) }}">

                </div>


                <div class="form-group">

                    <label>
                        Priority *
                    </label>

                    <select name="priority"
                            class="form-control">

                        @foreach([
                            'low' => 'Low',
                            'medium' => 'Medium',
                            'high' => 'High',
                            'critical' => 'Critical'
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old(
                                    'priority',
                                    $carePlan->priority
                                ) == $value ? 'selected' : '' }}>

                                {{ $label }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Status *
                    </label>

                    <select name="status"
                            class="form-control">

                        @foreach([
                            'draft' => 'Draft',
                            'active' => 'Active',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled'
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old(
                                    'status',
                                    $carePlan->status
                                ) == $value ? 'selected' : '' }}>

                                {{ $label }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group full">

                    <label>
                        Care Needs
                    </label>

                    <textarea name="care_needs"
                              class="form-control">{{ old(
                                'care_needs',
                                $carePlan->care_needs
                              ) }}</textarea>

                </div>


                <div class="form-group full">

                    <label>
                        Care Goals
                    </label>

                    <textarea name="goals"
                              class="form-control">{{ old(
                                'goals',
                                $carePlan->goals
                              ) }}</textarea>

                </div>


                <div class="form-group full">

                    <label>
                        Care Activities
                    </label>

                    <textarea name="activities"
                              class="form-control">{{ old(
                                'activities',
                                $carePlan->activities
                              ) }}</textarea>

                </div>


                <div class="form-group full">

                    <label>
                        Additional Notes
                    </label>

                    <textarea name="notes"
                              class="form-control">{{ old(
                                'notes',
                                $carePlan->notes
                              ) }}</textarea>

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
                    Update Care Plan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection