@extends('layouts.guest-master')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    Edit Helpseeker
                </div>

                <div class="card-body">

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('helpseeker.profile.update', $helpseeker->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                name="name"
                                value="{{ old('name', $helpseeker->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                name="email"
                                value="{{ old('email', $helpseeker->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Phone
                            </label>
                            <input type="text"
                                name="phone"
                                value="{{ old('phone', $helpseeker->phone) }}"
                                class="form-control @error('phone') is-invalid @enderror">

                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- City --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                City
                            </label>
                            <input type="text"
                                name="city"
                                value="{{ old('city', $helpseeker->city) }}"
                                class="form-control @error('city') is-invalid @enderror">

                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                New Password
                            </label>
                            <input type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Leave blank to keep current password">

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Confirm Password
                            </label>
                            <input type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Confirm password">
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('helpseeker.dashboard') }}" class="btn btn-outline-secondary">
                                Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update Helpseeker
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>


</div>
@endsection
