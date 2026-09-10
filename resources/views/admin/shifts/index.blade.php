@extends('layouts.admin')

@section('title', 'Shift Management')

@section('content')

<style>
    .shift-page {
        padding: 25px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
    }

    .page-title h1 {
        margin: 0;
        font-size: 28px;
        color: #222;
        font-weight: 700;
    }

    .page-title p {
        margin: 6px 0 0;
        color: #777;
        font-size: 14px;
    }

    .btn-add {
        background: #f4c430;
        color: #222;
        padding: 11px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: .2s;
    }

    .btn-add:hover {
        background: #dcae16;
        color: #111;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: #fff3c4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b48a00;
        font-size: 22px;
    }

    .stat-info h3 {
        margin: 0;
        font-size: 24px;
        color: #222;
    }

    .stat-info span {
        color: #777;
        font-size: 13px;
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
        grid-template-columns: 2fr 1fr auto;
        gap: 12px;
    }

    .form-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #ddd;
        border-radius: 7px;
        outline: none;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #f4c430;
        box-shadow: 0 0 0 2px rgba(244,196,48,.15);
    }

    .btn-filter {
        background: #222;
        color: #fff;
        border: none;
        border-radius: 7px;
        padding: 10px 18px;
        cursor: pointer;
    }

    .btn-filter:hover {
        background: #000;
    }

    .table-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h3 {
        margin: 0;
        font-size: 18px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .shift-table {
        width: 100%;
        border-collapse: collapse;
    }

    .shift-table th,
    .shift-table td {
        padding: 14px 15px;
        border-bottom: 1px solid #eee;
        text-align: left;
        white-space: nowrap;
    }

    .shift-table th {
        background: #fafafa;
        color: #555;
        font-size: 13px;
        text-transform: uppercase;
    }

    .shift-table td {
        font-size: 14px;
        color: #333;
    }

    .shift-table tbody tr:hover {
        background: #fffdf3;
    }

    .staff-name {
        font-weight: 600;
    }

    .staff-role {
        font-size: 12px;
        color: #888;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-scheduled {
        background: #fff3cd;
        color: #856404;
    }

    .badge-active {
        background: #d4edda;
        color: #155724;
    }

    .badge-completed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-absent {
        background: #e2e3e5;
        color: #383d41;
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
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background: #e8f1ff;
        color: #2563eb;
    }

    .btn-edit {
        background: #fff3cd;
        color: #856404;
    }

    .btn-delete {
        background: #f8d7da;
        color: #dc3545;
    }

    .pagination-wrapper {
        padding: 18px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 12px 15px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        padding: 12px 15px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    @media(max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-form {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 600px) {
        .shift-page {
            padding: 15px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="shift-page">

    {{-- Header --}}
    <div class="page-header">

        <div class="page-title">
            <h1>
                <i class="fa-solid fa-calendar-days"></i>
                Shift Management
            </h1>

            <p>
                Manage staff shifts and schedules
            </p>
        </div>

        <a href="{{ route('admin.shifts.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i>
            Add Shift
        </a>

    </div>


    {{-- Messages --}}
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
                <i class="fa-solid fa-calendar-days"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $totalShifts ?? 0 }}</h3>
                <span>Total Shifts</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $scheduledShifts ?? 0 }}</h3>
                <span>Scheduled</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-person-running"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $activeShifts ?? 0 }}</h3>
                <span>Active</span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="stat-info">
                <h3>{{ $completedShifts ?? 0 }}</h3>
                <span>Completed</span>
            </div>
        </div>

    </div>


    {{-- Filters --}}
    <div class="filter-card">

        <form action="{{ route('admin.shifts.index') }}"
              method="GET"
              class="filter-form">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search staff or shift..."
                   value="{{ request('search') }}">

            <input type="date"
                   name="shift_date"
                   class="form-control"
                   value="{{ request('shift_date') }}">

            <button type="submit" class="btn-filter">
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
                Shift Schedule
            </h3>

            <span>
                {{ $shifts->total() ?? 0 }} records
            </span>

        </div>


        <div class="table-responsive">

            <table class="shift-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff</th>
                        <th>Shift</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($shifts as $shift)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="staff-name">
                                    {{ $shift->user->name ?? 'N/A' }}
                                </div>

                                <div class="staff-role">
                                    {{ ucfirst($shift->user->role ?? '') }}
                                </div>
                            </td>

                            <td>
                                <strong>
                                    {{ $shift->shiftType->name ?? 'N/A' }}
                                </strong>
                            </td>

                            <td>
                                {{ $shift->shift_date
                                    ? \Carbon\Carbon::parse($shift->shift_date)->format('d M Y')
                                    : 'N/A'
                                }}
                            </td>

                            <td>
                                {{ $shift->start_time
                                    ? \Carbon\Carbon::parse($shift->start_time)->format('h:i A')
                                    : '--'
                                }}
                                -
                                {{ $shift->end_time
                                    ? \Carbon\Carbon::parse($shift->end_time)->format('h:i A')
                                    : '--'
                                }}
                            </td>

                            <td>

                                @php
                                    $statusClass = match($shift->status) {
                                        'scheduled' => 'badge-scheduled',
                                        'active' => 'badge-active',
                                        'completed' => 'badge-completed',
                                        'cancelled' => 'badge-cancelled',
                                        'absent' => 'badge-absent',
                                        default => 'badge-scheduled'
                                    };
                                @endphp

                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($shift->status) }}
                                </span>

                            </td>

                            <td>

                                <div class="action-buttons">

                                    <a href="{{ route('admin.shifts.show', $shift->id) }}"
                                       class="action-btn btn-view"
                                       title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.shifts.edit', $shift->id) }}"
                                       class="action-btn btn-edit"
                                       title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.shifts.destroy', $shift->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this shift?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn btn-delete"
                                                title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                style="text-align:center;padding:40px;color:#888;">

                                <i class="fa-solid fa-calendar-xmark"
                                   style="font-size:35px;margin-bottom:10px;"></i>

                                <br>

                                No shifts found.

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if(isset($shifts) && $shifts->hasPages())

            <div class="pagination-wrapper">
                {{ $shifts->links() }}
            </div>

        @endif

    </div>

</div>

@endsection