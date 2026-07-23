@extends('layouts.app')

@section('title', 'Contact Us - Caring Hands')

@section('content')
    <section class="section" style="padding-top: 150px;">
        <div class="container">
            <div class="section-title">
                <span class="section-tag">Contact</span>
                <h2>Get in Touch</h2>
                <p>We'd love to hear from you. Reach out with any questions or feedback.</p>
            </div>
        </div>
    </section>
    
    @include('components.sections.contact')
@endsection