@extends('layouts.admin')

@section('title', 'Edit Healthcare')

@section('content')

<div class="admin-page">

    <div class="page-header">

        <div>
            <h1>
                <i class="fa-solid fa-user-doctor"></i>
                Edit Healthcare
            </h1>

            <p>Update healthcare staff information.</p>
        </div>

        <a
            href="{{ route(
                'admin.healthcare.show',
                $healthcare->id
            ) }}"
            class="btn btn-outline"
        >

            <i class="fa-solid fa-arrow-left"></i>
            Back

        </a>

    </div>


    {{-- Errors --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <i class="fa-solid fa-circle-exclamation"></i>

            <ul style="margin:0;padding-left:20px;">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="content-card">

        <form
            action="{{ route(
                'admin.healthcare.update',
                $healthcare->id
            ) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            {{-- Account Information --}}
            <div class="form-section">

                <div class="section-title">
                    <i class="fa-solid fa-user"></i>
                    Account Information
                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Name <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old(
                                'name',
                                $healthcare->user->name ?? ''
                            ) }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Email <span>*</span>
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old(
                                'email',
                                $healthcare->user->email ?? ''
                            ) }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            New Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            placeholder="Leave blank to keep current password"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                        >

                    </div>


                    <div class="form-group">

                        <label>Status</label>

                        <select name="status">

                            <option value="active"
                                {{ old(
                                    'status',
                                    $healthcare->user->status ?? 'active'
                                ) == 'active'
                                    ? 'selected'
                                    : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old(
                                    'status',
                                    $healthcare->user->status ?? ''
                                ) == 'inactive'
                                    ? 'selected'
                                    : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- Personal Information --}}
            <div class="form-section">

                <div class="section-title">
                    <i class="fa-solid fa-id-card"></i>
                    Personal Information
                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label>Staff Code</label>

                        <input
                            type="text"
                            name="staff_code"
                            value="{{ old(
                                'staff_code',
                                $healthcare->staff_code
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>NIC</label>

                        <input
                            type="text"
                            name="nic"
                            value="{{ old(
                                'nic',
                                $healthcare->nic
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Date of Birth</label>

                        <input
                            type="date"
                            name="date_of_birth"
                            value="{{ old(
                                'date_of_birth',
                                $healthcare->date_of_birth
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Gender</label>

                        <select name="gender">

                            <option value="">
                                Select Gender
                            </option>

                            <option value="male"
                                {{ old(
                                    'gender',
                                    $healthcare->gender
                                ) == 'male'
                                    ? 'selected'
                                    : '' }}>
                                Male
                            </option>

                            <option value="female"
                                {{ old(
                                    'gender',
                                    $healthcare->gender
                                ) == 'female'
                                    ? 'selected'
                                    : '' }}>
                                Female
                            </option>

                            <option value="other"
                                {{ old(
                                    'gender',
                                    $healthcare->gender
                                ) == 'other'
                                    ? 'selected'
                                    : '' }}>
                                Other
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Phone</label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old(
                                'phone',
                                $healthcare->phone
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Joining Date</label>

                        <input
                            type="date"
                            name="joining_date"
                            value="{{ old(
                                'joining_date',
                                $healthcare->joining_date
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Employment Type</label>

                        <select name="employment_type">

                            @foreach([
                                'full_time' => 'Full Time',
                                'part_time' => 'Part Time',
                                'contract' => 'Contract',
                                'temporary' => 'Temporary'
                            ] as $value => $label)

                                <option
                                    value="{{ $value }}"
                                    {{ old(
                                        'employment_type',
                                        $healthcare->employment_type
                                    ) == $value
                                        ? 'selected'
                                        : '' }}
                                >
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Profile Photo</label>

                        <input
                            type="file"
                            name="profile_photo"
                            accept="image/*"
                        >

                    </div>

                </div>


                @if($healthcare->profile_photo)

                    <div style="margin-bottom:20px;">

                        <img
                            src="{{ asset(
                                'storage/' .
                                $healthcare->profile_photo
                            ) }}"
                            alt="Profile"
                            style="
                                width:80px;
                                height:80px;
                                border-radius:50%;
                                object-fit:cover;
                            "
                        >

                    </div>

                @endif


                <div class="form-group">

                    <label>Address</label>

                    <textarea
                        name="address"
                        rows="3"
                    >{{ old(
                        'address',
                        $healthcare->address
                    ) }}</textarea>

                </div>

            </div>


            {{-- Professional Information --}}
            <div class="form-section">

                <div class="section-title">
                    <i class="fa-solid fa-stethoscope"></i>
                    Professional Information
                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label>Specialization</label>

                        <input
                            type="text"
                            name="specialization"
                            value="{{ old(
                                'specialization',
                                $healthcare->specialization
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>License Number</label>

                        <input
                            type="text"
                            name="license_number"
                            value="{{ old(
                                'license_number',
                                $healthcare->license_number
                            ) }}"
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label>Qualifications</label>

                    <textarea
                        name="qualifications"
                        rows="4"
                    >{{ old(
                        'qualifications',
                        $healthcare->qualifications
                    ) }}</textarea>

                </div>


                <div class="form-group">

                    <label>Experience</label>

                    <textarea
                        name="experience"
                        rows="4"
                    >{{ old(
                        'experience',
                        $healthcare->experience
                    ) }}</textarea>

                </div>

            </div>


            {{-- Emergency --}}
            <div class="form-section">

                <div class="section-title">
                    <i class="fa-solid fa-phone"></i>
                    Emergency Contact
                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label>Contact Name</label>

                        <input
                            type="text"
                            name="emergency_contact_name"
                            value="{{ old(
                                'emergency_contact_name',
                                $healthcare->emergency_contact_name
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Relationship</label>

                        <input
                            type="text"
                            name="emergency_relationship"
                            value="{{ old(
                                'emergency_relationship',
                                $healthcare->emergency_relationship
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Emergency Phone</label>

                        <input
                            type="text"
                            name="emergency_phone"
                            value="{{ old(
                                'emergency_phone',
                                $healthcare->emergency_phone
                            ) }}"
                        >

                    </div>

                </div>

            </div>


            {{-- Notes --}}
            <div class="form-section">

                <div class="section-title">
                    <i class="fa-solid fa-note-sticky"></i>
                    Notes
                </div>


                <div class="form-group">

                    <textarea
                        name="notes"
                        rows="4"
                    >{{ old(
                        'notes',
                        $healthcare->notes
                    ) }}</textarea>

                </div>

            </div>


            {{-- Buttons --}}
            <div class="form-actions">

                <a
                    href="{{ route(
                        'admin.healthcare.show',
                        $healthcare->id
                    ) }}"
                    class="btn btn-outline"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="fa-solid fa-save"></i>

                    Update Healthcare

                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('styles')

<style>

.form-section {
    padding:25px;
    border-bottom:1px solid #eee;
}

.section-title {
    font-size:17px;
    font-weight:700;
    color:#222831;
    margin-bottom:20px;
    display:flex;
    align-items:center;
    gap:10px;
}

.section-title i {
    color:#ffbe33;
}

.form-grid {
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.form-group {
    margin-bottom:18px;
}

.form-group label {
    display:block;
    font-size:13px;
    font-weight:600;
    color:#444;
    margin-bottom:7px;
}

.form-group label span {
    color:#dc3545;
}

.form-group input,
.form-group select,
.form-group textarea {
    width:100%;
    padding:11px 13px;
    border:2px solid #e8e8e8;
    border-radius:8px;
    font-size:14px;
    color:#222831;
    background:#fff;
    outline:none;
    box-sizing:border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color:#ffbe33;
    box-shadow:0 0 0 4px rgba(255,190,51,.1);
}

.form-actions {
    padding:20px 25px;
    display:flex;
    justify-content:flex-end;
    gap:12px;
    border-top:1px solid #eee;
}

@media(max-width:768px) {

    .form-grid {
        grid-template-columns:1fr;
    }

    .form-actions {
        flex-direction:column;
    }

    .form-actions .btn {
        width:100%;
        justify-content:center;
    }

}

</style>

@endpush