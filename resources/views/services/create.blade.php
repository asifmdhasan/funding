@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fa fa-cogs me-2"></i> Create Service
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf

                    {{-- Business Category --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Business Category <span class="text-danger">*</span>
                        </label>
                        <select name="business_category_id"
                                class="form-select search_select @error('business_category_id') is-invalid @enderror"
                                required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('business_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('business_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Service Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Service Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Enter service name"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button class="btn btn-primary">
                            <i class="fa fa-save me-1"></i> Save
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
