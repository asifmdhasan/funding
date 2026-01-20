@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <h4 class="fw-bold mb-3">Crisis Donation Analytics</h4>

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body row g-3 align-items-end">

            {{-- Crisis Filter --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Filter by Crisis</label>
                <form method="GET">
                    <select name="crisis_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Crises</option>
                        @foreach($crisisList as $crisis)
                            <option value="{{ $crisis->id }}"
                                {{ request('crisis_id') == $crisis->id ? 'selected' : '' }}>
                                {{ $crisis->title }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            {{-- Reset --}}
            <div class="col-md-6">
                <a href="{{ route('crises.analytics') }}" class="btn btn-outline-secondary w-100">
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
                        <th>Crisis</th>
                        <th>Category</th>
                        <th>Total Amount</th>
                        <th width="120">Details</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($crises as $row)
                        <tr>
                            <td>{{ $row->crisis->title ?? '' }}</td>
                            <td>{{ $row->crisis->category->name ?? '' }}</td>
                            <td> {{ number_format($row->total_amount, 2) }} BDT</td>
                            <td>
                                @if($row->crisis_id)
                                    <a href="{{ route('crises.analytics.details', ['crisis' => $row->crisis_id]) }}"
                                    class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- {{ $crises->links() }} --}}

        </div>
    </div>

</div>
@endsection
