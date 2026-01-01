<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\Product;
use App\Models\Backend\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')->with('category', 'subCategory');
        $this->applyFilters($query, $request);
        $products = $query->paginate(12);
        $categories = Category::where('status', 'active')->with('subCategories')->get();

        // Get price range data with safe defaults
        $minPrice = Product::where('status', 'active')->min('regular_price');
        $maxPrice = Product::where('status', 'active')->max('regular_price');

        // Set defaults if no products
        $minPrice = $minPrice ? floor($minPrice) : 0;
        $maxPrice = $maxPrice ? ceil($maxPrice) : 1000;

        // Current price values from request or defaults
        $currentMin = $request->get('min_price', $minPrice);
        $currentMax = $request->get('max_price', $maxPrice);

        $allSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        $allColors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Gray', 'Navy', 'Maroon', 'Beige', 'Purple', 'Pink'];

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('frontend.partials.products-grid', compact('products'))->render(),
                'count' => $products->total(),
                'firstItem' => $products->firstItem() ?? 0,
                'lastItem' => $products->lastItem() ?? 0
            ]);
        }

        return view('frontend.shop', compact(
            'products', 'categories', 'minPrice', 'maxPrice',
            'currentMin', 'currentMax', 'allSizes', 'allColors'
        ));
    }

    private function applyFilters($query, $request)
    {
        // Search
        if ($request->has('search') && !empty(trim($request->search))) {
            $query->where('name', 'like', '%' . trim($request->search) . '%');
        }

        // Category
        if ($request->has('category') && !empty($request->category) && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Subcategory
        if ($request->has('subcategory') && !empty($request->subcategory) && $request->subcategory != 'all') {
            $query->where('sub_category_id', $request->subcategory);
        }

         // Price filter - only apply if values are provided and valid
        if ($request->has('min_price') && $request->has('max_price') &&
            is_numeric($request->min_price) && is_numeric($request->max_price) &&
            $request->min_price > 0 && $request->max_price > 0) {

            $query->whereBetween('regular_price', [
                floatval($request->min_price),
                floatval($request->max_price)
            ]);
        }

        // Size
        if ($request->has('size') && !empty($request->size)) {
            $sizes = explode(',', $request->size);
            $validSizes = array_filter($sizes);
            if (!empty($validSizes)) {
                $query->where(function($q) use ($validSizes) {
                    foreach ($validSizes as $size) {
                        $q->orWhereJsonContains('sizes', strtoupper(trim($size)));
                    }
                });
            }
        }

        // Color
        if ($request->has('color') && !empty($request->color)) {
            $colors = explode(',', $request->color);
            $validColors = array_filter($colors);
            if (!empty($validColors)) {
                $query->where(function($q) use ($validColors) {
                    foreach ($validColors as $color) {
                        $q->orWhereJsonContains('colors', ucfirst(trim($color)));
                    }
                });
            }
        }

        // Sort
        switch ($request->get('sort', 'latest')) {
            case 'price_asc': $query->orderBy('regular_price', 'asc'); break;
            case 'price_desc': $query->orderBy('regular_price', 'desc'); break;
            case 'name_asc': $query->orderBy('name', 'asc'); break;
            case 'name_desc': $query->orderBy('name', 'desc'); break;
            default: $query->latest(); break;
        }
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with('category', 'subCategory')
            ->firstOrFail();

        $related_products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('frontend.product-details', compact('product', 'related_products'));
    }
}
