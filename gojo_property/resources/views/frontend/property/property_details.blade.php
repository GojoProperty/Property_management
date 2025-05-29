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
                <h1>{{ $property->property_name }}</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="index.html">Home</a></li>
                    <li>{{ $property->property_name }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <!-- property-details -->
    <section class="property-details property-details-one">
        <div class="auto-container">
            <div class="top-details clearfix">
                <!-- Left column content remains the same -->
                <div class="left-column pull-left clearfix">
                    <h3>{{ $property->property_name }}</h3>
                    <div class="author-info clearfix">
                        <div class="author-box pull-left">
                            @if ($property->agent_id == null)
                                <figure class="author-thumb"><img src="{{ url('upload/heriadmin.jpg') }}" alt="">
                                </figure>
                                <h6>Admin</h6>
                            @else
                                <figure class="author-thumb"><img
                                        src="{{ !empty($property->user->photo) ? url('upload/agent_images/' . $property->user->photo) : url('upload/no_image.jpg') }}"
                                        alt=""></figure>
                                <h6>{{ $property->user->name }}</h6>
                            @endif
                        </div>
                        <ul class="rating clearfix pull-left">
                            <li><i class="icon-39"></i></li>
                            <li><i class="icon-39"></i></li>
                            <li><i class="icon-39"></i></li>
                            <li><i class="icon-39"></i></li>
                            <li><i class="icon-40"></i></li>
                        </ul>
                    </div>
                </div>

                <!-- Right column content remains the same -->
                <div class="right-column pull-right clearfix">
                    <div class="price-inner clearfix">
                        <ul class="category clearfix pull-left">
                            <li><a href="property-details.html">{{ $property->type->type_name }}</a></li>
                            <li><a href="property-details.html">For {{ $property->property_status }}</a></li>
                        </ul>
                        <div class="price-box pull-right">
                            <h3>${{ $property->lowest_price }}</h3>
                        </div>
                    </div>
                    <ul class="other-option pull-right clearfix">
                        <li><a href="property-details.html"><i class="icon-37"></i></a></li>
                        <li><a href="property-details.html"><i class="icon-38"></i></a></li>
                        <li><a href="property-details.html"><i class="icon-12"></i></a></li>
                        <li><a href="property-details.html"><i class="icon-13"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="row clearfix">
                <!-- Main Content Column (8 columns) -->
                <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                    <div class="property-details-content">
                        <!-- Image Carousel -->
                        <div class="carousel-inner">
                            <div class="single-item-carousel owl-carousel owl-theme owl-dots-none">
                                @foreach ($multiImage as $img)
                                    <figure class="image-box"><img src="{{ asset($img->photo_name) }}" alt="">
                                    </figure>
                                @endforeach
                            </div>
                        </div>

                        <!-- Property Description -->
                        <div class="discription-box content-widget">
                            <div class="title-box">
                                <h4>Property Description</h4>
                            </div>
                            <div class="text">
                                <p>{!! $property->long_descp !!}</p>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="details-box content-widget">
                            <div class="title-box">
                                <h4>Property Details</h4>
                            </div>
                            <ul class="list clearfix">
                                <li>Property ID: <span>{{ $property->property_code }}</span></li>
                                <li>Rooms: <span>{{ $property->bedrooms }}</span></li>
                                <li>Property Type: <span>{{ $property->type->type_name }}</span></li>
                                <li>Bathrooms: <span>{{ $property->bathrooms }}</span></li>
                                <li>Property Status: <span>For {{ $property->property_status }}</span></li>
                                <li>Property Size: <span>{{ $property->property_size }} Sq Ft</span></li>
                            </ul>
                        </div>

                        <!-- Amenities -->
                        <div class="amenities-box content-widget">
                            <div class="title-box">
                                <h4>Amenities</h4>
                            </div>
                            <ul class="amenities-list clearfix">
                                @foreach ($property_amen as $amen)
                                    <li>{{ $amen }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Location -->
                        <div class="location-box content-widget">
                            <div class="title-box">
                                <h4>Location</h4>
                            </div>
                            <ul class="info clearfix">
                                <li><span>Address:</span> {{ $property->address }}</li>
                                <li><span>State/county:</span> {{ $property['pstate']['state_name'] ?? 'N/A' }}</li>
                                <li><span>Neighborhood:</span> {{ $property->neighborhood }}</li>
                                <li><span>City:</span> {{ $property->city }}</li>
                            </ul>
                            <div class="google-map-area">
                                <div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
                            </div>
                        </div>

                        <!-- Nearby -->
                        <div class="nearby-box content-widget">
                            <div class="title-box">
                                <h4>What's Nearby?</h4>
                            </div>
                            <div class="inner-box">
                                <div class="single-item">
                                    <div class="icon-box"><i class="fas fa-book-reader"></i></div>
                                    <div class="inner">
                                        <h5>Places:</h5>
                                        @foreach ($facility as $item)
                                            <div class="box clearfix">
                                                <div class="text pull-left">
                                                    <h6>{{ $item->facility_name }} <span>({{ $item->distance }})</span>
                                                    </h6>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Property Video -->
                        <div class="statistics-box content-widget">
                            <div class="title-box">
                                <h4>Property Video</h4>
                            </div>
                            <figure class="image-box">
                                <iframe width="100%" height="400" src="{{ $property->property_video }}"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </figure>
                        </div>

                        <!-- Terms & Conditions -->
                        @if ($property->rules->count())
                            <div class="amenities-box content-widget">
                                <div class="title-box">
                                    <h4>Terms & Conditions</h4>
                                </div>
                                <div class="card-body">
                                    <ul>
                                        @foreach ($property->rules as $rule)
                                            <li>{{ $rule->content }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="amenities-box content-widget">
                                <div class="title-box">
                                    <h4>Terms & Conditions</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">No terms and conditions added by the owner.</p>
                                </div>
                            </div>
                        @endif

                        <!-- Schedule Site Visit -->
                        <div class="schedule-box content-widget">
                            <div class="title-box">
                                <h4>Schedule Site Visit</h4>
                            </div>
                            <div class="form-inner">
                                <form action="{{ route('store.schedule') }}" method="post">
                                    @csrf
                                    <div class="row clearfix">
                                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                                        @if ($property->agent_id == null)
                                            <input type="hidden" name="agent_id" value="">
                                        @else
                                            <input type="hidden" name="agent_id" value="{{ $property->agent_id }}">
                                        @endif

                                        <div class="col-lg-6 col-md-12 col-sm-12 column">
                                            <div class="form-group">
                                                <i class="far fa-calendar-alt"></i>
                                                <input type="text" name="tour_date" placeholder="Tour Date"
                                                    id="datepicker">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 column">
                                            <div class="form-group">
                                                <i class="far fa-clock"></i>
                                                <input type="text" name="tour_time" placeholder="Any Time">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 column">
                                            <div class="form-group">
                                                <textarea name="message" placeholder="Your message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 column">
                                            <div class="form-group message-btn">
                                                <button type="submit" class="theme-btn btn-one">Submit Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Column (4 columns) -->
                <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                    <!-- Author Widget -->
                    <div class="property-sidebar default-sidebar">
                        <div class="author-widget sidebar-widget">
                            <div class="author-box">
                                @if ($property->agent_id == null)
                                    <figure class="author-thumb"><img src="{{ url('upload/heriadmin.jpg') }}"
                                            alt=""></figure>
                                    <div class="inner">
                                        <h4>Admin</h4>
                                        <ul class="info clearfix">
                                            <li><i class="fas fa-map-marker-alt"></i> Hawassa University</li>
                                            <li><i class="fas fa-phone"></i><a href="tel:03030571965">+251-946948447</a>
                                            </li>
                                        </ul>
                                        <div class="btn-box"><a href="agents-details.html">View Listing</a></div>
                                    </div>
                                @else
                                    <figure class="author-thumb"><img
                                            src="{{ !empty($property->user->photo) ? url('upload/agent_images/' . $property->user->photo) : url('upload/no_image.jpg') }}"
                                            alt=""></figure>
                                    <div class="inner">
                                        <h4>{{ $property->user->name }}</h4>
                                        <ul class="info clearfix">
                                            <li><i class="fas fa-map-marker-alt"></i>{{ $property->user->address }}</li>
                                            <li><i class="fas fa-phone"></i><a
                                                    href="tel:03030571965">{{ $property->user->phone }}</a></li>
                                        </ul>
                                        <div class="btn-box"><a href="agents-details.html">View Listing</a></div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div class="form-inner">
                            @auth
                                @php
                                    $id = Auth::user()->id;
                                    $userData = App\Models\User::find($id);
                                @endphp

                                <form action="{{ route('property.message') }}" method="post" class="default-form">
                                    @csrf
                                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                                    @if ($property->agent_id == null)
                                        <input type="hidden" name="agent_id" value="">
                                    @else
                                        <input type="hidden" name="agent_id" value="{{ $property->agent_id }}">
                                    @endif

                                    <div class="form-group">
                                        <input type="text" name="msg_name" placeholder="Your name"
                                            value="{{ $userData->name }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="msg_email" placeholder="Your Email"
                                            value="{{ $userData->email }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="msg_phone" placeholder="Phone"
                                            value="{{ $userData->phone }}">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="message" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group message-btn">
                                        <button type="submit" class="theme-btn btn-one">Send Message</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('property.message') }}" method="post" class="default-form">
                                    @csrf
                                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                                    @if ($property->agent_id == null)
                                        <input type="hidden" name="agent_id" value="">
                                    @else
                                        <input type="hidden" name="agent_id" value="{{ $property->agent_id }}">
                                    @endif

                                    <div class="form-group">
                                        <input type="text" name="msg_name" placeholder="Your name" required="">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="msg_email" placeholder="Your Email" required="">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="msg_phone" placeholder="Phone" required="">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="message" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group message-btn">
                                        <button type="submit" class="theme-btn btn-one">Send Message</button>
                                    </div>
                                </form>
                            @endauth
                        </div>

                        <!-- Property Request Section -->
                        <div class="calculator-widget sidebar-widget">
                            <div class="property-request-section" style="margin-top: 40px; margin-bottom: 60px;">
                                <div class="calculate-inner">
                                    <div class="widget-title">
                                        <h4>Request This Property</h4>
                                    </div>

                                    @auth
                                        <form method="post"
                                            action="{{ $property->property_status == 'buy' ? route('purchase.request') : route('rent.request') }}"
                                            class="default-form">
                                            @csrf
                                            <input type="hidden" name="property_id" value="{{ $property->id }}">

                                            <div class="form-group">
                                                <label>Property Price</label>
                                                <input type="text" value="{{ $property->max_price }} ETB"
                                                    class="form-control" readonly>
                                            </div>

                                            <div class="form-group message-btn">
                                                @if ($property->property_status == 'buy')
                                                    <button type="submit" class="btn btn-success w-100">Buy Now</button>
                                                @elseif ($property->property_status == 'rent')
                                                    <button type="submit" class="btn btn-info w-100">Rent Now</button>
                                                @endif
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">
                                            <strong>Notice:</strong> Please <a href="{{ route('login') }}">Login</a> to make a
                                            transaction request.
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Properties -->
                    <div class="similar-content">
                        <div class="title">
                            <h4>Similar Properties</h4>
                        </div>

                        @if ($relatedProperty->isEmpty())
                            <div class="alert alert-info">
                                <p>No similar properties available at this time.</p>
                            </div>
                        @else
                            <div class="row">
                                @foreach ($relatedProperty as $item)
                                    <div class="col-md-12 mb-4">
                                        <div class="feature-block-one">
                                            <div class="inner-box">
                                                <div class="image-box">
                                                    <figure class="image">
                                                        <img src="{{ asset($item->property_thambnail) }}" alt=""
                                                            class="img-fluid">
                                                    </figure>
                                                    <div class="batch"><i class="icon-11"></i></div>
                                                    <span class="category">{{ $item->type->type_name }}</span>
                                                </div>
                                                <div class="lower-content">
                                                    <div class="author-info clearfix">
                                                        <div class="author pull-left">
                                                            @if ($item->agent_id == null)
                                                                <figure class="author-thumb">
                                                                    <img src="{{ url('upload/heriadmin.jpg') }}"
                                                                        alt="" class="img-fluid">
                                                                </figure>
                                                                <h6>Admin</h6>
                                                            @else
                                                                <figure class="author-thumb">
                                                                    <img src="{{ !empty($item->user->photo) ? url('upload/agent_images/' . $item->user->photo) : url('upload/no_image.jpg') }}"
                                                                        alt="" class="img-fluid">
                                                                </figure>
                                                                <h6>{{ $item->user->name }}</h6>
                                                            @endif
                                                        </div>
                                                        <div class="buy-btn pull-right">
                                                            <a href="property-details.html">For
                                                                {{ $item->property_status }}</a>
                                                        </div>
                                                    </div>
                                                    <div class="title-text">
                                                        <h4><a
                                                                href="{{ url('property/details/' . $item->id . '/' . $item->property_slug) }}">{{ $item->property_name }}</a>
                                                        </h4>
                                                    </div>
                                                    <div class="price-box clearfix">
                                                        <div class="price-info pull-left">
                                                            <h6>Start From</h6>
                                                            <h4>${{ $item->lowest_price }}</h4>
                                                        </div>
                                                        <ul class="other-option pull-right clearfix">
                                                            <li><a href="property-details.html"><i
                                                                        class="icon-12"></i></a></li>
                                                            <li><a href="property-details.html"><i
                                                                        class="icon-13"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <p>{{ $item->short_descp }}</p>
                                                    <ul class="more-details clearfix">
                                                        <li><i class="icon-14"></i>{{ $item->bedrooms }} Beds</li>
                                                        <li><i class="icon-15"></i>{{ $item->bathrooms }} Baths</li>
                                                        <li><i class="icon-16"></i>{{ $item->property_size }} Sq Ft</li>
                                                    </ul>
                                                    <div class="btn-box">
                                                        <a href="{{ url('property/details/' . $item->id . '/' . $item->property_slug) }}"
                                                            class="theme-btn btn-two">See Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- property-details end -->
@endsection
