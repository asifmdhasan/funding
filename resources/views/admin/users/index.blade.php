@extends('layouts.master')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">Admins</h4>
        <a href="{{ route('user.create') }}" class="btn btn-primary">
            Add Admin
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="userTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->status ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $user->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('user.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('user.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this admin?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#userTable').DataTable(); // Optional: If you want pagination & search
    });
</script>
@endpush
@endsection
