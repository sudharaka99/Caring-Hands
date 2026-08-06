@extends('layouts.admin')

@section('title', 'Elder Profile')

@section('content')

<div class="dashboard-page">

    <!-- ==========================================
        PAGE HEADER
    ========================================== -->

    <div class="dashboard-heading">

        <div>

            <h1>Elder Profile</h1>

            <p class="dashboard-subtitle">
                View resident information.
            </p>

        </div>

        <div style="display:flex; gap:10px;">

            <a href="{{ route('admin.elders.edit', $elder->id) }}"
                class="btn btn-primary">

                <i class="fa-solid fa-pen"></i>

                Edit

            </a>

            <a href="{{ route('admin.elders.index') }}"
                class="btn btn-outline">

                <i class="fa-solid fa-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

    <!-- ==========================================
        PROFILE GRID
    ========================================== -->

    <div class="profile-grid">

        <!-- ==========================================
            LEFT SIDE - PROFILE CARD
        ========================================== -->

        <div class="dashboard-card profile-card">

            <img src="{{ $elder->photo ? asset('storage/' . $elder->photo) : asset('images/default-user.png') }}"
                class="profile-image"
                alt="{{ $elder->name }}">

            <h2>{{ $elder->name ?? 'N/A' }}</h2>

            <span class="status-badge {{ ($elder->status ?? 'active') == 'active' ? 'active' : 'inactive' }}">
                {{ ucfirst($elder->status ?? 'Active') }}
            </span>

            <hr style="margin: 20px 0;">

            <div class="profile-item">

                <strong>Age</strong>

                <span>{{ $elder->age ?? 'N/A' }} Years</span>

            </div>

            <div class="profile-item">

                <strong>Gender</strong>

                <span>{{ ucfirst($elder->gender ?? 'N/A') }}</span>

            </div>

            <div class="profile-item">

                <strong>Blood Group</strong>

                <span>{{ $elder->blood_group ?? 'N/A' }}</span>

            </div>

            <div class="profile-item">

                <strong>Phone</strong>

                <span>{{ $elder->phone ?? 'N/A' }}</span>

            </div>

            <div class="profile-item">

                <strong>Email</strong>

                <span>{{ $elder->email ?? 'N/A' }}</span>

            </div>

            <div class="profile-item">

                <strong>Room</strong>

                <span>{{ $elder->room ?? 'N/A' }}</span>

            </div>

            <div class="profile-item">

                <strong>Caregiver</strong>

                <span>{{ $elder->caregiver ?? 'N/A' }}</span>

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
                        <td>{{ $elder->name ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Elder Code</th>
                        <td>{{ $elder->elder_code ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>NIC / Passport</th>
                        <td>{{ $elder->nic ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Date of Birth</th>
                        <td>{{ $elder->dob ? date('d M Y', strtotime($elder->dob)) : 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Age</th>
                        <td>{{ $elder->age ?? 'N/A' }} Years</td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td>{{ ucfirst($elder->gender ?? 'N/A') }}</td>
                    </tr>

                    <tr>
                        <th>Blood Group</th>
                        <td>{{ $elder->blood_group ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>{{ $elder->address ?? 'N/A' }}</td>
                    </tr>

                </table>

            </div>

            <!-- ==========================================
                CONTACT INFORMATION
            ========================================== -->

            <div class="dashboard-card mt-20">

                <h3 class="card-title">

                    <i class="fa-solid fa-phone"></i>

                    Contact Information

                </h3>

                <table class="details-table">

                    <tr>
                        <th>Phone Number</th>
                        <td>{{ $elder->phone ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $elder->email ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>{{ $elder->address ?? 'N/A' }}</td>
                    </tr>

                </table>

            </div>

            <!-- ==========================================
                EMERGENCY CONTACT
            ========================================== -->

            <div class="dashboard-card mt-20">

                <h3 class="card-title">

                    <i class="fa-solid fa-triangle-exclamation"></i>

                    Emergency Contact

                </h3>

                <table class="details-table">

                    <tr>
                        <th>Contact Name</th>
                        <td>{{ $elder->emergency_contact_name ?? $elder->guardian_name ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Relationship</th>
                        <td>{{ $elder->emergency_contact_relationship ?? $elder->guardian_relationship ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Phone Number</th>
                        <td>{{ $elder->emergency_contact_phone ?? $elder->guardian_phone ?? 'N/A' }}</td>
                    </tr>

                </table>

            </div>

            <!-- ==========================================
                ROOM & CAREGIVER
            ========================================== -->

            <div class="dashboard-card mt-20">

                <h3 class="card-title">

                    <i class="fa-solid fa-bed"></i>

                    Room & Caregiver

                </h3>

                <table class="details-table">

                    <tr>
                        <th>Room Number</th>
                        <td>{{ $elder->room ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Caregiver</th>
                        <td>{{ $elder->caregiver ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Admission Date</th>
                        <td>{{ $elder->admission_date ? date('d M Y', strtotime($elder->admission_date)) : 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="status-badge {{ ($elder->status ?? 'active') == 'active' ? 'active' : 'inactive' }}">
                                {{ ucfirst($elder->status ?? 'Active') }}
                            </span>
                        </td>
                    </tr>

                </table>

            </div>

            <!-- ==========================================
                MEDICAL INFORMATION
            ========================================== -->

            <div class="dashboard-card mt-20">

                <h3 class="card-title">

                    <i class="fa-solid fa-heart-pulse"></i>

                    Medical Information

                </h3>

                <table class="details-table">

                    <tr>
                        <th>Medical Notes</th>
                        <td>{{ $elder->medical_notes ?? 'No medical notes recorded.' }}</td>
                    </tr>

                    <tr>
                        <th>Allergies</th>
                        <td>{{ $elder->allergies ?? 'None reported' }}</td>
                    </tr>

                    <tr>
                        <th>Medication</th>
                        <td>{{ $elder->medication ?? 'None reported' }}</td>
                    </tr>

                    <tr>
                        <th>Blood Group</th>
                        <td>{{ $elder->blood_group ?? 'N/A' }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')
<style>
    .profile-card hr {
        border: none;
        border-top: 2px solid #f0f0f0;
    }

    .profile-card .profile-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .profile-card .profile-item:last-child {
        border-bottom: none;
    }

    .profile-card .profile-item strong {
        color: #555;
    }

    .profile-card .profile-item span {
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
    }

    .details-table td {
        color: #333;
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
        }

        .details-table td {
            font-size: 13px;
        }
    }
</style>
@endpush