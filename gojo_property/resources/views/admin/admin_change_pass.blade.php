@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="row profile-body">

            <!-- left wrapper start -->
            <div class="d-none d-md-block col-md-4 c ol-xl-4 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <img class="wd-70 rounded-circle"
                                    src="{{ !empty($profileData->photo) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                    alt="profile">
                                <span class="h4 ms-3 ">{{ $profileData->username }}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                            <p class="text-muted">{{ $profileData->name }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                            <p class="text-muted">{{ $profileData->email }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">phone:</label>
                            <p class="text-muted">{{ $profileData->phone }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
                            <p class="text-muted">{{ $profileData->address }}</p>
                        </div>
                        <div class="mt-3 d-flex social-links">
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="github"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="twitter"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- left wrapper end -->

            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="card-body">
                        <h3 class="card-title">Admin Change password</h3>
                        <br>
                        <form method="POST" action="{{ route('admin.update.password') }}" class="forms-sample">

                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label"> old password </label>
                                <input type="password" name="old_password"
                                    class="form-control @error('old_password') is-invalid @enderror" id="old_password"
                                    autocomplete="off">
                                @error('old_password')
                                    <span class="text-danger"> {{ $message }}
                                    @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label"> new password </label>
                                <input type="password" name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror" id="new_password"
                                    autocomplete="off">
                                @error('new_password')
                                    <span class="text-danger"> {{ $message }}
                                    @enderror
                            </div>
                            <div class="mb-3">
                                <label for ="exampleInputUsername1" class="form-label"> confirm password </label>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                                    autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-primary me-2">save changes </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- middle wrapper end -->
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('showImage').src = e.target.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endsection
