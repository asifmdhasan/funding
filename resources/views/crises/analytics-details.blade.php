@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Crisis Details</h4>
        <a href="{{ route('reports.crisis.print', $crisis->id) }}" class="btn btn-outline-primary" target="_blank">
            Print PDF
        </a>

    </div>

    {{-- Crisis Info --}}
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Crisis:</strong> {{ $crisis->title }}</p>
            <p><strong>Category:</strong> {{ $crisis->category->name ?? 'N/A' }}</p>
            <p><strong>Total Collected:</strong> ৳ {{ number_format($totalAmount, 2) }}</p>
        </div>
    </div>

    {{-- Donor Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Donor</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $row)
                        <tr>
                            <td>{{ $row->donor->name }}</td>
                            <td>৳ {{ number_format($row->total_amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->last_donation_date)->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                    {{-- Total Row --}}
                    <tr class="total-row">
                        <td colspan="1" style="text-align:right;font-weight:bold;">Total Amount</td>
                        <td style="font-weight:bold;">{{ number_format($totalAmount, 2) }} BDT</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
