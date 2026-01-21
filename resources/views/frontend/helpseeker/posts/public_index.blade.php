@extends('layouts.guest-master')

@section('content')

<style>
    .progress {
        background-color: #e9ecef;
        border-radius: 6px;
    }
    .progress-bar {
        background-color: #dc3545;
        transition: width 0.6s ease;
    }
    .post-image {
        height: 180px;
        width: 100%;
        object-fit: cover;
        border-radius: 6px;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">

        @forelse($posts as $post)

            @php
                $collected = $post->donations->sum('amount');
                $required  = $post->required_amount ?? 0;
                $percent   = $required > 0
                    ? min(($collected / $required) * 100, 100)
                    : 0;
            @endphp

            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm">

                    {{-- Image --}}
                    @if($post->file_path && file_exists(public_path($post->file_path)))
                        <img src="{{ asset($post->file_path) }}"
                             class="post-image"
                             alt="Help Request Image">
                    @endif

                    <div class="card-body text-center">

                        <h5 class="mb-2">{{ $post->title }}</h5>

                        <p class="text-muted mb-2">
                            By {{ $post->helpseeker->name ?? 'Helpseeker' }}
                        </p>

                        <p class="small text-muted mb-3">
                            {{ \Illuminate\Support\Str::limit($post->reason, 80) }}
                        </p>

                        {{-- Progress --}}
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar"
                                 role="progressbar"
                                 style="width: {{ $percent }}%"
                                 aria-valuenow="{{ $percent }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>

                        <small class="d-block mb-1 fw-semibold">
                            {{ number_format($collected) }} /
                            {{ number_format($required) }}
                        </small>

                        <small class="text-muted">
                            Collected: {{ round($percent, 2) }}%
                        </small>

                        <a href="{{ route('helpseeker.posts.show', $post->id) }}"
                           class="btn btn-dark d-block mt-3 fw-semibold">
                            View Details
                        </a>

                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center">
                <p class="text-muted">No approved help requests found.</p>
            </div>
        @endforelse

    </div>
</div>

@endsection
