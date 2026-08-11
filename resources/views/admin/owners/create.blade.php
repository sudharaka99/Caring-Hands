@extends('layouts.admin')

@section('title', 'Add Owner')

@section('content')

<div class="dashboard-page">

    <!-- ==========================================
         PAGE HEADER
    ========================================== -->

    <div class="dashboard-heading">

        <div>
            <h1>Add New Owner</h1>

            <p class="dashboard-subtitle">
                Register a new owner or guardian for elderly residents.
            </p>

        </div>

        <a href="{{ route('admin.owners.index') }}"
           class="btn btn-outline">

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>

    <form action="{{ route('admin.owners.store') }}"
          method="POST"
          enctype="multipart/form-data"
          id="ownerForm">

        @csrf

        <!-- ==========================================
             PROFILE PHOTO
        ========================================== -->

        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-camera"></i>

                Profile Photo

            </h3>

            <div class="photo-upload-wrapper">

                <img src="{{ asset('images/default-user.png') }}"
                     id="photoPreview"
                     class="photo-preview">

                <input type="file"
                       name="photo"
                       id="photo"
                       accept="image/*"
                       onchange="previewPhoto(event)">

                <label for="photo"
                       class="btn btn-primary">

                    <i class="fa-solid fa-upload"></i>

                    Upload Photo

                </label>

                <small style="color:#999; font-size:12px;">
                    Recommended: Square image, max 2MB
                </small>

                @error('photo')
                    <small style="color:red;">{{ $message }}</small>
                @enderror

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
                           value="{{ old('name') }}"
                           required
                           placeholder="Enter full name">

                    @error('name')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>NIC</label>

                    <input type="text"
                           name="nic"
                           class="form-control @error('nic') is-invalid @enderror"
                           value="{{ old('nic') }}"
                           placeholder="Enter NIC number">

                    @error('nic')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Phone Number <span style="color:red;">*</span></label>

                    <input type="text"
                           name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}"
                           required
                           placeholder="Enter phone number">

                    @error('phone')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="Enter email address">

                    @error('email')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group full-width">

                    <label>Address</label>

                    <textarea name="address"
                              rows="3"
                              class="form-control @error('address') is-invalid @enderror"
                              placeholder="Enter residential address">{{ old('address') }}</textarea>

                    @error('address')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Relationship</label>

                    <input type="text"
                           name="relationship"
                           class="form-control @error('relationship') is-invalid @enderror"
                           value="{{ old('relationship') }}"
                           placeholder="e.g., Son, Daughter, Guardian">

                    @error('relationship')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Status <span style="color:red;">*</span></label>

                    <select name="status"
                            class="form-control @error('status') is-invalid @enderror"
                            required>

                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>

                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>

                    </select>

                    @error('status')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                </div>

            </div>

        </div>

        <!-- ==========================================
             ELDER ASSIGNMENT
        ========================================== -->

        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-person-cane"></i>

                Assign Elders

            </h3>

            <div class="form-group">

                <label>Select Elders to Assign</label>

                <p style="color:#777; font-size:14px; margin-bottom:10px;">
                    Select one or more elders to link with this owner.
                </p>

                <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:10px; max-height:300px; overflow-y:auto; padding:10px; border:1px solid #ddd; border-radius:10px;">

                    @forelse($elders ?? [] as $elder)

                        <label style="display:flex; align-items:center; gap:10px; padding:8px; cursor:pointer; border-radius:8px; transition:background 0.3s;"
                               onmouseover="this.style.background='#FFF4F6'"
                               onmouseout="this.style.background='transparent'">

                            <input type="checkbox"
                                   name="elder_ids[]"
                                   value="{{ $elder->id }}"
                                   {{ in_array($elder->id, old('elder_ids', [])) ? 'checked' : '' }}>

                            <span>
                                <strong>{{ $elder->name }}</strong>
                                <br>
                                <small style="color:#999;">Room: {{ $elder->room ?? 'N/A' }}</small>
                            </span>

                            <span class="status-badge {{ $elder->status == 'active' ? 'active' : 'inactive' }}"
                                  style="font-size:10px; padding:2px 10px; margin-left:auto;">
                                {{ ucfirst($elder->status ?? 'Active') }}
                            </span>

                        </label>

                    @empty

                        <p style="color:#999; text-align:center; padding:20px; grid-column: 1/-1;">
                            No active elders available. Please add elders first.
                        </p>

                    @endforelse

                </div>

                <small style="color:#999; font-size:12px; margin-top:10px; display:block;">
                    <i class="fa-solid fa-info-circle"></i>
                    Hold Ctrl/Cmd to select multiple elders.
                </small>

                @error('elder_ids')
                    <small style="color:red;">{{ $message }}</small>
                @enderror

            </div>

        </div>

        <!-- ==========================================
             FORM ACTIONS
        ========================================== -->

        <div class="form-actions">

            <a href="{{ route('admin.owners.index') }}"
               class="btn btn-outline">

                <i class="fa-solid fa-times"></i>

                Cancel

            </a>

            <button type="submit"
                    class="btn btn-primary"
                    id="submitBtn">

                <i class="fa-solid fa-floppy-disk"></i>

                Save Owner

            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>
    function previewPhoto(event) {
        let reader = new FileReader();
        reader.onload = function() {
            document.getElementById('photoPreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('ownerForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            if (form.checkValidity()) {
                showLoading('Saving owner...');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            }
        });

        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('invalid', function() {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Owner';
            });
        });
    });

</script>

@endpush