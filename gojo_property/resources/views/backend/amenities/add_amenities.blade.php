@extends('admin.admin_dashboard')

@section('admin')

<!-- Include jQuery and jQuery Validate Plugin -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Add Amenities</h6>

                        <!-- Corrected Form -->
                        <form id="amenitiesForm" method="POST" action="{{ route('store.amenitie') }}" class="forms-sample">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="amenities_name" class="form-label">Amenities Name</label>
                                <input type="text" name="amenities_name" id="amenities_name" class="form-control @error('amenities_name') is-invalid @enderror" placeholder="Enter Amenities Name">
                                
                                @error('amenities_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Validation Script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#amenitiesForm').validate({
            rules: {
                amenities_name: {
                    required: true,
                    minlength: 3
                },
            },
            messages: {
                amenities_name: {
                    required: 'Please enter an amenities name',
                    minlength: 'The name must be at least 3 characters long'
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.after(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection
