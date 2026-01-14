@extends('layouts.master')
@section('content')
    <div class="min-h-[60vh] flex items-center">
        <div
            class="w-[65%] mx-auto p-6 border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border ">
            <h2 class="text-xl font-bold margin-b-8rem">
                {{ __('validation.settings_title') }}
            </h2>

            <form action="{{ route('admin.ftpsettingsupdate') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Host --}}
                <div>
                    <label for="host" class="block mb-1 font-medium">{{ __('ftp_settings_page.host') }}</label>
                    <input type="text" id="host" name="host" value="{{ old('host', $settings->host) }}"
                        placeholder="{{ __('ftp_settings_page.host') }}"
                        class="w-full mb-2 p-2 border rounded @error('host') border-red-500 @enderror" required>
                    @error('host')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Port --}}
                <div>
                    <label for="port" class="block mb-1 font-medium">{{ __('ftp_settings_page.port') }}</label>
                    <input type="number" id="port" name="port" value="{{ old('port', $settings->port) }}"
                        placeholder="{{ __('ftp_settings_page.port') }}"
                        class="w-full mb-2 p-2 border rounded @error('port') border-red-500 @enderror" required>
                    @error('port')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Username --}}
                <div>
                    <label for="username" class="block mb-1 font-medium">{{ __('ftp_settings_page.username') }}</label>
                    <input type="text" id="username" name="username" value="{{ old('username', $settings->username) }}"
                        placeholder="{{ __('ftp_settings_page.username') }}"
                        class="w-full mb-2 p-2 border rounded @error('username') border-red-500 @enderror" required>
                    @error('username')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-1 font-medium">{{ __('ftp_settings_page.password') }}</label>
                    <input type="text" id="password" name="password" value="{{ old('password', $settings->password) }}" placeholder="{{ __('ftp_settings_page.password') }}"
                        class="w-full mb-2 p-2 border rounded @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Root --}}
                <div>
                    <label for="root" class="block mb-1 font-medium">{{ __('ftp_settings_page.root') }}</label>
                    <input type="text" id="root" name="root" value="{{ old('root', $settings->root) }}"
                        placeholder="{{ __('ftp_settings_page.root') }}"
                        class="w-full mb-2 p-2 border rounded @error('root') border-red-500 @enderror" required>
                    @error('root')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Driver --}}
                <div>
                    <label for="driver" class="block mb-1 font-medium">{{ __('ftp_settings_page.driver') }}</label>
                    <select id="driver" name="driver"
                        class="w-full mb-2 p-2 border rounded @error('driver') border-red-500 @enderror" required>
                        <option value="sftp" {{ old('driver', $settings->driver) === 'sftp' ? 'selected' : '' }}>SFTP
                        </option>
                        <option value="ftp" {{ old('driver', $settings->driver) === 'ftp' ? 'selected' : '' }}>FTP
                        </option>
                        <option value="public" {{ old('driver', $settings->driver) === 'public' ? 'selected' : '' }}>Project Directory
                        </option>
                    </select>
                    @error('driver')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Timeout --}}
                <div>
                    <label for="timeout" class="block mb-1 font-medium">{{ __('ftp_settings_page.timeout') }}</label>
                    <input type="number" id="timeout" name="timeout" value="{{ old('timeout', $settings->timeout) }}"
                        placeholder="{{ __('ftp_settings_page.timeout') }}"
                        class="w-full mb-2 p-2 border rounded @error('timeout') border-red-500 @enderror" required>
                    @error('timeout')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="inline-block w-32 text-md px-2 py-2 font-bold text-white transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-lg">
                        {{ __('ftp_settings_page.update_settings') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
