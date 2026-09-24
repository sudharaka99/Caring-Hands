@extends('layouts.admin')

@section('title', $title . ' | Caring Hands')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>{{ $title }}</h1>
            <p class="dashboard-subtitle">{{ $subtitle }}</p>
        </div>
    </div>

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
                            <th></th>
                        @elseif($type === 'medications')
                            <th>Resident</th>
                            <th>Medication</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Status</th>
                        @elseif($type === 'appointments')
                            <th>Resident</th>
                            <th>Title</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Status</th>
                        @else
                            <th>Message</th>
                            <th>Date</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            @if($type === 'care-plans')
                                <td>{{ $item->elder_name ?? '-' }}</td>
                                <td><strong>{{ $item->title }}</strong></td>
                                <td>
                                    <span class="table-status {{ $item->priority === 'critical' ? 'danger' : ($item->priority === 'high' ? 'warning' : 'active') }}">
                                        {{ ucfirst($item->priority) }}
                                    </span>
                                </td>
                                <td>{{ ucfirst($item->status) }}</td>
                                <td>
                                    <a href="{{ route('owner.care-plans.show', $item->id) }}" class="table-action">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>

                            @elseif($type === 'medications')
                                <td>{{ $item->elder_name ?? '-' }}</td>
                                <td><strong>{{ $item->medication_name }}</strong></td>
                                <td>{{ $item->dosage }} {{ $item->dosage_unit }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($item->frequency)) }}</td>
                                <td><span class="table-status active">{{ ucfirst($item->status) }}</span></td>

                            @elseif($type === 'appointments')
                                <td>{{ $item->elder_name ?? '-' }}</td>
                                <td><strong>{{ $item->title }}</strong></td>
                                <td>{{ $item->doctor_name ?? '-' }}</td>
                                <td>{{ $item->appointment_date }}</td>
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

</div>
@endsection