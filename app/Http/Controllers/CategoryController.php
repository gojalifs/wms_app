<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('materials')->latest()->paginate(15);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string',
            ]);

            Category::create($validated);
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', __('wms.categories.error_create', ['message' => $e->getMessage()]));
        }

        return redirect()->route('categories.index')
            ->with('success', __('wms.categories.created'));
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'nullable|string',
            ]);

            $category->update($validated);
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', __('wms.categories.error_update', ['message' => $e->getMessage()]));
        }

        return redirect()->route('categories.index')
            ->with('success', __('wms.categories.updated'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            if ($category->materials()->exists()) {
                return back()->with('error', __('wms.categories.delete_has_materials'));
            }

            $category->delete();
        } catch (\Throwable $e) {
            return back()->with('error', __('wms.categories.error_delete', ['message' => $e->getMessage()]));
        }

        return redirect()->route('categories.index')
            ->with('success', __('wms.categories.deleted'));
    }
}
