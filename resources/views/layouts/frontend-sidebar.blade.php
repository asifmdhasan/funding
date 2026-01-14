<!-- Sidebar -->
<nav class="bg-dark text-white position-fixed h-100" style="width:260px; top:0; left:0; overflow-y:auto;">
    <div class="p-3">

        <!-- Branding -->
        <h4 class="text-center py-3 border-bottom">
            Gme Network
        </h4>

        <!-- Menu -->
        <ul class="nav flex-column mt-3">

            <!-- Dashboard -->
            {{-- <li class="nav-item mb-2">
                <a href="{{ route('customer.dashboard') }}" class="nav-link text-white fw-bold">
                    <i class="fa fa-home me-2"></i> All Business
                </a>
            </li> --}}

            <!-- Admin Channel -->
            {{-- <li class="nav-item mt-3">
                <span class="text-uppercase text-secondary small fw-bold">Admin Channel</span>
            </li>

            <li class="nav-item">
                <a href="{{ route('gme-business-admin.index') }}" class="nav-link text-white">
                    <i class="fa fa-list me-2"></i> Admin Index
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('gme-business-admin.create') }}" class="nav-link text-white">
                    <i class="fa fa-edit me-2"></i> Edit
                </a>
            </li> --}}

            <!-- Customer Channel -->
            {{-- <li class="nav-item mt-4">
                <span class="text-uppercase text-secondary small fw-bold">User Channel</span>
            </li> --}}

            <li class="nav-item">
                <a href="{{ route('customer.gme-business-form.index') }}" class="nav-link text-white">
                    <i class="fa fa-users me-2"></i> My Business
                </a>
            </li>

            {{-- <li class="nav-item">
                <a href="{{ route('customer.gme-business-form.create') }}" class="nav-link text-white">
                    <i class="fa fa-plus-circle me-2"></i> Create
                </a>
            </li> --}}



            <li class="nav-item">
                <a href="{{ route('gme.business.register') }}" class="nav-link text-white">
                    <i class="fa fa-plus-circle me-2"></i> Create Form
                </a>
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

        {{-- <ul class="nav flex-column mt-3">

            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                    <i class="fa fa-home me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link text-white">
                    <i class="fa fa-users me-2"></i> Users
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('gme-business.index') }}" class="nav-link text-white">
                    <i class="fa fa-box me-2"></i> Index
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('gme-business.create') }}" class="nav-link text-white">
                    <i class="fa fa-shopping-basket me-2"></i> Create
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('gme-business-admin.index') }}" class="nav-link text-white">
                    <i class="fa fa-shopping-basket me-2"></i> Admin Index
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('gme-business-admin.create') }}" class="nav-link text-white">
                    <i class="fa fa-shopping-basket me-2"></i> Edit
                </a>
            </li>

            <li class="nav-item mt-3">
                <a href="#" class="nav-link text-danger"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </li>


        </ul> --}}
    </div>
</nav>
