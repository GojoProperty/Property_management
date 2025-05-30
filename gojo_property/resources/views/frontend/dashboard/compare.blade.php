@extends('frontend.frontend_dashboard')
@section('main')
    <!--Page Title-->
    <section class="page-title-two bg-color-1 centred">
        <div class="pattern-layer">
            <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
            </div>
            <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});">
            </div>
        </div>

        <div class="auto-container">
            <div class="content-box clearfix">
                <h1>Compare Properties</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('dashboard') }}">Home</a></li>
                    <li>Compare Properties</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <!-- properties-section -->
    <section class="property-page-section property-list">
        <div class="auto-container">
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                    <!-- 🔵 JS will inject summary here -->
                    <div id="compare-summary" class="mb-3"></div>

                    <!-- 🔵 JS will inject property cards here -->
                    <div id="compare-cards" class="d-flex flex-column gap-4"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- properties-section end -->
    <style>
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
    </style>
@endsection
