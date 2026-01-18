<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Crowed Funding System</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/tooltips.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/choices.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/site.css') }}" rel="stylesheet" />




    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    :root {
        --primary-color: #D4AF37;
        --secondary-color: #2C3E50;
        --success-color: #27AE60;
        --text-muted: #7F8C8D;
         --primary-navy: #191970;
        --primary-gold: #FFD700;
        --dark-navy: #1f1f7a;
        --light-bg: #F8F8F8;
        --card-bg: #ffffff;
        --text-primary: #333333;
        --text-muted: #666666;
    }

    /* body {
        background-color: #F8F9FA;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    } */
    body {
        font-family: 'Exo 2', 'Segoe UI', sans-serif;
        background-color: var(--light-bg);
        color: var(--text-primary);
    }

        /* Category Cards */
    .category-card {
        background: white;
        border-radius: 12px;
        padding: 2rem 1rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
        border: 2px solid var(--primary-color);

    }

    .category-card:hover {
        background: var(--primary-color);
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        color: #fff;
    }

    .category-card .material-symbols-outlined {
        font-size: 3rem;
        color: var(--primary-color);
        transition: color 0.3s;
    }

    .category-card:hover .material-symbols-outlined {
        color: var(--primary-navy);
    }

    .category-card p {
        margin-top: 1rem;
        font-weight: 700;
        color: var(--text-primary);
        transition: color 0.3s;
    }

    .category-card:hover p {
        color: var(--primary-navy);
    }

        /* Islamic Pattern Background */
    .islamic-bg {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFD700' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h16v9h1v-9h9v9h1v-9h9v9h1v-9h9v9h1v-9h9v9h1v-9h9v9h1v-9h9v9h1v-9h9v9h1v-9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm-90-10v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm-90-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm-90-10v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm-90-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm-90-10v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm-90-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm-90-10v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9zm10 0v-9h-9v9h9z'/%3E%3Cpath d='M6 5V0h1v5h94V0h1v5h-1v90h1v5H95v-5H6v5H5v-5H0V5h5V0h1v5h94V0h1v5z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        padding-top:10rem; 
        padding-bottom:10rem;
    }
    .btn-login {
        
        background: var(--primary-color);
        color: var(--primary-navy);
        font-weight: 700;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        transition: transform 0.2s;
    }

    .btn-login:hover {
        transform: scale(1.05);
        background: var(--primary-color);
    }

    .filter-sidebar {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 20px;
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
        font-size: 20px;
        font-weight: 600;
        color: var(--secondary-color);
    }

    .filter-icon {
        color: var(--primary-color);
    }

    .search-box {
        margin-bottom: 25px;
    }

    .search-box input {
        border-radius: 8px;
        border: 1px solid #DDD;
        padding: 12px 15px;
        font-size: 14px;
    }

    .search-box input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.15);
    }

    .filter-section {
        margin-bottom: 25px;
    }

    .filter-label {
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 10px;
        font-size: 14px;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 8px;
        border-color: #DDD;
    }

    .radio-option {
        display: flex;
        align-items: center;
        padding: 10px;
        margin-bottom: 8px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .radio-option:hover {
        background: #F8F9FA;
    }

    .radio-option input[type="radio"] {
        margin-right: 10px;
        cursor: pointer;
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
    }

    .radio-option label {
        cursor: pointer;
        margin: 0;
        flex: 1;
        font-size: 14px;
    }

    .btn-apply-filter {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px;
        width: 100%;
        font-weight: 600;
        margin-bottom: 10px;
        transition: all 0.3s;
    }

    .btn-apply-filter:hover {
        background: #C4A037;
        transform: translateY(-1px);
    }

    .btn-reset {
        background: white;
        color: var(--secondary-color);
        border: 1px solid #DDD;
        border-radius: 8px;
        padding: 12px;
        width: 100%;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-reset:hover {
        background: #F8F9FA;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .results-count {
        color: var(--text-muted);
        font-size: 15px;
    }

    .sort-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sort-label {
        font-weight: 500;
        color: var(--secondary-color);
        font-size: 14px;
    }

    .sort-dropdown {
        border-radius: 8px;
        border: 1px solid #DDD;
        padding: 8px 35px 8px 12px;
        font-size: 14px;
        background: white;
        cursor: pointer;
    }

    .sort-dropdown:focus {
        border-color: var(--primary-color);
        outline: none;
    }

    .business-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s;
        margin-bottom: 25px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .business-card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        transform: translateY(-3px);
    }

    .business-image {
        width: 15rem;
        height: auto;
        object-fit: cover;
        display: block;
        margin: 0 auto;
    }


    .verified-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: white;
        padding: 6px 12px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        color: var(--success-color);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .verified-icon {
        color: var(--success-color);
    }

    .business-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .business-header {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }

    .business-logo {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #EEE;
    }

    .business-info {
        flex: 1;
    }

    .business-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 3px;
    }

    .business-category {
        color: var(--text-muted);
        font-size: 13px;
    }

    .business-tagline {
        color: #555;
        font-size: 14px;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .business-location {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-muted);
        font-size: 13px;
        margin-top: auto;
    }

    .location-icon {
        color: var(--primary-color);
    }
    #businessGrid .col-md-6{
        padding-top: 1.5rem;
    }


    /* Footer */
    .footer {
        background: var(--primary-navy);
        color: white;
        padding: 4rem 0 2rem;
    }

    .footer h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .footer a {
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer a:hover {
        color: var(--primary-gold);
    }

    .footer-cta {
        background: var(--dark-navy);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 3rem;
    }
    .grow-business{
        text-align: left;
    }

    .hero-search-item {
        display: flex;
        gap: 12px;
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .hero-search-item:hover {
        background: #f8f9fa;
    }

    .hero-search-img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .hero-search-title {
        font-weight: 600;
        font-size: 14px;
        color: #191970;
    }

    .hero-search-category {
        font-size: 12px;
        color: #777;
    }
    .logo-box {
        width: 60px;
        height: 60px;
        background: white;
        padding: 0.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .logo-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .page-link {
        color: #000;
    }

    .active>.page-link, .page-link.active {
        z-index: 3;
        color: var(--bs-pagination-active-color);
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .category-image{
        width: 10rem;

        object-fit: cover;
        display: block;
        margin: 0 auto 10px auto;
    }
    .category-image img{
        width: 100%;
        height: 100%;
    }
    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2rem;
        }
        .filter-sidebar {
            position: relative;
            top: 0;
            margin-bottom: 2rem;
        }
    }
    @media (max-width: 768px) {
        .filter-sidebar {
            margin-bottom: 30px;
        }
    }
    @media (max-width: 768px) {
    .hero-section {
        padding-top: 4rem;
        padding-bottom: 4rem;
    }
    .hero-section h1 {
        font-size: 1.5rem;
    }
    .hero-section p {
        font-size: 0.875rem;
    }
    .position-relative.w-100 {
        max-width: 100% !important;
        padding: 0 0.5rem;
    }
    #heroSearchResults {
        max-height: 200px;
    }

    #businessGrid {
        grid-template-columns: 1fr;
    }

    .business-card {
        flex-direction: column;
    }

    .business-header {
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }

    .business-content {
        padding: 15px;
    }

    .business-name {
        font-size: 16px;
    }

    .business-category,
    .business-location {
        font-size: 12px;
    }

    .logo-box {
        width: 50px;
        height: 50px;
    }
    #categoryBrowse {
        grid-template-columns: repeat(2, 1fr);
    }
    .filter-sidebar {
        position: relative;
        top: 0;
        margin-bottom: 2rem;
    }
    .input-group-lg>.btn, .input-group-lg>.form-control, .input-group-lg>.form-select, .input-group-lg>.input-group-text {
        padding: .5rem 0.5rem;
        font-size: 1rem;
        border-radius: var(--bs-border-radius-lg);
    }
    .category-image {
        width: 100%;
    }
    .results-count{
        display: none;
    }
    .grow-business{
        text-align: center;
    }
    .islamic-bg {
        padding-top:7rem; 
        padding-bottom:7rem;
    }
    .footer.islamic-bg {
        padding-top:0rem; 
        padding-bottom:1.5rem;
    }
}

.join-network:hover {
    color: #fff;
}
</style>
</head>

<body class="bg-light">
    @include('layouts.guest-navbar')
    <!-- Main Content -->
    <main class="main-content" style="">
        
        <div class="container-fluid py-0 px-0">


            @yield('content')


        </div>
    </main>

    <!-- Core JS -->

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Choices.js -->
    <script src="{{ asset('assets/js/choices.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>

    <!-- Flatpickr -->
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>

    <!-- Custom -->
    <script src="{{ asset('assets/js/dropdown.js') }}"></script>
    <script src="{{ asset('assets/js/modal.js') }}"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script src="{{ asset('assets/js/accordion.js') }}"></script>

    <!-- Global Select2 -->
    <script>
        $(document).ready(function() {
            $('.search_select').select2();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {

        let allBusinesses = [];
        let filteredBusinesses = [];

        let currentPage = 1;
        const perPage = 6;

        /* =========================
        Select2 Init
        ========================== */
        $('#categoryFilter').select2({
            theme: 'bootstrap-5',
            placeholder: 'All Categories',
            allowClear: true
        });

        $('#locationFilter').select2({
            theme: 'bootstrap-5',
            placeholder: 'Select Location(s)',
            allowClear: true
        });

        /* =========================
        Fetch Businesses
        ========================== */
        function fetchBusinesses() {
            $.ajax({
                url: '{{ route("guest.gme-business.ajax") }}',
                method: 'GET',
                success: function (response) {
                    console.log(response);
                        allBusinesses = response.businesses;

                    // ✅ Parse countries_of_operation JSON
                    // allBusinesses = response.businesses.map(business => {
                    //     try {
                    //         business.countries_of_operation = Array.isArray(business.countries_of_operation)
                    //             ? business.countries_of_operation
                    //             : JSON.parse(business.countries_of_operation || '[]');
                    //     } catch(e) {
                    //         business.countries_of_operation = [];
                    //     }
                    //     return business;
                    // });

                    filteredBusinesses = [...allBusinesses];
                    renderFeatured(response.featured);

                    renderBusinesses();
                }
            });
        }

        /* =========================
        Fetch Categories
        ========================== */
        function fetchCategories() {
            $.ajax({
                url: '{{ route("guest.get-category.ajax") }}',
                method: 'GET',
                success: function (response) {
                        renderBrowseCategories(response.categories);

                        const $category = $('#categoryFilter').empty()
                        .append('<option value="">All Categories</option>');

                        response.categories.forEach(cat => {
                            $category.append(new Option(cat.name, cat.id));
                        });
                    // const $category = $('#categoryFilter').empty()
                    //     .append('<option value="">All Categories</option>');

                    // response.categories.forEach(cat => {
                    //     $category.append(new Option(cat.name, cat.id));
                    // });

                    // $category.trigger('change');
                }
            });
        }

        /* =========================
        Fetch Locations
        ========================== */
        function fetchLocations() {
            $.ajax({
                url: '{{ route("guest.get-locations.ajax") }}',
                method: 'GET',
                success: function (response) {
                    const $location = $('#locationFilter').empty();

                    response.locations.forEach(country => {
                        $location.append(new Option(country, country));
                    });

                    $location.trigger('change');
                }
            });
        }

        /* =========================
        Filter Businesses
        ========================== */
        function filterBusinesses() {

            const searchText = $('#searchInput').val().toLowerCase();
            const selectedCategory = $('#categoryFilter').val();
            const selectedLocations = $('#locationFilter').val() || [];
            const status = $('input[name="status"]:checked').val();

            filteredBusinesses = allBusinesses.filter(business => {

                // Search
                if (searchText) {
                    const text = [
                        business.business_name,
                        business.short_introduction,
                        business.category?.name
                    ].join(' ').toLowerCase();

                    if (!text.includes(searchText)) return false;
                }

                // Category
                if (selectedCategory && business.business_category_id != selectedCategory) {
                    return false;
                }

                // ✅ Location Filter (handle JSON array)
                if (selectedLocations.length > 0) {
                    const countries = business.countries_of_operation || [];
                    const match = selectedLocations.some(loc => countries.includes(loc));
                    if (!match) return false;
                }

                // Status
                if (status && business.status !== status) {
                    return false;
                }

                return true;
            });

            renderBusinesses();
        }

        /* =========================
        Sort
        ========================== */
        function sortBusinesses() {
            const sortBy = $('#sortBy').val();

            if (sortBy === 'newest') {
                filteredBusinesses.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            } else if (sortBy === 'asc') {
                filteredBusinesses.sort((a, b) => a.business_name.localeCompare(b.business_name));
            } else if (sortBy === 'desc') {
                filteredBusinesses.sort((a, b) => b.business_name.localeCompare(a.business_name));
            }

            renderBusinesses();
        }

        /* =========================
        Render Cards
        ========================== */
        // function renderBusinesses() {

        //     const $grid = $('#businessGrid').empty();

        //     if (!filteredBusinesses.length) {
        //         $grid.html(`
        //             <div class="col-12 no-results">
        //                 <i class="fas fa-search"></i>
        //                 <p>No businesses found.</p>
        //             </div>
        //         `);
        //         updateResultsCount(0);
        //         return;
        //     }

        //     filteredBusinesses.forEach(business => {
        //         $grid.append(createBusinessCard(business));
        //     });

        //     updateResultsCount(filteredBusinesses.length);
        // }

        function renderBusinesses() {

            const $grid = $('#businessGrid').empty();

            if (!filteredBusinesses.length) {
                $grid.html(`
                    <div class="col-12 no-results">
                        <i class="fas fa-search"></i>
                        <p>No businesses found.</p>
                    </div>
                `);
                updateResultsCount(0);
                $('#pagination').empty();
                return;
            }

            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const pageItems = filteredBusinesses.slice(start, end);

            pageItems.forEach(business => {
                $grid.append(createBusinessCard(business));
            });

            updateResultsCount(filteredBusinesses.length);
            renderPagination();
        }

        function renderPagination() {

            const totalPages = Math.ceil(filteredBusinesses.length / perPage);
            const $pagination = $('#pagination').empty();

            if (totalPages <= 1) return;

            // Prev
            $pagination.append(`
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                $pagination.append(`
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next
            $pagination.append(`
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                </li>
            `);
        }



        /* =========================
        Card HTML
        ========================== */
        function createBusinessCard(business) {

            const capitalizeFirstLetter = (str) => str ? str.charAt(0).toUpperCase() + str.slice(1) : '';

            const category = business.category?.name ?? '';
            // const logo = `{{ asset('assets') }}/${business.logo}`;
                const logo = business.logo
                ? `{{ asset('assets') }}/${business.logo}`
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(business.business_name)}`;

            const photo = business.photos?.length
                ? `{{ asset('assets') }}/${business.photos[0]}`
                : 'http://gme.network/wp-content/uploads/2025/08/GME-Logo-1-01.webp?w=500&h=300&fit=crop';

            const verified = business.status === 'approved'
                ? `<div class="verified-badge">
                        <i class="fas fa-check-circle"></i> GME Verified
                </div>`
                : '';


            const countries = business.countries_of_operation && business.countries_of_operation.length > 0
                ? business.countries_of_operation.join(', ')
                : 'Location not specified';

            return `
            <div class="col-md-4 col-lg-4 p-2">
                <div class="business-card" onclick="location.href='{{ url('guest-gme-business-form') }}/${business.id}'">
                    <div style="position:relative">
                        <img src="${photo}" class="business-image">
                        ${verified}
                    </div>
                    <div class="business-content">
                        <div class="business-header">
                            

                            <div class="logo-box">
                                <img src="${logo}" alt="${business.business_name}">
                            </div>


                            <div>
                                <div class="business-name">${business.business_name} - (${capitalizeFirstLetter(business.status)})</div>
                                <div class="business-category">${category}</div>
                            </div>
                        </div>
                        ${business.short_introduction ?? ''}
                        <div class="business-location">
                            <i class="fas fa-map-marker-alt location-icon"></i>
                            <div>${countries}</div>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        function renderBrowseCategories(categories) {
            const $wrap = $('#categoryBrowse').empty();

            categories.slice(0, 5).forEach(cat => {

                const image = cat.image
                    ? `{{ asset('assets') }}/${cat.image}`
                    : `https://ui-avatars.com/api/?name=${encodeURIComponent(cat.name)}&background=1E2A78&color=ffffff`;

                    console.log(cat);

                $wrap.append(`
                    <div class="col-6 col-md-3">
                        <div class="card p-3 shadow-sm category-card text-center"
                            style="cursor:pointer"
                            onclick="filterByCategory(${cat.id})">

                            <div class="category-image mb-2">
                                <img src="${image}" alt="${cat.name}">
                            </div>

                            <div class="fw-semibold">${cat.name}</div>
                        </div>
                    </div>
                `);
            });
        }

        // function renderBrowseCategories(categories) {
        //     const $wrap = $('#categoryBrowse').empty();

        //     categories.slice(0,5).forEach(cat => {
        //         $wrap.append(`
        //             <div class="col-6 col-md-2">
        //                 <div class="card p-3 shadow-sm category-card"
        //                     style="cursor:pointer"
        //                     onclick="filterByCategory(${cat.id})">
        //                     <div class="fw-semibold">${cat.name}</div>
        //                 </div>
        //             </div>
        //         `);
        //     });
        // }



        function filterByCategory(id) {
            $('#categoryFilter').val(id).trigger('change');
            $('html,body').animate({
                scrollTop: $('#businessGrid').offset().top - 100
            }, 400);
        }

        // function renderFeatured(businesses) {
        //     const $grid = $('#featuredGrid').empty();

        //     businesses.forEach(business => {
        //         $grid.append(createBusinessCard(business));
        //     });
        // }
        function renderFeatured(businesses) {
            console.log(businesses);
            const $grid = $('#featuredGrid').empty();

            if (!Array.isArray(businesses) || !businesses.length) {
                $grid.html(`
                    <div class="col-12 text-muted">
                        No featured businesses available.
                    </div>
                `);
                return;
            }

            businesses.forEach(business => {
                $grid.append(createBusinessCard(business));
            });
        }


        $('#heroSearchInput').on('keyup', function () {

            const query = $(this).val().toLowerCase().trim();
            const $results = $('#heroSearchResults').empty();

            if (!query || query.length < 2) {
                $results.addClass('d-none');
                return;
            }

            const matches = allBusinesses
                .filter(business => {
                    return (
                        business.business_name?.toLowerCase().includes(query) ||
                        business.short_introduction?.toLowerCase().includes(query)
                    );
                })
                .slice(0, 3);

            if (!matches.length) {
                $results
                    .removeClass('d-none')
                    .html(`<div class="p-3 text-muted">No results found</div>`);
                return;
            }

            matches.forEach(business => {

                const image = business.photos?.length
                    ? `{{ asset('assets') }}/${business.photos[0]}`
                    : 'http://gme.network/wp-content/uploads/2025/08/GME-Logo-1-01.webp';

                $results.append(`
                    <div class="hero-search-item"
                        onclick="location.href='{{ url('guest-gme-business-form') }}/${business.id}'">
                        <img src="${image}" class="hero-search-img">
                        <div>
                            <div class="hero-search-title">
                                ${business.business_name}
                            </div>
                            <div class="hero-search-category">
                                ${business.category?.name ?? ''}
                            </div>
                        </div>
                    </div>
                `);
            });

            $results.removeClass('d-none');
        });

        /* =========================
        Count
        ========================== */
        function updateResultsCount(count) {
            $('#showingCount').text(count);
            $('#totalCount').text(allBusinesses.length);
        }

        /* =========================
        Events
        ========================== */

        $(document).on('click', '#pagination a', function (e) {
            e.preventDefault();

            const page = $(this).data('page');
            const totalPages = Math.ceil(filteredBusinesses.length / perPage);

            if (page < 1 || page > totalPages) return;

            currentPage = page;
            renderBusinesses();

            $('html,body').animate({
                scrollTop: $('#businessGrid').offset().top - 100
            }, 300);
        });


        $('#applyFilters').on('click', filterBusinesses);
        $('#searchInput').on('keyup', filterBusinesses);
        $('#sortBy').on('change', sortBusinesses);
        $('#categoryFilter, #locationFilter').on('change', filterBusinesses);

        $('#resetFilters').on('click', function () {
            $('#searchInput').val('');
            $('#categoryFilter').val('').trigger('change');
            $('#locationFilter').val(null).trigger('change');
            $('#statusAll').prop('checked', true);
            filteredBusinesses = [...allBusinesses];
            renderBusinesses();
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('#heroSearchInput, #heroSearchResults').length) {
                $('#heroSearchResults').addClass('d-none');
            }
        });


        $('#heroSearchBtn').on('click', function () {
            $('#searchInput').val($('#heroSearchInput').val());
            filterBusinesses();
        });


        
        /* =========================
        Init
        ========================== */
        fetchBusinesses();
        fetchCategories();
        fetchLocations();

    });
</script>

    
    <!-- DataTable Language -->
    <script>
        window.dataTableLanguage = {
            sProcessing: "{{ __('layouts.sProcessing') }}",
            sLengthMenu: "{{ __('layouts.sLengthMenu') }}",
            sZeroRecords: "{{ __('layouts.sZeroRecords') }}",
            sInfo: "{{ __('layouts.sInfo') }}",
            sInfoEmpty: "{{ __('layouts.sInfoEmpty') }}",
            sInfoFiltered: "{{ __('layouts.sInfoFiltered') }}",
            sSearch: "{{ __('layouts.sSearch') }}",
            oPaginate: {
                sFirst: "{{ __('layouts.sFirst') }}",
                sPrevious: "{{ __('layouts.sPrevious') }}",
                sNext: "{{ __('layouts.sNext') }}",
                sLast: "{{ __('layouts.sLast') }}"
            }
        };

        $(document).ready(function() {
            $('#allDataTable').DataTable({
                "language": window.dataTableLanguage
            });
        });
    </script>

    <!-- Delete Confirmation -->
    <script>
        function confirmDelete() {
            Swal.fire({
                title: "{{ __('layouts.delete_confirm') }}",
                text: "{{ __('layouts.not_revert') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: "{{ __('layouts.delete_confirm') }}",
                cancelButtonText: "{{ __('layouts.cancel_btn') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }

        function prepareDelete(el) {
            const url = el.getAttribute('href');
            document.getElementById('deleteForm').setAttribute('action', url);
            confirmDelete();
        }
    </script>

    {{-- @stack('scripts') --}}

</body>
</html>
