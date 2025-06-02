<div class="widget-content">
    <ul class="category-list">

        <li><a href="{{ route('user.profile') }}"><i class="fa fa-cog" aria-hidden="true"></i> Profile Settings</a></li>

        <li><a href="{{ route('user.change.password') }}"><i class="fa fa-key" aria-hidden="true"></i> Password Setting</a>
        </li>
        <li><a href="{{ route('user.wishlist') }}"><i class="fa fa-indent" aria-hidden="true"></i> Your Wishlist Property
            </a></li>

        <li><a href="{{ route('user.compare') }}"><i class="fa fa-list-alt" aria-hidden="true"></i></i> Properties to
                Compare </a>

        <li><a href="{{ route('user.schedule.request') }}"><i class="fa fa-credit-card" aria-hidden="true"></i>Your
                Schedule Requests <span class="badge badge-info">( )</span></a></li>

        </li>
        <li><a href="{{ route('preferences.create') }}"><i class="fa fa-list-alt" aria-hidden="true"></i></i> Set your
                preference
            </a>
        </li>
        <li>
            <a href="{{ route('user.recommendations') }}">
                <i class="fas fa-star text-success"></i> Recommendations
            </a>
        </li>
        <li class="nav-item nav-category">Testimony</li>
        <!-- Testimonials Management -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#testimonials" role="button" aria-expanded="false"
                aria-controls="emails">
                <i class="link-icon" data-feather="mail"></i>
                <span class="link-title">Testimonials Manage</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="testimonials">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="{{ route('all.testimonials') }}" class="nav-link">All Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('add.testimonials') }}" class="nav-link">Add Testimonials</a>
                    </li>
                </ul>
            </div>
        </li>
        <li><a href="{{ route('user.logout') }}"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> Logout</a>
        </li>
    </ul>
</div>
