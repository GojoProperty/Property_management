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
                <ul class="social-links clearfix">
                    <li><a href="index.html"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="index.html"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="index.html"><i class="fab fa-pinterest-p"></i></a></li>
                    <li><a href="index.html"><i class="fab fa-google-plus-g"></i></a></li>
                    <li><a href="index.html"><i class="fab fa-vimeo-v"></i></a></li>
                </ul>
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
                                <li class="current dropdown"><a href="index.html"><span>Home</span></a>
                                    <ul>
                                        <li><a href="index.html">Main Home</a></li>
                                        <li><a href="index-2.html">Home Modern</a></li>
                                        <li><a href="index-3.html">Home Map</a></li>
                                        <li><a href="index-4.html">Home Half Map</a></li>
                                        <li><a href="index-5.html">Home Agent</a></li>
                                        <li><a href="index-onepage.html">OnePage Home</a></li>
                                        <li><a href="index-rtl.html">RTL Home</a></li>
                                        <li class="dropdown"><a href="index.html">Header Style</a>
                                            <ul>
                                                <li><a href="index.html">Header Style 01</a></li>
                                                <li><a href="index-2.html">Header Style 02</a></li>
                                                <li><a href="index-3.html">Header Style 03</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#team-section"><span>Our Agents </span></a>

                                </li>
                                <li class="dropdown"><a href="index.html"><span>Property</span></a>
                                    <ul>
                                        <li><a href="#deals-section">Hot properties</a></li>
                                        <li><a href="{{ route('all.properties') }}">All properties</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="index.html"><span>Pages</span></a>

                                </li>
                                <li class="dropdown"><a href="index.html"><span>Agency</span></a>

                                </li>
                                <li><a href="{{ route('blog.list') }}"><span>Blog </span></a> </li>
                                <li><a href="contact.html"><span>Contact</span></a></li>
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
