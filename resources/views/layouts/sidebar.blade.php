<!-- Sidebar -->
<nav class="bg-dark text-white position-fixed h-100" style="width:260px; top:0; left:0; overflow-y:auto; z-index:1000;">
    <div class="p-3">

        <!-- Branding -->
        <h4 class="text-center py-3 border-bottom">
            Crowed Funding System
        </h4>

        <!-- Menu -->
        <ul class="nav flex-column mt-3">

            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link text-white fw-bold {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa fa-home me-2"></i> Dashboard
                </a>
            </li>

            <!-- show analytics -->
            <li class="nav-item">
                <a href="{{ route('crises.analytics') }}" 
                   class="nav-link text-white fw-bold {{ request()->routeIs('crises.analytics') ? 'active' : '' }}">
                    <i class="fa fa-chart-bar me-2"></i> Crises Report
                </a>
            </li>

            {{-- <li class="nav-item">
                <a href="{{ route('gme-business-admin.index') }}" 
                    class="nav-link text-white {{ request()->routeIs('gme-business-admin.index') ? 'active' : '' }}">
                    <i class="fa fa-list me-2"></i> All Business
                </a>
            </li> --}}

                        

            <!-- Admin Channel Dropdown -->
            {{-- <li class="nav-item mt-3">
                <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                   data-bs-toggle="collapse" 
                   href="#adminChannelMenu" 
                   role="button" 
                   aria-expanded="{{ request()->routeIs('gme-business-admin.*') ? 'true' : 'false' }}" 
                   aria-controls="adminChannelMenu"
                   style="cursor: pointer;">
                    <span>
                        <i class="fa fa-user-shield me-2"></i>
                        <span class="text-uppercase small fw-bold">Admin Channel</span>
                    </span>
                    <i class="fa fa-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->routeIs('gme-business-admin.*') ? 'show' : '' }}" id="adminChannelMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="{{ route('gme-business-admin.index') }}" 
                               class="nav-link text-white {{ request()->routeIs('gme-business-admin.index') ? 'active' : '' }}">
                                <i class="fa fa-list me-2"></i> All Business
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}

            <!-- Categories Dropdown -->
            <li class="nav-item mt-3">
                <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                   data-bs-toggle="collapse" 
                   href="#categoriesMenu" 
                   role="button" 
                   aria-expanded="{{ request()->routeIs('categories.*') ? 'true' : 'false' }}" 
                   aria-controls="categoriesMenu"
                   style="cursor: pointer;">
                    <span>
                        <i class="fa fa-folder me-2"></i>
                        <span class="text-uppercase small fw-bold">Categories</span>
                    </span>
                    <i class="fa fa-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->routeIs('categories.*') ? 'show' : '' }}" id="categoriesMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" 
                               class="nav-link text-white {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                                <i class="fa fa-list me-2"></i> Category Index
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.create') }}" 
                               class="nav-link text-white {{ request()->routeIs('categories.create') ? 'active' : '' }}">
                                <i class="fa fa-plus-circle me-2"></i> Category Create
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Services/Products Dropdown -->
            <li class="nav-item mt-3">
                <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                   data-bs-toggle="collapse" 
                   href="#crisesMenu" 
                   role="button" 
                   aria-expanded="{{ request()->routeIs('crises.*') ? 'true' : 'false' }}" 
                   aria-controls="crisesMenu"
                   style="cursor: pointer;">
                    <span>
                        <i class="fa fa-box me-2"></i>
                        <span class="text-uppercase small fw-bold">Crises</span>
                    </span>
                    <i class="fa fa-chevron-down"></i>
                </a>
                <div class="collapse {{ request()->routeIs('crises.*') ? 'show' : '' }}" id="crisesMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="{{ route('crises.index') }}" 
                               class="nav-link text-white {{ request()->routeIs('crises.index') ? 'active' : '' }}">
                                <i class="fa fa-list me-2"></i> Crises Index
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('crises.create') }}" 
                               class="nav-link text-white {{ request()->routeIs('crises.create') ? 'active' : '' }}">
                                <i class="fa fa-plus-circle me-2"></i> Crises Create
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- User Channel Dropdown (Commented) -->
            {{-- <li class="nav-item mt-3">
                <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                   data-bs-toggle="collapse" 
                   href="#userChannelMenu" 
                   role="button" 
                   aria-expanded="false" 
                   aria-controls="userChannelMenu"
                   style="cursor: pointer;">
                    <span>
                        <i class="fa fa-users me-2"></i>
                        <span class="text-uppercase small fw-bold">User Channel</span>
                    </span>
                    <i class="fa fa-chevron-down"></i>
                </a>
                <div class="collapse" id="userChannelMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="{{ route('gme-business.index') }}" class="nav-link text-white">
                                <i class="fa fa-list me-2"></i> Index
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('gme-business.create') }}" class="nav-link text-white">
                                <i class="fa fa-plus-circle me-2"></i> Create
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}




            <li class="nav-item mt-3">
                <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                data-bs-toggle="collapse" 
                href="#usersMenu" 
                role="button" 
                aria-expanded="{{ request()->routeIs('user.*') ? 'true' : 'false' }}" 
                aria-controls="usersMenu"
                style="cursor: pointer;">
                    <span>
                        <i class="fa fa-users me-2"></i>
                        <span class="text-uppercase small fw-bold">Users</span>
                    </span>
                    <i class="fa fa-chevron-down"></i>
                </a>

                <div class="collapse {{ request()->routeIs('user.*') ? 'show' : '' }}" id="usersMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" 
                            class="nav-link text-white {{ request()->routeIs('user.index') ? 'active' : '' }}">
                                <i class="fa fa-list me-2"></i> User Index
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.create') }}" 
                            class="nav-link text-white {{ request()->routeIs('user.create') ? 'active' : '' }}">
                                <i class="fa fa-plus-circle me-2"></i> User Create
                            </a>
                        </li>
                    </ul>
                </div>
            </li>



            <!-- Logout -->
            <li class="nav-item mt-4">
                <a href="#" class="nav-link text-danger fw-bold"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</nav>

<style>
    /* Smooth dropdown animations */
    .collapse {
        transition: height 0.3s ease;
    }
    
    /* Hover effects for nav links */
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
    }
    
    /* Active link highlighting */
    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.15);
        border-left: 3px solid #007bff;
        padding-left: calc(0.5rem - 3px);
        border-radius: 5px;
        font-weight: 600;
    }
    
    /* Rotate chevron on dropdown open */
    .nav-link[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
    
    .nav-link .fa-chevron-down {
        transition: transform 0.3s ease;
    }
</style>