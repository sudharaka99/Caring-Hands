@extends('layouts.app')

@section('title', 'Features - Caring Hands')

@section('content')

    {{-- Page Header --}}
    <section class="section" style="padding-top: 150px;">
        <div class="container">
            <div class="section-title">
                <span class="section-tag">Features</span>
                <h2>Powerful Features for Better Care</h2>
                <p>Explore the tools that make Caring Hands the ultimate elder home management solution.</p>
            </div>
        </div>
    </section>


    {{-- Features Grid --}}
    <section class="section section-light" id="features">
        <div class="container">

            @if(isset($features) && $features->count() > 0)

                <div class="features-grid">

                    @foreach($features as $feature)

                        <div class="feature-card">

                            <div class="feature-icon">
                                <i class="{{ $feature->icon ?? 'fa-solid fa-star' }}"></i>
                            </div>

                            <div class="feature-content">
                                <h3>{{ $feature->title }}</h3>
                                <p>{{ $feature->description }}</p>
                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="empty-state">
                    <i class="fa-solid fa-inbox"></i>
                    <h4>No features yet</h4>
                    <p>Features will appear here once added.</p>
                </div>

            @endif

        </div>
    </section>


    @include('components.sections.stats')

@endsection