@extends('layouts.guest-master')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-header fw-bold">
                Edit Help Post
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('helpseeker.posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title', $post->title) }}"
                               class="form-control @error('title') is-invalid @enderror"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- File --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Document</label>
                        <input type="file"
                               name="file"
                               class="form-control @error('file') is-invalid @enderror"
                               accept="image/*,application/pdf,.doc,.docx"
                               onchange="previewFile(this)">
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Existing File Preview --}}
                        @if($post->file_path)
                            <div class="mt-2" id="existingPreview">
                                @if(in_array(pathinfo($post->file_path, PATHINFO_EXTENSION), ['jpg','jpeg','png','gif']))
                                    <img src="{{ asset($post->file_path) }}" alt="Existing File" style="max-width: 200px;">
                                @else
                                    <p>Existing File: <a href="{{ asset($post->file_path) }}" target="_blank">{{ basename($post->file_path) }}</a></p>
                                @endif
                            </div>
                        @endif

                        {{-- JS Preview --}}
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
                                  required>{{ old('reason', $post->reason) }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Required Amount --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Required Amount</label>
                        <input type="number"
                               name="required_amount"
                               value="{{ old('required_amount', $post->required_amount) }}"
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
                            Update Post
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
function previewFile(input){
    const preview = document.getElementById('filePreview');
    const existing = document.getElementById('existingPreview');

    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = 'block';
            if(existing) existing.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
