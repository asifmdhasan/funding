{{-- @extends('layouts.guest-master')

@section('content')

<style>
    .progress {
        background-color: #e9ecef;
    }
    .progress-bar {
        background-color: red;
    }
</style>

<div class="container py-5">


<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Helpseeker Details -->
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">
                Helpseeker Information
            </div>
            <div class="card-body">

                <p><strong>Name:</strong> {{ $post->helpseeker->name }}</p>

                @if($post->helpseeker->email)
                    <p><strong>Email:</strong> {{ $post->helpseeker->email }}</p>
                @endif

                @if($post->helpseeker->phone)
                    <p><strong>Phone:</strong> {{ $post->helpseeker->phone }}</p>
                @endif

                @if($post->helpseeker->city)
                    <p><strong>City:</strong> {{ $post->helpseeker->city }}</p>
                @endif

            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h3 class="fw-bold mb-2">{{ $post->title }}</h3>

                <p class="text-muted mb-3">
                    Requested by <strong>{{ $post->helpseeker->name }}</strong>
                    @if($post->helpseeker->city)
                        · {{ $post->helpseeker->city }}
                    @endif
                </p>

                <p class="mb-4">
                    {{ $post->reason }}
                </p>

                @php
                    $collected = $post->collectedAmount();
                    $percent = $post->required_amount > 0
                        ? ($collected / $post->required_amount) * 100
                        : 0;
                    $percent = min(100, $percent);
                @endphp

                <div class="progress mb-2" style="height: 10px;">
                    <div class="progress-bar"
                         role="progressbar"
                         style="width: {{ $percent }}%;"
                         aria-valuenow="{{ $percent }}"
                         aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                </div>

                <div class="d-flex justify-content-between small text-muted mb-4">
                    <span>
                        {{ number_format($collected) }} collected
                    </span>
                    <span>
                        Target: {{ number_format($post->required_amount) }}
                    </span>
                </div>

                <a href="#"
                   class="btn btn-dark w-100 fw-semibold">
                    Donate Now
                </a>

            </div>
        </div>

    </div>
</div>


</div>

@endsection --}}





@extends('layouts.guest-master')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Helpseeker Details -->
        {{-- <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">
                Helpseeker Information
            </div>
            <div class="card-body">

                <p><strong>Name:</strong> {{ $post->helpseeker->name }}</p>

                @if($post->helpseeker->email)
                    <p><strong>Email:</strong> {{ $post->helpseeker->email }}</p>
                @endif

                @if($post->helpseeker->phone)
                    <p><strong>Phone:</strong> {{ $post->helpseeker->phone }}</p>
                @endif

                @if($post->helpseeker->city)
                    <p><strong>City:</strong> {{ $post->helpseeker->city }}</p>
                @endif

            </div>
        </div> --}}

        <div class="card shadow-sm">
            <div class="card-header fw-semibold">
                Helpseeker Information
            </div>
            <div class="card-body">
                

                <!-- Post Title -->
                <h3 class="mb-2">{{ $post->title }}</h3>

                <p><strong>Name:</strong> {{ $post->helpseeker->name }}</p>

                @if($post->helpseeker->email)
                    <p><strong>Email:</strong> {{ $post->helpseeker->email }}</p>
                @endif

                @if($post->helpseeker->phone)
                    <p><strong>Phone:</strong> {{ $post->helpseeker->phone }}</p>
                @endif

                @if($post->helpseeker->city)
                    <p><strong>City:</strong> {{ $post->helpseeker->city }}</p>
                @endif


                <p class="mb-3">
                    {{ $post->reason }}
                </p>

                <!-- Progress -->
                @php
                    $collected = $post->collectedAmount();
                    $percent = $post->required_amount > 0
                        ? ($collected / $post->required_amount) * 100
                        : 0;
                    $percent = min(100, $percent);
                @endphp

                <div class="mb-3">
                    <div class="progress" style="height: 20px; border-radius: 10px;">
                        <div class="progress-bar bg-danger"
                             role="progressbar"
                             style="width: {{ $percent }}%;"
                             aria-valuenow="{{ $percent }}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                            {{ number_format($percent, 0) }}%
                        </div>
                    </div>

                    <small class="d-block mt-1 text-center">
                        {{ number_format($collected) }} /
                        {{ number_format($post->required_amount) }}
                    </small>
                </div>

                <!-- Donate Button -->
                <p class="text-center">
                    <button class="btn btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#donateModal">
                        Donate
                    </button>
                </p>

            </div>
        </div>

    </div>
</div>
```

</div>

<!-- Donate Modal -->

<div class="modal fade" id="donateModal" tabindex="-1"
     aria-labelledby="donateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

```
        <div class="modal-header">
            <h5 class="modal-title">
                Donate to {{ $post->title }}
            </h5>
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
        </div>

        <div class="modal-body text-center">

            @guest('donor')
                <p>You need to login to donate.</p>
                <a href="{{ route('donor.login') }}" class="btn btn-primary">
                    Login
                </a>
            @else

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('donation.store.helpseeker', $post->id) }}"
                      method="POST">
                    @csrf

                    <input type="hidden"
                           name="helpseeker_post_id"
                           value="{{ $post->id }}">

                    <div class="mb-3">
                        <label class="form-label">
                            Donation Amount
                        </label>

                        <input type="number"
                               name="amount"
                               class="form-control"
                               min="1"
                               max="{{ $post->required_amount - $collected }}"
                               value="{{ old('amount') }}"
                               required>

                        <small class="text-muted">
                            Max: {{ number_format($post->required_amount - $collected) }}
                        </small>
                    </div>

                    <button type="submit"
                            class="btn btn-success w-100">
                        Donate
                    </button>
                </form>

            @endguest

        </div>
    </div>
</div>
```

</div>

<!-- Auto open modal if error exists -->

@if(session('error'))

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var donateModal = new bootstrap.Modal(
            document.getElementById('donateModal')
        );
        donateModal.show();
    });
</script>

@endif

@endsection
