@extends('layouts.admin')

@section('title', 'Reports | Caring Hands')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>Reports</h1>
            <p class="dashboard-subtitle">Reports for your loved ones</p>
        </div>
    </div>

    <div class="dashboard-card">
        @forelse($elders as $elder)
            <div class="overview-row">
                <div class="overview-label">
                    <span class="status-dot active"></span>
                    {{ $elder->name }} ({{ $elder->elder_code }})
                </div>
                <a href="{{ route('owner.elders.show', $elder->id) }}" class="card-link">
                    View Report <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @empty
            <div class="empty-table">
                <i class="fa-solid fa-chart-column"></i>
                <strong>No reports available</strong>
                <span>Reports will appear once your elder is linked.</span>
            </div>
        @endforelse
    </div>

</div>
@endsection