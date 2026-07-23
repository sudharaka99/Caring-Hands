@extends('layouts.app')

@section('title', 'Features - Caring Hands')

@section('content')
    <section class="section" style="padding-top: 150px;">
        <div class="container">
            <div class="section-title">
                <span class="section-tag">Features</span>
                <h2>Powerful Features for Better Care</h2>
                <p>Explore the tools that make Caring Hands the ultimate elder home management solution.</p>
            </div>
        </div>
    </section>
    
    @include('components.sections.features')
    @include('components.sections.stats')
@endsection