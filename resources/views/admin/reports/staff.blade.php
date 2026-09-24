@extends('layouts.admin')

@section('content')

<style>
    .report-page {
        max-width: 1450px;
        margin: auto;
        padding: 20px;
    }

    .header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        flex-wrap:wrap;
        gap:10px;
    }

    .header h1 {
        margin:0;
        font-size:25px;
        font-weight:800;
    }

    .actions a,
    .actions button {
        display:inline-block;
        padding:9px 14px;
        border:0;
        border-radius:7px;
        background:#111;
        color:#fff;
        text-decoration:none;
        cursor:pointer;
        font-size:12px;
        font-weight:700;
    }

    .actions button {
        background:#f4c400;
        color:#111;
    }

    .summary {
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:12px;
        margin-bottom:20px;
    }

    .box {
        background:#fff;
        border:1px solid #eee;
        border-top:4px solid #f4c400;
        padding:18px;
        border-radius:9px;
        text-align:center;
    }

    .box strong {
        display:block;
        font-size:25px;
    }

    .box span {
        color:#777;
        font-size:12px;
    }

    .staff-section {
        background:#fff;
        border:1px solid #eee;
        border-radius:10px;
        margin-bottom:20px;
        overflow:hidden;
    }

    .section-header {
        background:#111;
        color:#fff;
        padding:13px 16px;
        font-weight:800;
        font-size:14px;
    }

    .table-responsive {
        overflow-x:auto;
    }

    table {
        width:100%;
        border-collapse:collapse;
        min-width:700px;
    }

    th {
        background:#f4c400;
        color:#111;
        padding:10px;
        text-align:left;
        font-size:11px;
    }

    td {
        padding:10px;
        border-bottom:1px solid #eee;
        font-size:12px;
    }

    .badge {
        background:#111;
        color:#fff;
        padding:4px 8px;
        border-radius:15px;
        font-size:10px;
    }

    @media(max-width:800px) {
        .summary {
            grid-template-columns:repeat(2,1fr);
        }
    }

    @media(max-width:500px) {
        .summary {
            grid-template-columns:1fr;
        }
    }

    @media print {
        .actions,
        .sidebar,
        .navbar {
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
            <i class="fa-solid fa-users"></i>
            Staff Report
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
            <strong>{{ $totalStaff }}</strong>
            <span>Total Staff</span>
        </div>

        <div class="box">
            <strong>{{ $totalCaregivers }}</strong>
            <span>Caregivers</span>
        </div>

        <div class="box">
            <strong>{{ $totalHealthcare }}</strong>
            <span>Healthcare</span>
        </div>

        <div class="box">
            <strong>{{ $totalManagers }}</strong>
            <span>Managers</span>
        </div>

    </div>


    {{-- CAREGIVERS --}}

    <div class="staff-section">

        <div class="section-header">
            <i class="fa-solid fa-user-nurse"></i>
            Caregivers
        </div>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>Staff Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Phone</th>
                        <th>Joining Date</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($caregivers as $staff)

                        <tr>
                            <td>{{ $staff->staff_code ?? '-' }}</td>
                            <td>{{ $staff->user_name ?? '-' }}</td>
                            <td>{{ $staff->email ?? '-' }}</td>
                            <td>{{ $staff->nic ?? '-' }}</td>
                            <td>{{ $staff->phone ?? '-' }}</td>
                            <td>
                                {{ $staff->joining_date
                                    ? \Carbon\Carbon::parse($staff->joining_date)->format('d M Y')
                                    : '-' }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" style="text-align:center;">
                                No caregivers found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- HEALTHCARE --}}

    <div class="staff-section">

        <div class="section-header">
            <i class="fa-solid fa-user-doctor"></i>
            Healthcare Staff
        </div>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Phone</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($healthcare as $staff)

                        <tr>
                            <td>{{ $staff->user_name ?? '-' }}</td>
                            <td>{{ $staff->email ?? '-' }}</td>
                            <td>{{ $staff->nic ?? '-' }}</td>
                            <td>{{ $staff->phone ?? '-' }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" style="text-align:center;">
                                No healthcare staff found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- MANAGERS --}}

    <div class="staff-section">

        <div class="section-header">
            <i class="fa-solid fa-user-tie"></i>
            Managers
        </div>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Phone</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($managers as $staff)

                        <tr>
                            <td>{{ $staff->user_name ?? '-' }}</td>
                            <td>{{ $staff->email ?? '-' }}</td>
                            <td>{{ $staff->nic ?? '-' }}</td>
                            <td>{{ $staff->phone ?? '-' }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" style="text-align:center;">
                                No managers found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection