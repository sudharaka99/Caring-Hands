@extends('layouts.app')

@section('title', 'About Us - Caring Hands')

@section('content')

    {{-- ==========================================
         PAGE HEADER
    =========================================== --}}
    <section class="section" style="padding-top: 150px;">
        <div class="container">
            <div class="section-title">
                <span class="section-tag">About Us</span>
                <h2>Learn More About Caring Hands</h2>
                <p>We're dedicated to transforming elder care through technology and compassion.</p>
            </div>
        </div>
    </section>


    {{-- ==========================================
         ABOUT SECTION (from partial)
    =========================================== --}}
    @include('components.sections.about')


    {{-- ==========================================
         OUR MISSION
    =========================================== --}}
    <section class="section" style="background: #F8F9FC;">
        <div class="container">
            <div class="section-title">
                <span class="section-tag">Our Mission</span>
                <h2>Compassion Meets Technology</h2>
                <p>
                    To provide a seamless, secure, and compassionate elder home
                    management experience for residents, families, caregivers,
                    and healthcare professionals alike.
                </p>
            </div>
        </div>
    </section>

@endsection