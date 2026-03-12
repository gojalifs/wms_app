<?php

namespace App\Http\Controllers;

use App\Exports\IntakeOrderExport;
use App\Exports\InventoryExport;
use App\Exports\OutgoingOrderExport;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('reports.index', compact('categories'));
    }

    public function exportIntake(Request $request): BinaryFileResponse
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to'   => 'nullable|date|after_or_equal:date_from',
            'supplier'  => 'nullable|string|max:255',
        ]);

        $filename = 'laporan-penerimaan-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new IntakeOrderExport(
                $request->date_from,
                $request->date_to,
                $request->supplier,
            ),
            $filename
        );
    }

    public function exportOutgoing(Request $request): BinaryFileResponse
    {
        $request->validate([
            'date_from'  => 'nullable|date',
            'date_to'    => 'nullable|date|after_or_equal:date_from',
            'department' => 'nullable|string|max:255',
        ]);

        $filename = 'laporan-pengeluaran-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new OutgoingOrderExport(
                $request->date_from,
                $request->date_to,
                $request->department,
            ),
            $filename
        );
    }

    public function exportInventory(Request $request): BinaryFileResponse
    {
        $request->validate([
            'category'   => 'nullable|string|max:255',
            'low_stock'  => 'nullable|boolean',
        ]);

        $filename = 'laporan-inventaris-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new InventoryExport(
                $request->category,
                (bool) $request->low_stock,
            ),
            $filename
        );
    }
}
