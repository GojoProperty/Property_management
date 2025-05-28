@extends('frontend.frontend_dashboard')    
@section('main')

<!-- Page Title -->
<section class="page-title-two bg-color-1 centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{asset('frontend/assets/images/shape/shape-9.png')}});"></div>
        <div class="pattern-2" style="background-image: url({{asset('frontend/assets/images/shape/shape-10.png')}});"></div>
    </div>
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>Forgot Password</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Forgot Password</li>
            </ul>
        </div>
    </div>
</section>
<!-- End Page Title -->

<!-- Forgot Password Section -->
<section class="ragister-section centred sec-pad">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-xl-8 col-lg-12 col-md-12 offset-xl-2 big-column">
                <div class="sec-title"></div>
                <div class="tabs-box">
                    <div class="inner-box">
                        <h4>Reset Your Password</h4>
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="default-form">
                            @csrf
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group message-btn">
                                <button type="submit" class="theme-btn btn-one">Send Password Reset Link</button>
                            </div>
                        </form>

                        <div class="othre-text">
                            <p>Back to <a href="{{ route('login') }}">Login</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Forgot Password Section End -->

@endsection
