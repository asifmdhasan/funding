@extends('layouts.guest-master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center mb-4">Helpseeker Login</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    
                    <form method="POST" action="{{ route('helpseeker.authenticate') }}">
                        @csrf

                        <div class="mb-3">
                            <input type="email" name="email" placeholder="Email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('helpseeker.register') }}">Register</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
