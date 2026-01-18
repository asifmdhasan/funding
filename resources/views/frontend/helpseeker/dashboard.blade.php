@extends('layouts.guest-master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center mb-4">Helpseeker Dashboard</h4>

                    <div class="mb-4">
                        <h5>Your Info:</h5>
                        <p><strong>Name:</strong> {{ auth('helpseeker')->user()->name }}</p>
                        <p><strong>Email:</strong> {{ auth('helpseeker')->user()->email }}</p>
                        <p><strong>City:</strong> {{ auth('helpseeker')->user()->city ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ auth('helpseeker')->user()->phone ?? '-' }}</p>
                        
                    </div>




                </div>
            </div>

        </div>
    </div>
</div>
@endsection
