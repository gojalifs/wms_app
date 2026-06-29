<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('wms.materials.title') }}</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('wms.materials.code') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('wms.materials.name') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('wms.materials.category') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('wms.materials.unit') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('wms.materials.min_stock') }}</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($materials as $material)
                            <tr>
                                <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $material->code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $material->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $material->category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $material->unit }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $material->min_stock }}</td>
                                <td class="px-6 py-4 text-sm text-right space-x-2">
                                    <a href="{{ route('materials.show', $material) }}"
                                            class="text-gray-600 hover:text-gray-900">{{ __('wms.general.view') }}</a>
                                    @if (auth()->user()->isAdmin())
                                        <a href="{{ route('materials.edit', $material) }}"
                                                class="text-indigo-600 hover:text-indigo-900">{{ __('wms.general.edit') }}</a>
                                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline"
                                              onsubmit="return confirm('{{ __('wms.materials.confirm_delete') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('wms.general.delete') }}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">{{ __('wms.materials.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $materials->links() }}</div>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('materials.create') }}"
                        class="inline-flex items-center ml-4 mb-4 px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                        {{ __('wms.materials.add') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>