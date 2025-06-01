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
                <h1>Recommendation</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('dashboard') }}">Home</a></li>
                    <li>Recommended Properties</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    <div class="container py-4">
        <h2 class="mb-4">Recommended Properties Based on Your Preferences</h2>

        @if ($notifications->count())
            <div class="row">
                @foreach ($notifications as $notify)
                    @php
                        $property = $notify->property;
                    @endphp
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            @if ($property->property_thambnail)
                                <img src="{{ asset($property->property_thambnail) }}" class="card-img-top"
                                    alt="Property Image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $property->property_name }}</h5>
                                <p class="card-text">
                                    <strong>Location:</strong> {{ $property->city ?? 'N/A' }} <br>
                                    <strong>Price Range:</strong>
                                    {{ $property->lowest_price ? '$' . number_format($property->lowest_price) : 'N/A' }} -
                                    {{ $property->max_price ? '$' . number_format($property->max_price) : 'N/A' }} <br>
                                    <strong>Type:</strong> {{ $property->type->type_name ?? 'N/A' }} <br>
                                    <strong>Bedrooms:</strong> {{ $property->bedrooms ?? 'N/A' }} <br>
                                    <strong>Bathrooms:</strong> {{ $property->bathrooms ?? 'N/A' }}<br>
                                    <strong>Property Status:</strong> For {{ $property->property_status ?? 'N/A' }}
                                </p>
                                <a href="{{ route('property.details', ['id' => $property->id, 'slug' => $property->property_slug]) }}"
                                    class="btn btn-success btn-sm">
                                    View Property
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No recommended properties yet.</p>
        @endif
    </div>
@endsection
