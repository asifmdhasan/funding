@extends('layouts.frontend-master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', $customer->name) }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ old('email', $customer->email) }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" 
                                   value="{{ old('phone', $customer->phone) }}">
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" 
                                   value="{{ old('dob', $customer->dob) }}">
                            @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Profile Image -->
                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" 
                                   onchange="previewImage(event)">
                            @error('profile_image') <small class="text-danger">{{ $message }}</small> @enderror

                            @if($customer->profile_image)
                                <div class="mt-3">
                                    <img id="profilePreview" src="{{ asset( $customer->profile_image) }}" 
                                         class="img-thumbnail" style="width:150px; height:150px; object-fit:cover;">
                                </div>
                            @else
                                <div class="mt-3">
                                    <img id="profilePreview" src="#" class="img-thumbnail" style="display:none; width:150px; height:150px; object-fit:cover;">
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();
    reader.onload = function(){
        const img = document.getElementById('profilePreview');
        img.src = reader.result;
        img.style.display = 'block';
    };
    if(input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
