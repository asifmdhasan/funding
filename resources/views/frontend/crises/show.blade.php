@extends('layouts.guest-master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- Crisis Title -->
                    <h3 class="mb-3">{{ $crisis->title }}</h3>
                    <p class="text-muted mb-2"><strong>City:</strong> {{ $crisis->city }}</p>
                    <p class="mb-3">{{ $crisis->description ?? 'No description provided.' }}</p>

                    <!-- Progress Bar -->
                    @php
                        $collected = $crisis->collectedAmount();
                        $percent = $crisis->target_amount > 0 ? ($collected / $crisis->target_amount) * 100 : 0;
                    @endphp

                    <div class="mb-3">
                        <div class="progress" style="height: 20px; border-radius: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format($percent, 0) }}%
                            </div>
                        </div>
                        <small class="d-block mt-1 text-center">
                            {{ number_format($collected) }} / {{ number_format($crisis->target_amount) }}
                        </small>
                    </div>

                    <!-- Donate Button triggers modal -->
                    <p class="text-center">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#donateModal">
                            Donate
                        </button>
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Donate Modal -->
<div class="modal fade" id="donateModal" tabindex="-1" aria-labelledby="donateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Donate to {{ $crisis->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                @guest('donor')
                    <p>You need to login to donate.</p>
                    <a href="{{ route('donor.login') }}" class="btn btn-primary">Login</a>
                @else
                    <!-- Show backend error if exists -->
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('donation.store', $crisis->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="crisis_id" value="{{ $crisis->id }}">
                        <div class="mb-3">
                            <label for="amountModal" class="form-label">Donation Amount</label>
                            <input type="number" name="amount" id="amountModal" class="form-control" 
                                   min="1" 
                                   
                                   value="{{ old('amount') }}" 
                                   required>
                            <small class="text-muted">Max: {{ number_format($crisis->target_amount - $collected) }}</small>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Donate</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Auto open modal if error exists -->
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var donateModal = new bootstrap.Modal(document.getElementById('donateModal'));
        donateModal.show();
    });
</script>
@endif

@endsection
