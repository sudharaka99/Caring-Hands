@extends('layouts.admin')

@section('title', 'Caregivers')

@section('content')

<div class="admin-page">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>👨‍⚕️ Caregivers</h1>
            <p>Manage caregivers and their account information.</p>
        </div>
        
        {{-- Check if user has permission to create --}}
        @php
            $canCreate = false;
            $canView = false;
            $canEdit = false;
            $canDelete = false;
            
            foreach($menus as $menu) {
                if($menu->id == 3) { // Caregivers menu ID = 3
                    foreach($menu->accesses as $access) {
                        if($access->role == $userRole) {
                            if($access->can_view) $canView = true;
                            if($access->can_create) $canCreate = true;
                            if($access->can_edit) $canEdit = true;
                            if($access->can_delete) $canDelete = true;
                        }
                    }
                }
            }
        @endphp
        
        @if($canCreate)
            <a href="{{ route('admin.caregivers.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add Caregiver
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

    {{-- Statistics --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-nurse"></i>
            </div>
            <div>
                <span>Total Caregivers</span>
                <h3>{{ $totalCaregivers }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <span>Active</span>
                <h3>{{ $activeCaregivers }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div>
                <span>Inactive</span>
                <h3>{{ $inactiveCaregivers }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-calendar-plus"></i>
            </div>
            <div>
                <span>Added This Month</span>
                <h3>{{ $newCaregiversThisMonth }}</h3>
                <small>New caregiver records</small>
            </div>
        </div>
    </div>

    {{-- Caregiver Table --}}
    <div class="content-card">
        <form method="GET" action="{{ route('admin.caregivers.index') }}" class="filter-form">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" placeholder="Search by name, email, staff code..." value="{{ request('search') }}">
            </div>
            <select name="status">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-outline">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.caregivers.index') }}" class="btn btn-outline">
                <i class="fa-solid fa-rotate"></i> Reset
            </a>
        </form>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Caregiver</th>
                        <th>Staff Code</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caregivers as $caregiver)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($caregiver->user->name ?? 'N/A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $caregiver->user->name ?? 'N/A' }}</strong>
                                        <br>
                                        <small style="color: #999; font-size: 12px;">{{ $caregiver->user->email ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $caregiver->staff_code ?? '-' }}</strong>
                            </td>
                            <td>{{ $caregiver->phone ?? '-' }}</td>
                            <td>
                                <span class="status-badge status-{{ $caregiver->user->status ?? 'inactive' }}">
                                    {{ ucfirst($caregiver->user->status ?? 'Inactive') }}
                                </span>
                            </td>
                            <td>{{ $caregiver->created_at ? \Carbon\Carbon::parse($caregiver->created_at)->format('d M Y') : '-' }}</td>
                            <td>
                                <div class="action-buttons">
                                    @if($canView)
                                        <a href="{{ route('admin.caregivers.show', $caregiver->id) }}" class="action-btn view" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    @endif

                                    @if($canEdit)
                                        <a href="{{ route('admin.caregivers.edit', $caregiver->id) }}" class="action-btn edit" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endif

                                    @if($canDelete)
                                        <form action="{{ route('admin.caregivers.destroy', $caregiver->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this caregiver?')" style="display: inline; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fa-solid fa-user-nurse"></i>
                                <p>No caregivers found.</p>
                                @if($canCreate)
                                    <a href="{{ route('admin.caregivers.create') }}" class="btn btn-primary" style="margin-top: 10px;">
                                        <i class="fa-solid fa-plus"></i> Add Caregiver
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $caregivers->links() }}
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* ============================================================
       CAREGIVERS - ADMIN PANEL STYLES
    ============================================================ */
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: #fff7e6;
        color: #ffbe33;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-card span {
        display: block;
        color: #999;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card h3 {
        font-size: 24px;
        font-weight: 700;
        color: #222831;
        margin: 2px 0 0 0;
    }

    /* Filter Form */
    .filter-form {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 15px;
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        background: #fff;
        transition: all 0.3s ease;
        flex: 1;
        min-width: 200px;
        height: 46px;
    }

    .search-box:focus-within {
        border-color: #ffbe33;
        box-shadow: 0 0 0 4px rgba(255, 190, 51, 0.1);
    }

    .search-box i {
        color: #999;
        font-size: 14px;
    }

    .search-box input {
        border: none;
        padding: 10px 0;
        font-size: 14px;
        flex: 1;
        background: transparent;
        outline: none;
        color: #222831;
        height: 100%;
    }

    .search-box input::placeholder {
        color: #aaa;
    }

    .filter-form select {
        padding: 10px 15px;
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        font-size: 14px;
        background: #fff;
        color: #222831;
        cursor: pointer;
        outline: none;
        transition: all 0.3s ease;
        min-width: 140px;
        height: 46px;
    }

    .filter-form select:focus {
        border-color: #ffbe33;
        box-shadow: 0 0 0 4px rgba(255, 190, 51, 0.1);
    }

    .filter-form .btn {
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 20px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        border: 2px solid #e8e8e8;
        background: transparent;
        color: #222831;
    }

    .filter-form .btn:hover {
        background: #f5f5f5;
        border-color: #ddd;
        transform: translateY(-2px);
    }

    .filter-form .btn i {
        font-size: 14px;
    }

    /* Table */
    .table-responsive {
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .admin-table thead th {
        background: #f8f9fa;
        color: #666;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        text-align: left;
        border-bottom: 2px solid #eee;
    }

    .admin-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f1f1;
        color: #555;
        font-size: 14px;
        vertical-align: middle;
    }

    .admin-table tbody tr:hover {
        background: #fffbf0;
    }

    .admin-table tbody tr:last-child td {
        border-bottom: none;
    }

    .text-center {
        text-align: center !important;
    }

    /* User Cell */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #ffbe33;
        color: #222831;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .action-btn.view {
        background: #e8f4fd;
        color: #0c5460;
    }

    .action-btn.view:hover {
        background: #d1ecf1;
        transform: scale(1.05);
    }

    .action-btn.edit {
        background: #fff3cd;
        color: #856404;
    }

    .action-btn.edit:hover {
        background: #ffe8a1;
        transform: scale(1.05);
    }

    .action-btn.delete {
        background: #f8d7da;
        color: #721c24;
    }

    .action-btn.delete:hover {
        background: #f1c0c3;
        transform: scale(1.05);
    }

    .action-btn form {
        margin: 0;
        display: inline;
    }

    .action-btn button {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0;
        font-size: 14px;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px !important;
        color: #999;
    }

    .empty-state i {
        font-size: 48px;
        color: #ddd;
        display: block;
        margin-bottom: 12px;
    }

    .empty-state p {
        font-size: 16px;
        margin: 0;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }

    .pagination-wrapper .pagination {
        margin: 0;
        justify-content: center;
    }

    .pagination-wrapper .page-link {
        color: #222831;
        border: 1px solid #dee2e6;
        padding: 8px 14px;
        margin: 0 3px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .pagination-wrapper .page-link:hover {
        background: #ffbe33;
        border-color: #ffbe33;
        color: #222831;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: #ffbe33;
        border-color: #ffbe33;
        color: #222831;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-form {
            flex-direction: column;
        }
        
        .search-box {
            width: 100%;
            min-width: auto;
        }
        
        .filter-form select {
            width: 100%;
            min-width: auto;
        }
        
        .filter-form .btn {
            width: 100%;
            justify-content: center;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .page-header .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-wrap: wrap;
        }
        
        .action-btn {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
    }
</style>
@endpush