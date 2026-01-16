<!-- Centered Large Menu Bar -->
<div class="bg-white shadow-sm border-bottom">
    <div class="container text-center py-3">

        <!-- Brand -->
        <a href="{{ route('frontend.view') }}" class="d-inline-block mb-2 fw-bold text-dark fs-4 text-decoration-none">
            Crowd Funding
        </a>

        <!-- Menu Links -->
        <div class="d-flex justify-content-center flex-wrap gap-4 mt-2">

            <a href="{{ route('crisis.list') }}" class="text-dark fw-semibold fs-5 text-decoration-none px-3 py-2 rounded hover-bg">
                Crisis List
            </a>
            <!-- if login user then see my donations -->
            @auth('donor')
            <a href="{{ route('donor.donations') }}" class="text-dark fw-semibold fs-5 text-decoration-none px-3 py-2 rounded hover-bg">
                My Donations
            </a>
            @endauth

            {{-- <a href="{{ route('crises.index') }}" class="text-dark fw-semibold fs-5 text-decoration-none px-3 py-2 rounded hover-bg">
                Donate
            </a> --}}

            @guest('donor')
                <a href="{{ route('donor.login') }}" class="text-dark fw-semibold fs-5 text-decoration-none px-3 py-2 rounded hover-bg">
                    Login
                </a>
                <a href="{{ route('donor.register') }}" class="text-dark fw-semibold fs-5 text-decoration-none px-3 py-2 rounded hover-bg">
                    Register
                </a>
            @else
                <div class="dropdown d-inline-block" style="padding-top:0.5rem;">
                    <a href="#" class="text-dark fw-semibold fs-5 text-decoration-none px-3 py-2 rounded hover-bg" id="donorMenu" data-bs-toggle="dropdown">
                        {{ auth('donor')->user()->name }} <i class="fa fa-caret-down ms-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-center mt-2">
                        <li>
                            <a class="dropdown-item" href="{{ route('donor.profile') }}">
                                Profile
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('donor.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest

        </div>
    </div>
</div>

<!-- Optional CSS -->
<style>
    .hover-bg:hover {
        background-color: #f8f9fa;
    }

    .dropdown-menu-center {
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
</style>
