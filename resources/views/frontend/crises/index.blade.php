@extends('layouts.guest-master')

@section('content')
<style>
    .progress {
        background-color: #e9ecef;
    }
    .progress-bar {
        background-color: Red;
    }
</style>
<div class="container py-4">
    <div class="row justify-content-center">
        {{-- add title for crisis --}}
        <h3 class="mb-4 text-center fw-bold">Latest Crises List</h3>
        @foreach($crises as $crisis)
            @php
                $collected = $crisis->collectedAmount();
                $percent = $crisis->target_amount > 0 ? ($collected / $crisis->target_amount) * 100 : 0;
            @endphp

            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="mb-2">{{ $crisis->title }}</h5>
                        <p class="text-muted mb-3">{{ $crisis->city }}</p>

                        <div class="progress mb-2" style="height: 8px; border-radius: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <small class="d-block mb-2">
                            {{ number_format($collected) }} / {{ number_format($crisis->target_amount) }}
                        </small>

                        <small class="text-muted">
                            Collected: {{ round($percent, 2) }}%
                        </small>

                        <!-- View page link -->
                        <a href="{{ route('crisis.show', $crisis->id) }}" class="text-decoration-none d-block mt-3 fw-semibold btn btn-dark">
                            View
                        </a>

                    </div>
                </div>
            </div>

        @endforeach
    </div>
    <br>
    <div class="row justify-content-center">
        <h3 class="mb-4 text-center fw-bold">Latest Posts List</h3>
        @foreach($posts as $post)
            @php
                $raised = \App\Models\Donation::where('helpseeker_post_id', $post->id)
                            ->where('status', 'success')
                            ->sum('amount');

                $percent = $post->required_amount > 0
                    ? ($raised / $post->required_amount) * 100
                    : 0;
            @endphp

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">
                        <small class="text-muted">
                            By {{ $post->helpseeker->name }}
                        </small>

                        <h5 class="fw-bold mt-2">{{ $post->title }}</h5>    
                        <div class="progress my-2">
                            <div class="progress-bar bg-warning" role="progressbar"
                                 style="width: {{ min($percent,100) }}%; background: Red;">
                            </div>
                        </div>

                        <p class="small mb-1">
                            {{ number_format($raised) }} BDT
                            raised of {{ number_format($post->required_amount) }} BDT
                        </p>

                        <!-- View page link -->
                        <a href="{{ route('helpseeker.posts.show', $post->id) }}" class="text-decoration-none d-block mt-3 fw-semibold btn btn-dark">
                            View
                        </a>

                        {{-- <a href="{{ route('donor.register') }}"
                           class="btn btn-success btn-sm mt-2" ">
                            Donate Now
                        </a> --}}
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
