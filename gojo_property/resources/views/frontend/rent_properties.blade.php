@extends('frontend.frontend_dashboard')

@section('main')
<div class="container py-5">
    <h2 class="mb-4 text-center">Available Properties for Rent</h2>

    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset($property->property_thumbnail) }}" class="card-img-top" alt="Property Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $property->property_name }}</h5>
                        <p class="card-text">{{ Str::limit($property->description, 100) }}</p>
                        <p><strong>Price:</strong> {{ $property->price }} ETB/month</p>
                        <a href="{{ route('property.details', $property->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No rental properties available at the moment.</p>
        @endforelse
    </div>
</div>
@endsection
