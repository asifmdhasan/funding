{{-- <!DOCTYPE html>


<body>
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-20 w-auto rounded-full" src="{{url('/backend/images/logo.png')}}" alt="logo"/>
        <h2 class="mt-6 text-center text-3xl leading-3 font-bold text-gray-900">
            Reset your password
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form action="{{route('customer.forget.password.post')}}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                        Enter Email <span class="text-red-800"> *</span>
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input placeholder="Enter your email" id="email" name="email" type="email"
                               value="{{old('email')}}"
                               required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                    </div>
                    @error('email')
                    <span class="text-red-600 text-sm ml-1 mt-1">{{$message}}</span>
                    @enderror
                </div>

                <div class="mt-6">
            <span class="block w-full rounded-md shadow-sm">
              <button type="submit"
                      class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                Submit to get reset link
              </button>
                <a href="{{route('login')}}"
                        class=" mt-2 w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                Back
              </a>
            </span>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
 --}}



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

                <form action="{{route('customer.forget.password.post')}}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                        Enter Email <span class="text-red-800"> *</span>
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input placeholder="Enter your email" id="email" name="email" type="email"
                               value="{{old('email')}}"
                               required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                    </div>
                    @error('email')
                    <span class="text-red-600 text-sm ml-1 mt-1">{{$message}}</span>
                    @enderror
                </div>

                <div class="mt-6">
            <span class="block w-full rounded-md shadow-sm">
              <button type="submit"
                      class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                Submit to get reset link
              </button>
                <a href="{{route('customer.login')}}"
                        class=" mt-2 w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                Back
              </a>
            </span>
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