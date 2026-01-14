@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fa fa-edit me-2"></i>
                    Edit Business Category
                </h5>
            </div>

            <div class="card-body">

                <form action="{{ route('business-categories.update', $businessCategory) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $businessCategory->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Enter category name"
                               required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Category Image
                        </label>
                        <!-- recomendation size 300x300 px -->
                        <p class="text-muted small">
                            Recommended size: 160 × 100 px
                        </p>
                        {{-- Image preview --}}
                        <div class="mb-2">
                            <img id="imagePreview"
                                 src="{{ $businessCategory->image ? asset('assets/' . $businessCategory->image) : '' }}"
                                 alt="Image Preview"
                                 style="max-width: 150px; max-height: 150px; display: {{ $businessCategory->image ? 'block' : 'none' }};"
                                 class="img-thumbnail">
                        </div>

                        <input type="file"
                               name="image"
                               id="imageInput"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/*">

                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Status
                        </label>
                        <select name="status"
                                class="form-select">
                            <option value="1" {{ old('status', $businessCategory->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="0" {{ old('status', $businessCategory->status) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('business-categories.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-warning text-dark">
                            <i class="fa fa-save me-1"></i> Update
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

{{-- Image preview script --}}
<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
});
</script>
@endsection
