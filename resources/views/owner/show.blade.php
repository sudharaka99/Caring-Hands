@extends('layouts.admin')

@section('title', $title . ' | Caring Hands')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-heading">
        <div>
            <h1>{{ $title }}</h1>
            <p class="dashboard-subtitle">{{ $item->title ?? $item->name ?? '' }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="card-link">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="dashboard-card">
        @if($type === 'care-plan')
            <div class="overview-details">
                <div class="overview-row"><div class="overview-label">Title</div><strong>{{ $item->title }}</strong></div>
                <div class="overview-row"><div class="overview-label">Status</div><span class="table-status active">{{ ucfirst($item->status) }}</span></div>
                <div class="overview-row"><div class="overview-label">Priority</div><strong>{{ ucfirst($item->priority) }}</strong></div>
                <div class="overview-row"><div class="overview-label">Care Needs</div><strong>{{ $item->care_needs ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Goals</div><strong>{{ $item->goals ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Activities</div><strong>{{ $item->activities ?? '-' }}</strong></div>
                <div class="overview-row"><div class="overview-label">Review Date</div><strong>{{ $item->review_date ?? '-' }}</strong></div>
            </div>
        @else
            <div class="overview-details">
                <div class="overview-row"><div class="overview-label">Name</div><strong>{{ $item->name ?? '-' }}</strong></div>
            </div>
        @endif
    </div>

</div>
@endsection