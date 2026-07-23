@extends('layouts.app')

@section('title', 'Caring Hands | Home')

@section('content')
    @include('components.sections.hero')
    @include('components.sections.services')
    @include('components.sections.about')
    @include('components.sections.features')
    @include('components.sections.stats')
    @include('components.sections.contact')
    @include('components.sections.cta')
@endsection