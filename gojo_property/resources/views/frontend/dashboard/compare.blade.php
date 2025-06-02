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

                <div class="col-lg-12 col-md-12 col-sm-12 content-side">

                    <div id="compare-summary" class="mb-3"></div>

                    <div id="compare-cards" class="d-flex flex-column gap-4"></div>

                    {{-- Message if compare list is empty --}}
                    <div id="no-compare-message" class="text-center my-5 d-none">
                        <h5 class="text-muted">No compare item has been added yet.</h5>
                        <a href="{{ route('all.properties') }}" class="btn btn-primary mt-3">View All Properties</a>
                    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const compareCards = document.getElementById('compare-cards');
            const noCompareMessage = document.getElementById('no-compare-message');

            // Wait a moment for any async compare items to load
            setTimeout(() => {
                const hasItems = compareCards.children.length > 0;
                if (!hasItems) {
                    noCompareMessage.classList.remove('d-none');
                }
            }, 200); // adjust timing if needed
        });
    </script>
@endsection
