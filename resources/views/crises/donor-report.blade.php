@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <h4 class="fw-bold mb-3">Donor Donation Report</h4>

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body row g-3 align-items-end">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Filter by Donor</label>
                <form method="GET">
                    <select name="donor_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Donors</option>
                        @foreach($donorList as $donor)
                            <option value="{{ $donor->id }}"
                                {{ request('donor_id') == $donor->id ? 'selected' : '' }}>
                                {{ $donor->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="col-md-6">
                <a href="{{ route('crises.donor.report') }}"
                   class="btn btn-outline-secondary w-100">
                    Reset Filter
                </a>
            </div>

        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Donor</th>
                        <th>Total Donated</th>
                        <th width="120">Details</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($donors as $row)
                        <tr>
                            <td>{{ $row->donor->name }}</td>
                            <td> {{ number_format($row->total_amount, 2) }} BDT</td>
                            <td>
                                <a href="{{ route('crises.donor.report.details', $row->donor_id) }}"
                                   class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                No data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $donors->links() }}

        </div>
    </div>

</div>
@endsection
