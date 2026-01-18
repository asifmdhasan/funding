@extends('master')

@section('contents')
<div class="container">
    <a href="{{ route('helpseeker.posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

    @foreach($posts as $post)
    @php
        $collected = $post->collectedAmount();
        $progress = $post->required_amount > 0 ? ($collected / $post->required_amount) * 100 : 0;
    @endphp
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5>{{ $post->title }} <small class="text-muted">({{ ucfirst($post->status) }})</small></h5>
            <p>{{ $post->reason }}</p>

            <div class="progress mb-2" style="height: 20px;">
                <div class="progress-bar" role="progressbar" style="width: {{ min($progress, 100) }}%;" 
                     aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                    {{ number_format($progress, 1) }}%
                </div>
            </div>
            <p>Collected: ${{ number_format($collected,2) }} / ${{ number_format($post->required_amount,2) }}</p>

            <a href="{{ route('helpseeker.posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>

            <form action="{{ route('helpseeker.posts.destroy', $post) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
