@extends('layouts.guest-master')

@section('content')
<style>
    .progress {
        background-color: #e9ecef;
    }
    .progress-bar {
        background-color: red;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">

        @forelse($posts as $post)
            @php
                $collected = $post->collected_amount ?? 0; // adjust if relation exists
                $percent = $post->required_amount > 0
                    ? ($collected / $post->required_amount) * 100
                    : 0;
            @endphp

            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">

                        <h5 class="mb-2">{{ $post->title }}</h5>

                        <p class="text-muted mb-2">
                            By {{ $post->helpseeker->name ?? 'Helpseeker' }}
                        </p>

                        <p class="small text-muted mb-3">
                            {{ Str::limit($post->reason, 80) }}
                        </p>

                        <div class="progress mb-2" style="height: 8px; border-radius: 5px;">
                            <div class="progress-bar"
                                 role="progressbar"
                                 style="width: {{ $percent }}%;"
                                 aria-valuenow="{{ $percent }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>

                        <small class="d-block mb-1">
                            {{ number_format($collected) }} /
                            {{ number_format($post->required_amount) }}
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
