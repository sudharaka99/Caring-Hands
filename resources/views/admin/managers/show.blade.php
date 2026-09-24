@extends('layouts.admin')

@section('title', 'Manager Details')

@section('content')

<div class="admin-page">

    <div class="page-header">

        <div>

            <h1>
                <i class="fa-solid fa-user-tie"></i>
                Manager Details
            </h1>

            <p>View manager information.</p>

        </div>


        <div style="display:flex;gap:10px;">

            <a
                href="{{ route('admin.managers.index') }}"
                class="btn btn-outline"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Back

            </a>


            @if(canAccess('admin.managers.index', 'can_edit'))
                <a
                    href="{{ route(
                        'admin.managers.edit',
                        $manager->id
                    ) }}"
                    class="btn btn-primary"
                >

                <i class="fa-solid fa-pen"></i>

                Edit

                </a>
            @endif

        </div>

    </div>


    <div class="content-card">

        {{-- Header --}}
        <div class="profile-header">

            <div class="profile-avatar">

                @if($manager->profile_photo)

                    <img
                        src="{{ asset(
                            'storage/' . $manager->profile_photo
                        ) }}"
                        alt="Manager"
                    >

                @else

                    {{
                        strtoupper(
                            substr(
                                $manager->user->name ?? 'N',
                                0,
                                1
                            )
                        )
                    }}

                @endif

            </div>


            <div>

                <h2>
                    {{ $manager->user->name ?? 'N/A' }}
                </h2>

                <p>
                    Manager
                </p>

                <span class="status-badge status-{{
                    $manager->user->status ?? 'inactive'
                }}">

                    {{
                        ucfirst(
                            $manager->user->status ?? 'Inactive'
                        )
                    }}

                </span>

            </div>

        </div>


        {{-- Account --}}
        <div class="info-section">

            <div class="section-title">

                <i class="fa-solid fa-user"></i>

                Account Information

            </div>


            <div class="info-grid">

                <div class="info-item">

                    <span>Name</span>

                    <strong>
                        {{ $manager->user->name ?? '-' }}
                    </strong>

                </div>


                <div class="info-item">

                    <span>Email</span>

                    <strong>
                        {{ $manager->user->email ?? '-' }}
                    </strong>

                </div>


                <div class="info-item">

                    <span>Staff Code</span>

                    <strong>
                        {{ $manager->staff_code ?? '-' }}
                    </strong>

                </div>


                <div class="info-item">

                    <span>Status</span>

                    <strong>
                        {{
                            ucfirst(
                                $manager->user->status ?? 'Inactive'
                            )
                        }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- Personal --}}
        <div class="info-section">

            <div class="section-title">

                <i class="fa-solid fa-id-card"></i>

                Personal Information

            </div>


            <div class="info-grid">

                <div class="info-item">

                    <span>NIC</span>

                    <strong>
                        {{ $manager->nic ?? '-' }}
                    </strong>

                </div>


                <div class="info-item">

                    <span>Date of Birth</span>

                    <strong>

                        {{
                            $manager->date_of_birth
                            ? \Carbon\Carbon::parse(
                                $manager->date_of_birth
                            )->format('d M Y')
                            : '-'
                        }}

                    </strong>

                </div>


                <div class="info-item">

                    <span>Gender</span>

                    <strong>
                        {{
                            $manager->gender
                            ? ucfirst($manager->gender)
                            : '-'
                        }}
                    </strong>

                </div>


                <div class="info-item">

                    <span>Phone</span>

                    <strong>
                        {{ $manager->phone ?? '-' }}
                    </strong>

                </div>


                <div class="info-item">

                    <span>Joining Date</span>

                    <strong>

                        {{
                            $manager->joining_date
                            ? \Carbon\Carbon::parse(
                                $manager->joining_date
                            )->format('d M Y')
                            : '-'
                        }}

                    </strong>

                </div>


                <div class="info-item">

                    <span>Employment Type</span>

                    <strong>

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

                    </strong>

                </div>

            </div>


            <div class="single-info">

                <span>Address</span>

                <p>
                    {{ $manager->address ?? '-' }}
                </p>

            </div>

        </div>


        {{-- Professional --}}
        <div class="info-section">

            <div class="section-title">

                <i class="fa-solid fa-briefcase"></i>

                Professional Information

            </div>


            <div class="single-info">

                <span>Qualifications</span>

                <p>
                    {{ $manager->qualifications ?? '-' }}
                </p>

            </div>


            <div class="single-info">

                <span>Experience</span>

                <p>
                    {{ $manager->experience ?? '-' }}
                </p>

            </div>

        </div>


        {{-- Emergency --}}
        <div class="info-section">

            <div class="section-title">

                <i class="fa-solid fa-phone"></i>

                Emergency Contact

            </div>


            <div class="info-grid">

                <div class="info-item">

                    <span>Name</span>

                    <strong>
                        {{ $manager->emergency_contact_name ?? '-' }}
                    </strong>

                </div>


                <div class="info-item">

                    <span>Relationship</span>

                    <strong>
                        {{ $manager->emergency_relationship ?? '-' }}
                    </strong>

                </div>


                <div class="info-item">

                    <span>Phone</span>

                    <strong>
                        {{ $manager->emergency_phone ?? '-' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- Notes --}}
        <div class="info-section">

            <div class="section-title">

                <i class="fa-solid fa-note-sticky"></i>

                Notes

            </div>


            <p class="notes">

                {{ $manager->notes ?? 'No notes available.' }}

            </p>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

.profile-header {
    padding:30px;
    display:flex;
    align-items:center;
    gap:20px;
    background:#fffbf0;
    border-bottom:1px solid #eee;
}

.profile-avatar {
    width:90px;
    height:90px;
    border-radius:50%;
    background:#ffbe33;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
    font-weight:700;
    overflow:hidden;
}

.profile-avatar img {
    width:100%;
    height:100%;
    object-fit:cover;
}

.profile-header h2 {
    margin:0 0 5px;
}

.profile-header p {
    margin:0 0 10px;
    color:#777;
}

.status-badge {
    padding:5px 15px;
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

.info-section {
    padding:25px;
    border-bottom:1px solid #eee;
}

.section-title {
    font-size:17px;
    font-weight:700;
    margin-bottom:20px;
}

.section-title i {
    color:#ffbe33;
    margin-right:8px;
}

.info-grid {
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.info-item {
    padding:15px;
    background:#f8f9fa;
    border-radius:8px;
}

.info-item span,
.single-info span {
    display:block;
    font-size:12px;
    color:#999;
    text-transform:uppercase;
    margin-bottom:5px;
}

.info-item strong {
    color:#222831;
}

.single-info {
    margin-top:20px;
}

.single-info p,
.notes {
    color:#555;
    line-height:1.7;
    white-space:pre-line;
}

@media(max-width:768px) {

    .profile-header {
        flex-direction:column;
        text-align:center;
    }

    .info-grid {
        grid-template-columns:1fr;
    }

}

</style>

@endpush