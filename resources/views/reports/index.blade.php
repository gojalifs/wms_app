<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('wms.reports.title') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('error'))
                <div class="px-4 py-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            {{-- Laporan Penerimaan --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                    <h3 class="text-base font-semibold text-blue-800">{{ __('wms.reports.intake_title') }}</h3>
                    <p class="text-sm text-blue-600 mt-0.5">{{ __('wms.reports.intake_desc') }}</p>
                </div>
                <form method="GET" action="{{ route('reports.intake') }}" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('wms.reports.date_from') }}</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('wms.reports.date_to') }}</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('wms.reports.supplier_filter') }}</label>
                            <input type="text" name="supplier" value="{{ request('supplier') }}"
                                   placeholder="{{ __('wms.intake.supplier') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            {{ __('wms.reports.export_excel') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Laporan Pengeluaran --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-orange-50">
                    <h3 class="text-base font-semibold text-orange-800">{{ __('wms.reports.outgoing_title') }}</h3>
                    <p class="text-sm text-orange-600 mt-0.5">{{ __('wms.reports.outgoing_desc') }}</p>
                </div>
                <form method="GET" action="{{ route('reports.outgoing') }}" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('wms.reports.date_from') }}</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('wms.reports.date_to') }}</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('wms.reports.department_filter') }}</label>
                            <input type="text" name="department" value="{{ request('department') }}"
                                   placeholder="{{ __('wms.outgoing.department') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-orange-700 text-white text-sm font-medium rounded-md hover:bg-orange-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            {{ __('wms.reports.export_excel') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Laporan Inventaris --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
                    <h3 class="text-base font-semibold text-green-800">{{ __('wms.reports.inventory_title') }}</h3>
                    <p class="text-sm text-green-600 mt-0.5">{{ __('wms.reports.inventory_desc') }}</p>
                </div>
                <form method="GET" action="{{ route('reports.inventory') }}" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('wms.reports.category_filter') }}</label>
                            <select name="category"
                                    class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">{{ __('wms.reports.select_category') }}</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->name }}" {{ request('category') === $cat->name ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="low_stock" value="1"
                                       {{ request('low_stock') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                {{ __('wms.reports.low_stock_only') }}
                            </label>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-700 text-white text-sm font-medium rounded-md hover:bg-green-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            {{ __('wms.reports.export_excel') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
