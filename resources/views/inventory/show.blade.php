<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $material->name }}
                <span class="ml-2 text-sm font-mono text-gray-400">{{ $material->code }}</span>
            </h2>
            <a href="{{ route('inventory.index') }}"
                class="text-sm text-gray-600 hover:underline">{{ __('wms.inventory.back') }}</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stock Card --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase mb-4">{{ __('wms.inventory.current_stock') }}
                </h3>
                @if ($material->inventory)
                    @php $isLow = $material->inventory->quantity <= $material->min_stock; @endphp
                    <p class="text-4xl font-bold {{ $isLow ? 'text-red-600' : 'text-gray-900' }}">
                        {{ number_format($material->inventory->quantity) }}
                        <span class="text-xl font-normal text-gray-500">{{ $material->unit }}</span>
                    </p>
                    @if ($isLow)
                        <p class="mt-2 text-sm text-red-600 font-medium">
                            {{ __('wms.inventory.below_min', ['min' => $material->min_stock, 'unit' => $material->unit]) }}</p>
                    @else
                        <p class="mt-2 text-sm text-green-600">
                            {{ __('wms.inventory.stock_ok', ['min' => $material->min_stock, 'unit' => $material->unit]) }}</p>
                    @endif
                    <p class="mt-3 text-xs text-gray-400">
                        {{ __('wms.inventory.last_updated', ['time' => $material->inventory->updated_at->diffForHumans()]) }}
                    </p>
                @else
                    <p class="text-sm text-gray-400">{{ __('wms.inventory.no_record') }}</p>
                @endif
            </div>

            {{-- Material Details --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase mb-4">{{ __('wms.inventory.details') }}</h3>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('wms.materials.code') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $material->code }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('wms.materials.category') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $material->category->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('wms.materials.unit') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $material->unit }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('wms.materials.min_stock') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $material->min_stock }}</dd>
                    </div>
                    @if ($material->description)
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">{{ __('wms.materials.description') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $material->description }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

        </div>
    </div>
</x-app-layout>