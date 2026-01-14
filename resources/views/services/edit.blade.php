@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0">
                    <i class="fa fa-edit me-2"></i> Edit Service
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('services.update', $service) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Business Category --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Business Category</label>
                        <select name="business_category_id"
                                class="form-select search_select">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('business_category_id', $service->business_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Service Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Service Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $service->name) }}"
                               class="form-control"
                               required>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button class="btn btn-warning">
                            <i class="fa fa-save me-1"></i> Update
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
