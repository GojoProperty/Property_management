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
                <h1>WishList Property </h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="index.html">Home</a></li>
                    <li>WishList Property</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->


    <!-- property-page-section -->
    <section class="property-page-section property-list">
        <div class="auto-container">
            <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                <div class="property-content-side">
                    <div class="wrapper list">
                        <div class="deals-list-content list-item">
                            <div id="wishlist">
                                <a href="{{ route('all.properties') }}" class="btn btn-primary mt-3">Browse Properties</a>
                            </div>
                            <!-- No Wishlist Message (hidden by default) -->
                            <div id="no-wishlist-message" class="text-center my-5 d-none">
                                <h5 class="text-muted">You haven’t added anything to your wishlist yet.</h5>
                                <a href="{{ route('all.properties') }}" class="btn btn-primary mt-3">Browse Properties</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- property-page-section end -->
    <script>
        function checkWishlistEmpty() {
            const wishlist = document.getElementById('wishlist');
            const noWishlistMsg = document.getElementById('no-wishlist-message');

            // Check if it has any visible items
            const items = wishlist.querySelectorAll('.wishlist-item');

            if (items.length === 0) {
                noWishlistMsg.classList.remove('d-none');
            } else {
                noWishlistMsg.classList.add('d-none');
            }
        }

        // If you load wishlist with AJAX or localStorage, call this after rendering
        document.addEventListener('DOMContentLoaded', function() {
            // If wishlist is loaded immediately (server-side), check right away
            checkWishlistEmpty();

            // OR if you load via AJAX, call checkWishlistEmpty() inside your success callback
        });
    </script>
@endsection
