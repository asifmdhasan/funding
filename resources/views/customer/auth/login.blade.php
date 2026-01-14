{{-- @extends('layouts.master')


@section('content') --}}
{{-- <div class="flex justify-center items-center h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">

        <h2 class="text-2xl font-bold text-center mb-4">Customer Login</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-2 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('customer.login.submit') }}" method="POST">

            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded"
                       placeholder="Enter email" required>
                @error('email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded"
                       placeholder="Enter password" required>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Login
            </button>

            <div class="text-center mt-3">
                <a href="{{ route('customer.register') }}" class="text-blue-600 text-sm">
                    Create new account
                </a>
            </div>

        </form>

    </div>
</div> --}}
{{-- @endsection --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>{{ __('layouts.projectName') }}</title> --}}
    <title>GME Network Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            border-color: #667eea;
        }

        .btn-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .floating-label {
            transition: all 0.2s ease;
        }

        .floating-label.active {
            transform: translateY(-1.5rem) scale(0.85);
            color: #667eea;
        }
    </style>
</head>

<body class="min-h-screen gradient-bg">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 30px 30px;">
        </div>
    </div>
    
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative">
        <!-- Header Section -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md">

            @if ($errors->any())
                <div class="mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2 class="text-center text-2xl font-bold text-white mb-2">
                GME Network
            </h2>

        </div>

        <!-- Form Section -->
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="glass-effect py-10 px-8 shadow-2xl sm:rounded-3xl relative overflow-hidden">
                <!-- Decorative elements -->
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full opacity-10 transform translate-x-16 -translate-y-16">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-blue-400 to-indigo-500 rounded-full opacity-10 transform -translate-x-12 translate-y-12">
                </div>

                <form action="{{ route('customer.login.submit') }}" method="POST">

                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Email</label>
                        <input type="email" name="email" class="w-full border p-2 rounded"
                            placeholder="Enter email" required>
                        @error('email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Password</label>
                        <input type="password" name="password" class="w-full border p-2 rounded"
                            placeholder="Enter password" required>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                        Login
                    </button>
                    <button type="button" onclick="location.href='{{ route('customer.forget.password') }}'"
                            class="mt-4 w-full bg-gray-600 text-white p-2 rounded hover:bg-gray-700">
                        Forgot Password
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('customer.register') }}" class="text-blue-600 text-sm">
                            Create new account
                        </a>
                    </div>

                </form>

                
            </div>
        </div>

        <!-- Footer -->
        {{-- <div class="mt-8 text-center">
            <p class="text-sm text-indigo-100 opacity-75">
                &copy; 2024 Inventory Management System. All rights reserved.
            </p>
        </div> --}}
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>

</html>
