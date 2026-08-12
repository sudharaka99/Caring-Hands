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
             ELDER ASSIGNMENT WITH SEARCH
        ========================================== -->

        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-person-cane"></i>

                Assign Elders

            </h3>

            <div class="form-group">

                <label>Select Elders to Assign</label>

                <p style="color:#777; font-size:14px; margin-bottom:10px;">
                    Search and select one or more elders to link with this owner.
                </p>

                <!-- Search Box -->
                <div style="margin-bottom:15px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

                    <div style="position:relative; flex:1; min-width:200px;">

                        <i class="fa-solid fa-search" 
                           style="position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#999;"></i>

                        <input type="text" 
                               id="elderSearchInput" 
                               class="form-control" 
                               placeholder="Search by name, code, room..." 
                               style="padding-left: 40px;">

                    </div>

                    <span id="searchCount" style="color:#999; font-size:13px; white-space:nowrap;">
                        Showing: <span id="visibleCount">0</span> / <span id="totalCount">0</span> elders
                    </span>

                    <button type="button" 
                            onclick="selectAllElders()" 
                            class="btn btn-sm btn-primary" 
                            style="padding: 8px 16px; font-size: 13px; background:#28a745;">

                        <i class="fa-solid fa-check-double"></i> Select All

                    </button>

                    <button type="button" 
                            onclick="deselectAllElders()" 
                            class="btn btn-sm btn-outline" 
                            style="padding: 8px 16px; font-size: 13px; border-color:#dc3545; color:#dc3545;">

                        <i class="fa-solid fa-times"></i> Deselect All

                    </button>

                </div>

                <!-- Elder List -->
                <div id="elderListContainer" 
                     style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:10px; max-height:350px; overflow-y:auto; padding:10px; border:1px solid #ddd; border-radius:10px; background:#fafafa;">

                    @forelse($elders ?? [] as $elder)

                        <label class="elder-checkbox-item" 
                               data-name="{{ strtolower($elder->name) }}"
                               data-code="{{ strtolower($elder->elder_code ?? '') }}"
                               data-room="{{ strtolower($elder->room ?? '') }}"
                               style="display:flex; align-items:center; gap:10px; padding:10px 12px; cursor:pointer; border-radius:8px; transition:background 0.3s; background:#fff; border:1px solid #eee;">

                            <input type="checkbox"
                                   name="elder_ids[]"
                                   value="{{ $elder->id }}"
                                   class="elder-checkbox"
                                   {{ in_array($elder->id, old('elder_ids', [])) ? 'checked' : '' }}>

                            <div style="flex:1; min-width:0;">

                                <div style="font-weight:600; font-size:14px; color:#333; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $elder->name }}
                                </div>

                                <div style="font-size:12px; color:#999; display:flex; gap:10px; flex-wrap:wrap;">

                                    @if($elder->elder_code)
                                        <span>Code: {{ $elder->elder_code }}</span>
                                    @endif

                                    @if($elder->room)
                                        <span>Room: {{ $elder->room }}</span>
                                    @endif

                                </div>

                            </div>

                            <span class="status-badge {{ $elder->status == 'active' ? 'active' : 'inactive' }}"
                                  style="font-size:10px; padding:2px 10px; flex-shrink:0;">
                                {{ ucfirst($elder->status ?? 'Active') }}
                            </span>

                        </label>

                    @empty

                        <p style="color:#999; text-align:center; padding:20px; grid-column: 1/-1;">
                            No active elders available. Please add elders first.
                        </p>

                    @endforelse

                </div>

                <!-- No Results Message -->
                <div id="noResults" style="display:none; text-align:center; padding:30px; color:#999;">
                    <i class="fa-solid fa-search" style="font-size:30px; display:block; margin-bottom:10px;"></i>
                    <p>No elders found matching your search.</p>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; flex-wrap:wrap; gap:10px;">

                    <small style="color:#999; font-size:12px;">
                        <i class="fa-solid fa-info-circle"></i>
                        <span id="selectedCount">0</span> elder(s) selected
                    </small>

                    <small style="color:#999; font-size:12px;">
                        Hold <kbd>Ctrl</kbd>/<kbd>Cmd</kbd> to select multiple elders.
                    </small>

                </div>

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

@push('styles')
<style>
    .elder-checkbox-item:hover {
        background: #FFF4F6 !important;
        border-color: #FF9CA9 !important;
    }

    .elder-checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #FF9CA9;
        flex-shrink: 0;
    }

    .elder-checkbox-item input[type="checkbox"]:checked + div {
        opacity: 1;
    }

    .elder-checkbox-item:has(input:checked) {
        background: #FFF4F6 !important;
        border-color: #FF9CA9 !important;
    }

    #elderListContainer::-webkit-scrollbar {
        width: 6px;
    }

    #elderListContainer::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #elderListContainer::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }

    #elderListContainer::-webkit-scrollbar-thumb:hover {
        background: #ccc;
    }

    kbd {
        background: #f4f4f4;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 2px 6px;
        font-size: 11px;
        font-weight: 600;
        color: #555;
    }
</style>
@endpush

@push('scripts')

<script>
    function previewPhoto(event) {
        let reader = new FileReader();
        reader.onload = function() {
            document.getElementById('photoPreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // ==========================================
    // ELDER SEARCH FUNCTION
    // ==========================================

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('elderSearchInput');
        const elderItems = document.querySelectorAll('.elder-checkbox-item');
        const noResults = document.getElementById('noResults');
        const visibleCount = document.getElementById('visibleCount');
        const totalCount = document.getElementById('totalCount');
        const selectedCount = document.getElementById('selectedCount');

        // Update total count
        if (totalCount) {
            totalCount.textContent = elderItems.length;
        }

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.elder-checkbox:checked');
            if (selectedCount) {
                selectedCount.textContent = checked.length;
            }
        }

        // Update selected count on checkbox change
        document.querySelectorAll('.elder-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        // Initial selected count
        updateSelectedCount();

        // Search function
        function filterElders() {
            const query = searchInput.value.toLowerCase().trim();
            let visible = 0;

            elderItems.forEach(item => {
                const name = item.dataset.name || '';
                const code = item.dataset.code || '';
                const room = item.dataset.room || '';

                const matches = name.includes(query) || 
                              code.includes(query) || 
                              room.includes(query);

                if (matches) {
                    item.style.display = 'flex';
                    visible++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Update counts
            if (visibleCount) {
                visibleCount.textContent = visible;
            }

            // Show/hide no results message
            if (noResults) {
                noResults.style.display = visible === 0 && elderItems.length > 0 ? 'block' : 'none';
            }

            // Show/hide container based on results
            const container = document.getElementById('elderListContainer');
            if (container) {
                // If no elders at all
                if (elderItems.length === 0) {
                    container.style.display = 'block';
                }
            }

            // Update selected count
            updateSelectedCount();
        }

        // Search on input
        if (searchInput) {
            searchInput.addEventListener('input', filterElders);
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    filterElders();
                }
            });
        }

        // Initial filter
        filterElders();

        // Select All function
        window.selectAllElders = function() {
            const visibleCheckboxes = document.querySelectorAll('.elder-checkbox-item[style*="display: flex"] input[type="checkbox"], .elder-checkbox-item:not([style*="display: none"]) input[type="checkbox"]');
            visibleCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            updateSelectedCount();
        }

        // Deselect All function
        window.deselectAllElders = function() {
            document.querySelectorAll('.elder-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectedCount();
        }

        // Select/Deselect all from the container
        window.selectAllElders = selectAllElders;
        window.deselectAllElders = deselectAllElders;
    });

    // ==========================================
    // FORM SUBMISSION
    // ==========================================

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