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
                {{-- Change Password --}}
                {{ __('layouts.change_password') }}
            </h2>

            <form action="{{ route('user.changePassword') }}" method="POST" class="md:px-8">
                @csrf

                <!-- Current Password -->
                <div class="mb-2 relative">
                    <label for="current_password"
                        class="block text-sm font-medium mb-1">{{ __('layouts.current_password') }}</label>
                    <input type="password" id="current_password" name="current_password"
                        placeholder="{{ __('layouts.current_password') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none pr-10"
                        required>
                    <span class="absolute right-3 top-8 cursor-pointer toggle-password" toggle="#current_password">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="mb-2 relative">
                    <label for="password" class="block text-sm font-medium mb-1">{{ __('layouts.new_password') }}</label>
                    <input type="password" id="password" name="password" placeholder="{{ __('layouts.new_password') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none pr-10"
                        required>
                    <span class="absolute right-3 top-8 cursor-pointer toggle-password" toggle="#password">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="mb-2 relative">
                    <label for="password_confirmation"
                        class="block text-sm font-medium mb-1">{{ __('layouts.confirm_password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="{{ __('layouts.confirm_password') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none pr-10"
                        required>
                    <span class="absolute right-3 top-8 cursor-pointer toggle-password" toggle="#password_confirmation">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                    @error('password_confirmation')
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
    @push('scripts')
        <script>
            $(document).on('click', '.toggle-password', function() {
                var input = $($(this).attr('toggle'));
                var icon = $(this).find('i');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        </script>
    @endpush
@endsection
