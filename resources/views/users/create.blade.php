<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('wms.users.create') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('wms.users.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('wms.users.email') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Peran --}}
                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('wms.users.role') }} <span class="text-red-500">*</span>
                            </label>
                            <select id="role" name="role" required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 @error('role') border-red-500 @enderror">
                                <option value="">{{ __('wms.users.select_role') }}</option>
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>{{ __('wms.users.role_user') }}</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>{{ __('wms.users.role_admin') }}</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <p class="text-xs text-gray-500 mb-4">{{ __('wms.users.temp_password_info') }}</p>

                        <div class="flex items-center gap-3">
                            <button type="submit"
                                    class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                                {{ __('wms.users.add') }}
                            </button>
                            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:underline">
                                {{ __('wms.general.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
