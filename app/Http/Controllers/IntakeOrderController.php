<?php

namespace App\Http\Controllers;

use App\Models\IntakeOrder;
use App\Models\Inventory;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IntakeOrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = IntakeOrder::with('user')->latest();

        if ($request->filled('search')) {
            $query->where('reference_no', 'like', '%' . $request->search . '%')
                ->orWhere('supplier', 'like', '%' . $request->search . '%');
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('intake.index', compact('orders'));
    }

    public function create(): View
    {
        $materials = Material::orderBy('name')->get();

        return view('intake.create', compact('materials'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'supplier'               => 'required|string|max:255',
                'received_at'            => 'required|date',
                'notes'                  => 'nullable|string',
                'items'                  => 'required|array|min:1',
                'items.*.material_id'    => 'required|exists:materials,id',
                'items.*.quantity'       => 'required|integer|min:1',
                'items.*.unit_price'     => 'nullable|numeric|min:0',
            ]);

            DB::transaction(function () use ($validated, $request) {
                $order = IntakeOrder::create([
                    'reference_no' => IntakeOrder::generateReferenceNo(),
                    'supplier'     => $validated['supplier'],
                    'received_at'  => $validated['received_at'],
                    'user_id'      => $request->user()->id,
                    'notes'        => $validated['notes'] ?? null,
                ]);

                foreach ($validated['items'] as $item) {
                    $order->items()->create($item);

                    $inventory = Inventory::firstOrCreate(
                        ['material_id' => $item['material_id']],
                        ['quantity' => 0]
                    );
                    $inventory->addStock($item['quantity']);
                }
            });
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', __('wms.intake.error_create', ['message' => $e->getMessage()]));
        }

        return redirect()->route('intake.index')
            ->with('success', __('wms.intake.created'));
    }

    public function show(IntakeOrder $intake): View
    {
        $intake->load('user', 'items.material');

        return view('intake.show', compact('intake'));
    }
}
