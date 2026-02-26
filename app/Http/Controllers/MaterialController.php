<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        $materials = Material::with('category')->latest()->paginate(15);

        return view('materials.index', compact('materials'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('materials.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'code'        => 'required|string|max:50|unique:materials,code',
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'unit'        => 'required|string|max:50',
                'min_stock'   => 'required|integer|min:0',
            ]);

            Material::create($validated);
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', __('wms.materials.error_create', ['message' => $e->getMessage()]));
        }

        return redirect()->route('materials.index')
            ->with('success', __('wms.materials.created'));
    }

    public function show(Material $material): View
    {
        $material->load('category', 'inventory');

        return view('materials.show', compact('material'));
    }

    public function edit(Material $material): View
    {
        $categories = Category::orderBy('name')->get();

        return view('materials.edit', compact('material', 'categories'));
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'code'        => 'required|string|max:50|unique:materials,code,' . $material->id,
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'unit'        => 'required|string|max:50',
                'min_stock'   => 'required|integer|min:0',
            ]);

            $material->update($validated);
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', __('wms.materials.error_update', ['message' => $e->getMessage()]));
        }

        return redirect()->route('materials.index')
            ->with('success', __('wms.materials.updated'));
    }

    public function destroy(Material $material): RedirectResponse
    {
        try {
            $material->delete();
        } catch (\Throwable $e) {
            return back()->with('error', __('wms.materials.error_delete', ['message' => $e->getMessage()]));
        }

        return redirect()->route('materials.index')
            ->with('success', __('wms.materials.deleted'));
    }
}
