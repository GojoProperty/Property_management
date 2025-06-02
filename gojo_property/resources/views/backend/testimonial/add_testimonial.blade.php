@extends('frontend.frontend_dashboard')
@section('main')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <div class="page-content">
        <div class="container py-5"> {{-- Add padding around the page --}}
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">

                    {{-- ✅ Card Start --}}
                    <div class="card shadow">
                        <div class="card-header text-center bg-primary text-white">
                            <h5 class="mb-0">Add Testimonial</h5>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('store.testimonials') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <input type="text" name="position" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea name="message" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Testimonial Photo</label>
                                    <input class="form-control" name="image" type="file" id="image">
                                </div>

                                <div class="mb-3 text-center">
                                    <img id="showImage" class="rounded-circle" style="width: 80px; height: 80px;"
                                        src="{{ url('upload/no_image.jpg') }}" alt="Preview">
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit Testimonial</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- ✅ Card End --}}

                </div>
            </div>
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
