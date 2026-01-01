<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\SubCategory;
use App\Models\Backend\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subCategory'])
            ->latest()
            ->paginate(10);
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        $subcategories = SubCategory::where('status', 'active')->get();
        $sizes = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Gray', 'Navy', 'Maroon', 'Beige', 'Purple', 'Pink'];

        return view('backend.products.create', compact('categories', 'subcategories', 'sizes', 'colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'regular_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:regular_price',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'string',
            'colors' => 'required|array|min:1',
            'colors.*' => 'string',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'is_featured' => 'boolean',        // Add this
            'is_hot_trend' => 'boolean',       // Add this
            'is_best_seller' => 'boolean',     // Add this
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'short_description' => $request->short_description,
            'regular_price' => $request->regular_price,
            'discount_price' => $request->discount_price,
            'stock_quantity' => $request->stock_quantity,
            'sku' => $request->sku ?? 'PROD-' . strtoupper(Str::random(8)),
            'sizes' => $request->sizes,
            'colors' => $request->colors,
            'images' => $imagePaths,
            'status' => $request->status,
            'featured' => $request->filled('featured'),
            'is_featured' => $request->filled('is_featured'),      // Add this
            'is_hot_trend' => $request->filled('is_hot_trend'),    // Add this
            'is_best_seller' => $request->filled('is_best_seller'),// Add this
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'subCategory']);
        return view('backend.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        $subcategories = SubCategory::where('status', 'active')->get();
        $sizes = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Gray', 'Navy', 'Maroon', 'Beige', 'Purple', 'Pink'];

        return view('backend.products.edit', compact('product', 'categories', 'subcategories', 'sizes', 'colors'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'regular_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:regular_price',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'string',
            'colors' => 'required|array|min:1',
            'colors.*' => 'string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'is_featured' => 'boolean',        // Add this
            'is_hot_trend' => 'boolean',       // Add this
            'is_best_seller' => 'boolean',     // Add this
        ]);

        $imagePaths = $product->images;

        // Handle new image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            // Upload new images
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'short_description' => $request->short_description,
            'regular_price' => $request->regular_price,
            'discount_price' => $request->discount_price,
            'stock_quantity' => $request->stock_quantity,
            'sku' => $request->sku ?? $product->sku,
            'sizes' => $request->sizes,
            'colors' => $request->colors,
            'images' => $imagePaths,
            'status' => $request->status,
            'featured' => $request->filled('featured'),
            'is_featured' => $request->filled('is_featured'),      // Add this
            'is_hot_trend' => $request->filled('is_hot_trend'),    // Add this
            'is_best_seller' => $request->filled('is_best_seller'),// Add this
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete product images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product->update([
            'stock_quantity' => $request->stock_quantity,
            'status' => $request->stock_quantity > 0 ? 'active' : 'inactive',
        ]);

        return redirect()->back()
            ->with('success', 'Stock updated successfully.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $product->status
        ]);
    }
}
