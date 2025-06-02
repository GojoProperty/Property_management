@extends('frontend.frontend_dashboard')
@section('main')
    <section class="page-title-two bg-color-1 centred">
        <div class="pattern-layer">
            <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
            </div>
            <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});">
            </div>
        </div>

        <div class="auto-container">
            <div class="content-box clearfix">
                <h1>Compare Properties</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('dashboard') }}">Home</a></li>
                    <li>Compare Properties</li>
                </ul>
            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <div class="page-content">
        <div class="row profile-body">
            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Edit Testimonial</h6>
                            <form method="POST" action="{{ route('update.testimonials') }}" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $testimonial->id }}">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $testimonial->name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <input type="text" name="position" class="form-control"
                                        value="{{ $testimonial->position }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea name="message" class="form-control" rows="3">{{ $testimonial->message }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Testimonial Photo</label>
                                    <input class="form-control" name="image" type="file" id="image">
                                </div>
                                <div class="mb-3">
                                    <img id="showImage" class="wd-80 rounded-circle" src="{{ asset($testimonial->image) }}"
                                        alt="profile">
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- middle wrapper end -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endsection
