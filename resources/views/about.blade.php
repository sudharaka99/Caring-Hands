@extends('layouts.app')

@section('title', 'About Us - Caring Hands')

@section('content')
    <section class="section" style="padding-top: 150px;">
        <div class="container">
            <div class="section-title">
                <span class="section-tag">About Us</span>
                <h2>Learn More About Caring Hands</h2>
                <p>We're dedicated to transforming elder care through technology and compassion.</p>
            </div>
        </div>
    </section>
    
    @include('components.sections.about')
    
    <section class="section section-light">
        <div class="container">
            <div class="section-title">
                <h2>Our Mission</h2>
                <p>To provide a seamless, secure, and compassionate elder home management experience for all stakeholders.</p>
            </div>
        </div>
    </section>
@endsection