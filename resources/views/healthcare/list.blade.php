@extends('layouts.admin')

@section('title', $title . ' | Caring Hands')

@section('content')
<div class="dashboard-page">

    {{-- ==========================================
         PAGE HEADER + ACTION BUTTONS
    =========================================== --}}
    <div class="dashboard-heading">
        <div>
            <h1>{{ $title }}</h1>
            <p class="dashboard-subtitle">{{ $subtitle }}</p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">

            @if($type === 'care-plans')
                <a href="{{ route('healthcare.care-plans.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    New Care Plan
                </a>
            @endif

            @if($type === 'medications')
                <a href="{{ route('healthcare.medication.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    New Medication
                </a>
            @endif

            @if($type === 'appointments')
                <a href="{{ route('healthcare.appointments.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    New Appointment
                </a>
            @endif

        </div>
    </div>


    {{-- ==========================================
         MEDICATIONS — Grouped by Resident
    =========================================== --}}
    @if($type === 'medications')

        @php
            $grouped = $items->groupBy(fn($med) => $med->elder_id ?? 0);
        @endphp

        @forelse($grouped as $elderId => $meds)

            @php
                $elder = $meds->first()->elder ?? null;
            @endphp

            <div class="dashboard-card" style="margin-bottom: 20px;">

                {{-- Resident Header --}}
                <div class="dashboard-card-header" style="border-bottom: 1px solid #EAECF0; padding-bottom: 16px;">
                    <div class="resident-user">
                        <div class="resident-avatar" style="width: 52px; height: 52px; font-size: 20px;">
                            @if($elder && !empty($elder->photo))
                                <img src="{{ asset('storage/' . $elder->photo) }}" alt="{{ $elder->name }}">
                            @else
                                {{ strtoupper(substr($elder->name ?? '?', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <strong style="font-size: 16px;">
                                {{ $elder->name ?? 'Unknown Resident' }}
                            </strong>
                            <span style="display: block; color: #98A2B3; font-size: 13px;">
                                {{ $elder->elder_code ?? '' }}
                                @if($elder && $elder->room) · Room {{ $elder->room }} @endif
                            </span>
                        </div>
                    </div>

                    <span class="table-status active" style="font-size: 12px;">
                        {{ $meds->count() }} {{ Str::plural('Medication', $meds->count()) }}
                    </span>
                </div>


                {{-- Medications Table --}}
                <div class="dashboard-table-wrapper" style="margin-top: 12px;">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Medication</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meds as $med)
                                <tr>
                                    <td>
                                        <strong>{{ $med->medication_name }}</strong>
                                        @if($med->generic_name)
                                            <span style="display: block; font-size: 12px; color: #98A2B3;">
                                                {{ $med->generic_name }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $med->dosage }} {{ $med->dosage_unit }}</td>
                                    <td>{{ str_replace('_', ' ', ucfirst($med->frequency)) }}</td>
                                    <td>{{ $med->administration_time ?? '-' }}</td>
                                    <td>
                                        <span class="table-status {{ $med->status === 'active' ? 'active' : 'warning' }}">
                                            {{ ucfirst($med->status) }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 6px;">
                                            <a href="{{ route('healthcare.medication.show', $med->id) }}"
                                               class="table-action" title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('healthcare.medication.edit', $med->id) }}"
                                               class="table-action" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        @empty
            <div class="dashboard-card">
                <div class="empty-table">
                    <i class="fa-solid fa-pills"></i>
                    <strong>No medications found</strong>
                    <span>No medications are assigned yet.</span>
                    <a href="{{ route('healthcare.medication.create') }}"
                       class="btn btn-primary"
                       style="margin-top: 12px; display: inline-flex;">
                        <i class="fa-solid fa-plus"></i>
                        Add First Medication
                    </a>
                </div>
            </div>
        @endforelse


    {{-- ==========================================
         OTHER TYPES — Flat Table
    =========================================== --}}
    @else

        <div class="dashboard-card">
            <div class="dashboard-table-wrapper">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            @if($type === 'care-plans')
                                <th>Resident</th>
                                <th>Care Plan</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            @elseif($type === 'appointments')
                                <th>Resident</th>
                                <th>Title</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            @elseif($type === 'shifts')
                                <th>Date</th><th>Shift</th><th>Start</th><th>End</th><th>Status</th>
                            @elseif($type === 'attendance')
                                <th>Date</th><th>Check In</th><th>Check Out</th><th>Status</th>
                            @else
                                <th>Message</th><th>Date</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                @if($type === 'care-plans')
                                    <td>{{ $item->elder->name ?? '-' }}</td>
                                    <td><strong>{{ $item->title }}</strong></td>
                                    <td>
                                        <span class="table-status {{ $item->priority === 'critical' ? 'danger' : ($item->priority === 'high' ? 'warning' : 'active') }}">
                                            {{ ucfirst($item->priority) }}
                                        </span>
                                    </td>
                                    <td>{{ ucfirst($item->status) }}</td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 6px;">
                                            <a href="{{ route('healthcare.care-plans.show', $item->id) }}"
                                               class="table-action" title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('healthcare.care-plans.edit', $item->id) }}"
                                               class="table-action" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        </div>
                                    </td>

                                @elseif($type === 'appointments')
                                    <td>{{ $item->elder_name ?? '-' }}</td>
                                    <td><strong>{{ $item->title }}</strong></td>
                                    <td>{{ $item->doctor_name ?? '-' }}</td>
                                    <td>{{ $item->appointment_date }} · {{ $item->appointment_time }}</td>
                                    <td><span class="table-status active">{{ ucfirst($item->status) }}</span></td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('healthcare.appointments.edit', $item->id) }}"
                                           class="table-action" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </td>

                                @elseif($type === 'shifts')
                                    <td>{{ $item->shift_date }}</td>
                                    <td>{{ $item->shiftType->name ?? '-' }}</td>
                                    <td>{{ $item->start_time ?? '-' }}</td>
                                    <td>{{ $item->end_time ?? '-' }}</td>
                                    <td><span class="table-status active">{{ ucfirst($item->status) }}</span></td>

                                @elseif($type === 'attendance')
                                    <td>{{ $item->attendance_date }}</td>
                                    <td>{{ $item->check_in ?? '-' }}</td>
                                    <td>{{ $item->check_out ?? '-' }}</td>
                                    <td><span class="table-status active">{{ ucfirst($item->status) }}</span></td>

                                @else
                                    <td>{{ $item->subject ?? $item->message ?? 'Message' }}</td>
                                    <td>{{ $item->created_at ?? '-' }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-table">
                                        <i class="fa-solid fa-inbox"></i>
                                        <strong>No records found</strong>
                                        <span>Nothing to display yet.</span>

                                        @if($type === 'care-plans')
                                            <a href="{{ route('healthcare.care-plans.create') }}"
                                               class="btn btn-primary"
                                               style="margin-top: 12px; display: inline-flex;">
                                                <i class="fa-solid fa-plus"></i>
                                                Add First Care Plan
                                            </a>
                                        @endif

                                        @if($type === 'appointments')
                                            <a href="{{ route('healthcare.appointments.create') }}"
                                               class="btn btn-primary"
                                               style="margin-top: 12px; display: inline-flex;">
                                                <i class="fa-solid fa-plus"></i>
                                                Add First Appointment
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($items, 'links'))
                <div class="pagination-container">{{ $items->links() }}</div>
            @endif
        </div>

    @endif

</div>
@endsection