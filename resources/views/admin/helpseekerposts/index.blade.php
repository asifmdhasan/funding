@extends('layouts.master')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    <h4 class="fw-bold mb-3">Help Seeker Posts</h4>
            

    <div class="card shadow-sm">
        

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Helpseeker</th>
                        <th>Title</th>
                        <th>Reason</th>
                        <th>Required Amount</th>
                        <th>Collected Amount</th>
                        <th>Status</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr class="text-center">
                        <td>{{ $post->helpseeker->name }}</td>
                        <td class="fw-semibold">{{ $post->title }}</td>
                        <td>{{ Str::limit($post->reason, 50) }}</td>
                        <td>৳ {{ number_format($post->required_amount, 2) }}</td>
                        <td>৳ {{ number_format($post->collectedAmount(), 2) }}</td>
                        <td>
                            @php
                                $badgeClass = match($post->status) {
                                    'approved' => 'bg-success',
                                    'pending' => 'bg-warning text-dark',
                                    'rejected' => 'bg-danger',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($post->status) }}</span>
                        </td>

                        <td>
                            @if($post->file_path)
                                <a href="{{ asset($post->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    View File
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('admin.helpseekerposts.update_status', $post) }}" method="POST" class="d-flex gap-2 justify-content-center align-items-center">
                                @csrf
                                <select name="status" class="form-select form-select-sm" required>
                                    <option value="pending" {{ $post->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $post->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $post->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No help posts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
