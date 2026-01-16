@extends('layouts.guest-master')


@section('content')
<div class="container-fluid"  style="padding:5rem;">
    <div>
            {{-- <h4 class="fw-bold">Donor Details</h4> --}}
            <div class="row justify-content-center">
                <h4 class="fw-bold text-center">My Donations</h4> 
            </div>

            <div class="text-center mb-3 mt-3">
                <a href="{{ route('donor.donations.print') }}" target="_blank"
                    class="btn btn-outline-primary">
                    Print Details
                </a>
            </div>
        
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {{-- <table class="table table-bordered table-striped" id="donationsTable">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Crisis Name</th>
                        <th>City</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $donation->crisis->title ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $donation->crisis->city ?? '-' }}
                            </td>

                            <td class="fw-bold">
                                ৳ {{ number_format($donation->amount, 2) }}
                            </td>
                            <td>
                                {{ $donation->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No donations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table> --}}
            <table class="table table-bordered table-striped" id="donationsTable">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Crisis Name</th>
                        <th>City</th>
                        <th>Amount</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        <tr>
                            <td>{{ $donation->created_at->format('d M Y') }}</td>
                            <td>{{ $donation->crisis->title ?? 'N/A' }}</td>
                            <td>{{ $donation->crisis->city ?? '-' }}</td>
                            <td>{{ number_format($donation->amount, 2) }} BDT</td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No donations found.</td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- Total Row --}}
                <tfoot>
                    <tr class="table-light fw-bold">
                        <td colspan="3" class="text-end">Total</td>
                        <td>
                            {{ number_format($donations->sum('amount'), 2) }} BDT
                        </td>
                    
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#donationsTable').DataTable({
            pageLength: 10,
            lengthChange: true,
            searching: true,
            ordering: true,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 4 }
            ]
        });
    });
</script>
@endpush
