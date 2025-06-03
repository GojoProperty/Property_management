<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>Easy - Gojo Property </title>

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('gojo.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Stylesheets -->
    <link href="{{ asset('frontend/assets/css/font-awesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/flaticon.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/owl.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/color/theme-color.css') }}" id="jssDefault" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/switcher-style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

</head>

<!-- page wrapper -->

<body>

    <div class="boxed_wrapper">

        @if (!isset($hideHeader))
            @include('frontend.home.header')
        @endif


        <!-- Mobile Menu  -->
        @include('frontend.home.mobile_menu')
        <!-- End Mobile Menu -->

        @yield('main')

        @if (!isset($hideFooter))
            @include('frontend.home.footer')
        @endif

        <!--Scroll to top-->
        <button class="scroll-top scroll-to-target" data-target="html">
            <span class="fal fa-angle-up"></span>
        </button>

    </div>

    <!-- jequery plugins -->
    <script src="{{ asset('frontend/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/validation.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/appear.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jQuery.style.switcher.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/nav-tool.js') }}"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @isset($property)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lat = {{ $property->latitude ?? 9.03 }};
                const lng = {{ $property->longitude ?? 38.74 }};

                const map = L.map('map').setView([lat, lng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, lng]).addTo(map)
                    .bindPopup("{{ $property->property_name }}")
                    .openPopup();
            });
        </script>
    @endisset

    <!-- ptTimeSelect JS -->
    <script src="https://cdn.jsdelivr.net/gh/neo22s/jquery.ptTimeSelect/jquery.ptTimeSelect.js"></script>

    <!-- Your custom JS (make sure this comes AFTER the plugin) -->
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>


    <!-- main-js -->
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;
                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;
                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;
                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        // Add To Wishlist 
        function addToWishList(property_id) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/add-to-wishList/" + property_id,
                success: function(data) {

                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message  
                }
            })
        }
    </script>

    <!-- start load and delete Wishlist Data  -->
    <script type="text/javascript">
        // load data
        function wishlist() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/get-wishlist-property/",
                success: function(response) {
                    $('#wishQty').text(response.wishQty);

                    var rows = ""
                    $.each(response.wishlist, function(key, value) {
                        rows +=
                            `<div class="deals-block-one wishlist-item">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><img src="/${value.property.property_thambnail}" alt=""></figure>
                                    <div class="batch"><i class="icon-11"></i></div>
                                    <span class="category">Featured</span>
                                    <div class="buy-btn"><a href="#">For ${value.property.property_status}</a></div>
                                </div>
                                <div class="lower-content">
                                    <div class="title-text"><h4><a href="">${value.property.property_name}</a></h4></div>
                                    <div class="price-box clearfix">
                                        <div class="price-info pull-left">
                                            <h6>Start From</h6>
                                            <h4>$${value.property.lowest_price}</h4>
                                        </div>
                                    </div>                       
                                    <ul class="more-details clearfix">
                                        <li><i class="icon-14"></i>${value.property.bedrooms} Beds</li>
                                        <li><i class="icon-15"></i>${value.property.bathrooms} Baths</li>
                                        <li><i class="icon-16"></i>${value.property.property_size} Sq Ft</li>
                                    </ul>
                                    <div class="other-info-box clearfix">                                   
                                        <ul class="other-option pull-right clearfix">                                       
                                             <li><a type="submit" class="text-body" id="${value.id}" onclick="wishlistRemove(this.id)" ><i class="fa fa-trash"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> `
                    });
                    $('#wishlist').html(rows);
                    checkWishlistEmpty();
                }
            })
        }
        wishlist();

        // Wishlist Remove 
        function wishlistRemove(id) {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/wishlist-remove/" + id,
                success: function(data) {
                    wishlist();

                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message  
                }
            })
        } // End method 
    </script>

    <!-- /// Add to Carepage  -->
    <script type="text/javascript">
        function addToCompare(property_id) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/add-to-compare/" + property_id,
                success: function(data) {

                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message  
                }
            })
        }
    </script>

    <!-- // start load Compare Data  -->
    <script type="text/javascript">
        function compare() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/get-compare-property/",
                success: function(response) {
                    let output = "";

                    $.each(response.compare, function(key, value) {
                        const p = value.property;

                        const isLowestPrice = p.lowest_price == response.lowestPrice;
                        const isLargestArea = p.property_size == response.largestArea;
                        const isMostRooms = p.bedrooms == response.mostRooms;

                        output += `
                <div class="card shadow-sm p-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <img src="/${p.property_thambnail}" alt="" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-1">${p.property_name}</h5>
                            <p class="mb-1 text-primary fw-semibold">$${p.lowest_price}
                                ${isLowestPrice ? '<span class="badge bg-success ms-2">Lowest Price</span>' : ''}
                            </p>
                            <p class="mb-1"><strong>Area:</strong> ${p.property_size} Sq Ft
                                ${isLargestArea ? '<span class="badge bg-info text-dark ms-2">Largest Area</span>' : ''}
                            </p>
                            <p class="mb-1"><strong>Rooms:</strong> ${p.bedrooms}
                                ${isMostRooms ? '<span class="badge bg-warning text-dark ms-2">Most Rooms</span>' : ''}
                            </p>
                            <p class="mb-1"><strong>Bathrooms:</strong> ${p.bathrooms}</p>
                            <p class="mb-1"><strong>City:</strong> ${p.city}</p>
                            <a type="submit" class="btn btn-sm btn-outline-danger mt-2" id="${value.id}" onclick="compareRemove(this.id)">
                                <i class="fa fa-trash"></i> Remove
                            </a>
                        </div>
                    </div>
                </div>`;
                    });
                    let summary = `
                        <div class="alert alert-info">
                            Among the compared properties:
                            <strong>${response.lowestPriceName}</strong> has the <strong>lowest price</strong>,
                            <strong>${response.largestAreaName}</strong> has the <strong>largest area</strong>,
                            and <strong>${response.mostRoomsName}</strong> has the <strong>most rooms</strong>.
                        </div>
                    `;
                    $('#compare-summary').html(summary);

                    $('#compare-cards').html(output);
                }
            });
        }

        compare();

        function compareRemove(id) {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/compare-remove/" + id,
                success: function(data) {
                    compare();

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            icon: 'success',
                            title: data.success
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.error
                        });
                    }
                }
            });
        }
    </script>

</body><!-- End of .page_wrapper -->

</html>
