@extends('layouts.master')

@section('content')
{{-- <!DOCTYPE html>
<html lang="en"> --}}
<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GME Business Directory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> --}}
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

        @media (max-width: 768px) {
            .filter-sidebar {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
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
                            <option value="Finance">Finance</option>
                            <option value="Technology">Technology</option>
                            <option value="Food & Beverage">Food & Beverage</option>
                            <option value="Consulting">Consulting</option>
                            <option value="Design & Media">Design & Media</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="Education">Education</option>
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div class="filter-section">
                        <div class="filter-label">Location</div>
                        <input type="text" class="form-control" id="locationFilter" placeholder="Country, City">
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
                            <input type="radio" name="status" id="statusCompliant" value="faith-compliant">
                            <label for="statusCompliant">Faith-Compliant</label>
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
                        Showing <strong id="showingCount">1-6</strong> of <strong id="totalCount">24</strong> businesses
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
                    <!-- Business Card 1 -->
                    <div class="col-md-6 col-lg-4 business-item" data-category="Finance" data-location="Dubai, UAE" data-status="approved" data-name="Fintech Global">
                        <div class="business-card">
                            <div style="position: relative;">
                                <img src="https://images.unsplash.com/photo-1560472355-536de3962603?w=500&h=300&fit=crop" alt="Business" class="business-image">
                                <div class="verified-badge">
                                    <i class="fas fa-check-circle verified-icon"></i>
                                    GME Verified
                                </div>
                            </div>
                            <div class="business-content">
                                <div class="business-header">
                                    <img src="https://ui-avatars.com/api/?name=FG&background=D4AF37&color=fff&size=50" alt="Logo" class="business-logo">
                                    <div class="business-info">
                                        <div class="business-name">Fintech Global</div>
                                        <div class="business-category">Finance</div>
                                    </div>
                                </div>
                                <div class="business-tagline">
                                    Ethical financial solutions for a global market.
                                </div>
                                <div class="business-location">
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    Dubai, UAE
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Card 2 -->
                    <div class="col-md-6 col-lg-4 business-item" data-category="Technology" data-location="Kuala Lumpur, Malaysia" data-status="approved" data-name="Innovate Tech">
                        <div class="business-card">
                            <div style="position: relative;">
                                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=500&h=300&fit=crop" alt="Business" class="business-image">
                            </div>
                            <div class="business-content">
                                <div class="business-header">
                                    <img src="https://ui-avatars.com/api/?name=IT&background=2C3E50&color=fff&size=50" alt="Logo" class="business-logo">
                                    <div class="business-info">
                                        <div class="business-name">Innovate Tech</div>
                                        <div class="business-category">Technology</div>
                                    </div>
                                </div>
                                <div class="business-tagline">
                                    Cutting-edge software development and IT consulting.
                                </div>
                                <div class="business-location">
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    Kuala Lumpur, Malaysia
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Card 3 -->
                    <div class="col-md-6 col-lg-4 business-item" data-category="Food & Beverage" data-location="London, UK" data-status="approved" data-name="Nur Halal Foods">
                        <div class="business-card">
                            <div style="position: relative;">
                                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&h=300&fit=crop" alt="Business" class="business-image">
                                <div class="verified-badge">
                                    <i class="fas fa-check-circle verified-icon"></i>
                                    GME Verified
                                </div>
                            </div>
                            <div class="business-content">
                                <div class="business-header">
                                    <img src="https://ui-avatars.com/api/?name=NH&background=27AE60&color=fff&size=50" alt="Logo" class="business-logo">
                                    <div class="business-info">
                                        <div class="business-name">Nur Halal Foods</div>
                                        <div class="business-category">Food & Beverage</div>
                                    </div>
                                </div>
                                <div class="business-tagline">
                                    Premium quality halal and organic products.
                                </div>
                                <div class="business-location">
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    London, UK
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Card 4 -->
                    <div class="col-md-6 col-lg-4 business-item" data-category="Consulting" data-location="Toronto, Canada" data-status="pending" data-name="Barakah Consultants">
                        <div class="business-card">
                            <div style="position: relative;">
                                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=500&h=300&fit=crop" alt="Business" class="business-image">
                            </div>
                            <div class="business-content">
                                <div class="business-header">
                                    <img src="https://ui-avatars.com/api/?name=BC&background=3498DB&color=fff&size=50" alt="Logo" class="business-logo">
                                    <div class="business-info">
                                        <div class="business-name">Barakah Consultants</div>
                                        <div class="business-category">Consulting</div>
                                    </div>
                                </div>
                                <div class="business-tagline">
                                    Strategic business consulting with an ethical focus.
                                </div>
                                <div class="business-location">
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    Toronto, Canada
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Card 5 -->
                    <div class="col-md-6 col-lg-4 business-item" data-category="Design & Media" data-location="Sydney, Australia" data-status="approved" data-name="Ihsan Creatives">
                        <div class="business-card">
                            <div style="position: relative;">
                                <img src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=500&h=300&fit=crop" alt="Business" class="business-image">
                                <div class="verified-badge">
                                    <i class="fas fa-check-circle verified-icon"></i>
                                    GME Verified
                                </div>
                            </div>
                            <div class="business-content">
                                <div class="business-header">
                                    <img src="https://ui-avatars.com/api/?name=IC&background=E67E22&color=fff&size=50" alt="Logo" class="business-logo">
                                    <div class="business-info">
                                        <div class="business-name">Ihsan Creatives</div>
                                        <div class="business-category">Design & Media</div>
                                    </div>
                                </div>
                                <div class="business-tagline">
                                    Branding and marketing for purpose-driven businesses.
                                </div>
                                <div class="business-location">
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    Sydney, Australia
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Card 6 -->
                    <div class="col-md-6 col-lg-4 business-item" data-category="Fashion" data-location="Istanbul, Turkey" data-status="approved" data-name="Modest Wear Co.">
                        <div class="business-card">
                            <div style="position: relative;">
                                <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=500&h=300&fit=crop" alt="Business" class="business-image">
                            </div>
                            <div class="business-content">
                                <div class="business-header">
                                    <img src="https://ui-avatars.com/api/?name=MW&background=8E44AD&color=fff&size=50" alt="Logo" class="business-logo">
                                    <div class="business-info">
                                        <div class="business-name">Modest Wear Co.</div>
                                        <div class="business-category">Fashion</div>
                                    </div>
                                </div>
                                <div class="business-tagline">
                                    Elegant and modern modest fashion for all occasions.
                                </div>
                                <div class="business-location">
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    Istanbul, Turkey
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- @endsection
@section('scripts') --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#categoryFilter').select2({
                theme: 'bootstrap-5',
                placeholder: 'All Categories',
                allowClear: true
            });

            // Filter and Sort Functions
            function filterBusinesses() {
                const searchText = $('#searchInput').val().toLowerCase();
                const category = $('#categoryFilter').val();
                const location = $('#locationFilter').val().toLowerCase();
                const status = $('input[name="status"]:checked').val();

                let visibleCount = 0;

                $('.business-item').each(function() {
                    const $item = $(this);
                    const itemName = $item.data('name').toLowerCase();
                    const itemCategory = $item.data('category');
                    const itemLocation = $item.data('location').toLowerCase();
                    const itemStatus = $item.data('status');

                    let show = true;

                    // Search filter
                    if (searchText && !itemName.includes(searchText)) {
                        show = false;
                    }

                    // Category filter
                    if (category && itemCategory !== category) {
                        show = false;
                    }

                    // Location filter
                    if (location && !itemLocation.includes(location)) {
                        show = false;
                    }

                    // Status filter
                    if (status && itemStatus !== status) {
                        show = false;
                    }

                    if (show) {
                        $item.show();
                        visibleCount++;
                    } else {
                        $item.hide();
                    }
                });

                updateResultsCount(visibleCount);
            }

            function sortBusinesses() {
                const sortBy = $('#sortBy').val();
                const $grid = $('#businessGrid');
                const $items = $('.business-item').detach();

                let sorted = $items.toArray();

                switch(sortBy) {
                    case 'newest':
                        sorted.reverse();
                        break;
                    case 'asc':
                        sorted.sort((a, b) => {
                            return $(a).data('name').localeCompare($(b).data('name'));
                        });
                        break;
                    case 'desc':
                        sorted.sort((a, b) => {
                            return $(b).data('name').localeCompare($(a).data('name'));
                        });
                        break;
                }

                $grid.append(sorted);
            }

            function updateResultsCount(count) {
                const total = $('.business-item').length;
                $('#showingCount').text(`1-${count}`);
                $('#totalCount').text(total);
            }

            // Event Listeners
            $('#applyFilters').on('click', function() {
                filterBusinesses();
            });

            $('#resetFilters').on('click', function() {
                $('#searchInput').val('');
                $('#categoryFilter').val('').trigger('change');
                $('#locationFilter').val('');
                $('#statusAll').prop('checked', true);
                $('.business-item').show();
                updateResultsCount($('.business-item').length);
            });

            $('#sortBy').on('change', function() {
                sortBusinesses();
            });

            // Real-time search
            $('#searchInput').on('keyup', function() {
                filterBusinesses();
            });

            // Initial count
            updateResultsCount($('.business-item').length);
        });
    </script>
    @endsection

