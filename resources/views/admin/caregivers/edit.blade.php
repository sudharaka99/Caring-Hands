@extends('layouts.admin')

@section('title', 'Edit Caregiver')

@section('content')

<div class="admin-page">
    <div class="page-header">
        <div>
            <h1>Edit Caregiver</h1>
            <p>Update caregiver information.</p>
        </div>
        <a href="{{ route('admin.caregivers.index') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="content-card form-card">
        <form method="POST" action="{{ route('admin.caregivers.update', $caregiver->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                {{-- Name --}}
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $caregiver->user->name ?? '') }}" placeholder="Enter full name" required>
                    @error('name')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" value="{{ old('email', $caregiver->user->email ?? '') }}" placeholder="Enter email address" required>
                    @error('email')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $caregiver->phone) }}" placeholder="Enter phone number">
                </div>

                {{-- Staff Code --}}
                <div class="form-group">
                    <label>Staff Code</label>
                    <input type="text" name="staff_code" value="{{ old('staff_code', $caregiver->staff_code) }}" placeholder="Enter staff code">
                </div>

                {{-- NIC --}}
                <div class="form-group">
                    <label>NIC</label>
                    <input type="text" name="nic" value="{{ old('nic', $caregiver->nic) }}" placeholder="Enter NIC number">
                </div>

                {{-- Date of Birth --}}
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $caregiver->date_of_birth) }}">
                </div>

                {{-- Gender --}}
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $caregiver->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $caregiver->gender) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $caregiver->gender) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                {{-- Address --}}
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Address</label>
                    <textarea name="address" rows="2" placeholder="Enter address">{{ old('address', $caregiver->address) }}</textarea>
                </div>

                {{-- Joining Date --}}
                <div class="form-group">
                    <label>Joining Date</label>
                    <input type="date" name="joining_date" value="{{ old('joining_date', $caregiver->joining_date) }}">
                </div>

                {{-- Employment Type --}}
                <div class="form-group">
                    <label>Employment Type</label>
                    <select name="employment_type">
                        <option value="full_time" {{ old('employment_type', $caregiver->employment_type) === 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ old('employment_type', $caregiver->employment_type) === 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ old('employment_type', $caregiver->employment_type) === 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="temporary" {{ old('employment_type', $caregiver->employment_type) === 'temporary' ? 'selected' : '' }}>Temporary</option>
                    </select>
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <option value="active" {{ old('status', $caregiver->user->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $caregiver->user->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Emergency Contact --}}
                <div class="form-group">
                    <label>Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $caregiver->emergency_contact_name) }}" placeholder="Emergency contact name">
                </div>

                <div class="form-group">
                    <label>Emergency Relationship</label>
                    <input type="text" name="emergency_relationship" value="{{ old('emergency_relationship', $caregiver->emergency_relationship) }}" placeholder="Relationship">
                </div>

                <div class="form-group">
                    <label>Emergency Phone</label>
                    <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $caregiver->emergency_phone) }}" placeholder="Emergency phone number">
                </div>

                {{-- New Password --}}
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current password">
                    <small>Leave blank if you don't want to change the password.</small>
                    @error('password')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm new password">
                </div>

                {{-- Qualifications --}}
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Qualifications</label>
                    <textarea name="qualifications" rows="2" placeholder="Enter qualifications">{{ old('qualifications', $caregiver->qualifications) }}</textarea>
                </div>

                {{-- Experience --}}
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Experience</label>
                    <textarea name="experience" rows="2" placeholder="Enter experience">{{ old('experience', $caregiver->experience) }}</textarea>
                </div>

                {{-- Notes --}}
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Notes</label>
                    <textarea name="notes" rows="2" placeholder="Additional notes">{{ old('notes', $caregiver->notes) }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.caregivers.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Update Caregiver
                </button>
            </div>
        </form>
    </div>
</div>

@endsection