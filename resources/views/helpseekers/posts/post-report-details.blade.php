@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Post Donation Details</h4>
        <a href="{{ route('helpseekerposts.report.print', $post->id) }}" class="btn btn-outline-primary">
            Print PDF
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Helpseeker:</strong> {{ $post->helpseeker->name ?? 'N/A' }}</p>
            <p><strong>Post Title:</strong> {{ $post->title }}</p>
            <p><strong>Required Amount:</strong> {{ number_format($post->required_amount, 2) }} BDT</p>
            <p><strong>Total Collected:</strong> {{ number_format($totalAmount, 2) }} BDT</p>
        </div>
    </div>

    {{-- Donations Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Donor</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->created_at->format('d M Y') }}</td>
                            <td>{{ $donation->donor->name ?? 'N/A' }}</td>
                            <td>{{ number_format($donation->amount, 2) }} BDT</td>
                        </tr>
                    @endforeach

                    <tr class="total-row">
                        <td colspan="2" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">{{ number_format($totalAmount, 2) }} BDT</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
