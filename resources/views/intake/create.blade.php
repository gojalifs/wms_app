<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('wms.intake.new') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" id="intake-form" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('wms.intake.supplier') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="supplier" value="{{ old('supplier') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm @error('supplier') border-red-500 @enderror">
                            @error('supplier')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('wms.intake.received_at') }}
                                <span class="text-red-500">*</span></label>
                            <input type="date" name="received_at"
                                value="{{ old('received_at', today()->toDateString()) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm @error('received_at') border-red-500 @enderror">
                            @error('received_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('wms.general.notes') }}</label>
                        <textarea name="notes" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Items --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('wms.general.items') }} <span
                                    class="text-red-500">*</span></label>
                            <button type="button" id="add-row"
                                class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">{{ __('wms.general.add_item') }}</button>
                        </div>
                        @error('items')<p class="mb-2 text-sm text-red-600">{{ $message }}</p>@enderror

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm border border-gray-200 rounded-md">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-medium text-gray-600">
                                            {{ __('wms.intake.material') }}
                                        </th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-600 w-28">
                                            {{ __('wms.intake.qty') }}
                                        </th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-600 w-36">
                                            {{ __('wms.intake.unit_price') }}
                                        </th>
                                        <th class="px-3 py-2 w-10"></th>
                                    </tr>
                                </thead>
                                <tbody id="items-body">
                                    <tr class="item-row">
                                        <td class="px-3 py-2">
                                            <select name="items[0][material_id]"
                                                class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                                <option value="">-- Select --</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->code }} —
                                                        {{ $material->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="number" name="items[0][quantity]" min="1" value="1"
                                                class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="number" name="items[0][unit_price]" min="0" step="0.01"
                                                placeholder="0.00"
                                                class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <button type="button"
                                                class="remove-row text-red-500 hover:text-red-700 font-bold">×</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                            {{ __('wms.general.submit') }}
                        </button>
                        <a href="{{ route('intake.index') }}"
                            class="text-sm text-gray-600 hover:underline">{{ __('wms.general.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const materialsOptions = `@foreach ($materials as $m)<option value="{{ $m->id }}">{{ $m->code }} — {{ addslashes($m->name) }}</option>@endforeach`;
        let rowIndex = 1;

        document.getElementById('add-row').addEventListener('click', () => {
            const tbody = document.getElementById('items-body');
            const tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML = `
                <td class="px-3 py-2">
                    <select name="items[${rowIndex}][material_id]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        <option value="">-- Select --</option>${materialsOptions}
                    </select>
                </td>
                <td class="px-3 py-2">
                    <input type="number" name="items[${rowIndex}][quantity]" min="1" value="1"
                           class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </td>
                <td class="px-3 py-2">
                    <input type="number" name="items[${rowIndex}][unit_price]" min="0" step="0.01" placeholder="0.00"
                           class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </td>
                <td class="px-3 py-2 text-center">
                    <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold">×</button>
                </td>`;
            tbody.appendChild(tr);
            rowIndex++;
        });

        document.getElementById('items-body').addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-row')) {
                const rows = document.querySelectorAll('.item-row');
                if (rows.length > 1) e.target.closest('tr').remove();
            }
        });
    </script>
</x-app-layout>