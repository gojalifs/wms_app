<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('wms.categories.edit') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
                    @csrf @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            {{ __('wms.categories.name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('wms.categories.description') }}</label>
                        <textarea name="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $category->description) }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                            {{ __('wms.general.update') }}
                        </button>
                        <a href="{{ route('categories.index') }}"
                           class="text-sm text-gray-600 hover:underline">{{ __('wms.general.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
