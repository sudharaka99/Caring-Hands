@extends('layouts.admin')

@section('title', 'Managers')

@section('content')

<div class="admin-page">

    <div class="page-header">

        <div>
            <h1>
                <i class="fa-solid fa-user-tie"></i>
                Managers
            </h1>

            <p>Manage managers and their account information.</p>
        </div>


        @php

            $canCreate = false;
            $canView = false;
            $canEdit = false;
            $canDelete = false;

            foreach($menus as $menu) {

                /*
                 * CHANGE 5 TO YOUR ACTUAL MANAGERS MENU ID
                 */
                if($menu->id == 5) {

                    foreach($menu->accesses as $access) {

                        if($access->role == $userRole) {

                            if($access->can_view)
                                $canView = true;

                            if($access->can_create)
                                $canCreate = true;

                            if($access->can_edit)
                                $canEdit = true;

                            if($access->can_delete)
                                $canDelete = true;
                        }
                    }
                }
            }

        @endphp


        @if($canCreate)

            <a
                href="{{ route('admin.managers.create') }}"
                class="btn btn-primary"
            >

                <i class="fa-solid fa-plus"></i>

                Add Manager

            </a>

        @endif

    </div>


    @if(session('success'))

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif


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
                <i class="fa-solid fa-user-tie"></i>
            </div>

            <div>

                <span>Total Managers</span>

                <h3>
                    {{ $totalManagers }}
                </h3>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div>

                <span>Active</span>

                <h3>
                    {{ $activeManagers }}
                </h3>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-user-xmark"></i>
            </div>

            <div>

                <span>Inactive</span>

                <h3>
                    {{ $inactiveManagers }}
                </h3>

            </div>

        </div>

    </div>


    {{-- Table --}}
    <div class="content-card">

        <form
            method="GET"
            action="{{ route('admin.managers.index') }}"
            class="filter-form"
        >

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="search"
                    placeholder="Search name, email, staff code..."
                    value="{{ request('search') }}"
                >

            </div>


            <select name="status">

                <option value="">
                    All Status
                </option>

                <option value="active"
                    {{ request('status') == 'active'
                        ? 'selected'
                        : '' }}>
                    Active
                </option>

                <option value="inactive"
                    {{ request('status') == 'inactive'
                        ? 'selected'
                        : '' }}>
                    Inactive
                </option>

            </select>


            <button
                type="submit"
                class="btn btn-outline"
            >

                <i class="fa-solid fa-filter"></i>

                Filter

            </button>


            <a
                href="{{ route('admin.managers.index') }}"
                class="btn btn-outline"
            >

                <i class="fa-solid fa-rotate"></i>

                Reset

            </a>

        </form>


        <div class="table-responsive">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>Manager</th>

                        <th>Staff Code</th>

                        <th>Phone</th>

                        <th>Employment</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($managers as $manager)

                        <tr>

                            <td>

                                <div class="user-cell">

                                    <div class="user-avatar">

                                        {{
                                            strtoupper(
                                                substr(
                                                    $manager->user->name ?? 'N',
                                                    0,
                                                    1
                                                )
                                            )
                                        }}

                                    </div>

                                    <div>

                                        <strong>
                                            {{ $manager->user->name ?? 'N/A' }}
                                        </strong>

                                        <br>

                                        <small>
                                            {{ $manager->user->email ?? 'N/A' }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <strong>
                                    {{ $manager->staff_code ?? '-' }}
                                </strong>

                            </td>


                            <td>
                                {{ $manager->phone ?? '-' }}
                            </td>


                            <td>

                                {{
                                    $manager->employment_type
                                    ? ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $manager->employment_type
                                        )
                                    )
                                    : '-'
                                }}

                            </td>


                            <td>

                                <span class="status-badge status-{{
                                    $manager->user->status ?? 'inactive'
                                }}">

                                    {{
                                        ucfirst(
                                            $manager->user->status
                                            ?? 'Inactive'
                                        )
                                    }}

                                </span>

                            </td>


                            <td>

                                {{
                                    $manager->created_at
                                    ? $manager->created_at->format('d M Y')
                                    : '-'
                                }}

                            </td>


                            <td>

                                <div class="action-buttons">

                                    @if($canView)

                                        <a
                                            href="{{ route(
                                                'admin.managers.show',
                                                $manager->id
                                            ) }}"
                                            class="action-btn view"
                                            title="View"
                                        >

                                            <i class="fa-solid fa-eye"></i>

                                        </a>

                                    @endif


                                    @if($canEdit)

                                        <a
                                            href="{{ route(
                                                'admin.managers.edit',
                                                $manager->id
                                            ) }}"
                                            class="action-btn edit"
                                            title="Edit"
                                        >

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                    @endif


                                    @if($canDelete)

                                        <form
                                            action="{{ route(
                                                'admin.managers.destroy',
                                                $manager->id
                                            ) }}"
                                            method="POST"
                                            style="display:inline"
                                            onsubmit="return confirm(
                                                'Are you sure you want to delete this manager?'
                                            )"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete"
                                            >

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="empty-state"
                            >

                                <i class="fa-solid fa-user-tie"></i>

                                <p>
                                    No managers found.
                                </p>

                                @if($canCreate)

                                    <a
                                        href="{{ route(
                                            'admin.managers.create'
                                        ) }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="fa-solid fa-plus"></i>

                                        Add Manager

                                    </a>

                                @endif

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="pagination-wrapper">

            {{ $managers->links() }}

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
    text-transform:uppercase;
}

.stat-card h3 {
    font-size:24px;
    color:#222831;
    margin:2px 0;
}

.filter-form {
    padding:20px;
    border-bottom:1px solid #eee;
    display:flex;
    flex-wrap:wrap;
    gap:12px;
}

.search-box {
    display:flex;
    align-items:center;
    gap:10px;
    padding:0 15px;
    border:2px solid #e8e8e8;
    border-radius:8px;
    flex:1;
    min-width:220px;
    height:46px;
}

.search-box input {
    border:none;
    outline:none;
    width:100%;
    height:100%;
}

.filter-form select {
    padding:10px 15px;
    border:2px solid #e8e8e8;
    border-radius:8px;
    min-width:140px;
}

.table-responsive {
    overflow-x:auto;
}

.admin-table {
    width:100%;
    border-collapse:collapse;
    min-width:850px;
}

.admin-table th {
    background:#f8f9fa;
    color:#666;
    font-size:12px;
    padding:14px 16px;
    text-align:left;
}

.admin-table td {
    padding:14px 16px;
    border-bottom:1px solid #f1f1f1;
    font-size:14px;
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
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
}

.status-badge {
    padding:5px 14px;
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
    justify-content:center;
    gap:6px;
}

.action-btn {
    width:34px;
    height:34px;
    border:none;
    border-radius:8px;
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
    padding:50px!important;
}

.empty-state i {
    font-size:48px;
    color:#ddd;
    margin-bottom:15px;
}

.pagination-wrapper {
    padding:15px 20px;
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