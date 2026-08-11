@extends('layouts.admin')

@section('title', 'Owner Profile')

@section('content')

<div class="dashboard-page">

    <!-- ==========================================
         PAGE HEADER
    ========================================== -->

    <div class="dashboard-heading">

        <div>

            <h1>Owner Profile</h1>

            <p class="dashboard-subtitle">
                View owner information for {{ $owner->name ?? 'N/A' }}.
            </p>

        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap;">

            <a href="{{ route('admin.owners.edit', $owner->id) }}"
               class="btn btn-primary">

                <i class="fa-solid fa-pen"></i>

                Edit

            </a>

            <button onclick="printProfile()"
                    class="btn btn-outline"
                    style="border-color: #2196F3; color: #2196F3;">

                <i class="fa-solid fa-print"></i>

                Print

            </button>

            <button onclick="deleteOwner({{ $owner->id }}, '{{ $owner->name }}')"
                    class="btn btn-outline"
                    style="border-color: #dc3545; color: #dc3545;">

                <i class="fa-solid fa-trash"></i>

                Delete

            </button>

            <a href="{{ route('admin.owners.index') }}"
               class="btn btn-outline">

                <i class="fa-solid fa-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

    <!-- ==========================================
         PROFILE GRID
    ========================================== -->

    <div class="profile-grid" id="profileContent">

        <!-- ==========================================
             LEFT SIDE - PROFILE CARD
        ========================================== -->

        <div class="dashboard-card profile-card">

            <img src="{{ $owner->photo ? asset('storage/' . $owner->photo) : asset('images/default-user.png') }}"
                 class="profile-image"
                 alt="{{ $owner->name ?? 'N/A' }}">

            <h2>{{ $owner->name ?? 'N/A' }}</h2>

            <span class="status-badge {{ ($owner->status ?? 'active') == 'active' ? 'active' : 'inactive' }}">
                {{ ucfirst($owner->status ?? 'Active') }}
            </span>

            <hr style="margin: 20px 0;">

            <div class="profile-item">

                <strong>Relationship</strong>

                <span>{{ ucfirst($owner->relationship ?? 'N/A') }}</span>

            </div>

            <div class="profile-item">

                <strong>Phone</strong>

                <span>{{ $owner->phone ?? 'N/A' }}</span>

            </div>

            <div class="profile-item">

                <strong>Email</strong>

                <span>{{ $owner->email ?? 'N/A' }}</span>

            </div>

            <div class="profile-item">

                <strong>NIC</strong>

                <span>{{ $owner->nic ?? 'N/A' }}</span>

            </div>

            <div class="profile-item">

                <strong>Connected Elders</strong>

                <span>{{ $owner->elders->count() ?? 0 }}</span>

            </div>

        </div>

        <!-- ==========================================
             RIGHT SIDE - DETAILS
        ========================================== -->

        <div>

            <!-- ==========================================
                 PERSONAL INFORMATION
            ========================================== -->

            <div class="dashboard-card">

                <h3 class="card-title">

                    <i class="fa-solid fa-user"></i>

                    Personal Information

                </h3>

                <table class="details-table">

                    <tr>
                        <th>Full Name</th>
                        <td>{{ $owner->name ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>NIC</th>
                        <td>{{ $owner->nic ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Relationship</th>
                        <td>{{ ucfirst($owner->relationship ?? 'N/A') }}</td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>{{ $owner->phone ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $owner->email ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>{{ $owner->address ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="status-badge {{ ($owner->status ?? 'active') == 'active' ? 'active' : 'inactive' }}">
                                {{ ucfirst($owner->status ?? 'Active') }}
                            </span>
                        </td>
                    </tr>

                </table>

            </div>

            <!-- ==========================================
                 CONNECTED ELDERS
            ========================================== -->

            <div class="dashboard-card mt-20">

                <h3 class="card-title">

                    <i class="fa-solid fa-person-cane"></i>

                    Connected Elders

                </h3>

                @if($owner->elders && $owner->elders->count())

                    <table class="details-table">

                        <thead>
                            <tr>
                                <th>Elder Name</th>
                                <th>Room</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($owner->elders as $elder)

                                <tr>
                                    <td>
                                        <a href="{{ route('admin.elders.show', $elder->id) }}"
                                           style="color: #FF9CA9; text-decoration: none;">
                                            {{ $elder->name }}
                                        </a>
                                    </td>
                                    <td>{{ $elder->room ?? 'N/A' }}</td>
                                    <td>
                                        <span class="status-badge {{ $elder->status == 'active' ? 'active' : 'inactive' }}">
                                            {{ ucfirst($elder->status ?? 'Active') }}
                                        </span>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="empty-state" style="padding: 30px;">

                        <i class="fa-solid fa-users" style="font-size: 40px;"></i>

                        <h4>No Elders Connected</h4>

                        <p>
                            This owner is not linked to any elder yet.
                        </p>

                        <a href="{{ route('admin.owners.edit', $owner->id) }}"
                           class="btn btn-primary">

                            <i class="fa-solid fa-link"></i>

                            Connect Elders

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')
<style>
    .profile-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .profile-item:last-child {
        border-bottom: none;
    }

    .profile-item strong {
        color: #555;
    }

    .profile-item span {
        color: #333;
        font-weight: 500;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .details-table th {
        width: 180px;
        background: #FFF7F8;
        font-weight: 600;
        color: #555;
        padding: 14px 18px;
    }

    .details-table td {
        color: #333;
        padding: 14px 18px;
    }

    .details-table tr:hover {
        background: #FFF9FA;
    }

    .details-table thead th {
        background: #FFF4F6;
        font-weight: 600;
    }

    @media print {
        .dashboard-heading .btn {
            display: none !important;
        }
        
        .dashboard-card {
            box-shadow: none !important;
            border: 1px solid #e0e0e0 !important;
            break-inside: avoid;
        }
    }

    @media(max-width: 992px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }

        .details-table th {
            width: 140px;
        }
    }

    @media(max-width: 576px) {
        .details-table th {
            width: 100px;
            font-size: 13px;
            padding: 10px 12px;
        }

        .details-table td {
            font-size: 13px;
            padding: 10px 12px;
        }
        
        .dashboard-heading {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .dashboard-heading > div:last-child {
            width: 100%;
        }
        
        .dashboard-heading .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function printProfile() {
        window.print();
    }

    function deleteOwner(id, name) {
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

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showSuccess('{{ session('success') }}');
        });
    @endif

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            showError('{{ session('error') }}');
        });
    @endif
</script>
@endpush