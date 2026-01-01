<?php
// app/Http/Controllers/Frontend/HomeController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\Product;
use App\Models\Backend\Banner; // Add this line

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products' => function($query) {
            $query->where('status', 'active')->where('stock_quantity', '>', 0);
        }])
        ->where('status', 'active')
        ->get();

        $new_products = Product::with('category')
            ->where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        $featured_products = Product::with('category')
            ->where('status', 'active')
            ->where('featured', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        $best_sellers = Product::with('category')
            ->where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Get active banners ordered by order field
        $banners = Banner::active()->ordered()->get();

        return view('frontend.index', compact(
            'categories',
            'new_products',
            'featured_products',
            'best_sellers',
            'banners' // Add this
        ));
    }
}
