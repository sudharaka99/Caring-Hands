@extends('layouts.app')

@section('title', 'Our Services - Caring Hands')

@section('content')

    {{-- ==========================================
         PAGE HEADER
    =========================================== --}}
    <section class="section" style="padding-top: 150px;">
        <div class="container">
            <div class="section-title">
                <span class="section-tag">Our Services</span>
                <h2>Comprehensive Elder Care Solutions</h2>
                <p>Discover how Caring Hands can transform your elder care facility.</p>
            </div>
        </div>
    </section>


    {{-- ==========================================
         SERVICES GRID (from DB)
    =========================================== --}}
    <section class="section section-light" id="services">
        <div class="container">

            @if(isset($services) && $services->count() > 0)

                <div class="services-grid">

                    @foreach($services as $service)

                        <div class="service-card">

                            <div class="service-icon">
                                <i class="{{ $service->icon ?? 'fa-solid fa-heart-pulse' }}"></i>
                            </div>

                            <h3>{{ $service->title }}</h3>

                            <p>{{ $service->description }}</p>

                        </div>

                    @endforeach

                </div>

            @else

                <div style="text-align: center; padding: 60px 20px;">
                    <i class="fa-solid fa-inbox" style="font-size: 48px; color: #EAECF0; margin-bottom: 16px; display: block;"></i>
                    <h3 style="margin: 0 0 8px; color: #25324B;">No services yet</h3>
                    <p style="color: #98A2B3; margin: 0;">Services will appear here once added.</p>
                </div>

            @endif

        </div>
    </section>


    {{-- ==========================================
         CTA SECTION
    =========================================== --}}
    <section class="cta">
        <div class="container">
            <div class="cta-box">
                <h2>Ready to Get Started?</h2>
                <p>Join hundreds of care facilities using Caring Hands.</p>

                @guest
                    <button class="btn" onclick="openLogin()">
                        Start Your Journey
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                @else
                    @php
                        $role = auth()->user()->role ?? 'admin';
                        $dashboardRoute = Route::has($role . '.dashboard')
                            ? $role . '.dashboard'
                            : 'admin.dashboard';
                    @endphp

                    <a href="{{ route($dashboardRoute) }}" class="btn">
                        Go to Dashboard
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endguest

            </div>
        </div>
    </section>

@endsection