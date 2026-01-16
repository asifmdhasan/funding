@extends('layouts.guest-master')

@section('content')
<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card">
<div class="card-body">
<h4 class="text-center mb-3">Donor Login</h4>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<form method="POST" action="{{ route('donor.authenticate') }}">
@csrf
<input class="form-control mb-2" name="email" placeholder="Email">
@error('email')
    <div class="mt-2 flex items-center text-red-600 text-sm">
        {{ $message }}
    </div>
@enderror
<input type="password" class="form-control mb-2" name="password" placeholder="Password">
@error('password')
    <div class="mt-2 flex items-center text-red-600 text-sm">
        {{ $message }}
    </div>
@enderror
<button class="btn btn-primary w-100">Login</button>
</form>

</div>
</div>

</div>
</div>
</div>
@endsection
