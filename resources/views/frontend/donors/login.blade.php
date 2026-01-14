@extends('layouts.guest-master')

@section('content')
<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card">
<div class="card-body">
<h4 class="text-center mb-3">Donor Login</h4>

<form method="POST" action="{{ route('donor.authenticate') }}">
@csrf
<input class="form-control mb-2" name="email" placeholder="Email">
<input type="password" class="form-control mb-2" name="password" placeholder="Password">
<button class="btn btn-primary w-100">Login</button>
</form>

</div>
</div>

</div>
</div>
</div>
@endsection
