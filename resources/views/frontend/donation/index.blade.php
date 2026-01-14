@extends('layouts.guest-master')


@section('content')
<div class="container-fluid"  style="padding:5rem;">

    <div class="d-flex justify-content-center align-items-center mb-3">
        <div class="row justify-content-center">
<h4 class="fw-bold text-center">My Donations</h4>
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
            <table class="table table-bordered table-striped" id="donationsTable">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Crisis Name</th>
                        <th>City</th>
                        <th>Amount</th>
                        {{-- <th>Status</th> --}}
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

                            {{-- <td>
                                @if($donation->status === 'success')
                                    <span class="badge bg-success">Success</span>
                                @elseif($donation->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </td> --}}

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
