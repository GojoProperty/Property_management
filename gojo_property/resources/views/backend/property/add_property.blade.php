@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="page-content">
        <div class="row profile-body">
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Property not added. Please fix the following errors:</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <h6 class="card-title">Add Property </h6>
                            <form method="post" action="{{ route('store.property') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="row">
                                        <!-- Property Name -->
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Property Name</label>
                                                <input type="text" name="property_name"
                                                    class="form-control @error('property_name') is-invalid @enderror"
                                                    value="{{ old('property_name') }}">
                                                @error('property_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Property Status -->
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Property Status</label>
                                                <select name="property_status"
                                                    class="form-select @error('property_status') is-invalid @enderror">
                                                    <option selected disabled>Select Status</option>
                                                    <option value="rent"
                                                        {{ old('property_status') == 'rent' ? 'selected' : '' }}>For Rent
                                                    </option>
                                                    <option value="buy"
                                                        {{ old('property_status') == 'buy' ? 'selected' : '' }}>For Buy
                                                    </option>
                                                </select>
                                                @error('property_status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="text" name="max_price"
                                                    class="form-control @error('max_price') is-invalid @enderror"
                                                    value="{{ old('max_price') }}" placeholder="e.g. 1,000.00">
                                                @error('max_price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <!-- Main Thumbnail -->
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Main Thumbnail</label>
                                                <input type="file" name="property_thambnail"
                                                    class="form-control @error('property_thambnail') is-invalid @enderror">
                                                @error('property_thambnail')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Multiple Images -->
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Multiple Images</label>
                                                <input type="file" name="multi_img[]"
                                                    class="form-control @error('multi_img') is-invalid @enderror" multiple>
                                                @error('multi_img')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Bedrooms -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Bedrooms</label>
                                            <input type="text" name="bedrooms"
                                                class="form-control @error('bedrooms') is-invalid @enderror"
                                                value="{{ old('bedrooms') }}">
                                            @error('bedrooms')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Bathrooms -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Bathrooms</label>
                                            <input type="text" name="bathrooms"
                                                class="form-control @error('bathrooms') is-invalid @enderror"
                                                value="{{ old('bathrooms') }}">
                                            @error('bathrooms')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" name="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                value="{{ old('address') }}">
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" name="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                value="{{ old('city') }}">
                                            @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- State -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">State</label>
                                            <select name="state" class="form-select @error('state') is-invalid @enderror">
                                                <option selected disabled>Select State</option>
                                                @foreach ($pstate as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ old('state') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->state_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Property Size -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Property Size</label>
                                            <input type="text" name="property_size"
                                                class="form-control @error('property_size') is-invalid @enderror"
                                                value="{{ old('property_size') }}">
                                            @error('property_size')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Property Video -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Property Video</label>
                                            <input type="text" name="property_video"
                                                class="form-control @error('property_video') is-invalid @enderror"
                                                value="{{ old('property_video') }}"
                                                placeholder="https://example.com/video">
                                            @error('property_video')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Neighborhood -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Neighborhood</label>
                                            <input type="text" name="neighborhood" class="form-control"
                                                value="{{ old('neighborhood') }}">
                                        </div>
                                    </div>

                                    <!-- Latitude -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Latitude</label>
                                            <input type="text" name="latitude"
                                                class="form-control @error('latitude') is-invalid @enderror"
                                                value="{{ old('latitude') }}">
                                            @error('latitude')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Longitude -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Longitude</label>
                                            <input type="text" name="longitude"
                                                class="form-control @error('longitude') is-invalid @enderror"
                                                value="{{ old('longitude') }}">
                                            @error('longitude')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Property Type -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Property Type</label>
                                            <select name="ptype_id"
                                                class="form-select @error('ptype_id') is-invalid @enderror">
                                                <option selected disabled>Select Type</option>
                                                @foreach ($propertytype as $ptype)
                                                    <option value="{{ $ptype->id }}"
                                                        {{ old('ptype_id') == $ptype->id ? 'selected' : '' }}>
                                                        {{ $ptype->type_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('ptype_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Amenities -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <div class="mb-3" data-select2-id="25">
                                                <label class="form-label" for="amenities_id">Property
                                                    Amenities</label>
                                                <select id="amenities_id" name="amenities_id[]"
                                                    class="js-example-basic-multiple form-select select2-hidden-accessible"
                                                    multiple="" data-width="100%" tabindex="-1" aria-hidden="true">
                                                    @foreach ($amenities as $ameni)
                                                        <option value="{{ $ameni->amenities_name }}">
                                                            {{ $ameni->amenities_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Agent -->
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Agent</label>
                                            <select name="agent_id"
                                                class="form-select @error('agent_id') is-invalid @enderror">
                                                <option selected disabled>Select Agent</option>
                                                @foreach ($activeAgent as $agent)
                                                    <option value="{{ $agent->id }}"
                                                        {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                                        {{ $agent->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('agent_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Short Description -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Short Description</label>
                                            <textarea name="short_descp" class="form-control @error('short_descp') is-invalid @enderror">{{ old('short_descp') }}</textarea>
                                            @error('short_descp')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Long Description -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Long Description</label>
                                            <textarea name="long_descp" class="form-control @error('long_descp') is-invalid @enderror" rows="10">{{ old('long_descp') }}</textarea>
                                            @error('long_descp')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Facilities (Dynamic) -->
                                    <div class="row add_item">
                                        <div class="col-md-4">
                                            <label class="form-label">Facility</label>
                                            <select name="facility_name[]" class="form-control">
                                                <option value="">Select Facility</option>
                                                <option value="Hospital">Hospital</option>
                                                <option value="School">School</option>
                                                <option value="SuperMarket">Super Market</option>
                                                <option value="Mall">Mall</option>
                                                <!-- Add more if needed -->
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Distance</label>
                                            <input type="text" name="distance[]" class="form-control"
                                                placeholder="Distance (Km)">
                                        </div>
                                        <div class="col-md-4" style="padding-top: 30px;">
                                            <a class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> Add
                                                More</a>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-sm-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Save Property</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="visibility: hidden">
        <div class="whole_extra_item_add" id="whole_extra_item_add">
            <div class="whole_extra_item_delete" id="whole_extra_item_delete">
                <div class="container mt-2">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="facility_name">Facilities</label>
                            <select name="facility_name[]" id="facility_name" class="form-control">
                                <option value="">Select Facility</option>
                                <option value="Hospital">Hospital</option>
                                <option value="SuperMarket">Super Market</option>
                                <option value="School">School</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Pharmacy">Pharmacy</option>
                                <option value="Airport">Airport</option>
                                <option value="Railways">Railways</option>
                                <option value="Bus Stop">Bus Stop</option>
                                <option value="Beach">Beach</option>
                                <option value="Mall">Mall</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="distance">Distance</label>
                            <input type="text" name="distance[]" id="distance" class="form-control"
                                placeholder="Distance (Km)">
                        </div>
                        <div class="form-group col-md-4" style="padding-top: 20px">
                            <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add</i></span>
                            <span class="btn btn-danger btn-sm removeeventmore"><i
                                    class="fa fa-minus-circle">Remove</i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--javascript or jquery codes -->
    <script>
        document.getElementById('multiImg').addEventListener('change', function() {
            console.log('Selected Files:', this.files);
            console.log('Number of Files Selected:', this.files.length);
        });
    </script>
    {{-- to display customized css fo type='file' --}}
    <script>
        document.getElementById("property_thambnail").addEventListener("change", function() {
            var fileName = this.files[0] ? this.files[0].name : "No file chosen";
            document.getElementById("file-name").textContent = fileName;
        });
    </script>

    {{-- to display more add facility  --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", ".addeventmore", function() {
                var whole_extra_item_add = $("#whole_extra_item_add").html();
                $(".add_item").append(whole_extra_item_add); // Append inside the correct container
            });

            $(document).on("click", ".removeeventmore", function() {
                $(this).closest(".whole_extra_item_delete").remove(); // Remove the clicked row
            });
        });
    </script>




    {{-- to validate the inputs --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    property_name: {
                        required: true,
                    },
                    property_status: {
                        required: true,
                    },
                    lowest_price: {
                        required: true,
                    },
                    max_price: {
                        required: true,
                    },
                    ptype_id: {
                        required: true,
                    },
                },
                messages: {
                    property_name: {
                        required: 'Please Enter Property Name',
                    },
                    property_status: {
                        required: 'Please Select Property Status',
                    },
                    lowest_price: {
                        required: 'Please Enter Lowest Price',
                    },
                    max_price: {
                        required: 'Please Enter Max Price',
                    },
                    ptype_id: {
                        required: 'Please Select Property Type',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>


    <script type="text/javascript">
        function mainThamUrl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mainThmb').attr('src', e.target.result).width(80).height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#multiImg').on('change', function() { //on file input change
                if (window.File && window.FileReader && window.FileList && window
                    .Blob) //check File API supported browser
                {
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file) { //loop though each file
                        if (/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file
                                .type)) { //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file) { //trigger function on successful read
                                return function(e) {
                                    var img = $('<img/>').addClass('thumb').attr('src',
                                            e.target.result).width(100)
                                        .height(80); //create image element 
                                    $('#preview_img').append(
                                        img); //append image to output element
                                };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });

                } else {
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: "Select Amenities",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
