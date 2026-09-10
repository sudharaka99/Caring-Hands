@extends('layouts.admin')

@section('title', 'Add Manager')

@section('content')

<div class="admin-page">

    <div class="page-header">

        <div>

            <h1>
                <i class="fa-solid fa-user-tie"></i>
                Add Manager
            </h1>

            <p>Create a new manager account.</p>

        </div>


        <a
            href="{{ route('admin.managers.index') }}"
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
            action="{{ route('admin.managers.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


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
                            value="{{ old('name') }}"
                            required
                            placeholder="Manager full name"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Email <span>*</span>
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="manager@example.com"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Password <span>*</span>
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Confirm Password <span>*</span>
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>Status</label>

                        <select name="status">

                            <option value="active">
                                Active
                            </option>

                            <option value="inactive">
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
                            value="{{ old('staff_code') }}"
                            placeholder="MGR001"
                        >

                    </div>


                    <div class="form-group">

                        <label>NIC</label>

                        <input
                            type="text"
                            name="nic"
                            value="{{ old('nic') }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Date of Birth</label>

                        <input
                            type="date"
                            name="date_of_birth"
                            value="{{ old('date_of_birth') }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Gender</label>

                        <select name="gender">

                            <option value="">
                                Select Gender
                            </option>

                            <option value="male">
                                Male
                            </option>

                            <option value="female">
                                Female
                            </option>

                            <option value="other">
                                Other
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>Phone</label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Joining Date</label>

                        <input
                            type="date"
                            name="joining_date"
                            value="{{ old('joining_date') }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Employment Type</label>

                        <select name="employment_type">

                            <option value="full_time">
                                Full Time
                            </option>

                            <option value="part_time">
                                Part Time
                            </option>

                            <option value="contract">
                                Contract
                            </option>

                            <option value="temporary">
                                Temporary
                            </option>

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


                <div class="form-group">

                    <label>Address</label>

                    <textarea
                        name="address"
                        rows="3"
                    >{{ old('address') }}</textarea>

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
                    >{{ old('qualifications') }}</textarea>

                </div>


                <div class="form-group">

                    <label>Experience</label>

                    <textarea
                        name="experience"
                        rows="4"
                    >{{ old('experience') }}</textarea>

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
                                'emergency_contact_name'
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Relationship</label>

                        <input
                            type="text"
                            name="emergency_relationship"
                            value="{{ old(
                                'emergency_relationship'
                            ) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Emergency Phone</label>

                        <input
                            type="text"
                            name="emergency_phone"
                            value="{{ old(
                                'emergency_phone'
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
                >{{ old('notes') }}</textarea>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('admin.managers.index') }}"
                    class="btn btn-outline"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="fa-solid fa-save"></i>

                    Save Manager

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