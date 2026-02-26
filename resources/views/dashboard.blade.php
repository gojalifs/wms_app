<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('wms.dashboard.title') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Total Material --}}
                <div class="bg-white rounded-lg shadow-sm p-6 flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('wms.dashboard.total_materials') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalMaterials) }}</p>
                        <p class="text-xs text-gray-400">{{ __('wms.dashboard.items_unit') }}</p>
                    </div>
                </div>

                {{-- Stok Rendah --}}
                <div class="bg-white rounded-lg shadow-sm p-6 flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 {{ $lowStockCount > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 {{ $lowStockCount > 0 ? 'text-red-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('wms.dashboard.low_stock') }}</p>
                        <p class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ number_format($lowStockCount) }}
                        </p>
                        <a href="{{ route('inventory.index', ['low_stock' => 1]) }}"
                           class="text-xs text-indigo-500 hover:underline">{{ __('wms.dashboard.view_all') }}</a>
                    </div>
                </div>

                {{-- Penerimaan Bulan Ini --}}
                <div class="bg-white rounded-lg shadow-sm p-6 flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('wms.dashboard.intake_this_month') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($intakeThisMonth) }}</p>
                        <p class="text-xs text-gray-400">{{ __('wms.dashboard.orders_unit') }}</p>
                    </div>
                </div>

                {{-- Pengeluaran Bulan Ini --}}
                <div class="bg-white rounded-lg shadow-sm p-6 flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8V4m0 0l4 4m-4-4l-4 4M7 16v4m0 0l-4-4m4 4l4-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('wms.dashboard.outgoing_this_month') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($outgoingThisMonth) }}</p>
                        <p class="text-xs text-gray-400">{{ __('wms.dashboard.orders_unit') }}</p>
                    </div>
                </div>

            </div>

            {{-- Recent Activity --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Penerimaan Terbaru --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-700">{{ __('wms.dashboard.recent_intakes') }}</h3>
                        <a href="{{ route('intake.index') }}"
                           class="text-xs text-indigo-500 hover:underline">{{ __('wms.dashboard.view_all') }}</a>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @forelse ($recentIntakes as $intake)
                            <li class="px-6 py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 font-mono">{{ $intake->reference_no }}</p>
                                    <p class="text-xs text-gray-500">{{ $intake->supplier }} &middot; {{ $intake->received_at->format('d M Y') }}</p>
                                </div>
                                <a href="{{ route('intake.show', $intake) }}"
                                   class="text-xs text-indigo-600 hover:underline">{{ __('wms.general.view') }}</a>
                            </li>
                        @empty
                            <li class="px-6 py-4 text-sm text-gray-400 text-center">{{ __('wms.dashboard.no_recent_intakes') }}</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Pengeluaran Terbaru --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-700">{{ __('wms.dashboard.recent_outgoings') }}</h3>
                        <a href="{{ route('outgoing.index') }}"
                           class="text-xs text-indigo-500 hover:underline">{{ __('wms.dashboard.view_all') }}</a>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @forelse ($recentOutgoings as $outgoing)
                            <li class="px-6 py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 font-mono">{{ $outgoing->reference_no }}</p>
                                    <p class="text-xs text-gray-500">{{ $outgoing->department }} &middot; {{ $outgoing->issued_at->format('d M Y') }}</p>
                                </div>
                                <a href="{{ route('outgoing.show', $outgoing) }}"
                                   class="text-xs text-indigo-600 hover:underline">{{ __('wms.general.view') }}</a>
                            </li>
                        @empty
                            <li class="px-6 py-4 text-sm text-gray-400 text-center">{{ __('wms.dashboard.no_recent_outgoings') }}</li>
                        @endforelse
                    </ul>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
