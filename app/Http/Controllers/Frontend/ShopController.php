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

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Subcategory filter
        if ($request->has('subcategory')) {
            $query->where('sub_category_id', $request->subcategory);
        }

        // Price filter
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('regular_price', [$request->min_price, $request->max_price]);
        }

        // Sort products
        switch ($request->get('sort', 'latest')) {
            case 'price_asc':
                $query->orderBy('regular_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('regular_price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::where('status', 'active')->with('subCategories')->get();

        return view('frontend.shop', compact('products', 'categories'));
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
