@extends('layouts.admin')

@section('title', 'Add Healthcare')

@section('content')

<div class="admin-page">

    <div class="page-header">

        <div>
            <h1>
                <i class="fa-solid fa-user-doctor"></i>
                Add Healthcare
            </h1>

            <p>Create a new healthcare staff account.</p>
        </div>

        <a href="{{ route('admin.healthcare.index') }}"
           class="btn btn-outline">

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
            action="{{ route('admin.healthcare.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


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
                            value="{{ old('name') }}"
                            required
                            placeholder="Enter full name"
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
                            placeholder="Enter email address"
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
                            placeholder="Enter password"
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
                            placeholder="Confirm password"
                        >

                    </div>


                    <div class="form-group">

                        <label>Status</label>

                        <select name="status">

                            <option value="active"
                                {{ old('status','active') == 'active'
                                    ? 'selected'
                                    : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status') == 'inactive'
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
                            value="{{ old('staff_code') }}"
                            placeholder="HC001"
                        >

                    </div>


                    <div class="form-group">

                        <label>NIC</label>

                        <input
                            type="text"
                            name="nic"
                            value="{{ old('nic') }}"
                            placeholder="NIC number"
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

                            <option value="">Select Gender</option>

                            <option value="male"
                                {{ old('gender') == 'male'
                                    ? 'selected'
                                    : '' }}>
                                Male
                            </option>

                            <option value="female"
                                {{ old('gender') == 'female'
                                    ? 'selected'
                                    : '' }}>
                                Female
                            </option>

                            <option value="other"
                                {{ old('gender') == 'other'
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
                            value="{{ old('phone') }}"
                            placeholder="Phone number"
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
                        placeholder="Enter address"
                    >{{ old('address') }}</textarea>

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
                            value="{{ old('specialization') }}"
                            placeholder="e.g. Nursing, Physiotherapy"
                        >

                    </div>


                    <div class="form-group">

                        <label>License Number</label>

                        <input
                            type="text"
                            name="license_number"
                            value="{{ old('license_number') }}"
                            placeholder="Professional license number"
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label>Qualifications</label>

                    <textarea
                        name="qualifications"
                        rows="4"
                        placeholder="Enter qualifications"
                    >{{ old('qualifications') }}</textarea>

                </div>


                <div class="form-group">

                    <label>Experience</label>

                    <textarea
                        name="experience"
                        rows="4"
                        placeholder="Enter professional experience"
                    >{{ old('experience') }}</textarea>

                </div>

            </div>


            {{-- Emergency Contact --}}
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
                            value="{{ old('emergency_contact_name') }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Relationship</label>

                        <input
                            type="text"
                            name="emergency_relationship"
                            value="{{ old('emergency_relationship') }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>Emergency Phone</label>

                        <input
                            type="text"
                            name="emergency_phone"
                            value="{{ old('emergency_phone') }}"
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
                        placeholder="Additional notes..."
                    >{{ old('notes') }}</textarea>

                </div>

            </div>


            {{-- Buttons --}}
            <div class="form-actions">

                <a
                    href="{{ route('admin.healthcare.index') }}"
                    class="btn btn-outline"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fa-solid fa-save"></i>
                    Save Healthcare
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

.form-section:last-child {
    border-bottom:none;
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
    transition:.3s;
    box-sizing:border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color:#ffbe33;
    box-shadow:0 0 0 4px rgba(255,190,51,.1);
}

.form-group textarea {
    resize:vertical;
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