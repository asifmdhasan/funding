@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">
                    Edit Crisis
                </h5>
            </div>

            <div class="card-body">

                <form action="{{ route('crises.update', $crisis) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Category --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror"
                                required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $crisis->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Crisis Title <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title', $crisis->title) }}"
                               class="form-control @error('title') is-invalid @enderror"
                               required>

                        @error('title')
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
                               value="{{ old('city', $crisis->city) }}"
                               class="form-control">
                    </div>

                    {{-- Target Amount --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Target Amount <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               name="target_amount"
                               value="{{ old('target_amount', $crisis->target_amount) }}"
                               class="form-control @error('target_amount') is-invalid @enderror"
                               required>

                        @error('target_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Description
                        </label>
                        <textarea name="description"
                                  rows="4"
                                  class="form-control">{{ old('description', $crisis->description) }}</textarea>
                    </div>



                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <button type="submit" class="btn btn-warning">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
