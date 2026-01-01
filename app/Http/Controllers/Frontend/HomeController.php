<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\Product;
use App\Models\Backend\Banner;
use App\Models\Backend\DiscountBanner;
use App\Models\Backend\Service;
use App\Models\Backend\InstagramPost;

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
            ->where('is_featured', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        $hot_trend_products = Product::with('category')
            ->where('status', 'active')
            ->where('is_hot_trend', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        $best_seller_products = Product::with('category')
            ->where('status', 'active')
            ->where('is_best_seller', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        $banners = Banner::active()->ordered()->get();

        // FIX 2: Remove ordered() and use latest()
        $discount_banners = DiscountBanner::where('is_active', true)
                    ->latest()
                    ->take(5) // Show max 5 discount banners
                    ->get();
        $services = Service::active()->ordered()->take(4)->get();
        $instagram_posts = InstagramPost::active()
                ->ordered()
                ->take(12) // Take more for slider
                ->get();

        return view('frontend.index', compact(
            'categories',
            'new_products',
            'featured_products',
            'hot_trend_products',
            'best_seller_products',
            'banners',
            'discount_banners',
            'services',
            'instagram_posts'
        ));
    }
}
