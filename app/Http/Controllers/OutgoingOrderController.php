<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Material;
use App\Models\OutgoingOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OutgoingOrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = OutgoingOrder::with('user')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('reference_no', 'like', '%' . $request->search . '%')
                    ->orWhere('department', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('outgoing.index', compact('orders'));
    }

    public function create(): View
    {
        $materials = Material::with('inventory')->orderBy('name')->get();

        return view('outgoing.create', compact('materials'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'department'             => 'required|string|max:255',
                'issued_at'              => 'required|date',
                'notes'                  => 'nullable|string',
                'items'                  => 'required|array|min:1',
                'items.*.material_id'    => 'required|exists:materials,id',
                'items.*.quantity'       => 'required|integer|min:1',
            ]);

            DB::transaction(function () use ($validated, $request) {
                $order = OutgoingOrder::create([
                    'reference_no' => OutgoingOrder::generateReferenceNo(),
                    'department'   => $validated['department'],
                    'issued_at'    => $validated['issued_at'],
                    'user_id'      => $request->user()->id,
                    'notes'        => $validated['notes'] ?? null,
                ]);

                foreach ($validated['items'] as $item) {
                    $order->items()->create($item);

                    $inventory = Inventory::where('material_id', $item['material_id'])->firstOrFail();
                    $inventory->deductStock($item['quantity']);
                }
            });
        } catch (\RuntimeException $e) {
            // Stok tidak mencukupi — pesan untuk pengguna
            return back()->withInput()
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', __('wms.outgoing.error_create', ['message' => $e->getMessage()]));
        }

        return redirect()->route('outgoing.index')
            ->with('success', __('wms.outgoing.created'));
    }

    public function show(OutgoingOrder $outgoing): View
    {
        $outgoing->load('user', 'items.material');

        return view('outgoing.show', compact('outgoing'));
    }
}
