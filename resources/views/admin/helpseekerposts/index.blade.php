@extends('layouts.master')

@section('content')
    <div class="container py-5">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Reason</th>
                    <th>Required Amount</th>
                    <th>Collected Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->reason }}</td>
                    <td>{{ number_format($post->required_amount, 2) }}</td>
                    <td>{{ number_format($post->collectedAmount(), 2) }}</td>
                    <td>
                        <form action="{{ route('admin.helpseekerposts.update_status', $post) }}" method="POST" class="d-inline">
                            @csrf
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ $post->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $post->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $post->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Change Status</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
