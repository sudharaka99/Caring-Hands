@extends('layouts.admin')

@section('title', 'Edit Elder')

@section('content')

<div class="dashboard-page">

    <!-- ==========================================
        PAGE HEADER
    ========================================== -->

    <div class="dashboard-heading">

        <div>

            <h1>Edit Elder</h1>

            <p class="dashboard-subtitle">
                Update resident information for {{ $elder->name }}.
            </p>

        </div>

        <a href="{{ route('admin.elders.index') }}"
            class="btn btn-outline">

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>

    <form action="{{ route('admin.elders.update', $elder->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- ==========================================
            PROFILE PHOTO
        ========================================== -->

        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-camera"></i>

                Profile Photo

            </h3>

            <div class="photo-upload-wrapper">

                <img src="{{ $elder->photo ? asset('storage/' . $elder->photo) : asset('images/default-user.png') }}"
                    id="photoPreview"
                    class="photo-preview"
                    alt="{{ $elder->name }}">

                <input type="file"
                    name="photo"
                    id="photo"
                    accept="image/*"
                    onchange="previewPhoto(event)">

                <label for="photo"
                    class="btn btn-primary">

                    <i class="fa-solid fa-upload"></i>

                    Change Photo

                </label>

                <small style="color:#999; font-size:12px;">
                    Leave empty to keep current photo. Recommended: Square image, max 2MB
                </small>

                @if($elder->photo)
                    <div style="margin-top: 5px;">
                        <small style="color: #666;">
                            Current: {{ basename($elder->photo) }}
                        </small>
                    </div>
                @endif

            </div>

        </div>

        <!-- ==========================================
            PERSONAL INFORMATION
        ========================================== -->

        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-user"></i>

                Personal Information

            </h3>

            <div class="form-grid">

                <div class="form-group">

                    <label>Full Name <span style="color:red;">*</span></label>

                    <input type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $elder->name) }}"
                        required>

                    @error('name')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Elder Code</label>

                    <input type="text"
                        name="elder_code"
                        class="form-control @error('elder_code') is-invalid @enderror"
                        value="{{ old('elder_code', $elder->elder_code) }}"
                        placeholder="Auto-generated if left blank">

                    @error('elder_code')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>NIC / Passport</label>

                    <input type="text"
                        name="nic"
                        class="form-control @error('nic') is-invalid @enderror"
                        value="{{ old('nic', $elder->nic) }}">

                    @error('nic')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Date of Birth</label>

                    <input type="date"
                        name="dob"
                        id="dob"
                        class="form-control @error('dob') is-invalid @enderror"
                        value="{{ old('dob', $elder->dob ? date('Y-m-d', strtotime($elder->dob)) : '') }}">

                    @error('dob')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Age</label>

                    <input type="number"
                        name="age"
                        id="age"
                        class="form-control"
                        value="{{ old('age', $elder->age) }}"
                        readonly>

                </div>

                <div class="form-group">

                    <label>Gender <span style="color:red;">*</span></label>

                    <select name="gender"
                        class="form-control @error('gender') is-invalid @enderror"
                        required>

                        <option value="">Select Gender</option>

                        <option value="male" {{ old('gender', $elder->gender) == 'male' ? 'selected' : '' }}>Male</option>

                        <option value="female" {{ old('gender', $elder->gender) == 'female' ? 'selected' : '' }}>Female</option>

                        <option value="other" {{ old('gender', $elder->gender) == 'other' ? 'selected' : '' }}>Other</option>

                    </select>

                    @error('gender')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Blood Group</label>

                    <select name="blood_group"
                        class="form-control @error('blood_group') is-invalid @enderror">

                        <option value="">Select</option>

                        <option value="A+" {{ old('blood_group', $elder->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('blood_group', $elder->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('blood_group', $elder->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('blood_group', $elder->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('blood_group', $elder->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('blood_group', $elder->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('blood_group', $elder->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('blood_group', $elder->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>

                    </select>

                    @error('blood_group')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

            </div>

        </div>

        <!-- ==========================================
            CONTACT INFORMATION
        ========================================== -->

        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-phone"></i>

                Contact Information

            </h3>

            <div class="form-grid">

                <div class="form-group">

                    <label>Phone Number <span style="color:red;">*</span></label>

                    <input type="text"
                        name="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $elder->phone) }}"
                        required>

                    @error('phone')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $elder->email) }}">

                    @error('email')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group full-width">

                    <label>Address</label>

                    <textarea name="address"
                        rows="3"
                        class="form-control @error('address') is-invalid @enderror">{{ old('address', $elder->address) }}</textarea>

                    @error('address')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

            </div>

        </div>

        <!-- ==========================================
            EMERGENCY CONTACT
        ========================================== -->

        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-triangle-exclamation"></i>

                Emergency Contact

            </h3>

            <div class="form-grid">

                <div class="form-group">

                    <label>Emergency Contact Name</label>

                    <input type="text"
                        name="emergency_contact_name"
                        class="form-control @error('emergency_contact_name') is-invalid @enderror"
                        value="{{ old('emergency_contact_name', $elder->emergency_contact_name ?? $elder->guardian_name) }}">

                    @error('emergency_contact_name')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Emergency Contact Phone</label>

                    <input type="text"
                        name="emergency_contact_phone"
                        class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                        value="{{ old('emergency_contact_phone', $elder->emergency_contact_phone ?? $elder->guardian_phone) }}">

                    @error('emergency_contact_phone')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group full-width">

                    <label>Relationship</label>

                    <input type="text"
                        name="emergency_contact_relationship"
                        class="form-control @error('emergency_contact_relationship') is-invalid @enderror"
                        value="{{ old('emergency_contact_relationship', $elder->emergency_contact_relationship ?? $elder->guardian_relationship) }}"
                        placeholder="e.g., Son, Daughter, Spouse">

                    @error('emergency_contact_relationship')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

            </div>

        </div>

        <!-- ==========================================
            ROOM & CAREGIVER
        ========================================== -->

        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-bed"></i>

                Room & Caregiver

            </h3>

            <div class="form-grid">

                <div class="form-group">

                    <label>Room Number <span style="color:red;">*</span></label>

                    <input type="text"
                        name="room"
                        class="form-control @error('room') is-invalid @enderror"
                        value="{{ old('room', $elder->room) }}"
                        required>

                    @error('room')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Caregiver Assigned</label>

                    <input type="text"
                        name="caregiver"
                        class="form-control @error('caregiver') is-invalid @enderror"
                        value="{{ old('caregiver', $elder->caregiver) }}">

                    @error('caregiver')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Admission Date</label>

                    <input type="date"
                        name="admission_date"
                        class="form-control @error('admission_date') is-invalid @enderror"
                        value="{{ old('admission_date', $elder->admission_date ? date('Y-m-d', strtotime($elder->admission_date)) : date('Y-m-d')) }}">

                    @error('admission_date')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Status <span style="color:red;">*</span></label>

                    <select name="status"
                        class="form-control @error('status') is-invalid @enderror"
                        required>

                        <option value="active" {{ old('status', $elder->status) == 'active' ? 'selected' : '' }}>Active</option>

                        <option value="inactive" {{ old('status', $elder->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>

                    </select>

                    @error('status')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group full-width">

                    <label>Medical Notes</label>

                    <textarea name="medical_notes"
                        rows="3"
                        class="form-control @error('medical_notes') is-invalid @enderror"
                        placeholder="Any medical conditions, allergies, or special requirements...">{{ old('medical_notes', $elder->medical_notes) }}</textarea>

                    @error('medical_notes')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

            </div>

        </div>

        <!-- ==========================================
            FORM ACTIONS
        ========================================== -->

        <div class="form-actions">

            <a href="{{ route('admin.elders.index') }}"
                class="btn btn-outline">

                Cancel

            </a>

            <button type="submit"
                class="btn btn-primary">

                <i class="fa-solid fa-floppy-disk"></i>

                Update Elder

            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

function previewPhoto(event){

    let reader = new FileReader();

    reader.onload = function(){

        document.getElementById('photoPreview').src =
        reader.result;

    }

    reader.readAsDataURL(event.target.files[0]);

}

document.getElementById('dob').addEventListener('change',function(){

    let birth = new Date(this.value);

    let today = new Date();

    let age = today.getFullYear() - birth.getFullYear();

    let m = today.getMonth() - birth.getMonth();

    if(m < 0 || (m === 0 && today.getDate() < birth.getDate())){

        age--;

    }

    if (age > 0 && age < 120) {
        document.getElementById('age').value = age;
    } else {
        document.getElementById('age').value = '';
    }

});

document.addEventListener('DOMContentLoaded', function() {
    const dobInput = document.getElementById('dob');
    if (dobInput && dobInput.value) {
        dobInput.dispatchEvent(new Event('change'));
    }
});

</script>

@endpush