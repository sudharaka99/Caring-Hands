@extends('layouts.admin')

@section('content')

<style>
    .med-page {
        padding: 25px;
        background: #f7f7f7;
        min-height: 100vh;
    }

    .med-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
        flex-wrap: wrap;
    }

    .med-title h1 {
        margin: 0;
        color: #111;
        font-size: 28px;
        font-weight: 700;
    }

    .med-title p {
        margin: 5px 0 0;
        color: #777;
    }

    .btn-add {
        background: #f4c400;
        color: #111;
        padding: 12px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        background: #111;
        color: #fff;
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
        box-shadow: 0 3px 15px rgba(0,0,0,.07);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: #f4c400;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111;
        font-size: 22px;
    }

    .stat-card h3 {
        margin: 0;
        font-size: 24px;
        color: #111;
    }

    .stat-card span {
        color: #777;
        font-size: 13px;
    }

    .filter-card {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 3px 15px rgba(0,0,0,.06);
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
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
        border-color: #f4c400;
    }

    .btn-filter {
        border: none;
        background: #111;
        color: #fff;
        border-radius: 7px;
        padding: 11px 18px;
        cursor: pointer;
        font-weight: 600;
    }

    .table-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 15px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .med-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
    }

    .med-table th {
        background: #111;
        color: #fff;
        padding: 14px;
        text-align: left;
        font-size: 13px;
    }

    .med-table td {
        padding: 14px;
        border-bottom: 1px solid #eee;
        color: #333;
        font-size: 14px;
    }

    .med-table tr:hover {
        background: #fffbea;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
    }

    .badge-active {
        background: #d9f7df;
        color: #18752c;
    }

    .badge-completed {
        background: #dcecff;
        color: #175a9e;
    }

    .badge-stopped {
        background: #eee;
        color: #555;
    }

    .badge-cancelled {
        background: #ffdede;
        color: #a40000;
    }

    .actions {
        display: flex;
        gap: 7px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .view-btn {
        background: #e9f2ff;
        color: #1768b0;
    }

    .edit-btn {
        background: #fff4cc;
        color: #916d00;
    }

    .delete-btn {
        background: #ffe4e4;
        color: #b40000;
    }

    .pagination {
        padding: 18px;
    }

    .alert-success {
        background: #dff6e4;
        color: #176b2a;
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    @media(max-width: 1000px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-form {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width: 600px) {
        .med-page {
            padding: 15px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="med-page">

    <div class="med-header">
        <div class="med-title">
            <h1>
                <i class="fa-solid fa-pills"></i>
                Medication Management
            </h1>

            <p>Manage medicines and prescriptions for elders</p>
        </div>

        @if(canAccess('admin.medication.index', 'can_create'))
            <a href="{{ route('admin.medication.create') }}" class="btn-add">
                <i class="fa-solid fa-plus"></i>
                Add Medication
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-pills"></i>
            </div>

            <div>
                <h3>{{ $totalMedications }}</h3>
                <span>Total Medications</span>
                <small>All prescriptions</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h3>{{ $activeMedications }}</h3>
                <span>Active</span>
                <small>Currently active</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-flag-checkered"></i>
            </div>

            <div>
                <h3>{{ $completedMedications }}</h3>
                <span>Completed</span>
                <small>Completed courses</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-ban"></i>
            </div>

            <div>
                <h3>{{ $stoppedMedications }}</h3>
                <span>Stopped</span>
                <small>Stopped courses</small>
            </div>
        </div>

    </div>

    <div class="filter-card">

        <form method="GET"
              action="{{ route('admin.medication.index') }}"
              class="filter-form">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search medicine, elder, code, NIC..."
                value="{{ request('search') }}"
            >

            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                    Completed
                </option>
                <option value="stopped" {{ request('status') == 'stopped' ? 'selected' : '' }}>
                    Stopped
                </option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>
            </select>

            <select name="route" class="form-control">
                <option value="">All Routes</option>
                <option value="oral" {{ request('route') == 'oral' ? 'selected' : '' }}>
                    Oral
                </option>
                <option value="injection" {{ request('route') == 'injection' ? 'selected' : '' }}>
                    Injection
                </option>
                <option value="topical" {{ request('route') == 'topical' ? 'selected' : '' }}>
                    Topical
                </option>
                <option value="inhalation" {{ request('route') == 'inhalation' ? 'selected' : '' }}>
                    Inhalation
                </option>
                <option value="eye" {{ request('route') == 'eye' ? 'selected' : '' }}>
                    Eye
                </option>
                <option value="ear" {{ request('route') == 'ear' ? 'selected' : '' }}>
                    Ear
                </option>
                <option value="other" {{ request('route') == 'other' ? 'selected' : '' }}>
                    Other
                </option>
            </select>

            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-filter"></i>
                Filter
            </button>

        </form>

    </div>

    <div class="table-card">

        <div class="table-wrapper">

            <table class="med-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Medicine</th>
                        <th>Elder</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Time</th>
                        <th>Route</th>
                        <th>Start Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($medications as $medication)

                        <tr>

                            <td>
                                {{ $medications->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $medication->medication_name }}
                                </strong>

                                @if($medication->generic_name)
                                    <br>
                                    <small>
                                        {{ $medication->generic_name }}
                                    </small>
                                @endif
                            </td>

                            <td>
                                {{ $medication->elder->name ?? 'N/A' }}

                                @if($medication->elder && $medication->elder->elder_code)
                                    <br>
                                    <small>
                                        {{ $medication->elder->elder_code }}
                                    </small>
                                @endif
                            </td>

                            <td>
                                {{ $medication->dosage }}
                                {{ $medication->dosage_unit }}
                            </td>

                            <td>
                                {{ ucwords(str_replace('_', ' ', $medication->frequency)) }}
                            </td>

                            <td>
                                {{ $medication->administration_time
                                    ? \Carbon\Carbon::parse($medication->administration_time)->format('h:i A')
                                    : '-' }}
                            </td>

                            <td>
                                {{ ucfirst($medication->route) }}
                            </td>

                            <td>
                                {{ $medication->start_date
                                    ? $medication->start_date->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>

                                @if($medication->status === 'active')
                                    <span class="badge badge-active">
                                        Active
                                    </span>
                                @elseif($medication->status === 'completed')
                                    <span class="badge badge-completed">
                                        Completed
                                    </span>
                                @elseif($medication->status === 'stopped')
                                    <span class="badge badge-stopped">
                                        Stopped
                                    </span>
                                @else
                                    <span class="badge badge-cancelled">
                                        Cancelled
                                    </span>
                                @endif

                            </td>

                            <td>

                                <div class="actions">

                                    @if(canAccess('admin.medication.index', 'can_view'))
                                        <a href="{{ route('admin.medication.show', $medication->id) }}"
                                           class="action-btn view-btn"
                                           title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    @endif

                                    @if(canAccess('admin.medication.index', 'can_edit'))
                                        <a href="{{ route('admin.medication.edit', $medication->id) }}"
                                           class="action-btn edit-btn"
                                           title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endif

                                    @if(canAccess('admin.medication.index', 'can_delete'))
                                        <form action="{{ route('admin.medication.destroy', $medication->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this medication?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn delete-btn"
                                                title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                        </form>
                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" style="text-align:center;padding:40px;">
                                <i class="fa-solid fa-pills"
                                   style="font-size:40px;color:#f4c400;"></i>

                                <p>No medications found.</p>

                                @if(canAccess('admin.medication.index', 'can_create'))
                                    <a href="{{ route('admin.medication.create') }}"
                                       class="btn-add">
                                        Add First Medication
                                    </a>
                                @endif
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="pagination">
            {{ $medications->links() }}
        </div>

    </div>

</div>

@endsection