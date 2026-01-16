@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <div class="mb-3">
        <h4 class="fw-bold">Crisis Donation Analytics</h4>
    </div>

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body row g-3 align-items-end">
            {{-- Donor Filter --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Filter by Donor</label>
                <select id="donorFilter" class="form-select">
                    <option value="">All Donors</option>
                    @foreach($donors as $donor)
                        <option value="{{ $donor->name }}">{{ $donor->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Crisis Filter --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Filter by Crisis</label>
                <select id="crisisFilter" class="form-select">
                    <option value="">All Crises</option>
                    @foreach($crises as $crisis)
                        <option value="{{ $crisis->title }}">{{ $crisis->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
            <div class="col-md-4">
                <button id="resetFilter" class="btn btn-outline-secondary w-100">
                    Reset Filters
                </button>
            </div>
        </div>
    </div>

    {{-- Analytics Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="analyticsTable">
                <thead class="table-light">
                    <tr>
                        <th>Crisis</th>
                        <th>Donor</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($crises as $crisis)
                    @foreach($crisis->donations as $donation)
                        <tr 
                            data-crisis="{{ $crisis->title }}" 
                            data-donor="{{ $donation->donor->name ?? '' }}">
                            <td>{{ $crisis->title }}</td>
                            <td>{{ $donation->donor->name ?? 'N/A' }}</td>
                            <td>৳ {{ number_format($donation->amount, 2) }}</td>
                            <td>{{ $donation->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <nav>
                <ul class="pagination" id="tablePagination"></ul>
            </nav>
        </div>
    </div>

</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    const rowsPerPage = 10; // Number of rows per page
    let currentPage = 1;

    function filterRows() {
        const selectedDonor  = $('#donorFilter').val();
        const selectedCrisis = $('#crisisFilter').val();

        $('#analyticsTable tbody tr').each(function() {
            const rowDonor  = $(this).data('donor');
            const rowCrisis = $(this).data('crisis');

            if (
                (selectedDonor === "" || selectedDonor === rowDonor) &&
                (selectedCrisis === "" || selectedCrisis === rowCrisis)
            ) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        currentPage = 1; // Reset to first page
        paginateTable();
    }

    function paginateTable() {
        const rows = $('#analyticsTable tbody tr:visible');
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        rows.hide();
        rows.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).show();

        // Build pagination
        const pagination = $('#tablePagination');
        pagination.empty();

        for (let i = 1; i <= totalPages; i++) {
            pagination.append(`<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#">${i}</a>
            </li>`);
        }

        // Page click
        $('.page-link').off().on('click', function(e) {
            e.preventDefault();
            currentPage = parseInt($(this).text());
            paginateTable();
        });
    }

    // On filter change
    $('#donorFilter, #crisisFilter').on('change', filterRows);

    // Reset button
    $('#resetFilter').on('click', function() {
        $('#donorFilter').val('');
        $('#crisisFilter').val('');
        $('#analyticsTable tbody tr').show();
        currentPage = 1;
        paginateTable();
    });

    // Initial pagination
    paginateTable();

});
</script>

@endsection
