@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Business Categories</h4>
        <a href="{{ route('business-categories.create') }}"
           class="btn btn-primary">
            + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="categoriesTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('assets/' . $category->image) }}"
                                         alt="{{ $category->name }}"
                                         width="50"
                                         height="50"
                                         style="object-fit: cover; border-radius: 5px;">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $category->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('business-categories.edit', $category) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('business-categories.destroy', $category) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#categoriesTable').DataTable({
            pageLength: 10,
            lengthChange: true,
            searching: true,
            ordering: true,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 3 }
            ]
        });
    });
</script>
@endpush
