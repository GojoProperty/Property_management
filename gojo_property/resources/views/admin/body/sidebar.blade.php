@php
    $user = Auth::user();
    $status = null;

    if ($user) {
        $agent = App\Models\User::find($user->id);
        $status = $agent?->status;
    }
@endphp


<nav class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="sidebar-brand">
            Gojo<span>property</span>
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
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            @if ($status === 'active')
                <li class="nav-item nav-category">Gojo Property</li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#propertyType" role="button"
                        aria-expanded="false" aria-controls="propertyType">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="link-title">Property Type</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="propertyType">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.type') }}" class="nav-link">All Type</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('add.type') }}" class="nav-link">Add Type</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#amenitieSection" role="button"
                        aria-expanded="false" aria-controls="amenitieSection">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="link-title">Amenitie</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="amenitieSection">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.amenitie') }}" class="nav-link">All Amenitie</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('add.amenitie') }}" class="nav-link">Add Amenitie</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#property" role="button" aria-expanded="false"
                        aria-controls="property">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="link-title">Property</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="property">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.property') }}" class="nav-link">All Property</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('add.property') }}" class="nav-link">Add Property</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.package.history') }}" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Package History</span>
                    </a>
                </li>
                <li class="nav-item nav-category">User All Function</li>
                <!-- Testimonials Management -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#testimonials" role="button"
                        aria-expanded="false" aria-controls="emails">
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

                <!-- Blog Category -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#blogcategory" role="button"
                        aria-expanded="false" aria-controls="uiComponents">
                        <i class="link-icon" data-feather="feather"></i>
                        <span class="link-title">Blog Category</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="blogcategory">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.blog.category') }}" class="nav-link">All Blog Category</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Blog Post -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#Post" role="button"
                        aria-expanded="false" aria-controls="uiComponents">
                        <i class="link-icon" data-feather="feather"></i>
                        <span class="link-title">Blog Post</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="Post">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.post') }}" class="nav-link">All Post</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('add.post') }}" class="nav-link">Add Post</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Blog Comment -->
                <li class="nav-item">
                    <a href="{{ route('admin.blog.comment') }}" class="nav-link">
                        <i class="link-icon" data-feather="calendar"></i>
                        <span class="link-title">Blog Comment</span>
                    </a>
                </li>

                {{-- <!-- UI Kit -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button"
                        aria-expanded="false" aria-controls="uiComponents">
                        <i class="link-icon" data-feather="feather"></i>
                        <span class="link-title">UI Kit</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="uiComponents">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/ui-components/accordion.html" class="nav-link">Accordion</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/ui-components/alerts.html" class="nav-link">Alerts</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <!-- Transaction -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button"
                        aria-expanded="false" aria-controls="advancedUI">
                        <i class="link-icon" data-feather="anchor"></i>
                        <span class="link-title">Transaction</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="advancedUI">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('transaction.details') }}" class="nav-link">All Transactions</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
                            </li> --}}
                        </ul>
                    </div>
                </li>

                {{-- <!-- Docs Section -->
                <li class="nav-item nav-category">Docs</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="hash"></i>
                        <span class="link-title">Documentation</span>
                    </a>
                </li> --}}
            @endif
        </ul>
    </div>
</nav>
