@extends('layouts.admin')

@section('title', 'Residents | Caring Hands')

@section('content')
<div class="dashboard-page">

    {{-- Page Header --}}
    <div class="dashboard-heading">
        <div>
            <h1>Residents</h1>
            <p class="dashboard-subtitle">
                All residents under care
            </p>
        </div>
        <div class="dashboard-date">
            <i class="fa-solid fa-person-cane"></i>
            {{ $elders->total() }} {{ Str::plural('Resident', $elders->total()) }}
        </div>
    </div>


    {{-- Filter Card --}}
    <div class="dashboard-card filter-card">

        <form method="GET" action="{{ route('healthcare.elders.index') }}">

            <div class="table-toolbar">

                {{-- Left: Search --}}
                <div class="toolbar-left">

                    <div class="table-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text"
                               name="search"
                               class="search-input"
                               placeholder="Search by name, code, room, or phone..."
                               value="{{ request('search') }}">
                    </div>

                </div>

                {{-- Right: Filters + Buttons --}}
                <div class="toolbar-right">

                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fa-solid fa-filter"></i>
                            Gender
                        </label>
                        <select name="gender" class="filter-select">
                            <option value="">All</option>
                            <option value="male"   @selected(request('gender') === 'male')>Male</option>
                            <option value="female" @selected(request('gender') === 'female')>Female</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Search
                    </button>

                    @if(request('search') || request('gender'))
                        <a href="{{ route('healthcare.elders.index') }}" class="btn btn-outline">
                            <i class="fa-solid fa-xmark"></i>
                            Clear
                        </a>
                    @endif

                </div>

            </div>

        </form>

    </div>


    {{-- Result count --}}
    @if(request('search') || request('gender'))
        <div style="margin-bottom: 16px; color: #667085; font-size: 14px;">
            Showing <strong>{{ $elders->total() }}</strong> result(s)
            @if(request('search'))
                · Search: "<strong>{{ request('search') }}</strong>"
            @endif
            @if(request('gender'))
                · Gender: <strong>{{ ucfirst(request('gender')) }}</strong>
            @endif
        </div>
    @endif


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
                                <a href="{{ route('healthcare.elders.show', $elder->id) }}"
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
                                    <strong>No residents found</strong>
                                    <span>
                                        @if(request('search') || request('gender'))
                                            Try a different search or clear filters.
                                        @else
                                            No active residents in the system yet.
                                        @endif
                                    </span>
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