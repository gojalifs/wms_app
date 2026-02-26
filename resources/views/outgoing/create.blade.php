<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('wms.outgoing.new') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('outgoing.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('wms.outgoing.department') }}
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="department" value="{{ old('department') }}"
                                placeholder="{{ __('wms.outgoing.department_placeholder') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm @error('department') border-red-500 @enderror">
                            @error('department')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('wms.outgoing.issued_at') }}
                                <span class="text-red-500">*</span></label>
                            <input type="date" name="issued_at" value="{{ old('issued_at', today()->toDateString()) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm @error('issued_at') border-red-500 @enderror">
                            @error('issued_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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
                                            {{ __('wms.outgoing.stock') }}
                                        </th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-600 w-28">
                                            {{ __('wms.intake.qty') }}
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
                                                    <option value="{{ $material->id }}"
                                                        data-stock="{{ $material->inventory?->quantity ?? 0 }}"
                                                        data-unit="{{ $material->unit }}">
                                                        {{ $material->code }} — {{ $material->name }}
                                                        (stock: {{ $material->inventory?->quantity ?? 0 }}
                                                        {{ $material->unit }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-3 py-2 text-sm text-gray-500 stock-display">—</td>
                                        <td class="px-3 py-2">
                                            <input type="number" name="items[0][quantity]" min="1" value="1"
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
                        <a href="{{ route('outgoing.index') }}"
                            class="text-sm text-gray-600 hover:underline">{{ __('wms.general.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const materialsOptions = `@foreach ($materials as $m)<option value="{{ $m->id }}" data-stock="{{ $m->inventory?->quantity ?? 0 }}" data-unit="{{ $m->unit }}">{{ $m->code }} — {{ addslashes($m->name) }} (stock: {{ $m->inventory?->quantity ?? 0 }} {{ $m->unit }})</option>@endforeach`;
        let rowIndex = 1;

        function bindSelectChange(row) {
            row.querySelector('select').addEventListener('change', function () {
                const opt = this.options[this.selectedIndex];
                const stock = opt.dataset.stock ?? '—';
                const unit = opt.dataset.unit ?? '';
                row.querySelector('.stock-display').textContent = opt.value ? `${stock} ${unit}` : '—';
            });
        }

        bindSelectChange(document.querySelector('.item-row'));

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
                <td class="px-3 py-2 text-sm text-gray-500 stock-display">—</td>
                <td class="px-3 py-2">
                    <input type="number" name="items[${rowIndex}][quantity]" min="1" value="1"
                           class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </td>
                <td class="px-3 py-2 text-center">
                    <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold">×</button>
                </td>`;
            tbody.appendChild(tr);
            bindSelectChange(tr);
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