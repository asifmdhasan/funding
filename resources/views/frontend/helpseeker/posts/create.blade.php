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

                <form method="POST" action="{{ route('helpseeker.posts.store') }}" enctype="multipart/form-data">
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

                    {{-- File --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Document</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept="image/*,application/pdf,.doc,.docx" onchange="previewFile(this)">

                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview --}}
                        <div class="mt-2">
                            <img id="filePreview" src="#" alt="Preview" style="display:none; max-width: 200px;"/>
                        </div>
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

<script>
function previewFile(input){
    const preview = document.getElementById('filePreview');
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
