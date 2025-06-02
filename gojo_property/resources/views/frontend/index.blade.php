@extends('frontend.frontend_dashboard')
@section('main')
    <!-- banner-section -->
    @include('frontend.home.banner')
    <!-- banner-section end -->

    <div id="category-section">
        <!-- category-section -->
        @include('frontend.home.category')
        <!-- category-section end -->
    </div>
    <div id="deals-section">
        <!-- deals-section -->
        @include('frontend.home.deals')
        <!-- deals-section end -->
    </div>

    <div id="video-section">
        <!-- video-section -->
        @include('frontend.home.video')
        <!-- video-section end -->
    </div>

    <div id="testimonial-section">
        <!-- testimonial-section end -->
        @include('frontend.home.testimonial')
        <!-- testimonial-section end -->
    </div>
    <div id="chooseus-section">
        <!-- chooseus-section -->
        @include('frontend.home.chooseus')
        <!-- chooseus-section end -->
    </div>
    <div id="place-section">
        <!-- place-section -->
        @include('frontend.home.place')
        <!-- place-section end -->
    </div>
    <div id="team-section">
        <!-- team-section -->
        @include('frontend.home.team')
        <!-- team-section end -->
    </div>
    <div id="cta-section">
        <!-- cta-section -->
        @include('frontend.home.cta')
        <!-- cta-section end -->
    </div>
    <div id="news-section">
        <!-- news-section -->
        @include('frontend.home.news')
        <!-- news-section end -->
    </div>
    <div id="download-section">
        <!-- download-section -->
        @include('frontend.home.download')
        <!-- download-section end -->
    </div>
@endsection
