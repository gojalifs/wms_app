<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private readonly ?string $category,
        private readonly bool $lowStockOnly,
    ) {}

    public function query()
    {
        $query = Inventory::with('material.category')
            ->join('materials', 'materials.id', '=', 'inventories.material_id')
            ->orderBy('materials.code')
            ->select('inventories.*');

        if ($this->category) {
            $query->whereHas('material.category', fn ($q) => $q->where('name', 'like', '%' . $this->category . '%'));
        }

        if ($this->lowStockOnly) {
            $query->whereColumn('inventories.quantity', '<=', 'materials.min_stock');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama Material',
            'Kategori',
            'Satuan',
            'Stok Saat Ini',
            'Stok Minimum',
            'Status',
            'Terakhir Diperbarui',
        ];
    }

    public function map($inventory): array
    {
        $isLow = $inventory->quantity <= $inventory->material->min_stock;

        return [
            $inventory->material->code,
            $inventory->material->name,
            $inventory->material->category->name,
            $inventory->material->unit,
            $inventory->quantity,
            $inventory->material->min_stock,
            $isLow ? 'Rendah' : 'OK',
            $inventory->updated_at->format('d/m/Y H:i'),
        ];
    }

    public function title(): string
    {
        return 'Inventaris';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
