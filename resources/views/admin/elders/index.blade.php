@extends('layouts.admin')

@section('title', 'Elder Management')

@section('content')

<div class="dashboard-page">

    <!-- ==========================================
        PAGE HEADER
    ========================================== -->

    <div class="dashboard-heading">

        <div>

            <h1>Elder Management</h1>

            <p class="dashboard-subtitle">
                Manage all elderly residents from one place.
            </p>

        </div>

        <a href="{{ route('admin.elders.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>

            Add Elder

        </a>

    </div>


    <!-- ==========================================
        STATISTICS
    ========================================== -->

    <div class="stats-grid">

        <div class="dashboard-card stat-card">

            <div class="stat-icon pink">
                <i class="fa-solid fa-person-cane"></i>
            </div>

            <div class="stat-info">

                <span>Total Elders</span>

                <h3>{{ $totalElders ?? 0 }}</h3>

            </div>

        </div>


        <div class="dashboard-card stat-card">

            <div class="stat-icon teal">
                <i class="fa-solid fa-heart"></i>
            </div>

            <div class="stat-info">

                <span>Active</span>

                <h3>{{ $activeElders ?? 0 }}</h3>

            </div>

        </div>


        <div class="dashboard-card stat-card">

            <div class="stat-icon purple">
                <i class="fa-solid fa-person"></i>
            </div>

            <div class="stat-info">

                <span>Male</span>

                <h3>{{ $maleElders ?? 0 }}</h3>

            </div>

        </div>


        <div class="dashboard-card stat-card">

            <div class="stat-icon orange">
                <i class="fa-solid fa-person-dress"></i>
            </div>

            <div class="stat-info">

                <span>Female</span>

                <h3>{{ $femaleElders ?? 0 }}</h3>

            </div>

        </div>

    </div>


    <!-- ==========================================
        FILTER
    ========================================== -->

    <div class="dashboard-card filter-card">

        <div class="table-toolbar">

            <div class="toolbar-left">

                <div class="table-search">

                    <i class="fa-solid fa-search"></i>

                    <input type="text"
                           placeholder="Search by name or code..."
                           id="searchInput"
                           class="search-input">

                </div>

            </div>


            <div class="toolbar-right">

                <div class="filter-group">

                    <label for="statusFilter" class="filter-label">
                        <i class="fa-solid fa-filter"></i>
                        Status:
                    </label>

                    <select id="statusFilter" class="filter-select">

                        <option value="all">All Status</option>

                        <option value="active">Active</option>

                        <option value="inactive">Inactive</option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    <!-- ==========================================
        TABLE
    ========================================== -->

    <div class="dashboard-card">

        <div class="dashboard-table-wrapper">

            <table class="dashboard-table" id="eldersTable">

                <thead>

                <tr>

                    <th>Photo</th>

                    <th>Name</th>

                    <th>Age</th>

                    <th>Gender</th>

                    <th>Room</th>

                    <th>Caregiver</th>

                    <th>Status</th>

                    <th width="170">Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($elders ?? [] as $elder)

                    <tr>

                        <td>

                            <img src="{{ $elder->photo ? asset('storage/' . $elder->photo) : asset('images/default-user.png') }}"
                                 class="table-avatar"
                                 alt="{{ $elder->name }}">

                        </td>

                        <td>

                            <strong>{{ $elder->name }}</strong>

                            <br>

                            <small>{{ $elder->elder_code ?? 'N/A' }}</small>

                        </td>

                        <td>{{ $elder->age ?? 'N/A' }}</td>

                        <td>{{ ucfirst($elder->gender ?? 'N/A') }}</td>

                        <td>{{ $elder->room ?? 'N/A' }}</td>

                        <td>{{ $elder->caregiver ?? 'N/A' }}</td>

                        <td>

                            <span class="status-badge {{ ($elder->status ?? 'active') == 'active' ? 'active' : 'inactive' }}">

                                {{ ucfirst($elder->status ?? 'Active') }}

                            </span>

                        </td>

                        <td>

                            <a href="{{ route('admin.elders.show', $elder->id) }}"
                               class="action-btn view">

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            <a href="{{ route('admin.elders.edit', $elder->id) }}"
                               class="action-btn edit">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <button class="action-btn delete"
                                    onclick="confirmDelete({{ $elder->id }})">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8">

                            <div class="empty-state">

                                <i class="fa-solid fa-person-cane"></i>

                                <h4>No Elders Found</h4>

                                <p>

                                    Click "Add Elder" to register
                                    your first resident.

                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this elder?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.elders.destroy", "") }}/' + id;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('eldersTable');
    const rows = table.querySelectorAll('tbody tr:not(:last-child)');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusValue = statusFilter.value;

        let hasVisibleRows = false;

        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2) strong')?.textContent.toLowerCase() || '';
            const code = row.querySelector('td:nth-child(2) small')?.textContent.toLowerCase() || '';
            const statusBadge = row.querySelector('.status-badge');
            const rowStatus = statusBadge ? statusBadge.textContent.toLowerCase().trim() : '';

            const matchesSearch = name.includes(searchTerm) || code.includes(searchTerm);
            const matchesStatus = statusValue === 'all' || rowStatus === statusValue;

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                hasVisibleRows = true;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide empty state
        const emptyRow = table.querySelector('tbody tr:last-child');
        if (emptyRow && emptyRow.querySelector('.empty-state')) {
            emptyRow.style.display = hasVisibleRows ? 'none' : '';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                filterTable();
            }
        });
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterTable);
    }

    // Initial filter
    filterTable();
});
</script>
@endpush