@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Crises</h4>
        <a href="{{ route('crises.create') }}" class="btn btn-primary">
            + Add Crisis
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="crisisTable">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>City</th>
                    <th>Target</th>
                    <th width="160">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($crises as $crisis)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $crisis->title }}</td>
                        <td>{{ $crisis->category->name }}</td>
                        <td>{{ $crisis->city }}</td>
                        <td>{{ number_format($crisis->target_amount,2) }}</td>

                        <td>
                            <a href="{{ route('crises.edit',$crisis) }}"
                               class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('crises.destroy',$crisis) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete?')">
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
    $('#crisisTable').DataTable();
</script>
@endpush
