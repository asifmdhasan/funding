@extends('layouts.guest-master')

@section('content')


<style>
    .featured-business{
        text-align: left;
    }
    @media (max-width: 768px) {
        .featured-business{
            text-align: center;
        }
    }
</style>


{{-- HERO SECTION --}}
{{-- <section class="hero-section text-center text-white islamic-bg"
    style="background:linear-gradient(135deg,#1E2A78,#283593); padding-top:10rem; padding-bottom:10rem;">
    <div class="container">
        <h1 class="fw-bold mb-3">Find a Muslim Entrepreneur Near You</h1>
        <p class="mb-4">Search by business name, keyword...</p>

        <div class="d-flex justify-content-center">
            

            <div class="input-group input-group-lg" style="max-width:600px">
                <input type="text" id="heroSearchInput" class="form-control"
                       placeholder="Search by business name, keyword...">
                <button class="btn btn-warning" id="heroSearchBtn">Search</button>
            </div>
        </div>
    </div>
</section> --}}


{{-- BROWSE BY CATEGORY --}}
{{-- <section class="py-5 bg-light">
    <div class="container text-center">
        <h4 class="fw-bold mb-4">Browse by Category</h4>

        <div class="row g-4 justify-content-center" id="categoryBrowse">
        </div>
    </div>
</section> --}}

<section class="py-5 bg-white">
    <div class="container">
        <h4 class="fw-bold mb-4 featured-business">Browse by Category</h4>
        <div class="row g-4 pt-4" id="categoryBrowse">
            {{-- Dynamically populated --}}
        </div>
    </div>
</section>



{{-- FEATURED BUSINESSES --}}
<section class="py-5">
    <div class="container">
        <h4 class="fw-bold mb-4 featured-business">Featured Businesses</h4>
        <div class="row" id="featuredGrid"></div>
    </div>
</section>

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
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    <nav>
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>
</div>




@endsection

