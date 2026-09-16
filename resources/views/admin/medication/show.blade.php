@extends('layouts.admin')

@section('content')

<style>
    .med-show-page {
        padding: 25px;
        background: #f7f7f7;
        min-height: 100vh;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
        flex-wrap: wrap;
    }

    .page-header h1 {
        margin: 0;
        color: #111;
        font-size: 28px;
        font-weight: 700;
    }

    .page-header p {
        margin: 6px 0 0;
        color: #777;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 11px 17px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back {
        background: #111;
        color: #fff;
    }

    .btn-back:hover {
        background: #333;
    }

    .btn-edit {
        background: #f4c400;
        color: #111;
    }

    .btn-edit:hover {
        background: #111;
        color: #fff;
    }

    .medicine-header-card {
        background: #111;
        color: #fff;
        border-radius: 14px;
        padding: 25px;
        margin-bottom: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        box-shadow: 0 4px 18px rgba(0,0,0,.08);
    }

    .medicine-main {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .medicine-icon {
        width: 65px;
        height: 65px;
        background: #f4c400;
        color: #111;
        border-radius: 13px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 28px;
    }

    .medicine-main h2 {
        margin: 0;
        font-size: 25px;
    }

    .medicine-main p {
        margin: 6px 0 0;
        color: #ddd;
    }

    .medicine-status {
        padding: 9px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .status-active {
        background: #d8f6df;
        color: #166c29;
    }

    .status-completed {
        background: #dcecff;
        color: #155a9b;
    }

    .status-stopped {
        background: #e7e7e7;
        color: #555;
    }

    .status-cancelled {
        background: #ffdede;
        color: #a00000;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 22px;
        align-items: start;
    }

    .card {
        background: #fff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 4px 18px rgba(0,0,0,.06);
        margin-bottom: 22px;
    }

    .card:last-child {
        margin-bottom: 0;
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #111;
        border-bottom: 2px solid #f4c400;
        padding-bottom: 10px;
        margin: 0 0 20px;
    }

    .card-title i {
        margin-right: 7px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .info-item {
        padding: 14px;
        background: #fafafa;
        border-radius: 9px;
        border-left: 3px solid #f4c400;
    }

    .info-label {
        font-size: 12px;
        color: #777;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .info-value {
        color: #222;
        font-weight: 600;
        font-size: 14px;
        word-break: break-word;
    }

    .info-item.full {
        grid-column: 1 / -1;
    }

    .elder-card {
        background: #fff9d9;
        border: 1px solid #f4c400;
        border-radius: 10px;
        padding: 18px;
    }

    .elder-name {
        font-size: 20px;
        font-weight: 700;
        color: #111;
        margin-bottom: 5px;
    }

    .elder-code {
        color: #777;
        font-size: 13px;
    }

    .history-item {
        border-left: 3px solid #f4c400;
        padding: 15px;
        margin-bottom: 12px;
        background: #fafafa;
        border-radius: 0 8px 8px 0;
    }

    .history-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .history-date {
        font-weight: 700;
        color: #111;
    }

    .history-status {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 700;
    }

    .log-pending {
        background: #fff1bd;
        color: #866500;
    }

    .log-given {
        background: #d8f6df;
        color: #166c29;
    }

    .log-missed {
        background: #ffdede;
        color: #a00000;
    }

    .log-skipped {
        background: #e8e8e8;
        color: #555;
    }

    .log-refused {
        background: #ffe4cc;
        color: #9a4c00;
    }

    .history-details {
        margin-top: 8px;
        color: #666;
        font-size: 13px;
        line-height: 1.6;
    }

    .empty-history {
        text-align: center;
        padding: 30px 10px;
        color: #777;
    }

    .empty-history i {
        font-size: 35px;
        color: #f4c400;
        margin-bottom: 10px;
    }

    .danger-zone {
        border: 1px solid #ffd0d0;
        background: #fff7f7;
    }

    .delete-btn {
        width: 100%;
        border: none;
        background: #c00000;
        color: #fff;
        padding: 12px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 700;
    }

    .delete-btn:hover {
        background: #900000;
    }

    @media(max-width: 900px) {

        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 650px) {

        .med-show-page {
            padding: 15px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .info-item.full {
            grid-column: auto;
        }

        .medicine-header-card {
            padding: 20px;
        }

        .medicine-main h2 {
            font-size: 21px;
        }
    }
</style>


<div class="med-show-page">


    {{-- Header --}}
    <div class="page-header">

        <div>

            <h1>
                <i class="fa-solid fa-pills"></i>
                Medication Details
            </h1>

            <p>
                View complete medication information.
            </p>

        </div>


        <div class="header-actions">

            <a href="{{ route('admin.medication.index') }}"
               class="btn btn-back">

                <i class="fa-solid fa-arrow-left"></i>
                Back

            </a>


            <a href="{{ route('admin.medication.edit', $medication->id) }}"
               class="btn btn-edit">

                <i class="fa-solid fa-pen"></i>
                Edit Medication

            </a>

        </div>

    </div>


    {{-- Medicine Header --}}
    <div class="medicine-header-card">

        <div class="medicine-main">

            <div class="medicine-icon">

                <i class="fa-solid fa-pills"></i>

            </div>

            <div>

                <h2>
                    {{ $medication->medication_name }}
                </h2>

                <p>

                    @if($medication->generic_name)

                        {{ $medication->generic_name }}

                    @else

                        Medication #{{ $medication->id }}

                    @endif

                </p>

            </div>

        </div>


        {{-- Status --}}
        <div>

            @if($medication->status === 'active')

                <span class="medicine-status status-active">
                    <i class="fa-solid fa-circle-check"></i>
                    Active
                </span>

            @elseif($medication->status === 'completed')

                <span class="medicine-status status-completed">
                    <i class="fa-solid fa-flag-checkered"></i>
                    Completed
                </span>

            @elseif($medication->status === 'stopped')

                <span class="medicine-status status-stopped">
                    <i class="fa-solid fa-stop"></i>
                    Stopped
                </span>

            @else

                <span class="medicine-status status-cancelled">
                    <i class="fa-solid fa-ban"></i>
                    Cancelled
                </span>

            @endif

        </div>

    </div>


    <div class="content-grid">


        {{-- LEFT SIDE --}}
        <div>


            {{-- Medication Details --}}
            <div class="card">

                <h2 class="card-title">

                    <i class="fa-solid fa-capsules"></i>
                    Medication Information

                </h2>


                <div class="info-grid">


                    <div class="info-item">

                        <div class="info-label">
                            Medication Name
                        </div>

                        <div class="info-value">
                            {{ $medication->medication_name }}
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Generic Name
                        </div>

                        <div class="info-value">
                            {{ $medication->generic_name ?: '-' }}
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Dosage
                        </div>

                        <div class="info-value">

                            {{ $medication->dosage }}

                            @if($medication->dosage_unit)
                                {{ $medication->dosage_unit }}
                            @endif

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Frequency
                        </div>

                        <div class="info-value">

                            {{ ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $medication->frequency
                                )
                            ) }}

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Administration Time
                        </div>

                        <div class="info-value">

                            @if($medication->administration_time)

                                {{ \Carbon\Carbon::parse(
                                    $medication->administration_time
                                )->format('h:i A') }}

                            @else

                                -

                            @endif

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Route
                        </div>

                        <div class="info-value">

                            {{ ucfirst($medication->route) }}

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Start Date
                        </div>

                        <div class="info-value">

                            @if($medication->start_date)

                                {{ $medication->start_date->format('d M Y') }}

                            @else

                                -

                            @endif

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            End Date
                        </div>

                        <div class="info-value">

                            @if($medication->end_date)

                                {{ $medication->end_date->format('d M Y') }}

                            @else

                                Ongoing

                            @endif

                        </div>

                    </div>


                    <div class="info-item full">

                        <div class="info-label">
                            Prescribed By
                        </div>

                        <div class="info-value">

                            {{ $medication->prescribed_by ?: '-' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- Purpose & Instructions --}}
            <div class="card">

                <h2 class="card-title">

                    <i class="fa-solid fa-file-medical"></i>
                    Prescription Instructions

                </h2>


                <div class="info-grid">


                    <div class="info-item full">

                        <div class="info-label">
                            Purpose
                        </div>

                        <div class="info-value"
                             style="font-weight:400;line-height:1.7;">

                            {!! nl2br(e($medication->purpose ?: 'No purpose information provided.')) !!}

                        </div>

                    </div>


                    <div class="info-item full">

                        <div class="info-label">
                            Instructions
                        </div>

                        <div class="info-value"
                             style="font-weight:400;line-height:1.7;">

                            {!! nl2br(e(
                                $medication->instructions
                                ?: 'No special instructions provided.'
                            )) !!}

                        </div>

                    </div>


                    <div class="info-item full">

                        <div class="info-label">
                            Notes
                        </div>

                        <div class="info-value"
                             style="font-weight:400;line-height:1.7;">

                            {!! nl2br(e(
                                $medication->notes
                                ?: 'No additional notes.'
                            )) !!}

                        </div>

                    </div>

                </div>

            </div>


            {{-- Administration History --}}
            <div class="card">

                <h2 class="card-title">

                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Medication Administration History

                </h2>


                @forelse($medication->logs as $log)

                    <div class="history-item">

                        <div class="history-top">

                            <div class="history-date">

                                <i class="fa-regular fa-calendar"></i>

                                @if($log->scheduled_date)
                                    {{ $log->scheduled_date->format('d M Y') }}
                                @else
                                    -
                                @endif

                                @if($log->scheduled_time)

                                    &nbsp; |

                                    {{ \Carbon\Carbon::parse(
                                        $log->scheduled_time
                                    )->format('h:i A') }}

                                @endif

                            </div>


                            <div>

                                @if($log->status === 'pending')

                                    <span class="history-status log-pending">
                                        Pending
                                    </span>

                                @elseif($log->status === 'given')

                                    <span class="history-status log-given">
                                        <i class="fa-solid fa-check"></i>
                                        Given
                                    </span>

                                @elseif($log->status === 'missed')

                                    <span class="history-status log-missed">
                                        <i class="fa-solid fa-xmark"></i>
                                        Missed
                                    </span>

                                @elseif($log->status === 'skipped')

                                    <span class="history-status log-skipped">
                                        Skipped
                                    </span>

                                @elseif($log->status === 'refused')

                                    <span class="history-status log-refused">
                                        Refused
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="history-details">

                            @if($log->administered_at)

                                <div>

                                    <strong>
                                        Administered:
                                    </strong>

                                    {{ $log->administered_at->format('d M Y h:i A') }}

                                </div>

                            @endif


                            @if($log->caregiver)

                                <div>

                                    <strong>
                                        Caregiver:
                                    </strong>

                                    {{ $log->caregiver->user->name ?? 'N/A' }}

                                </div>

                            @endif


                            @if($log->notes)

                                <div>

                                    <strong>
                                        Notes:
                                    </strong>

                                    {{ $log->notes }}

                                </div>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="empty-history">

                        <div>
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>

                        <strong>
                            No Administration Records
                        </strong>

                        <p>
                            Medication administration records
                            will appear here.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- RIGHT SIDE --}}
        <div>


            {{-- Elder --}}
            <div class="card">

                <h2 class="card-title">

                    <i class="fa-solid fa-user"></i>
                    Elder

                </h2>


                @if($medication->elder)

                    <div class="elder-card">

                        <div class="elder-name">

                            {{ $medication->elder->name }}

                        </div>


                        @if($medication->elder->elder_code)

                            <div class="elder-code">

                                Elder Code:
                                {{ $medication->elder->elder_code }}

                            </div>

                        @endif


                        @if($medication->elder->room)

                            <div class="elder-code"
                                 style="margin-top:5px;">

                                <i class="fa-solid fa-door-open"></i>

                                Room:
                                {{ $medication->elder->room }}

                            </div>

                        @endif


                        @if($medication->elder->phone)

                            <div class="elder-code"
                                 style="margin-top:5px;">

                                <i class="fa-solid fa-phone"></i>

                                {{ $medication->elder->phone }}

                            </div>

                        @endif

                    </div>

                @else

                    <p style="color:#777;">
                        Elder information unavailable.
                    </p>

                @endif

            </div>


            {{-- Medication Summary --}}
            <div class="card">

                <h2 class="card-title">

                    <i class="fa-solid fa-chart-simple"></i>
                    Quick Summary

                </h2>


                <div style="display:flex;flex-direction:column;gap:12px;">


                    <div class="info-item">

                        <div class="info-label">
                            Total Administration Records
                        </div>

                        <div class="info-value"
                             style="font-size:20px;">

                            {{ $medication->logs->count() }}

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Given
                        </div>

                        <div class="info-value"
                             style="font-size:20px;color:#16752b;">

                            {{ $medication->logs->where('status', 'given')->count() }}

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Missed
                        </div>

                        <div class="info-value"
                             style="font-size:20px;color:#b00000;">

                            {{ $medication->logs->where('status', 'missed')->count() }}

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Pending
                        </div>

                        <div class="info-value"
                             style="font-size:20px;color:#916d00;">

                            {{ $medication->logs->where('status', 'pending')->count() }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- Record Information --}}
            <div class="card">

                <h2 class="card-title">

                    <i class="fa-solid fa-circle-info"></i>
                    Record Information

                </h2>


                <div style="display:flex;flex-direction:column;gap:14px;">

                    <div>

                        <div class="info-label">
                            Medication ID
                        </div>

                        <div class="info-value">
                            #{{ $medication->id }}
                        </div>

                    </div>


                    <div>

                        <div class="info-label">
                            Created
                        </div>

                        <div class="info-value">

                            {{ $medication->created_at
                                ? $medication->created_at->format('d M Y h:i A')
                                : '-' }}

                        </div>

                    </div>


                    <div>

                        <div class="info-label">
                            Last Updated
                        </div>

                        <div class="info-value">

                            {{ $medication->updated_at
                                ? $medication->updated_at->format('d M Y h:i A')
                                : '-' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- Delete --}}
            <div class="card danger-zone">

                <h2 class="card-title"
                    style="border-color:#c00000;color:#a00000;">

                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Delete Medication

                </h2>

                <p style="color:#666;font-size:13px;line-height:1.6;">

                    Deleting this medication will also delete its
                    associated administration records.

                    This action cannot be undone.

                </p>


                <form method="POST"
                      action="{{ route('admin.medication.destroy', $medication->id) }}"
                      onsubmit="return confirm('Are you sure you want to permanently delete this medication and all its administration records?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="delete-btn">

                        <i class="fa-solid fa-trash"></i>
                        Delete Medication

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection