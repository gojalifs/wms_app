<?php

namespace App\Exports;

use App\Models\OutgoingOrder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OutgoingOrderExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private readonly ?string $dateFrom,
        private readonly ?string $dateTo,
        private readonly ?string $department,
    ) {}

    public function query()
    {
        $query = OutgoingOrder::with('user', 'items.material')
            ->orderBy('issued_at')
            ->orderBy('reference_no');

        if ($this->dateFrom) {
            $query->whereDate('issued_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('issued_at', '<=', $this->dateTo);
        }
        if ($this->department) {
            $query->where('department', 'like', '%' . $this->department . '%');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No. Referensi',
            'Departemen / Lini Produksi',
            'Tanggal Pengeluaran',
            'Kode Material',
            'Nama Material',
            'Satuan',
            'Jumlah',
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
                $order->department,
                $order->issued_at->format('d/m/Y'),
                $item->material->code,
                $item->material->name,
                $item->material->unit,
                $item->quantity,
                $order->notes ?? '',
                $order->user->name,
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Pengeluaran Material';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
