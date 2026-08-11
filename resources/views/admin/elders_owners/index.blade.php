@extends('layouts.admin')

@section('title', 'Elder Owners')

@section('content')

<div class="dashboard-page">

    <!-- ==========================================
         PAGE HEADER
    ========================================== -->

    <div class="dashboard-heading">

        <div>
            <h1>Elder Owners</h1>

            <p class="dashboard-subtitle">
                Manage guardians and family members connected
                with elderly residents.
            </p>
        </div>

        <a href="{{ route('admin.owners.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-user-plus"></i>

            Add Owner

        </a>

    </div>


    <!-- ==========================================
         STATISTICS
    ========================================== -->

    <div class="stats-grid">

        <div class="dashboard-card stat-card">

            <div class="stat-icon pink">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="stat-info">

                <span>Total Owners</span>

                <h3>{{ $totalOwners ?? 0 }}</h3>

            </div>

        </div>


        <div class="dashboard-card stat-card">

            <div class="stat-icon teal">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div class="stat-info">

                <span>Active Owners</span>

                <h3>{{ $activeOwners ?? 0 }}</h3>

            </div>

        </div>


        <div class="dashboard-card stat-card">

            <div class="stat-icon purple">
                <i class="fa-solid fa-shield-heart"></i>
            </div>

            <div class="stat-info">

                <span>Guardians</span>

                <h3>{{ $guardianCount ?? 0 }}</h3>

            </div>

        </div>


        <div class="dashboard-card stat-card">

            <div class="stat-icon orange">
                <i class="fa-solid fa-link"></i>
            </div>

            <div class="stat-info">

                <span>Linked Owners</span>

                <h3>{{ $linkedOwners ?? 0 }}</h3>

            </div>

        </div>

    </div>


    <!-- ==========================================
         SEARCH & FILTER
    ========================================== -->

    <div class="dashboard-card filter-card">

        <form method="GET"
              action="{{ route('admin.owners.index') }}"
              class="table-toolbar">

            <div class="toolbar-left">

                <div class="table-search">

                    <i class="fa-solid fa-search"></i>

                    <input type="text"
                           name="search"
                           class="search-input"
                           value="{{ request('search') }}"
                           placeholder="Search owner name, NIC, phone...">

                </div>

            </div>


            <div class="toolbar-right">

                <div class="filter-group">

                    <label class="filter-label">
                        <i class="fa-solid fa-filter"></i>
                        Status:
                    </label>

                    <select name="status" class="filter-select">

                        <option value="">All Status</option>

                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fa-solid fa-filter"></i>

                    Filter

                </button>

            </div>

        </form>

    </div>


    <!-- ==========================================
         OWNER TABLE
    ========================================== -->

    <div class="dashboard-card">

        <div class="dashboard-table-wrapper">

            <table class="dashboard-table" id="ownersTable">

                <thead>

                    <tr>

                        <th>Owner</th>

                        <th>Relationship</th>

                        <th>Phone</th>

                        <th>Email</th>

                        <th>Connected Elders</th>

                        <th>Status</th>

                        <th width="170">Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($owners ?? [] as $owner)

                        <tr>

                            <!-- Owner -->
                            <td>

                                <div class="resident-user">

                                    <div class="resident-avatar">

                                        @if($owner->photo ?? false)

                                            <img src="{{ asset('storage/' . $owner->photo) }}"
                                                 alt="{{ $owner->name }}">

                                        @else

                                            {{ strtoupper(substr($owner->name, 0, 1)) }}

                                        @endif

                                    </div>


                                    <div>

                                        <strong>
                                            {{ $owner->name }}
                                        </strong>

                                        <span>
                                            NIC: {{ $owner->nic ?? 'Not Provided' }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <!-- Relationship -->
                            <td>

                                <span class="relationship-badge">

                                    <i class="fa-solid fa-user-group"></i>

                                    {{ ucfirst($owner->relationship ?? 'Family') }}

                                </span>

                            </td>


                            <!-- Phone -->
                            <td>

                                <span class="contact-value">

                                    <i class="fa-solid fa-phone"></i>

                                    {{ $owner->phone ?? '-' }}

                                </span>

                            </td>


                            <!-- Email -->
                            <td>

                                {{ $owner->email ?? '-' }}

                            </td>


                            <!-- Connected Elders -->
                            <td>

                                @if(isset($owner->elders) && $owner->elders->count())

                                    <div class="linked-elders">

                                        @foreach($owner->elders->take(2) as $elder)

                                            <span class="elder-chip">

                                                <i class="fa-solid fa-person-cane"></i>

                                                {{ $elder->name }}

                                            </span>

                                        @endforeach


                                        @if($owner->elders->count() > 2)

                                            <span class="elder-more">

                                                +{{ $owner->elders->count() - 2 }}

                                            </span>

                                        @endif

                                    </div>

                                @else

                                    <span class="text-muted">

                                        Not Assigned

                                    </span>

                                @endif

                            </td>


                            <!-- Status -->
                            <td>

                                @if(($owner->status ?? 'active') === 'active')

                                    <span class="status-badge active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <!-- Actions -->
                            <td>

                                <div class="elder-actions">

                                    <a href="{{ route('admin.owners.show', $owner->id) }}"
                                       class="action-btn view"
                                       title="View Owner">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>


                                    <a href="{{ route('admin.owners.edit', $owner->id) }}"
                                       class="action-btn edit"
                                       title="Edit Owner">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>


                                    <button class="action-btn delete"
                                            onclick="confirmDelete({{ $owner->id }}, '{{ $owner->name }}')"
                                            title="Delete Owner">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7">

                                <div class="empty-state">

                                    <i class="fa-solid fa-users"></i>

                                    <h4>No Elder Owners Found</h4>

                                    <p>
                                        Add an owner or guardian and
                                        connect them with an elder.
                                    </p>

                                    <a href="{{ route('admin.owners.create') }}"
                                       class="btn btn-primary">

                                        <i class="fa-solid fa-user-plus"></i>

                                        Add Owner

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->

        @if(isset($owners) && method_exists($owners, 'links'))

            <div class="elder-pagination">

                {{ $owners->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        confirmDeleteOwner(name, function() {
            showLoading('Deleting...');
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.owners.destroy", "") }}/' + id;
            
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
        });
    }
</script>
@endpush