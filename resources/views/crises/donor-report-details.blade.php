@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Donor Details</h4>
        <a href="{{ route('reports.donor.print', $donor->id) }}"
            class="btn btn-outline-primary">
            Print PDF
        </a>
    </div>

    {{-- Donor Info --}}
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Donor:</strong> {{ $donor->name }}</p>
            <p><strong>Total Donated:</strong> {{ number_format($totalAmount, 2) }} BDT</p>
        </div>
    </div>

    {{-- Crisis Breakdown --}}
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Crisis</th>
                        <th>Category</th>
                        <th>Amount</th>
                        
                </thead>

                <tbody>
                    @foreach($donations as $row)
                        <tr>
                            <td> {{ \Carbon\Carbon::parse($row->last_donation_date)->format('d M Y') }}</td>
                            <td>{{ $row->crisis->title }}</td>
                            <td>{{ $row->crisis->category->name ?? 'N/A' }}</td>
                            <td>{{ number_format($row->total_amount, 2) }} BDT</td>
                            
                        </tr>
                    @endforeach
                    {{-- Total Row --}}
                    <tr class="total-row">
                        <td colspan="3" style="text-align:right;font-weight:bold;">Total Amount</td>
                        <td style="font-weight:bold;">{{ number_format($totalAmount, 2) }} BDT</td> 
                        <td></td>
                    </tr>
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
