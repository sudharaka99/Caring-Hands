@extends('layouts.app')

@section('title', 'Our Services - Caring Hands')

@section('content')
    <section class="section" style="padding-top: 150px;">
        <div class="container">
            <div class="section-title">
                <span class="section-tag">Our Services</span>
                <h2>Comprehensive Elder Care Solutions</h2>
                <p>Discover how Caring Hands can transform your elder care facility.</p>
            </div>
        </div>
    </section>
    
    @include('components.sections.services')
    
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
                    <a href="{{ route('dashboard') }}" class="btn">
                        Go to Dashboard
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endguest
            </div>
        </div>
    </section>
@endsection