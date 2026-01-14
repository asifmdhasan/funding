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
            <h2 class="text-xl font-bold margin-b-8rem">
                {{ __('layouts.edit_user') }}
            </h2>

            <form action="{{ route('users.update', $user) }}" method="POST" class="md:px-8 space-y-4">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-2">
                    <label for="name" class="block text-sm font-medium mb-1">{{ __('layouts.name') }}</label>
                    <input type="text" id="name" name="name" placeholder="{{ __('layouts.name') }}"
                        value="{{ old('name', $user->name) }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-2">
                    <label for="username" class="block text-sm font-medium mb-1">{{ __('layouts.username') }}</label>
                    <input type="text" id="username" name="username" placeholder="{{ __('layouts.username') }}"
                        value="{{ old('username', $user->username) }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('username') border-red-500 @enderror"
                        required>
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium mb-1">{{ __('layouts.email') }}</label>
                    <input type="email" id="email" name="email" placeholder="{{ __('layouts.email') }}"
                        value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="block text-sm font-medium mb-1">{{ __('layouts.edit_pass') }}</label>
                    <div class="flex items-center gap-2">
                        <input id="password" type="text" name="password" placeholder="{{ __('layouts.edit_pass') }}"
                            class="flex-1 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('password') border-red-500 @enderror">
                        <button type="button" onclick="generatePassword()"
                            class="text-black text-sm border px-3 py-2 rounded hover:bg-gray-100">
                            {{ __('layouts.generate_password') }}
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Role -->
                <div class="mb-2">
                    <label for="role_id" class="block text-sm font-medium mb-1">{{ __('layouts.user_role') }}
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
                        <option value="">{{ __('layouts.select_user_role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ $role->id == old('role_id', $user->role_id) ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Notifications -->
                <div class="flex items-center gap-2 my-1">
                    <input id="receive_low_stock" type="checkbox" name="notifications_enabled" value="1"
                        {{ isset($user) && $user->userSetting->notifications_enabled ? 'checked' : '' }}>
                    <label for="receive_low_stock">Receive low stock notifications</label>
                </div>

                <!-- Status -->
                <div class="mb-2">
                    <label for="status" class="block text-sm font-medium mb-1">{{ __('layouts.status') }}</label>
                    <select name="status" id="status"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('status') border-red-500 @enderror"
                        required>
                        <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>
                            {{ __('layouts.active') }}</option>
                        <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>
                            {{ __('layouts.inactive') }}</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center w-50">
                    <button type="submit"
                        class="inline-block w-full px-6 py-3 mt-6 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                        {{ __('layouts.update_user') }}
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
