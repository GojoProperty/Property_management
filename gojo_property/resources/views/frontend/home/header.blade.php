<header class="main-header">
    <!-- header-top -->
    <div class="header-top">
        <div class="top-inner clearfix">
            <div class="left-column pull-left">
                <ul class="info clearfix">
                    <li><i class="far fa-map-marker-alt"></i>Hawassa,Ethiopia</li>
                    <li><i class="far fa-phone"></i><a href="tel:2512353256">+251 462 12 68 80</a></li>
                </ul>
            </div>
            <div class="right-column pull-right">
             
                <div> {{-- sign up based on autentication  --}}
                    @auth
                        <div class="sign-box">
                            @php
                                $role = Auth::user()->role;
                            @endphp

                            @if ($role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-user"></i>Dashboard</a>
                            @elseif ($role === 'agent')
                                <a href="{{ route('agent.dashboard') }}"><i class="fas fa-user"></i>Dashboard</a>
                            @else
                                <a href="{{ route('dashboard') }}"><i class="fas fa-user"></i>Dashboard</a>
                            @endif

                            <a href="{{ route('user.logout') }}"><i class="fas fa-user"></i>Logout</a>
                        </div>
                    @else
                        <div class="sign-box">
                            <a href="{{ route('login') }}"><i class="fas fa-user"></i>Sign In</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="header-lower">
        <div class="outer-box">
            <div class="main-box">
                <div class="logo-box">
                    <figure class="logo"><a href="{{ url('/') }}"><img
                                src="{{ asset('frontend/assets/images/gojo.png') }}" alt=""></a></figure>
                </div>
                <div class="menu-area clearfix">

                    <div class="mobile-nav-toggler">
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                    </div>
                    <nav class="main-menu navbar-expand-md navbar-light">
                        <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li><a href="{{ url('/') }}"><span>Home</span></a>
                                </li>
                                <li class="dropdown"><a href="#"><span>Property</span></a>
                                    <ul>
                                        <li><a href="{{ url('/') }}#deals-section">Hot properties</a></li>
                                        <li><a href="{{ route('all.properties') }}">All properties</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('/') }}#team-section"><span>Our Agents </span></a>
                                </li>

                                <li><a href="{{ url('/') }}#testimonial-section"><span>Our Testimonies</span></a>

                                </li>
                                <li><a href="{{ url('/') }}#place-section"><span>Popular places</span></a>

                                </li>
                                <li><a href="{{ route('blog.list') }}"><span>Blog </span></a> </li>
                                <li><a href="{{ url('/') }}#chooseus-section"><span>why choose us</span></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div> {{-- add listing based on authentication --}}
                    <div> {{-- add listing based on autentication  --}}
                        @auth
                            <div class="btn-box">
                                @php
                                    $role = Auth::user()->role;
                                @endphp

                                @if ($role === 'admin')
                                    <a href="{{ route('add.property') }}" class="theme-btn btn-one">Add listing</a>
                                @elseif ($role === 'agent')
                                    <a href="{{ route('agent.add.property') }}" class="theme-btn btn-one">Add Listing</a>
                                @else
                                    <a href="{{ route('customer.add.property') }}" class="theme-btn btn-one">User Add
                                        Listing</a>
                                @endif
                            </div>
                        @endauth

                        @guest
                            <div class="btn-box">
                                <a href="{{ route('add.property') }}" class="theme-btn btn-one"><span>+</span> Add
                                    Listing</a>
                            </div>
                        @endauth
                    </div>

                </div>
            </div>
        </div>


        <!--sticky Header-->
        <div class="sticky-header">
            <div class="outer-box">
                <div class="main-box">
                    <div class="logo-box">
                        <figure class="logo"><a href="{{ url('/') }}"><img
                                    src="{{ asset('frontend/assets/images/gojo.png') }}" alt=""></a>
                        </figure>
                    </div>
                    <div class="menu-area clearfix">
                        <nav class="main-menu clearfix">
                            <!--Keep This Empty / Menu will come through Javascript-->
                        </nav>
                    </div>
                    <div> {{-- add listing based on autentication  --}}
                        @auth
                            <div class="btn-box">
                                @php
                                    $role = Auth::user()->role;
                                @endphp

                                @if ($role === 'admin')
                                    <a href="{{ route('add.property') }}" class="theme-btn btn-one">Add listing</a>
                                @elseif ($role === 'agent')
                                    <a href="{{ route('agent.add.property') }}" class="theme-btn btn-one">Add Listing</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="theme-btn btn-one">User Add Listing</a>
                                @endif
                            </div>
                        @endauth

                        @guest
                            <div class="btn-box">
                                <a href="{{ route('add.property') }}" class="theme-btn btn-one"><span>+</span> Add
                                    Listing</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
