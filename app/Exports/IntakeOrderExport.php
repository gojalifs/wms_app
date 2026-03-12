<?php

namespace App\Exports;

use App\Models\IntakeOrder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IntakeOrderExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private readonly ?string $dateFrom,
        private readonly ?string $dateTo,
        private readonly ?string $supplier,
    ) {}

    public function query()
    {
        $query = IntakeOrder::with('user', 'items.material')
            ->orderBy('received_at')
            ->orderBy('reference_no');

        if ($this->dateFrom) {
            $query->whereDate('received_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('received_at', '<=', $this->dateTo);
        }
        if ($this->supplier) {
            $query->where('supplier', 'like', '%' . $this->supplier . '%');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No. Referensi',
            'Pemasok',
            'Tanggal Penerimaan',
            'Kode Material',
            'Nama Material',
            'Satuan',
            'Jumlah',
            'Harga Satuan',
            'Subtotal',
            'Catatan',
            'Dibuat Oleh',
        ];
    }

    public function map($order): array
    {
        $rows = [];

        foreach ($order->items as $item) {
            $rows[] = [
                $order->reference_no,
                $order->supplier,
                $order->received_at->format('d/m/Y'),
                $item->material->code,
                $item->material->name,
                $item->material->unit,
                $item->quantity,
                $item->unit_price ?? '',
                $item->unit_price ? $item->quantity * $item->unit_price : '',
                $order->notes ?? '',
                $order->user->name,
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Penerimaan Material';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
