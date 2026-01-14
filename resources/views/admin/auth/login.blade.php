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
            <!-- Logo/Icon -->
            {{-- <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div> --}}
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
                {{-- {{ __('layouts.projectName') }} --}}
                GME Network
            </h2>
            {{-- <p class="text-center text-indigo-100 text-sm">
                Access your inventory management dashboard
            </p> --}}

            <!-- Language Toggle -->
            {{-- <div class="text-center mt-6">
                <div class="inline-flex bg-white bg-opacity-20 rounded-full p-1">
                    <a href="?lang=jp"
                        class="px-4 py-2 text-sm font-medium text-white hover:bg-white hover:bg-opacity-20 rounded-full transition-all duration-200">
                        日本語
                    </a>
                    <span class="text-white opacity-50 flex items-center">|</span>
                    <a href="?lang=en"
                        class="px-4 py-2 text-sm font-medium text-white hover:bg-white hover:bg-opacity-20 rounded-full transition-all duration-200">
                        English
                    </a>
                </div>
            </div> --}}
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

                <form action="{{ route('login') }}" method="POST" class="relative z-10">
                    @csrf

                    <!-- Username Field -->
                    <div class="relative mb-8">
                        <div class="relative">
                            <input placeholder=" " id="username" name="username" type="text"
                                value="{{ old('username', 'superadmin') }}" required
                                class="peer w-full px-4 py-4 pt-6 text-gray-900 bg-transparent border-2 border-gray-200 rounded-xl input-focus placeholder-transparent transition-all duration-200 focus:outline-none" />
                            <label for="username"
                                class="absolute left-4 top-4 text-gray-500 text-sm transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-sm peer-focus:text-indigo-600 peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-sm peer-[:not(:placeholder-shown)]:text-indigo-600">
                                {{ __('login.username') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('username')
                            <div class="mt-2 flex items-center text-red-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="relative mb-3">
                        <div class="relative">
                            <input value="" placeholder=" " id="password" name="password" type="password"
                                required
                                class="peer w-full px-4 py-4 pt-6 text-gray-900 bg-transparent border-2 border-gray-200 rounded-xl input-focus placeholder-transparent transition-all duration-200 focus:outline-none" />
                            <label for="password"
                                class="absolute left-4 top-4 text-gray-500 text-sm transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-sm peer-focus:text-indigo-600 peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-sm peer-[:not(:placeholder-shown)]:text-indigo-600">
                                {{ __('login.password') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <button type="button" onclick="togglePassword()"
                                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                    <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <div class="mt-2 flex items-center text-red-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- <div class="my-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_token" value="true" type="checkbox" name="remember_me"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition duration-150 ease-in-out" />
                            <label for="remember_token" class="ml-2 block text-sm text-gray-700">
                                {{ __('login.remember_me') }}
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#"
                                class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out">
                                {{ __('login.forgot_pass') }}
                            </a>
                        </div>
                    </div> --}}

                    <!-- Submit Button -->
                    <div class="mb-6">
                        <button type="submit"
                            class="w-full flex justify-center items-center py-4 px-6 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 btn-hover transition-all duration-200 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            {{ __('login.sign_in_button') }}
                        </button>
                    </div>

                    <!-- Additional Info -->
                    {{-- <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Secure access to your inventory dashboard
                        </p>
                    </div> --}}
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
