@extends('frontend.frontend_dashboard')
@section('main')
    <div class="container">
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
        <h2>Set Your Property Preferences</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('preferences.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="location">Preferred city</label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $preference->city) }}">
            </div>

            <div class="form-group">
                <label for="min_price">Minimum Price</label>
                <input type="number" name="lowest_price" class="form-control"
                    value="{{ old('lowest_price', $preference->lowest_price) }}">
            </div>

            <div class="form-group">
                <label for="max_price">Maximum Price</label>
                <input type="number" name="max_price" class="form-control"
                    value="{{ old('max_price', $preference->max_price) }}">
            </div>

            <div class="form-group">
                <label for="property_type">Property Type</label>
                <input type="text" name="property_type" class="form-control"
                    value="{{ old('property_type', $preference->property_type) }}">
            </div>

            <div class="form-group">
                <label for="property_type">Bedrooms</label>
                <input type="text" name="bedrooms" class="form-control"
                    value="{{ old('bedrooms', $preference->bedrooms) }}">
            </div>

            <div class="form-group">
                <label for="property_type">Bathrooms</label>
                <input type="text" name="bathrooms" class="form-control"
                    value="{{ old('bathrooms', $preference->bathrooms) }}">
            </div>

            <button type="submit" class="btn btn-success">Save Preferences</button>
        </form>
    </div>
@endsection
