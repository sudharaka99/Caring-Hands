@extends('layouts.admin')

@section('content')

<style>
    .report-page {
        max-width: 1450px;
        margin: auto;
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 25px;
        font-weight: 800;
        color: #111;
    }

    .back-btn,
    .print-btn {
        background: #111;
        color: #fff;
        padding: 9px 14px;
        border-radius: 7px;
        text-decoration: none;
        border: 0;
        cursor: pointer;
        font-size: 12px;
        font-weight: 700;
    }

    .back-btn:hover,
    .print-btn:hover {
        color: #fff;
        background: #333;
    }

    .summary {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        margin-bottom: 18px;
    }

    .summary-box {
        background: #fff;
        border: 1px solid #eee;
        border-top: 4px solid #f4c400;
        border-radius: 9px;
        padding: 13px;
        text-align: center;
    }

    .summary-box strong {
        display: block;
        font-size: 22px;
        color: #111;
    }

    .summary-box span {
        color: #777;
        font-size: 11px;
    }

    .filter-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 18px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto auto;
        gap: 10px;
        align-items: end;
    }

    .field label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .field input,
    .field select {
        width: 100%;
        padding: 9px 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 12px;
        background: #fff;
    }

    .filter-btn {
        background: #f4c400;
        color: #111;
        border: 0;
        padding: 10px 14px;
        border-radius: 6px;
        font-weight: 800;
        cursor: pointer;
    }

    .clear-btn {
        background: #eee;
        color: #111;
        padding: 10px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .table-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    th {
        background: #111;
        color: #fff;
        padding: 11px;
        text-align: left;
        font-size: 11px;
    }

    td {
        padding: 10px 11px;
        border-bottom: 1px solid #eee;
        font-size: 12px;
    }

    .badge {
        display: inline-block;
        background: #f4c400;
        color: #111;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
    }

    .pagination {
        padding: 15px;
    }

    @media(max-width:1100px) {
        .summary {
            grid-template-columns: repeat(3, 1fr);
        }

        .filter-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media(max-width:650px) {
        .summary {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }
    }

    @media print {
        .filter-card,
        .back-btn,
        .print-btn,
        .sidebar,
        .navbar,
        .pagination {
            display: none !important;
        }

        .report-page {
            padding: 0;
            max-width: 100%;
        }
    }
</style>

<div class="report-page">

    <div class="page-header">

        <div>
            <h1>
                <i class="fa-solid fa-person-cane"></i>
                Elder Report
            </h1>
        </div>

        <div>
            <a href="{{ route('admin.reports.index') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Reports
            </a>

            <button onclick="window.print()" class="print-btn">
                <i class="fa-solid fa-print"></i>
                Print
            </button>
        </div>

    </div>


    <div class="summary">

        <div class="summary-box">
            <strong>{{ $total }}</strong>
            <span>Total</span>
        </div>

        <div class="summary-box">
            <strong>{{ $active }}</strong>
            <span>Active</span>
        </div>

        <div class="summary-box">
            <strong>{{ $inactive }}</strong>
            <span>Inactive</span>
        </div>

        <div class="summary-box">
            <strong>{{ $male }}</strong>
            <span>Male</span>
        </div>

        <div class="summary-box">
            <strong>{{ $female }}</strong>
            <span>Female</span>
        </div>

        <div class="summary-box">
            <strong>{{ $other }}</strong>
            <span>Other</span>
        </div>

    </div>


    <div class="filter-card">

        <form method="GET">

            <div class="filter-grid">

                <div class="field">
                    <label>Search</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Name, code, NIC..."
                    >
                </div>

                <div class="field">
                    <label>Status</label>

                    <select name="status">
                        <option value="">All</option>
                        <option value="active"
                            {{ request('status') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="inactive"
                            {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label>Gender</label>

                    <select name="gender">
                        <option value="">All</option>
                        <option value="male"
                            {{ request('gender') == 'male' ? 'selected' : '' }}>
                            Male
                        </option>
                        <option value="female"
                            {{ request('gender') == 'female' ? 'selected' : '' }}>
                            Female
                        </option>
                        <option value="other"
                            {{ request('gender') == 'other' ? 'selected' : '' }}>
                            Other
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label>From</label>
                    <input
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                    >
                </div>

                <div class="field">
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

                <a href="{{ route('admin.reports.elders') }}"
                   class="clear-btn">
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
                        <th>Code</th>
                        <th>Name</th>
                        <th>NIC</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Blood Group</th>
                        <th>Admission</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($elders as $elder)

                        <tr>

                            <td>{{ $elder->elder_code ?? '-' }}</td>

                            <td>
                                <strong>{{ $elder->name }}</strong>
                            </td>

                            <td>{{ $elder->nic ?? '-' }}</td>

                            <td>
                                {{ ucfirst($elder->gender ?? '-') }}
                            </td>

                            <td>{{ $elder->age ?? '-' }}</td>

                            <td>{{ $elder->blood_group ?? '-' }}</td>

                            <td>
                                {{ $elder->admission_date
                                    ? \Carbon\Carbon::parse($elder->admission_date)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>
                                <span class="badge">
                                    {{ ucfirst($elder->status ?? '-') }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" style="text-align:center;">
                                No elder records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="pagination">
            {{ $elders->links() }}
        </div>

    </div>

</div>

@endsection