<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $intake->reference_no }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ __('wms.intake.title') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="px-4 py-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="px-4 py-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            {{-- Header Info --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <dl class="grid grid-cols-2 gap-x-4 gap-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('wms.intake.supplier') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $intake->supplier }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('wms.intake.received_at') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $intake->received_at->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('wms.general.created_by') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $intake->user->name }}</dd>
                    </div>
                    @if ($intake->notes)
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">{{ __('wms.general.notes') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $intake->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Items --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700">{{ __('wms.general.items') }}</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.intake.material') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.intake.code') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.intake.qty') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.intake.unit_price') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                {{ __('wms.intake.subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($intake->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item->material->name }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-gray-500">{{ $item->material->code }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-900">
                                    {{ number_format($item->quantity) }} {{ $item->material->unit }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-gray-500">
                                    {{ $item->unit_price ? number_format($item->unit_price, 2) : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-gray-900">
                                    {{ $item->unit_price ? number_format($item->quantity * $item->unit_price, 2) : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('intake.index') }}"
                class="text-sm text-gray-600 hover:underline">{{ __('wms.intake.back') }}</a>
        </div>
    </div>
</x-app-layout>