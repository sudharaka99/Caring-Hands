@extends('layouts.admin')

@section('title', 'Care Plan Details')

@section('content')

<style>
    .care-plan-show {
        padding: 25px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .header h1 {
        margin: 0;
        color: #222;
    }

    .header p {
        color: #777;
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 7px;
        text-decoration: none;
        font-weight: 600;
    }

    .back {
        background: #eee;
        color: #333;
    }

    .edit {
        background: #f4c430;
        color: #222;
    }

    .details-card {
        max-width: 1000px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        overflow: hidden;
    }

    .top {
        padding: 25px;
        background: #fff9df;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .icon {
        width: 65px;
        height: 65px;
        background: #f4c430;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .top h2 {
        margin: 0;
    }

    .top p {
        margin: 5px 0 0;
        color: #777;
    }

    .body {
        padding: 25px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 20px;
    }

    .item {
        border-bottom: 1px solid #eee;
        padding-bottom: 14px;
    }

    .label {
        display: block;
        color: #888;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .value {
        font-weight: 600;
        color: #222;
    }

    .text-section {
        margin-top: 25px;
        padding: 18px;
        background: #fafafa;
        border-radius: 8px;
    }

    .text-section h4 {
        margin-top: 0;
    }

    .text-section p {
        color: #555;
        line-height: 1.7;
        white-space: pre-line;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .active {
        background: #d4edda;
        color: #155724;
    }

    .draft {
        background: #e2e3e5;
        color: #383d41;
    }

    .completed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .low {
        background: #d4edda;
        color: #155724;
    }

    .medium {
        background: #fff3cd;
        color: #856404;
    }

    .high {
        background: #ffe0b2;
        color: #8a4b00;
    }

    .critical {
        background: #f8d7da;
        color: #721c24;
    }

    @media(max-width:700px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="care-plan-show">

    <div class="header">

        <div>

            <h1>
                <i class="fa-solid fa-notes-medical"></i>
                Care Plan Details
            </h1>

            <p>
                View complete care plan information
            </p>

        </div>


        <div class="actions">

            <a href="{{ route('admin.care-plans.index') }}"
               class="btn back">

                <i class="fa-solid fa-arrow-left"></i>
                Back

            </a>


                @if(canAccess('admin.care-plans.index', 'can_edit'))
                     <a href="{{ route('admin.care-plans.edit', $carePlan->id) }}"
                         class="btn edit">

                <i class="fa-solid fa-pen"></i>
                Edit

                </a>
            @endif

        </div>

    </div>


    <div class="details-card">

        <div class="top">

            <div class="icon">
                <i class="fa-solid fa-notes-medical"></i>
            </div>

            <div>

                <h2>
                    {{ $carePlan->title }}
                </h2>

                <p>
                   {{ $carePlan->elder->name ?? 'N/A' }}
                </p>

            </div>

        </div>


        <div class="body">

            <div class="grid">


                <div class="item">

                    <span class="label">
                        Elder
                    </span>

                    <span class="value">

                        {{ $carePlan->elder->first_name ?? '' }}
                        {{ $carePlan->elder->last_name ?? '' }}

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Assigned Caregiver
                    </span>

                    <span class="value">

                        {{ $carePlan->caregiver->user->name
                            ?? 'Not Assigned'
                        }}

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Start Date
                    </span>

                    <span class="value">

                        {{ $carePlan->start_date
                            ? $carePlan->start_date->format('d F Y')
                            : 'N/A'
                        }}

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Review Date
                    </span>

                    <span class="value">

                        {{ $carePlan->review_date
                            ? $carePlan->review_date->format('d F Y')
                            : 'Not Set'
                        }}

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Priority
                    </span>

                    <span class="value">

                        <span class="badge {{ $carePlan->priority }}">
                            {{ ucfirst($carePlan->priority) }}
                        </span>

                    </span>

                </div>


                <div class="item">

                    <span class="label">
                        Status
                    </span>

                    <span class="value">

                        <span class="badge {{ $carePlan->status }}">
                            {{ ucfirst($carePlan->status) }}
                        </span>

                    </span>

                </div>

            </div>


            <div class="text-section">

                <h4>
                    <i class="fa-solid fa-heart-pulse"></i>
                    Care Needs
                </h4>

                <p>
                    {{ $carePlan->care_needs ?: 'No care needs specified.' }}
                </p>

            </div>


            <div class="text-section">

                <h4>
                    <i class="fa-solid fa-bullseye"></i>
                    Care Goals
                </h4>

                <p>
                    {{ $carePlan->goals ?: 'No goals specified.' }}
                </p>

            </div>


            <div class="text-section">

                <h4>
                    <i class="fa-solid fa-list-check"></i>
                    Care Activities
                </h4>

                <p>
                    {{ $carePlan->activities ?: 'No activities specified.' }}
                </p>

            </div>


            <div class="text-section">

                <h4>
                    <i class="fa-solid fa-note-sticky"></i>
                    Additional Notes
                </h4>

                <p>
                    {{ $carePlan->notes ?: 'No additional notes.' }}
                </p>

            </div>

        </div>

    </div>

</div>

@endsection