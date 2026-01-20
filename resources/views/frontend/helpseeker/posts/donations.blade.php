@extends('layouts.guest-master')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Donations for: {{ $post->title }}</h4>
        <div>
            <a href="{{ route('helpseeker.posts.donations.print', $post->id) }}" target="_blank" class="btn btn-outline-primary">
                Print
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Donor Name</th>
                        <th>Donor Email</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        <tr>
                            <td>{{ $donation->created_at->format('d M Y') }}</td>
                            <td>{{ $donation->donor->name ?? '-' }}</td>
                            <td>{{ $donation->donor->email ?? '-' }}</td>
                            <td>{{ number_format($donation->amount, 2) }} BDT</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No donations yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-light fw-bold">
                        <td colspan="3" class="text-end">Total Collected</td>
                        <td>{{ number_format($totalAmount, 2) }} BDT</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
