@extends('layouts.admin')

@section('title', 'My Residents | Caring Hands')

@section('content')

<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>My Residents</h1>
            <p class="dashboard-subtitle">
                Elders assigned to you
            </p>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-table-wrapper">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Resident</th>
                        <th>Room</th>
                        <th>Age</th>
                        <th>Blood Group</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($elders as $elder)
                        <tr>
                            <td>
                                <div class="resident-user">
                                    <div class="resident-avatar">
                                        @if($elder->photo)
                                            <img src="{{ asset('storage/' . $elder->photo) }}"
                                                 alt="{{ $elder->name }}">
                                        @else
                                            {{ strtoupper(substr($elder->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <strong>{{ $elder->name }}</strong>
                                        <span>{{ $elder->elder_code }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $elder->room }}</td>
                            <td>{{ $elder->age }}</td>
                            <td>{{ $elder->blood_group ?? '-' }}</td>
                            <td>
                                <span class="table-status active">
                                    {{ ucfirst($elder->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('caregiver.elders.show', $elder->id) }}"
                                   class="table-action" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-table">
                                    <i class="fa-solid fa-person-cane"></i>
                                    <strong>No residents assigned</strong>
                                    <span>You'll see residents here when assigned by your manager.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            {{ $elders->links() }}
        </div>
    </div>

</div>

@endsection