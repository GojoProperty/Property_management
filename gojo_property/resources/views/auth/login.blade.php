@extends('frontend.frontend_dashboard')

@section('main')
    <!-- Page Title -->
    <section class="page-title-two bg-color-1 centred">
        <div class="pattern-layer">
            <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
            </div>
            <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});">
            </div>
        </div>
        <div class="auto-container">
            <div class="content-box clearfix">
                <h1>Sign In</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Sign In</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Page Title -->

    <!-- Login Section -->
    <section class="ragister-section centred sec-pad">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-xl-8 col-lg-12 col-md-12 offset-xl-2 big-column">
                    <div class="inner-box">
                        <h4>Sign In</h4>
                        <form action="{{ route('login') }}" method="POST" class="default-form">
                            @csrf
                            <div class="form-group">
                                <label>Email/Name/Phone</label>
                                <input type="text" name="login" id="login" value="{{ old('login') }}" required>
                                @error('login')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="tab" id="tab-2">
                            <div class="inner-box">
                                <h4>Sign in</h4>
                                <form action="{{ route('register') }}" method="post" class="default-form">
    @csrf
    <div class="form-group">
        <label>User name</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Email address</label>
        <input type="email" name="email" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <div class="form-group message-btn">
        <button type="submit" class="theme-btn btn-one">Register</button>
    </div>
</form>

                                <div class="othre-text">
                                    <p>Have not any account? <a href="signup.html">Register Now</a></p>
                                </div>
                            </div>
                        </form>

                        <div class="othre-text">
                            <p>Don't have an account? <a href="{{ route('register') }}">Register Now</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
