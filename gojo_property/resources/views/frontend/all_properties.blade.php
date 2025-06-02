@extends('frontend.frontend_dashboard')
@section('main')
    <div class="container py-4">

        {{-- Search Form --}}
        <form method="GET" action="{{ route('all.properties') }}" class="mb-4 row g-3 align-items-end">
            <div class="col-md-4">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" class="form-control" placeholder="Enter city"
                    value="{{ request('city') }}">
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label">Property Status</label>
                <select name="status" class="form-select">
                    <option value="">-- Select Status --</option>
                    <option value="Rent" {{ request('status') == 'Rent' ? 'selected' : '' }}>For Rent</option>
                    <option value="Buy" {{ request('status') == 'Buy' ? 'selected' : '' }}>For Sale</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="type" class="form-label">Property Type</label>
                <select name="type" class="form-select">
                    <option value="">-- Select Type --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                            {{ $type->type_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        {{-- Properties Listing --}}
        <div class="row">
            @forelse ($properties as $property)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($property->property_thambnail) }}" class="card-img-top"
                            style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->property_name }}</h5>
                            <p class="card-text">
                                <strong>Status:</strong> {{ $property->property_status }}<br>
                                <strong>City:</strong> {{ $property->city }}<br>
                                <strong>Type:</strong> {{ $property->type->type_name ?? 'N/A' }}
                            </p>
                            <a href="{{ route('property.details', ['id' => $property->id, 'slug' => $property->property_slug]) }}"
                                class="btn btn-outline-primary">View
                                Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No properties found.</p>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $properties->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
