<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('wms.inventory.title') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filters --}}
            <form method="GET" action="{{ route('inventory.index') }}" class="mb-4 flex items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('wms.inventory.search_placeholder') }}"
                    class="w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <label class="flex items-center gap-1 text-sm text-gray-700">
                    <input type="checkbox" name="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600">
                    {{ __('wms.inventory.low_stock_only') }}
                </label>
                <button type="submit"
                    class="px-3 py-2 bg-gray-700 text-white text-sm rounded-md hover:bg-gray-600">{{ __('wms.general.filter') }}</button>
                @if (request('search') || request('low_stock'))
                    <a href="{{ route('inventory.index') }}"
                        class="text-sm text-gray-500 hover:underline">{{ __('wms.general.reset') }}</a>
                @endif
            </form>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.inventory.code') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.inventory.name') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.inventory.category') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.inventory.unit') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.inventory.stock') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.inventory.min_stock') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.inventory.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($inventories as $inventory)
                            @php $isLow = $inventory->quantity <= $inventory->material->min_stock; @endphp
                            <tr class="{{ $isLow ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4 text-sm font-mono text-gray-700">{{ $inventory->material->code }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    <a href="{{ route('inventory.show', $inventory->material) }}"
                                        class="hover:text-indigo-600">{{ $inventory->material->name }}</a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $inventory->material->category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $inventory->material->unit }}</td>
                                <td
                                    class="px-6 py-4 text-sm font-semibold text-right {{ $isLow ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ number_format($inventory->quantity) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-gray-500">
                                    {{ number_format($inventory->material->min_stock) }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($isLow)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">
                                            {{ __('wms.inventory.status_low') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                                            {{ __('wms.inventory.status_ok') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                                    {{ __('wms.inventory.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $inventories->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>