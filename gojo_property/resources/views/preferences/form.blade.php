@extends('frontend.frontend_dashboard')
@section('main')
    <div class="container py-5"> {{-- py-5 = padding-top and padding-bottom --}}
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
                <label for="max_price">Maximum Price</label>
                <input type="number" name="max_price" class="form-control"
                    value="{{ old('max_price', $preference->max_price) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Property Type </label>
                <select name="property_type" class="form-select" id="exampleFormControlSelect1">
                    <option selected="" disabled="">Select Type</option>
                    @foreach ($propertyTypes as $ptype)
                        <option value="{{ $ptype->id }}"
                            {{ old('property_type', $preference->property_type) == $ptype->id ? 'selected' : '' }}>
                            {{ $ptype->type_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="bedrooms">Bedrooms</label>
                <input type="text" name="bedrooms" class="form-control"
                    value="{{ old('bedrooms', $preference->bedrooms) }}">
            </div>

            <div class="form-group">
                <label for="bathrooms">Bathrooms</label>
                <input type="text" name="bathrooms" class="form-control"
                    value="{{ old('bathrooms', $preference->bathrooms) }}">
            </div>
            <div class="form-group ">
                <label class="form-label">Property Status</label>
                <select name="property_status" class="form-select" id="propStatus">
                    <option selected="" disabled="">Select Status</option>
                    <option value="rent">For Rent</option>
                    <option value="buy">For Buy</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-4">Save Preferences</button>
        </form>
    </div>
@endsection
