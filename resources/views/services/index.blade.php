@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-12">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">
                <i class="fa fa-cogs me-2"></i> Services
            </h4>

            <a href="{{ route('services.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Add Service
            </a>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- DataTable --}}
        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-bordered table-hover align-middle" id="allDataTable">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Business Category</th>
                            <th>Service Name</th>
                            <th width="120">Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $service->businessCategory->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $service->name }}
                                </td>

                                <td>
                                    <span class="badge {{ $service->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $service->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('services.edit', $service) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="{{ route('services.destroy', $service) }}"
                                       class="btn btn-sm btn-danger"
                                       onclick="event.preventDefault(); prepareDelete(this)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>
</div>

{{-- Global Delete Form --}}
<form id="deleteForm" method="POST">
    @csrf
    @method('DELETE')
</form>

@endsection
