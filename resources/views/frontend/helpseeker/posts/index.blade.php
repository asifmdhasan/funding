@extends('layouts.guest-master')

@section('content')

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">My Help Posts</h4>
    <a href="{{ route('helpseeker.posts.create') }}" class="btn btn-primary">
        + Create New Post
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Title</th>
                    <th>Required Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($posts as $post)
                <tr class="text-center">
                    <td>{{ $post->title }}</td>
                    <td> {{ number_format($post->required_amount, 2) }} BDT</td>
                    <td>
                        <span class="badge 
                            {{ $post->status == 'approved' ? 'bg-success' : ($post->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </td>
                    <td>
                         <a href="{{ route('helpseeker.posts.donations', $post->id) }}" class="btn btn-sm btn-outline-success">
                            View Donations
                        </a>
                        <a href="{{ route('helpseeker.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>

                        <form action="{{ route('helpseeker.posts.destroy', $post->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No posts found.
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>

    </div>
</div>


</div>
@endsection
