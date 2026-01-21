@extends('layouts.master')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Donor Details</h4>
        <a href="{{ route('reports.donor.print', $donor->id) }}"
           class="btn btn-outline-primary">
            Print PDF
        </a>
    </div>

    {{-- Donor Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Donor Name:</strong> {{ $donor->name }}</p>
            <p><strong>Total Donated:</strong> {{ number_format($totalAmount, 2) }} BDT</p>
        </div>
    </div>

    {{-- ================= CRISIS DONATIONS ================= --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold">
            Crisis Donations
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Crisis Title</th>
                        <th>Category</th>
                        <th>Amount (BDT)</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($crisisDonations as $row)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($row->last_donation_date)->format('d M Y') }}
                            </td>
                            <td>{{ $row->crisis->title ?? 'N/A' }}</td>
                            <td>{{ $row->crisis->category->name ?? 'N/A' }}</td>
                            <td>{{ number_format($row->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No crisis donations found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= HELPSEEKER POST DONATIONS ================= --}}
    <div class="card">
        <div class="card-header fw-semibold">
            Helpseeker Post Donations
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Post Title</th>
                        <th>Helpseeker Name</th>
                        <th>Amount (BDT)</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($helpseekerDonations as $row)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($row->last_donation_date)->format('d M Y') }}
                            </td>
                            <td>{{ $row->helpseekerPost->title ?? 'N/A' }}</td>
                            <td>{{ $row->helpseekerPost->helpseeker->name ?? 'N/A' }}</td>
                            <td>{{ number_format($row->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No helpseeker post donations found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
