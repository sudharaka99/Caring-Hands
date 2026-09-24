@extends('layouts.admin')

@section('title', 'Caregiver Details')

@section('content')

<div class="admin-page">
    <div class="page-header">
        <div>
            <h1>👤 Caregiver Details</h1>
            <p>View caregiver information.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.caregivers.index') }}" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @if(canAccess('admin.caregivers.index', 'can_edit'))
                <a href="{{ route('admin.caregivers.edit', $caregiver->id) }}" class="btn btn-primary">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
            @endif
        </div>
    </div>

    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($caregiver->user->name ?? 'N/A', 0, 1)) }}
            </div>
            <div>
                <h2>{{ $caregiver->user->name ?? 'N/A' }}</h2>
                <p>
                    <i class="fa-solid fa-user-nurse"></i>
                    Caregiver
                </p>
            </div>
            <span class="status-badge status-{{ $caregiver->user->status ?? 'inactive' }}">
                {{ ucfirst($caregiver->user->status ?? 'Inactive') }}
            </span>
        </div>

        <div class="profile-details">
            <div class="detail-item">
                <span>Email Address</span>
                <strong>{{ $caregiver->user->email ?? 'N/A' }}</strong>
            </div>
            <div class="detail-item">
                <span>Phone Number</span>
                <strong>{{ $caregiver->phone ?? '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>Staff Code</span>
                <strong>{{ $caregiver->staff_code ?? '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>NIC</span>
                <strong>{{ $caregiver->nic ?? '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>Date of Birth</span>
                <strong>{{ $caregiver->date_of_birth ? \Carbon\Carbon::parse($caregiver->date_of_birth)->format('d M Y') : '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>Gender</span>
                <strong>{{ ucfirst($caregiver->gender ?? '-') }}</strong>
            </div>
            <div class="detail-item">
                <span>Address</span>
                <strong>{{ $caregiver->address ?? '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>Joining Date</span>
                <strong>{{ $caregiver->joining_date ? \Carbon\Carbon::parse($caregiver->joining_date)->format('d M Y') : '-' }}</strong>
            </div>
            <div class="detail-item">
                <span>Employment Type</span>
                <strong>{{ ucfirst(str_replace('_', ' ', $caregiver->employment_type ?? '-')) }}</strong>
            </div>
            <div class="detail-item">
                <span>Role</span>
                <strong>Caregiver</strong>
            </div>
            <div class="detail-item">
                <span>Account Created</span>
                <strong>{{ $caregiver->created_at ? \Carbon\Carbon::parse($caregiver->created_at)->format('d M Y, h:i A') : '-' }}</strong>
            </div>
            <div class="detail-item" style="grid-column: 1 / -1;">
                <span>Qualifications</span>
                <strong>{{ $caregiver->qualifications ?? '-' }}</strong>
            </div>
            <div class="detail-item" style="grid-column: 1 / -1;">
                <span>Experience</span>
                <strong>{{ $caregiver->experience ?? '-' }}</strong>
            </div>
            <div class="detail-item" style="grid-column: 1 / -1;">
                <span>Notes</span>
                <strong>{{ $caregiver->notes ?? '-' }}</strong>
            </div>
            <div class="detail-item" style="grid-column: 1 / -1;">
                <span>Emergency Contact</span>
                <strong>
                    @if($caregiver->emergency_contact_name || $caregiver->emergency_phone)
                        {{ $caregiver->emergency_contact_name ?? 'N/A' }} 
                        ({{ $caregiver->emergency_relationship ?? 'N/A' }}) - 
                        {{ $caregiver->emergency_phone ?? 'N/A' }}
                    @else
                        No emergency contact provided
                    @endif
                </strong>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .profile-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #eee;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 30px;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
        flex-wrap: wrap;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #ffbe33;
        color: #222831;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .profile-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #222831;
        margin: 0 0 4px 0;
    }

    .profile-header p {
        color: #999;
        font-size: 14px;
        margin: 0;
    }

    .profile-header p i {
        margin-right: 6px;
    }

    .profile-header .status-badge {
        margin-left: auto;
    }

    .profile-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        padding: 30px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-item span {
        color: #999;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-item strong {
        color: #222831;
        font-size: 16px;
        font-weight: 600;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .page-actions {
        display: flex;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-header .status-badge {
            margin-left: 0;
        }
        
        .profile-details {
            grid-template-columns: 1fr;
            padding: 20px;
        }
        
        .page-actions {
            width: 100%;
            flex-direction: column;
        }
        
        .page-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush