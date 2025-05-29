@extends('frontend.frontend_dashboard')

@section('main')
    <!--Page Title-->
    <section class="page-title-two bg-color-1 centred">
        <div class="pattern-layer">
            <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
            </div>
            <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});">
            </div>
        </div>
        <div class="auto-container">
            <div class="content-box clearfix">
                <h1>Agent Register</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Register</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <!-- register-section -->
    <section class="register-section centred sec-pad">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-xl-6 col-lg-8 col-md-10 mx-auto">
                    <div class="form-wrapper">
                        <h4 class="mb-4 text-center">Register as an Agent</h4>

                        <form action="{{ route('agent.register') }}" method="POST" class="default-form">
                            @csrf

                            <div class="form-group mt-3">
                                <label for="name" class="form-label" style="display: block; text-align: left;">Agent
                                    Company Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="email" class="form-label" style="display: block; text-align: left;">Email
                                    Address</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="phone" class="form-label" style="display: block; text-align: left;">Agent
                                    Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="password" class="form-label"
                                    style="display: block; text-align: left;">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="password_confirmation" class="form-label"
                                    style="display: block; text-align: left;">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="theme-btn btn-one w-100">Register</button>
                            </div>
                        </form>
                        <div class="othre-text">
                            <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- register-section end -->
@endsection
