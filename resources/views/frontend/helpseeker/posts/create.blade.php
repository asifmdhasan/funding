@extends('layouts.guest-master')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-header fw-bold">
                Create Help Post
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('helpseeker.posts.store') }}">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               required>

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Reason --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Reason</label>
                        <textarea name="reason"
                                  rows="4"
                                  class="form-control @error('reason') is-invalid @enderror"
                                  required>{{ old('reason') }}</textarea>

                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Required Amount --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Required Amount</label>
                        <input type="number"
                               name="required_amount"
                               value="{{ old('required_amount') }}"
                               class="form-control @error('required_amount') is-invalid @enderror"
                               required>

                        @error('required_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('helpseeker.posts.index') }}" class="btn btn-outline-secondary">
                            Back
                        </a>
                        <button class="btn btn-primary">
                            Submit for Approval
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>


</div>
@endsection
