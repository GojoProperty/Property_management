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
        <li><a href="{{ route('user.logout') }}"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> Logout</a>
        </li>
    </ul>
</div>
