@extends('layouts.frontend-master')

@section('content')



    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #D4AF37;
            --secondary-color: #2C3E50;
            --success-color: #27AE60;
            --text-muted: #7F8C8D;
        }

        body {
            background-color: #F8F9FA;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            width: 100%;
            height: 200px;
            object-fit: cover;
            position: relative;
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

        @media (max-width: 768px) {
            .filter-sidebar {
                margin-bottom: 30px;
            }
        }
    </style>


    <div class="container py-5">
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <div class="filter-header">
                        <i class="fas fa-filter filter-icon"></i>
                        Filter Businesses
                    </div>

                    <!-- Search Box -->
                    <div class="search-box">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search businesses...">
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-section">
                        <div class="filter-label">Category</div>
                        <select class="form-select" id="categoryFilter" style="width: 100%;">
                            <option value="">All Categories</option>
                        </select>

                        {{-- <select class="form-select" id="categoryFilter" style="width: 100%;">
                            <option value="">All Categories</option>
                        </select> --}}
                    </div>

                    <!-- Location Filter -->
                    <div class="filter-section">
                        <div class="filter-label">Location</div>
                        <select class="form-select" id="locationFilter" style="width: 100%;" multiple>
                        </select>
                    </div>

                    <!-- Verification Status -->
                    <div class="filter-section">
                        <div class="filter-label">Verification Status</div>
                        <div class="radio-option">
                            <input type="radio" name="status" id="statusAll" value="" checked>
                            <label for="statusAll">All Businesses</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" name="status" id="statusVerified" value="approved">
                            <label for="statusVerified">GME Verified</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" name="status" id="statusPending" value="pending">
                            <label for="statusPending">Pending</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" name="status" id="statusRejected" value="rejected">
                            <label for="statusRejected">Rejected</label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <button class="btn-apply-filter" id="applyFilters">Apply Filters</button>
                    <button class="btn-reset" id="resetFilters">Reset</button>
                </div>
            </div>

            <!-- Business Listings -->
            <div class="col-lg-9">
                <!-- Content Header -->
                <div class="content-header">
                    <div class="results-count">
                        Showing <strong id="showingCount">0</strong> of <strong id="totalCount">0</strong> businesses
                    </div>
                    <div class="sort-section">
                        <label class="sort-label">Sort by:</label>
                        <select class="sort-dropdown" id="sortBy">
                            <option value="relevant">Most Relevant</option>
                            <option value="newest">New Business</option>
                            <option value="asc">Sort by Ascending</option>
                            <option value="desc">Sort by Descending</option>
                        </select>
                    </div>
                </div>

                <!-- Business Cards Grid -->
                <div class="row" id="businessGrid">
                    <div class="col-12 loading-spinner">
                        <i class="fas fa-spinner fa-spin fa-3x"></i>
                        <p class="mt-3">Loading businesses...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    






<script>
$(document).ready(function () {

    let allBusinesses = [];
    let filteredBusinesses = [];

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
            url: '{{ route("customer.gme-business.ajax") }}',
            method: 'GET',
            success: function (response) {
                // ✅ Parse countries_of_operation JSON
                allBusinesses = response.businesses.map(business => {
                    try {
                        business.countries_of_operation = Array.isArray(business.countries_of_operation)
                            ? business.countries_of_operation
                            : JSON.parse(business.countries_of_operation || '[]');
                    } catch(e) {
                        business.countries_of_operation = [];
                    }
                    return business;
                });

                filteredBusinesses = [...allBusinesses];
                renderBusinesses();
            }
        });
    }

    /* =========================
       Fetch Categories
    ========================== */
    function fetchCategories() {
        $.ajax({
            url: '{{ route("customer.get-category.ajax") }}',
            method: 'GET',
            success: function (response) {
                const $category = $('#categoryFilter').empty()
                    .append('<option value="">All Categories</option>');

                response.categories.forEach(cat => {
                    $category.append(new Option(cat.name, cat.id));
                });

                $category.trigger('change');
            }
        });
    }

    /* =========================
       Fetch Locations
    ========================== */
    function fetchLocations() {
        $.ajax({
            url: '{{ route("customer.get-locations.ajax") }}',
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
            return;
        }

        filteredBusinesses.forEach(business => {
            $grid.append(createBusinessCard(business));
        });

        updateResultsCount(filteredBusinesses.length);
    }

    /* =========================
       Card HTML
    ========================== */
    function createBusinessCard(business) {

        const capitalizeFirstLetter = (str) => str ? str.charAt(0).toUpperCase() + str.slice(1) : '';

        const category = business.category?.name ?? '';
        const logo = `{{ asset('assets') }}/${business.logo}`;

        const photo = business.photos?.length
            ? `{{ asset('assets') }}/${business.photos[0]}`
            : 'http://gme.network/wp-content/uploads/2025/08/GME-Logo-1-01.webp?w=500&h=300&fit=crop';

        const verified = business.status === 'approved'
            ? `<div class="verified-badge">
                    <i class="fas fa-check-circle"></i> GME Verified
               </div>`
            : '';

        return `
        <div class="col-md-6 col-lg-4">
            <div class="business-card" onclick="location.href='{{ url('gme-business-form') }}/${business.id}'">
                <div style="position:relative">
                    <img src="${photo}" class="business-image">
                    ${verified}
                </div>
                <div class="business-content">
                    <div class="business-header">
                        <img src="${logo}" class="business-logo">
                        <div>
                            <div class="business-name">${business.business_name} - (${capitalizeFirstLetter(business.status)})</div>
                            <div class="business-category">${category}</div>
                        </div>
                    </div>
                    ${business.short_introduction ?? ''}
                </div>
            </div>
        </div>`;
    }

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

    /* =========================
       Init
    ========================== */
    fetchBusinesses();
    fetchCategories();
    fetchLocations();

});
</script>


@endsection

