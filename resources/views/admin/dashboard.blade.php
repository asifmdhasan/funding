@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        <!-- Total Customers Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Total Customers</h5>
                        <h2 class="card-text">{{ $totalCustomers }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-people-fill" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <small class="text-white-50">Verified and active customers</small>
                </div>
            </div>
        </div>

        <!-- Total Businesses Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Total Businesses</h5>
                        <h2 class="card-text">{{ $totalBusinesses }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-building" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <small class="text-white-50">All registered businesses</small>
                </div>
            </div>
        </div>

        <!-- Approved Businesses Card -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Approved Businesses</h5>
                        <h2 class="card-text">{{ $approvedBusinesses }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-check-circle-fill" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <small class="text-white-50">Approved and verified</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: Add charts or tables below -->
    {{-- <div class="row mt-4">
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Quick Stats / Reports</h5>
                </div>
                <div class="card-body">
                    <p>Here you can add charts, tables, or recent activities.</p>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
