@extends('layouts.guest-master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="text-center mb-4">
                        Donor Registration
                    </h4>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if(session('error'))
                        <div>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('donor.store') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"name="name"value="{{ old('name') }}"class="form-control @error('name') is-invalid @enderror"placeholder="Enter your name"required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email"name="email"value="{{ old('email') }}"class="form-control @error('email') is-invalid @enderror"placeholder="Email"required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input type="password"name="password"class="form-control @error('password') is-invalid @enderror"placeholder="Password"required>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Confirm Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
