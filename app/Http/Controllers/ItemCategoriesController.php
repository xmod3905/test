<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoriesController extends Controller
{
    public function index()
    {
        $categories = ItemCategory::orderBy('id')->get();

        return view('item_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        ItemCategory::create($validated);

        return redirect('item-categories');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $category = ItemCategory::findOrFail($id);
        $category->update($validated);

        return redirect('item-categories');
    }

    public function delete($id)
    {
        $category = ItemCategory::findOrFail($id);
        $category->delete();

        return redirect('item-categories');
    }
}