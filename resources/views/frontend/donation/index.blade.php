@extends('layouts.guest-master')

@section('content')

<div class="container-fluid" style="padding:5rem;">

    {{-- Header --}}
    <div class="row justify-content-center mb-3">
        <h4 class="fw-bold text-center">My Donations</h4>
    </div>

    {{-- Buttons to switch type --}}
    <div class="text-center mb-4">
        <a href="{{ route('donor.donations', ['type' => 'crisis']) }}"
           class="btn {{ ($type ?? 'crisis') === 'crisis' ? 'btn-primary' : 'btn-outline-primary' }}">
            Crisis Lists
        </a>

        <a href="{{ route('donor.donations', ['type' => 'help']) }}"
           class="btn {{ ($type ?? '') === 'help' ? 'btn-primary' : 'btn-outline-primary' }}">
            Help Post Lists
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    {{-- Print Button --}}
    <div class="text-center mb-3" style="margin-top: 3rem;">
        @if(($type ?? 'crisis') === 'crisis')
            <a href="{{ route('donor.donations.print', ['type' => 'crisis']) }}" target="_blank"
               class="btn btn-outline-success">
                Print Crisis List
            </a>
        @else
            <a href="{{ route('donor.donations.print.help') }}" target="_blank"
               class="btn btn-outline-success">
                Print Help Post List
            </a>
        @endif
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr style="text-align:center;">
                        <th>Date</th>

                        @if(($type ?? 'crisis') === 'crisis')
                            <th>Crisis Name</th>
                            <th>City</th>
                        @else
                            <th>Help Post Title</th>
                            <th>Helpseeker Name</th>
                        @endif

                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($donations as $donation)
                        <tr style="text-align:center;">
                            <td>{{ $donation->created_at->format('d M Y') }}</td>

                            @if(($type ?? 'crisis') === 'crisis')
                                <td>{{ $donation->crisis->title ?? 'N/A' }}</td>
                                <td>{{ $donation->crisis->city ?? '-' }}</td>
                            @else
                                <td>{{ $donation->helpseekerPost->title ?? 'N/A' }}</td>
                                <td>{{ $donation->helpseekerPost->helpseeker->name ?? '-' }}</td>
                            @endif

                            <td>{{ number_format($donation->amount, 2) }} BDT</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No donations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- Total --}}
                <tfoot>
                    <tr class="table-light fw-bold">
                        <td colspan="3" class="text-end">Total</td>
                        <td>{{ number_format($donations->sum('amount'), 2) }} BDT</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
