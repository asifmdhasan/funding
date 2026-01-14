@extends('layouts.master')
@section('content')
    <style>

    </style>
    <div class="container mx-auto p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-xl p-4 md:p-8 border border-gray-100 max-w-2xl mx-auto">
            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <h2 class="text-xl font-bold mb-4 md:px-8">
                {{-- Profile User --}}
                {{ __('layouts.profile_update') }}
            </h2>

            <form action="{{ route('user.profileUpdate') }}" method="POST" class="md:px-8">
                @csrf

                <!-- Name -->
                <div class="mb-2">
                    <label for="name" class="block text-sm font-medium mb-1">{{ __('layouts.name') }}</label>
                    <input type="text" id="name" name="name" placeholder="{{ __('layouts.name') }}"
                        value="{{ $user->name }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-2">
                    <label for="username" class="block text-sm font-medium mb-1">{{ __('layouts.username') }}</label>
                    <input type="text" id="username" name="username" placeholder="{{ __('layouts.username') }}"
                        value="{{ $user->username }}"
                        class="w-full border border-gray-300 bg-gray-100 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required disabled>
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium mb-1">{{ __('layouts.email') }}</label>
                    <input type="email" id="email" name="email" placeholder="{{ __('layouts.email') }}"
                        value="{{ $user->email }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center w-50">
                    <button type="submit"
                        class="inline-block w-full px-6 py-3 mt-6 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                        {{ __('layouts.update') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
