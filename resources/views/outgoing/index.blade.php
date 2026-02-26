<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('wms.outgoing.title') }}</h2>
            <a href="{{ route('outgoing.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                {{ __('wms.outgoing.new') }}
            </a>
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

            <form method="GET" action="{{ route('outgoing.index') }}" class="mb-4 flex items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('wms.outgoing.search_placeholder') }}"
                    class="w-64 rounded-md border-gray-300 shadow-sm text-sm">
                <button type="submit"
                    class="px-3 py-2 bg-gray-700 text-white text-sm rounded-md hover:bg-gray-600">{{ __('wms.general.search') }}</button>
                @if (request('search'))
                    <a href="{{ route('outgoing.index') }}"
                        class="text-sm text-gray-500 hover:underline">{{ __('wms.general.reset') }}</a>
                @endif
            </form>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.outgoing.reference_no') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.outgoing.department') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.outgoing.issued_at') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.general.created_by') }}
                            </th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $order->reference_no }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->department }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->issued_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <a href="{{ route('outgoing.show', $order) }}"
                                        class="text-indigo-600 hover:text-indigo-900">{{ __('wms.general.view') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-400">{{ __('wms.outgoing.no_data') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>