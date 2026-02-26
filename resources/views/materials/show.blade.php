<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $material->name }}
                <span class="ml-2 text-sm font-mono text-gray-400">{{ $material->code }}</span>
            </h2>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('materials.edit', $material) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                    {{ __('wms.general.edit') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase mb-4">{{ __('wms.materials.details') }}</h3>
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
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-gray-500">{{ __('wms.materials.description') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $material->description ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase mb-4">{{ __('wms.inventory.current_stock') }}</h3>
                @if ($material->inventory)
                    <p class="text-3xl font-bold text-gray-900">
                        {{ $material->inventory->quantity }}
                        <span class="text-lg font-normal text-gray-500">{{ $material->unit }}</span>
                    </p>
                    @if ($material->inventory->quantity <= $material->min_stock)
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ __('wms.materials.below_min_stock') }}</p>
                    @endif
                @else
                    <p class="text-sm text-gray-400">{{ __('wms.materials.no_inventory') }}</p>
                @endif
            </div>

            <div>
                <a href="{{ route('materials.index') }}" class="text-sm text-gray-600 hover:underline">{{ __('wms.materials.back') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
