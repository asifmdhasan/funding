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
                        {{-- image --}}
                        <img src="{{ asset($crisis->image_url) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
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

</div>
@endsection
