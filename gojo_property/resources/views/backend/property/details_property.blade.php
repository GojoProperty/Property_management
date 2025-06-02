@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <div class="page-content">
        <ol class="breadcrumb">
            <a href="{{ route('all.property') }}" class="btn btn-inverse-info"> All Property </a>
        </ol>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card"> <!-- Changed from col-md-6 to col-md-12 -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Property Details</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Property Name</td>
                                        <td><code>{{ $property->property_name }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Property Status</td>
                                        <td><code>{{ $property->property_status }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Lowest Price</td>
                                        <td><code>{{ $property->lowest_price }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Max Price</td>
                                        <td><code>{{ $property->max_price }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>BedRooms</td>
                                        <td><code>{{ $property->bedrooms }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Bathrooms</td>
                                        <td><code>{{ $property->bathrooms }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td><code>{{ $property->address }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td><code>{{ $property->city }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>State</td>
                                        <td><code>{{ $property->state }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Main Image</td>
                                        <td>
                                            <img src="{{ asset($property->property_thambnail) }}" alt="property-image"
                                                style="width:100px; height:70px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            @if ($property->status == 1)
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">InActive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Property Code</td>
                                        <td><code>{{ $property->property_code }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Property Size</td>
                                        <td><code>{{ $property->property_size }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Property Video</td>
                                        <td><code>{{ $property->property_video }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Neighborhood</td>
                                        <td><code>{{ $property->neighborhood }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Latitude</td>
                                        <td><code>{{ $property->latitude }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Longitude</td>
                                        <td><code>{{ $property->longitude }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Property Type</td>
                                        <td><code>{{ $property['type']['type_name'] }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Property Amenities</td>
                                        <td>
                                            <select name="amenities_id[]" class="js-example-basic-multiple form-select"
                                                multiple="multiple" data-width="100%" disabled>
                                                @foreach ($amenities as $ameni)
                                                    <option value="{{ $ameni->amenities_name }}"
                                                        {{ in_array($ameni->amenities_name, $property_amin) ? 'selected' : '' }}>
                                                        {{ $ameni->amenities_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Agent</td>
                                        <td>
                                            @if ($property->agent_id == null)
                                                <code>Admin</code>
                                            @else
                                                <code>{{ $property['user']['name'] }}</code>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Short Description</td>
                                        <td><code>{{ $property->short_descp }}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Long Description</td>
                                        <td><code>{!! $property->long_descp !!}</code></td>
                                    </tr>
                                    <tr>
                                        <td>Action</td>
                                        <td>
                                            @if ($property->status == 1)
                                                @if ($property->property_status == 'buy')
                                                    <span class="badge bg-success">Available for Purchase</span>
                                                @elseif ($property->property_status == 'rent')
                                                    <span class="badge bg-info">Available for Rent</span>
                                                @else
                                                    <span class="badge bg-secondary">Not Available</span>
                                                @endif
                                            @else
                                                <span class="badge bg-danger">Inactive Property</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <br><br>

                            @if ($property->status == 1)
                                <form method="post" action="{{ route('inactive.property') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $property->id }}">
                                    <button type="submit" class="btn btn-primary">InActive</button>
                                </form>
                            @else
                                <form method="post" action="{{ route('active.property') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $property->id }}">
                                    <button type="submit" class="btn btn-primary">Active</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
