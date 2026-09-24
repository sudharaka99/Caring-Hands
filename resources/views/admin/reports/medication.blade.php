@extends('layouts.admin')

@section('content')

<style>
    .report-page {
        max-width:1450px;
        margin:auto;
        padding:20px;
    }

    .header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        flex-wrap:wrap;
        gap:10px;
    }

    h1 {
        margin:0;
        font-size:25px;
        font-weight:800;
    }

    .actions a,
    .actions button {
        padding:9px 14px;
        border:0;
        border-radius:7px;
        background:#111;
        color:#fff;
        text-decoration:none;
        font-size:12px;
        font-weight:700;
        cursor:pointer;
    }

    .actions button {
        background:#f4c400;
        color:#111;
    }

    .summary {
        display:grid;
        grid-template-columns:repeat(7,1fr);
        gap:9px;
        margin-bottom:18px;
    }

    .box {
        background:#fff;
        border:1px solid #eee;
        border-top:4px solid #f4c400;
        border-radius:8px;
        padding:12px;
        text-align:center;
    }

    .box strong {
        display:block;
        font-size:20px;
    }

    .box span {
        color:#777;
        font-size:10px;
    }

    .filter-card {
        background:#fff;
        border:1px solid #eee;
        border-radius:9px;
        padding:15px;
        margin-bottom:18px;
    }

    .filters {
        display:grid;
        grid-template-columns:2fr 1fr 1fr 1fr 1fr auto auto;
        gap:10px;
        align-items:end;
    }

    label {
        display:block;
        font-size:11px;
        font-weight:700;
        margin-bottom:5px;
    }

    input,
    select {
        width:100%;
        padding:9px;
        border:1px solid #ddd;
        border-radius:6px;
        font-size:12px;
    }

    .filter-btn {
        background:#f4c400;
        border:0;
        padding:10px 14px;
        border-radius:6px;
        font-weight:800;
    }

    .clear-btn {
        background:#eee;
        color:#111;
        padding:10px 14px;
        border-radius:6px;
        text-decoration:none;
        font-size:12px;
        font-weight:700;
    }

    .table-card {
        background:#fff;
        border:1px solid #eee;
        border-radius:9px;
        overflow:hidden;
    }

    .table-responsive {
        overflow-x:auto;
    }

    table {
        width:100%;
        min-width:1100px;
        border-collapse:collapse;
    }

    th {
        background:#111;
        color:#fff;
        padding:11px;
        font-size:11px;
        text-align:left;
    }

    td {
        padding:10px;
        border-bottom:1px solid #eee;
        font-size:12px;
    }

    .badge {
        background:#f4c400;
        color:#111;
        padding:4px 8px;
        border-radius:15px;
        font-size:10px;
        font-weight:800;
    }

    .pagination {
        padding:15px;
    }

    @media(max-width:1100px) {
        .summary {
            grid-template-columns:repeat(4,1fr);
        }

        .filters {
            grid-template-columns:repeat(3,1fr);
        }
    }

    @media(max-width:600px) {
        .summary {
            grid-template-columns:repeat(2,1fr);
        }

        .filters {
            grid-template-columns:1fr;
        }
    }

    @media print {
        .filter-card,
        .actions,
        .sidebar,
        .navbar,
        .pagination {
            display:none !important;
        }

        .report-page {
            padding:0;
            max-width:100%;
        }
    }
</style>

<div class="report-page">

    <div class="header">

        <h1>
            <i class="fa-solid fa-pills"></i>
            Medication Report
        </h1>

        <div class="actions">

            <a href="{{ route('admin.reports.index') }}">
                <i class="fa-solid fa-arrow-left"></i>
                Reports
            </a>

            <button onclick="window.print()">
                <i class="fa-solid fa-print"></i>
                Print
            </button>

        </div>

    </div>


    <div class="summary">

        <div class="box">
            <strong>{{ $total }}</strong>
            <span>Total</span>
        </div>

        <div class="box">
            <strong>{{ $active }}</strong>
            <span>Active</span>
        </div>

        <div class="box">
            <strong>{{ $completed }}</strong>
            <span>Completed</span>
        </div>

        <div class="box">
            <strong>{{ $stopped }}</strong>
            <span>Stopped</span>
        </div>

        <div class="box">
            <strong>{{ $cancelled }}</strong>
            <span>Cancelled</span>
        </div>

        <div class="box">
            <strong>{{ $given }}</strong>
            <span>Given</span>
        </div>

        <div class="box">
            <strong>{{ $missed }}</strong>
            <span>Missed</span>
        </div>

    </div>


    <div class="filter-card">

        <form method="GET">

            <div class="filters">

                <div>
                    <label>Search</label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Medication / Elder..."
                    >
                </div>

                <div>
                    <label>Status</label>

                    <select name="status">

                        <option value="">All</option>

                        <option value="active"
                            {{ request('status') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="completed"
                            {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="stopped"
                            {{ request('status') == 'stopped' ? 'selected' : '' }}>
                            Stopped
                        </option>

                        <option value="cancelled"
                            {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>
                </div>

                <div>
                    <label>Route</label>

                    <select name="route">

                        <option value="">All</option>

                        <option value="oral">Oral</option>
                        <option value="injection">Injection</option>
                        <option value="topical">Topical</option>
                        <option value="inhalation">Inhalation</option>
                        <option value="eye">Eye</option>
                        <option value="ear">Ear</option>
                        <option value="other">Other</option>

                    </select>
                </div>

                <div>
                    <label>From</label>

                    <input
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                    >
                </div>

                <div>
                    <label>To</label>

                    <input
                        type="date"
                        name="to_date"
                        value="{{ request('to_date') }}"
                    >
                </div>

                <button class="filter-btn">
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>

                <a
                    href="{{ route('admin.reports.medication') }}"
                    class="clear-btn"
                >
                    Clear
                </a>

            </div>

        </form>

    </div>


    <div class="table-card">

        <div class="table-responsive">

            <table>

                <thead>

                    <tr>
                        <th>Elder</th>
                        <th>Medication</th>
                        <th>Generic Name</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Route</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Prescribed By</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($medications as $medication)

                        <tr>

                            <td>
                                {{ $medication->elder->name ?? 'N/A' }}
                            </td>

                            <td>
                                <strong>
                                    {{ $medication->medication_name }}
                                </strong>
                            </td>

                            <td>
                                {{ $medication->generic_name ?? '-' }}
                            </td>

                            <td>
                                {{ $medication->dosage }}
                                {{ $medication->dosage_unit ?? '' }}
                            </td>

                            <td>
                                {{ ucwords(str_replace('_', ' ', $medication->frequency)) }}
                            </td>

                            <td>
                                {{ ucfirst($medication->route) }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($medication->start_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ $medication->end_date
                                    ? \Carbon\Carbon::parse($medication->end_date)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $medication->prescribed_by ?? '-' }}
                            </td>

                            <td>
                                <span class="badge">
                                    {{ ucfirst($medication->status) }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" style="text-align:center;">
                                No medications found.
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