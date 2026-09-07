@extends('layouts.admin')

@section('title', 'Healthcare')

@section('content')

<div class="admin-page">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>👨‍⚕️ Healthcare</h1>
            <p>Manage healthcare staff and their account information.</p>
        </div>

        {{-- Permissions --}}
        @php
            $canCreate = false;
            $canView = false;
            $canEdit = false;
            $canDelete = false;

            foreach($menus as $menu) {
                if($menu->id == 4) {

                    foreach($menu->accesses as $access) {

                        if($access->role == $userRole) {

                            if($access->can_view) {
                                $canView = true;
                            }

                            if($access->can_create) {
                                $canCreate = true;
                            }

                            if($access->can_edit) {
                                $canEdit = true;
                            }

                            if($access->can_delete) {
                                $canDelete = true;
                            }

                        }
                    }
                }
            }
        @endphp

        @if($canCreate)
            <a href="{{ route('admin.healthcare.create') }}"
               class="btn btn-primary">
                <i class="fa-solid fa-plus"></i>
                Add Healthcare
            </a>
        @endif
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif


    {{-- Statistics --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-doctor"></i>
            </div>

            <div>
                <span>Total Healthcare</span>
                <h3>{{ $totalHealthcare }}</h3>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div>
                <span>Active</span>
                <h3>{{ $activeHealthcare }}</h3>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-xmark"></i>
            </div>

            <div>
                <span>Inactive</span>
                <h3>{{ $inactiveHealthcare }}</h3>
            </div>
        </div>

    </div>


    {{-- Healthcare Table --}}
    <div class="content-card">

        {{-- Search --}}
        <form method="GET"
              action="{{ route('admin.healthcare.index') }}"
              class="filter-form">

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="search"
                    placeholder="Search by name, email, staff code..."
                    value="{{ request('search') }}"
                >

            </div>


            <select name="status">

                <option value="">All Status</option>

                <option value="active"
                    {{ request('status') === 'active' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="inactive"
                    {{ request('status') === 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>


            <button type="submit" class="btn btn-outline">
                <i class="fa-solid fa-filter"></i>
                Filter
            </button>


            <a href="{{ route('admin.healthcare.index') }}"
               class="btn btn-outline">
                <i class="fa-solid fa-rotate"></i>
                Reset
            </a>

        </form>


        {{-- Table --}}
        <div class="table-responsive">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>Healthcare Staff</th>
                        <th>Staff Code</th>
                        <th>Specialization</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($healthcare as $health)

                        <tr>

                            {{-- Staff --}}
                            <td>

                                <div class="user-cell">

                                    <div class="user-avatar">

                                        {{ strtoupper(
                                            substr(
                                                $health->user->name ?? 'N/A',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>

                                    <div>

                                        <strong>
                                            {{ $health->user->name ?? 'N/A' }}
                                        </strong>

                                        <br>

                                        <small style="color:#999;font-size:12px;">
                                            {{ $health->user->email ?? 'N/A' }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- Staff Code --}}
                            <td>
                                <strong>
                                    {{ $health->staff_code ?? '-' }}
                                </strong>
                            </td>


                            {{-- Specialization --}}
                            <td>
                                {{ $health->specialization ?? '-' }}
                            </td>


                            {{-- Phone --}}
                            <td>
                                {{ $health->phone ?? '-' }}
                            </td>


                            {{-- Status --}}
                            <td>

                                <span class="status-badge status-{{
                                    $health->user->status ?? 'inactive'
                                }}">

                                    {{ ucfirst(
                                        $health->user->status ?? 'Inactive'
                                    ) }}

                                </span>

                            </td>


                            {{-- Created --}}
                            <td>
                                {{
                                    $health->created_at
                                    ? \Carbon\Carbon::parse(
                                        $health->created_at
                                    )->format('d M Y')
                                    : '-'
                                }}
                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="action-buttons">

                                    @if($canView)

                                        <a href="{{ route(
                                            'admin.healthcare.show',
                                            $health->id
                                        ) }}"
                                           class="action-btn view"
                                           title="View">

                                            <i class="fa-solid fa-eye"></i>

                                        </a>

                                    @endif


                                    @if($canEdit)

                                        <a href="{{ route(
                                            'admin.healthcare.edit',
                                            $health->id
                                        ) }}"
                                           class="action-btn edit"
                                           title="Edit">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                    @endif


                                    @if($canDelete)

                                        <form
                                            action="{{ route(
                                                'admin.healthcare.destroy',
                                                $health->id
                                            ) }}"
                                            method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm(
                                                'Are you sure you want to delete this healthcare staff member?'
                                            )">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete"
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

                            <td colspan="7" class="empty-state">

                                <i class="fa-solid fa-user-doctor"></i>

                                <p>No healthcare staff found.</p>

                                @if($canCreate)

                                    <a
                                        href="{{ route(
                                            'admin.healthcare.create'
                                        ) }}"
                                        class="btn btn-primary"
                                        style="margin-top:10px;"
                                    >

                                        <i class="fa-solid fa-plus"></i>
                                        Add Healthcare

                                    </a>

                                @endif

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        <div class="pagination-wrapper">

            {{ $healthcare->links() }}

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

.stats-grid {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat-card {
    background:#fff;
    border-radius:12px;
    padding:20px;
    border:1px solid #eee;
    display:flex;
    align-items:center;
    gap:15px;
    transition:.3s;
}

.stat-card:hover {
    transform:translateY(-4px);
    box-shadow:0 8px 25px rgba(0,0,0,.06);
}

.stat-icon {
    width:50px;
    height:50px;
    border-radius:12px;
    background:#fff7e6;
    color:#ffbe33;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
}

.stat-card span {
    display:block;
    color:#999;
    font-size:12px;
    font-weight:500;
    text-transform:uppercase;
}

.stat-card h3 {
    font-size:24px;
    font-weight:700;
    color:#222831;
    margin:2px 0 0;
}

.filter-form {
    padding:20px;
    border-bottom:1px solid #eee;
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    align-items:center;
}

.search-box {
    display:flex;
    align-items:center;
    gap:10px;
    padding:0 15px;
    border:2px solid #e8e8e8;
    border-radius:8px;
    background:#fff;
    flex:1;
    min-width:200px;
    height:46px;
}

.search-box:focus-within {
    border-color:#ffbe33;
    box-shadow:0 0 0 4px rgba(255,190,51,.1);
}

.search-box i {
    color:#999;
}

.search-box input {
    border:none;
    padding:10px 0;
    font-size:14px;
    flex:1;
    background:transparent;
    outline:none;
}

.filter-form select {
    padding:10px 15px;
    border:2px solid #e8e8e8;
    border-radius:8px;
    font-size:14px;
    background:#fff;
    min-width:140px;
    height:46px;
}

.filter-form .btn {
    height:46px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:0 20px;
    font-size:13px;
    font-weight:600;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
}

.table-responsive {
    overflow-x:auto;
}

.admin-table {
    width:100%;
    border-collapse:collapse;
    min-width:850px;
}

.admin-table thead th {
    background:#f8f9fa;
    color:#666;
    font-size:12px;
    font-weight:600;
    text-transform:uppercase;
    padding:14px 16px;
    text-align:left;
    border-bottom:2px solid #eee;
}

.admin-table tbody td {
    padding:14px 16px;
    border-bottom:1px solid #f1f1f1;
    color:#555;
    font-size:14px;
    vertical-align:middle;
}

.admin-table tbody tr:hover {
    background:#fffbf0;
}

.text-center {
    text-align:center!important;
}

.user-cell {
    display:flex;
    align-items:center;
    gap:12px;
}

.user-avatar {
    width:36px;
    height:36px;
    border-radius:50%;
    background:#ffbe33;
    color:#222831;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:14px;
    font-weight:700;
}

.status-badge {
    display:inline-flex;
    padding:4px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status-active {
    background:#d4edda;
    color:#155724;
}

.status-inactive {
    background:#f8d7da;
    color:#721c24;
}

.action-buttons {
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
}

.action-btn {
    width:34px;
    height:34px;
    border-radius:8px;
    border:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    text-decoration:none;
}

.action-btn.view {
    background:#e8f4fd;
    color:#0c5460;
}

.action-btn.edit {
    background:#fff3cd;
    color:#856404;
}

.action-btn.delete {
    background:#f8d7da;
    color:#721c24;
}

.empty-state {
    text-align:center;
    padding:50px 20px!important;
    color:#999;
}

.empty-state i {
    font-size:48px;
    color:#ddd;
    display:block;
    margin-bottom:12px;
}

.pagination-wrapper {
    padding:15px 20px;
    border-top:1px solid #eee;
}

.pagination-wrapper .pagination {
    margin:0;
    justify-content:center;
}

@media(max-width:992px) {
    .stats-grid {
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:768px) {

    .stats-grid {
        grid-template-columns:1fr;
    }

    .filter-form {
        flex-direction:column;
    }

    .search-box,
    .filter-form select,
    .filter-form .btn {
        width:100%;
    }
}

</style>

@endpush