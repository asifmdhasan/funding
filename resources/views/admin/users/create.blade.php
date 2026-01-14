@extends('layouts.master')
@section('content')
    <style>
        .margin-b-1rem {
            margin-bottom: 1rem;
        }

        .margin-b-8rem {
            margin-bottom: 4rem;
        }
    </style>


    <div class="container mx-auto p-4 sm:p-6">
        <div class="bg-white rounded-xl shadow-xl p-4 md:p-8 border border-gray-100 max-w-2xl mx-auto">
            <h2 class="text-xl font-bold mb-4 md:px-8">
                {{-- Create User --}}
                {{ __('layouts.create_user') }}
            </h2>

            <form action="{{ route('user.store') }}" method="POST" class="md:px-8">
                @csrf

                <!-- Name -->
                <div class="mb-2">
                    <label for="name" class="block text-sm font-medium mb-1">{{ __('layouts.name') }}</label>
                    <input type="text" id="name" name="name" placeholder="{{ __('layouts.name') }}"
                        value="{{ old('name') }}"
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
                        value="{{ old('username') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required>
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium mb-1">{{ __('layouts.email') }}</label>
                    <input type="email" id="email" name="email" placeholder="{{ __('layouts.email') }}"
                        value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="block text-sm font-medium mb-1">{{ __('layouts.password') }}</label>
                    <div class="flex items-center gap-2">
                        <input id="password" type="text" name="password" placeholder="{{ __('layouts.password') }}"
                            class="flex-1 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                        <button type="button" onclick="generatePassword()"
                            class="text-black text-sm border px-3 py-2 rounded hover:bg-gray-100">
                            {{ __('layouts.generate_password') }}
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="role_id" class="block text-sm font-medium mb-1">User Role
                        <span class="text-red-600">*</span>
                    </label>

                    <select required id="role_id" name="role_id"
                        class="form-select appearance-none
                block
                w-full
                px-3
                py-1.5
                text-base
                font-normal
                text-gray-700
                bg-white bg-clip-padding bg-no-repeat
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        aria-label="Default select example">
                        <option selected>{{ __('layouts.select_user_role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $role->id == request()->role_id ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach

                    </select>
                    @error('role_id')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>


                <div class="flex items-center gap-2 my-1">
                    <input id="receive_low_stock" type="checkbox" name="notifications_enabled" value="1"
                        {{ isset($user) && $user->userSetting->notifications_enabled ? 'checked' : '' }}>
                    <label for="receive_low_stock">Receive low stock notifications</label>
                </div>

                <!-- Status -->
                <div class="mb-2">
                    <label for="status" class="block text-sm font-medium mb-1">{{ __('layouts.status') }}</label>
                    <select name="status" id="status"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>{{ __('layouts.active') }}
                        </option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>{{ __('layouts.inactive') }}
                        </option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center w-50">
                    <button type="submit"
                        class="inline-block w-full px-6 py-3 mt-6 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                        {{ __('layouts.create') }}
                    </button>
                </div>
            </form>

        </div>
    </div>


    <script>
        function generatePassword() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
            let password = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }
            document.getElementById("password").value = password;
        }
    </script>
@endsection
