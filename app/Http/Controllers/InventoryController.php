<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Inventory::with('material.category')
            ->join('materials', 'inventories.material_id', '=', 'materials.id')
            ->select('inventories.*')
            ->orderBy('materials.name');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('materials.name', 'like', "%{$search}%")
                  ->orWhere('materials.code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('low_stock')) {
            $query->whereColumn('inventories.quantity', '<=', 'materials.min_stock');
        }

        $inventories = $query->paginate(20)->withQueryString();

        return view('inventory.index', compact('inventories'));
    }

    public function show(Material $material): View
    {
        $material->load('category', 'inventory');

        return view('inventory.show', compact('material'));
    }
}
