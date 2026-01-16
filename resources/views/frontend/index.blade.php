@extends('layouts.guest-master')

@section('content')
<style>
.hero-section {
    height: 85vh;
    background: url('{{ asset("assets/img/hero2.webp") }}') center/cover no-repeat;

    /* background: url('/images/hero.jpg') center/cover no-repeat; */
    /* margin: 20px; */
    /* border-radius: 20px; */
    position: relative;
}

.hero-section .overlay {
    background: rgba(0,0,0,0.45);
    height: 100%;
    display: flex;
    align-items: center;
}

.hero-title {
    font-size: 64px;
    font-weight: 800;
}

.hero-subtitle {
    max-width: 500px;
    font-size: 18px;
}
</style>


{{-- ================= HERO SECTION ================= --}}
<section class="hero-section mb-5">
    <div class="overlay">
        <div class="container text-white">
            <h1 class="hero-title">
                Fund <br> Help Others
            </h1>
            <p class="hero-subtitle">
                Fundraise at the speed of thought! Elevate your cause in just a minute.
            </p>

            <a href="{{ route('donor.register') }}" class="btn btn-success btn-lg mt-3">
                Start Fundraising
            </a>
        </div>
    </div>
</section>

{{-- ================= URGENT FUNDRAISING ================= --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4">Fundraising!</h2>

        <div class="row">
            @foreach($crises as $crisis)
                @php
                    $raised = \App\Models\Donation::where('crisis_id', $crisis->id)
                                ->where('status', 'success')
                                ->sum('amount');

                    $percent = $crisis->target_amount > 0
                        ? ($raised / $crisis->target_amount) * 100
                        : 0;
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">

                        {{-- <img src="{{ $crisis->category->image ?? '/images/default.jpg' }}"
                             class="card-img-top"
                             style="height:220px; object-fit:cover;"> --}}
                             <img src="{{ asset($crisis->image_url) }}"
                             class="card-img-top">

                        <div class="card-body">
                            <small class="text-muted">
                                {{ $crisis->category->name }}
                            </small>

                            <h5 class="fw-bold mt-2">
                                {{ $crisis->title }}
                            </h5>

                            <div class="progress my-2">
                                <div class="progress-bar bg-warning" role="progressbar"
                                     style="width: {{ min($percent,100) }}%; background: Red;">
                                </div>
                            </div>

                            <p class="small mb-1">
                                {{ number_format($raised) }} BDT
                                raised of {{ number_format($crisis->target_amount) }} BDT
                            </p>

                            <a href="{{ route('donor.register') }}"
                               class="btn btn-success btn-sm mt-2" ">
                                Donate Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


@endsection
