@extends('layouts.admin')

@section('title', 'Care Plans')

@section('content')

<style>
    .care-plan-page {
        padding: 25px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 28px;
        color: #222;
    }

    .page-header p {
        margin: 6px 0 0;
        color: #777;
    }

    .btn-add {
        background: #f4c430;
        color: #222;
        padding: 11px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-add:hover {
        background: #dcae16;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 9px;
        background: #fff3c4;
        color: #b48a00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-info h3 {
        margin: 0;
        font-size: 22px;
    }

    .stat-info span {
        font-size: 12px;
        color: #777;
    }

    .filter-card,
    .table-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        margin-bottom: 25px;
    }

    .filter-card {
        padding: 20px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 12px;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 11px;
        border: 1px solid #ddd;
        border-radius: 7px;
        outline: none;
    }

    .form-control:focus {
        border-color: #f4c430;
    }

    .btn-filter {
        background: #222;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 7px;
        cursor: pointer;
    }

    .table-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
    }

    .table-header h3 {
        margin: 0;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .care-plan-table {
        width: 100%;
        border-collapse: collapse;
    }

    .care-plan-table th,
    .care-plan-table td {
        padding: 14px;
        border-bottom: 1px solid #eee;
        text-align: left;
        white-space: nowrap;
    }

    .care-plan-table th {
        background: #fafafa;
        color: #555;
        font-size: 12px;
        text-transform: uppercase;
    }

    .care-plan-table tbody tr:hover {
        background: #fffdf3;
    }

    .elder-name {
        font-weight: 600;
    }

    .caregiver-name {
        font-size: 12px;
        color: #888;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
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

    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }

    .view {
        background: #e8f1ff;
        color: #2563eb;
    }

    .edit {
        background: #fff3cd;
        color: #856404;
    }

    .delete {
        background: #f8d7da;
        color: #dc3545;
    }

    .alert-success,
    .alert-danger {
        padding: 12px 15px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }

    @media(max-width:1100px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .filter-form {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width:700px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>

<div class="care-plan-page">

    <div class="page-header">

        <div>
            <h1>
                <i class="fa-solid fa-notes-medical"></i>
                Care Plans
            </h1>

            <p>
                Manage personalized care plans for elders
            </p>
        </div>

        <a href="{{ route('admin.care-plans.create') }}"
           class="btn-add">

            <i class="fa-solid fa-plus"></i>
            Create Care Plan

        </a>

    </div>


    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif


    {{-- Statistics --}}

    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-notes-medical"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $totalCarePlans }}</h3>
                <span>Total Plans</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $activeCarePlans }}</h3>
                <span>Active</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-file-pen"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $draftCarePlans }}</h3>
                <span>Draft</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $completedCarePlans }}</h3>
                <span>Completed</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $highPriorityPlans }}</h3>
                <span>High Priority</span>
            </div>
        </div>

    </div>


    {{-- Filters --}}

    <div class="filter-card">

        <form method="GET"
              action="{{ route('admin.care-plans.index') }}"
              class="filter-form">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search care plans or elders..."
                   value="{{ request('search') }}">


            <select name="priority"
                    class="form-control">

                <option value="">
                    All Priorities
                </option>

                <option value="low"
                    {{ request('priority') == 'low' ? 'selected' : '' }}>
                    Low
                </option>

                <option value="medium"
                    {{ request('priority') == 'medium' ? 'selected' : '' }}>
                    Medium
                </option>

                <option value="high"
                    {{ request('priority') == 'high' ? 'selected' : '' }}>
                    High
                </option>

                <option value="critical"
                    {{ request('priority') == 'critical' ? 'selected' : '' }}>
                    Critical
                </option>

            </select>


            <select name="status"
                    class="form-control">

                <option value="">
                    All Status
                </option>

                <option value="draft">Draft</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>

            </select>


            <button type="submit"
                    class="btn-filter">

                <i class="fa-solid fa-filter"></i>
                Filter

            </button>

        </form>

    </div>


    {{-- Table --}}

    <div class="table-card">

        <div class="table-header">

            <h3>
                <i class="fa-solid fa-list"></i>
                Care Plan Records
            </h3>

            <span>
                {{ $carePlans->total() }} records
            </span>

        </div>


        <div class="table-responsive">

            <table class="care-plan-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Elder</th>
                        <th>Care Plan</th>
                        <th>Caregiver</th>
                        <th>Start Date</th>
                        <th>Review Date</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($carePlans as $carePlan)

                        <tr>

                            <td>
                                {{ $carePlans->firstItem() + $loop->index }}
                            </td>


                            <td>

                                <div class="elder-name">
                                    {{ $carePlan->elder->name ?? 'N/A' }}
                                </div>

                            </td>


                            <td>
                                {{ $carePlan->title }}
                            </td>


                            <td>

                                <div class="caregiver-name">

                                    {{ $carePlan->caregiver->user->name
                                        ?? 'Not Assigned'
                                    }}

                                </div>

                            </td>


                            <td>

                                {{ $carePlan->start_date
                                    ? $carePlan->start_date->format('d M Y')
                                    : '--'
                                }}

                            </td>


                            <td>

                                {{ $carePlan->review_date
                                    ? $carePlan->review_date->format('d M Y')
                                    : '--'
                                }}

                            </td>


                            <td>

                                <span class="badge {{ $carePlan->priority }}">
                                    {{ ucfirst($carePlan->priority) }}
                                </span>

                            </td>


                            <td>

                                <span class="badge {{ $carePlan->status }}">
                                    {{ ucfirst($carePlan->status) }}
                                </span>

                            </td>


                            <td>

                                <div class="action-buttons">

                                    <a href="{{ route('admin.care-plans.show', $carePlan->id) }}"
                                       class="action-btn view"
                                       title="View">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>


                                    <a href="{{ route('admin.care-plans.edit', $carePlan->id) }}"
                                       class="action-btn edit"
                                       title="Edit">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>


                                    <form action="{{ route('admin.care-plans.destroy', $carePlan->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this care plan?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn delete">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                style="text-align:center;padding:40px;color:#888;">

                                <i class="fa-solid fa-notes-medical"
                                   style="font-size:35px;"></i>

                                <br><br>

                                No care plans found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div style="padding:18px;">
            {{ $carePlans->links() }}
        </div>

    </div>

</div>

@endsection