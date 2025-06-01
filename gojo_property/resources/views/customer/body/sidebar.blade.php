<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Gojo<span>Customer</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                {{-- <a href="{{ route('customer.customer.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a> --}}
            </li>

            <li class="nav-item nav-category">Property</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#property" role="button" aria-expanded="false"
                    aria-controls="property">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">My Properties</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="property">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('customer.all.property') }}" class="nav-link">All My Properties</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.add.property') }}" class="nav-link">Post Property</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
