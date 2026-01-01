<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::with('category')->latest()->paginate(10);
        return view('backend.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('backend.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Sub-category created successfully.');
    }

    public function show(SubCategory $subcategory)
    {
        return view('backend.subcategories.show', compact('subcategory'));
    }

    public function edit(SubCategory $subcategory)
    {
        $categories = Category::where('status', 'active')->get();
        return view('backend.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name,' . $subcategory->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Sub-category updated successfully.');
    }

    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Sub-category deleted successfully.');
    }

    public function getByCategory($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->where('status', 'active')
            ->get();

        return response()->json($subcategories);
    }
}
