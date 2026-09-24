@extends('layouts.admin')

@section('title', 'My Residents | Caring Hands')

@section('content')
<div class="dashboard-page">

    {{-- Page Header --}}
    <div class="dashboard-heading">
        <div>
            <h1>My Residents</h1>
            <p class="dashboard-subtitle">
                Elders linked to your account
            </p>
        </div>
        <div class="dashboard-date">
            <i class="fa-solid fa-person-cane"></i>
            {{ $elders->total() }} {{ Str::plural('Resident', $elders->total()) }}
        </div>
    </div>


    {{-- Table --}}
    <div class="dashboard-card">
        <div class="dashboard-table-wrapper">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Resident</th>
                        <th>Room</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Blood</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($elders as $elder)
                        <tr>
                            <td>
                                <div class="resident-user">
                                    <div class="resident-avatar">
                                        @if(!empty($elder->photo))
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
                            <td>{{ $elder->room ?? '-' }}</td>
                            <td>{{ $elder->age ?? '-' }}</td>
                            <td>{{ ucfirst($elder->gender ?? '-') }}</td>
                            <td>
                                <span class="table-status active">
                                    {{ $elder->blood_group ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="table-status active">
                                    {{ ucfirst($elder->status) }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('owner.elders.show', $elder->id) }}"
                                   class="table-action"
                                   title="View Details">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-table">
                                    <i class="fa-solid fa-person-cane"></i>
                                    <strong>No residents linked</strong>
                                    <span>Your account is not linked to any resident yet. Please contact the administrator.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($elders, 'links'))
            <div class="pagination-container">
                {{ $elders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection