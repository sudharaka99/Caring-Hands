@extends('layouts.admin')

@section('title', 'Edit Manager')

@section('content')

<div class="admin-page">

    <div class="page-header">

        <div>

            <h1>
                <i class="fa-solid fa-user-tie"></i>
                Edit Manager
            </h1>

            <p>Update manager information.</p>

        </div>


        <a
            href="{{ route(
                'admin.managers.show',
                $manager->id
            ) }}"
            class="btn btn-outline"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="content-card">

        <form
            action="{{ route(
                'admin.managers.update',
                $manager->id
            ) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            {{-- Account --}}
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
                                $manager->user->name ?? ''
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
                                $manager->user->email ?? ''
                            ) }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>New Password</label>

                        <input
                            type="password"
                            name="password"
                            placeholder="Leave blank to keep current"
                        >

                    </div>


                    <div class="form-group">

                        <label>Confirm Password</label>

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
                                    $manager->user->status ?? ''
                                ) == 'active'
                                    ? 'selected'
                                    : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old(
                                    'status',
                                    $manager->user->status ?? ''
                                ) == 'inactive'
                                    ? 'selected'
                                    : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- Personal --}}
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
                                $manager->staff_code
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
                                $manager->nic
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
                                $manager->date_of_birth
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
                                    $manager->gender
                                ) == 'male'
                                    ? 'selected'
                                    : '' }}>
                                Male
                            </option>

                            <option value="female"
                                {{ old(
                                    'gender',
                                    $manager->gender
                                ) == 'female'
                                    ? 'selected'
                                    : '' }}>
                                Female
                            </option>

                            <option value="other"
                                {{ old(
                                    'gender',
                                    $manager->gender
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
                                $manager->phone
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
                                $manager->joining_date
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
                                        $manager->employment_type
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


                @if($manager->profile_photo)

                    <div style="margin-bottom:20px;">

                        <img
                            src="{{ asset(
                                'storage/' .
                                $manager->profile_photo
                            ) }}"
                            style="
                                width:80px;
                                height:80px;
                                object-fit:cover;
                                border-radius:50%;
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
                        $manager->address
                    ) }}</textarea>

                </div>

            </div>


            {{-- Professional --}}
            <div class="form-section">

                <div class="section-title">

                    <i class="fa-solid fa-briefcase"></i>

                    Professional Information

                </div>


                <div class="form-group">

                    <label>Qualifications</label>

                    <textarea
                        name="qualifications"
                        rows="4"
                    >{{ old(
                        'qualifications',
                        $manager->qualifications
                    ) }}</textarea>

                </div>


                <div class="form-group">

                    <label>Experience</label>

                    <textarea
                        name="experience"
                        rows="4"
                    >{{ old(
                        'experience',
                        $manager->experience
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
                                $manager->emergency_contact_name
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
                                $manager->emergency_relationship
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
                                $manager->emergency_phone
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


                <textarea
                    name="notes"
                    rows="4"
                    style="width:100%;"
                >{{ old(
                    'notes',
                    $manager->notes
                ) }}</textarea>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route(
                        'admin.managers.show',
                        $manager->id
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

                    Update Manager

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
    margin-bottom:20px;
}

.section-title i {
    color:#ffbe33;
    margin-right:8px;
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
    margin-bottom:7px;
}

.form-group label span {
    color:#dc3545;
}

.form-group input,
.form-group select,
.form-group textarea,
.form-section > textarea {
    width:100%;
    padding:11px 13px;
    border:2px solid #e8e8e8;
    border-radius:8px;
    box-sizing:border-box;
    outline:none;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus,
.form-section > textarea:focus {
    border-color:#ffbe33;
}

.form-actions {
    padding:20px 25px;
    display:flex;
    justify-content:flex-end;
    gap:12px;
}

@media(max-width:768px) {

    .form-grid {
        grid-template-columns:1fr;
    }

    .form-actions {
        flex-direction:column;
    }

}

</style>

@endpush