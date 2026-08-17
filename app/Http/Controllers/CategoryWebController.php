<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryWebController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->paginate(15);
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|unique:categories,slug',
        ]);

        Category::create($request->only(['name', 'slug']));

        return redirect()->route('category.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
        ]);

        $category->update($request->only(['name', 'slug']));

        return redirect()->route('category.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('status', 'Kategori berhasil dihapus.');
    }
}
