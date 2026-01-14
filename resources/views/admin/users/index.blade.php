@extends('layouts.master')
@section('content')

    <div class="container mx-auto p-6">
        <div
            class="bg-white shadow rounded-lg p-6">
            @if ($errors->any())
                <div class="mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
                <h2 class="text-xl font-bold mb-4">
                    {{-- User List --}}
                    {{ __('layouts.user_list') }}
                </h2>

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- @permission('user.create') --}}
                    {{-- Create User --}}
                    <a href="{{ route('user.create') }}"
                        class="inline-block w-50 px-6 py-3 my-6 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                        {{-- Create User --}}
                        {{ __('layouts.create_user') }}
                    </a>
                {{-- @endpermission --}}

                <div class="overflow-x-auto">
                    <table id="allDataTable" class="min-w-full bg-white shadow-md rounded my-4">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left">{{ __('layouts.name') }}</th>
                                <th class="py-2 px-4 text-left">{{ __('layouts.email') }}</th>
                                <th class="py-2 px-4 text-left">{{ __('layouts.username') }}</th>
                                <th class="py-2 px-4 text-left">{{ __('layouts.role') }}</th>
                                <th class="py-2 px-4 text-left">{{ __('layouts.status') }}</th>
                                <th class="py-2 px-4 text-left">{{ __('layouts.created_at') }}</th>
                                @if((auth()->user()->hasPermission('users.edit')) || (auth()->user()->hasPermission('users.destroy')))
                                    <th class="py-2 px-4 text-left">{{ __('layouts.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $user->name }}</td>
                                    <td class="py-2 px-4">{{ $user->email }}</td>
                                    <td class="py-2 px-4">{{ $user->username }}</td>
                                    <td class="py-2 px-4">{{ $user->role->name }}</td>
                                    <td class="py-2 px-4">
                                        {{ $user->status
                                            ? // 'Active'
                                            __('layouts.active')
                                            : // 'Inactive'
                                            __('layouts.inactive') }}
                                    </td>
                                    <td class="py-2 px-4">{{ $user->created_at->format('Y-m-d') }}</td>
                                    @if((auth()->user()->hasPermission('users.edit')) || (auth()->user()->hasPermission('users.destroy')))
                                        <td class="py-2 px-4">
                                            @if((auth()->user()->hasPermission('users.edit')))
                                            <a title="{{ __('layouts.edit') }}" href="{{ route('users.edit', $user) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                                <i class="fa-solid fa-pencil w-3 h-3"></i>
                                            </a>
                                            @endif
                                            {{-- <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500">
                                                    {{ __('layouts.delete') }}
                                                </button>
                                            </form> --}}
                                            @if((auth()->user()->hasPermission('users.destroy')))
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                                    id="deleteForm">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="{{ __('layouts.delete') }}" type="button"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200"
                                                        onclick="confirmDelete()">
                                                        <i class="fa-solid fa-trash w-3 h-3"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
