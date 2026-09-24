@extends('layouts.admin')

@section('title', $title . ' | Caring Hands')

@section('content')
<div class="dashboard-page">

    <!-- Page Header -->
    <div class="dashboard-heading">
        <div>
            <h1>{{ $title }}</h1>
            <p class="dashboard-subtitle">{{ $subtitle }}</p>
        </div>
    </div>


    {{-- ==========================================
         MEDICATIONS — Grouped by Resident
    =========================================== --}}
    @if($type === 'medications')

        @php
            // Group medications by resident
            $grouped = $items->groupBy(function ($med) {
                return $med->elder->id ?? 0;
            });
        @endphp

        @forelse($grouped as $elderId => $meds)

            @php
                $elder = $meds->first()->elder ?? null;
            @endphp

            <div class="dashboard-card" style="margin-bottom: 20px;">

                <!-- Resident Header -->
                <div class="dashboard-card-header" style="border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                    <div class="resident-user">
                        <div class="resident-avatar" style="width: 52px; height: 52px; font-size: 20px;">
                            @if($elder && !empty($elder->photo))
                                <img src="{{ asset('storage/' . $elder->photo) }}"
                                     alt="{{ $elder->name }}">
                            @else
                                {{ strtoupper(substr($elder->name ?? '?', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <strong style="font-size: 16px;">
                                {{ $elder->name ?? 'Unknown Resident' }}
                            </strong>
                            <span style="display: block; color: #6b7280; font-size: 13px;">
                                {{ $elder->elder_code ?? '' }}
                                @if($elder && $elder->room)
                                    · Room {{ $elder->room }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <span class="table-status active" style="font-size: 12px;">
                        {{ $meds->count() }} {{ Str::plural('Medication', $meds->count()) }}
                    </span>
                </div>


                <!-- Medications Table for This Resident -->
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
                                            <span style="display:block; font-size:12px; color:#6b7280;">
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
                                        <form method="POST"
                                              action="{{ route('caregiver.medication.log', $med->id) }}"
                                              style="display: inline;">
                                            @csrf
                                            <button type="submit"
                                                    class="action-btn edit"
                                                    title="Mark as given">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
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
                    <span>No medications are assigned to your residents yet.</span>
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
                                <th>Resident</th><th>Care Plan</th><th>Status</th><th>Review Date</th><th></th>
                            @elseif($type === 'appointments')
                                <th>Resident</th><th>Appointment</th><th>Date</th><th>Status</th>
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
                                    <td>{{ $item->title }}</td>
                                    <td>{{ ucfirst($item->status) }}</td>
                                    <td>{{ $item->review_date?->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('caregiver.care-plans.show', $item->id) }}"
                                           class="table-action">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>

                                @elseif($type === 'appointments')
                                    <td>{{ $item->elder->name ?? $item->elder_name ?? '-' }}</td>
                                    <td>{{ $item->title ?? $item->type ?? 'Appointment' }}</td>
                                    <td>{{ $item->appointment_date ?? '-' }}</td>
                                    <td>{{ ucfirst($item->status ?? 'scheduled') }}</td>

                                @elseif($type === 'shifts')
                                    <td>{{ $item->shift_date?->format('Y-m-d') ?? '-' }}</td>
                                    <td>{{ $item->shiftType->name ?? '-' }}</td>
                                    <td>{{ $item->start_time ?? '-' }}</td>
                                    <td>{{ $item->end_time ?? '-' }}</td>
                                    <td>{{ ucfirst($item->status) }}</td>

                                @elseif($type === 'attendance')
                                    <td>{{ $item->attendance_date?->format('Y-m-d') ?? '-' }}</td>
                                    <td>{{ $item->check_in ?? '-' }}</td>
                                    <td>{{ $item->check_out ?? '-' }}</td>
                                    <td>{{ ucfirst($item->status) }}</td>

                                @else
                                    <td>{{ $item->subject ?? $item->message ?? 'Message' }}</td>
                                    <td>{{ $item->created_at ?? '-' }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-table">
                                        <strong>No records found</strong>
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