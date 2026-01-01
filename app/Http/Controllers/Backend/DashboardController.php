<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Product;
use App\Models\Backend\Category;
use App\Models\Backend\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'confirmed_orders' => Order::where('status', 'confirmed')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', 'delivered')
                ->sum('total_amount'),
        ];

        // Recent orders
        $recent_orders = Order::with(['items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Low stock products
        $low_stock_products = Product::where('stock_quantity', '<=', 10)
            ->where('stock_quantity', '>', 0)
            ->orderBy('stock_quantity')
            ->take(5)
            ->get();

        // Out of stock products
        $out_of_stock_products = Product::where('stock_quantity', 0)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('backend.dashboard.index', compact(
            'stats',
            'recent_orders',
            'low_stock_products',
            'out_of_stock_products'
        ));
    }

    public function getChartData(Request $request)
    {
        // Get sales data for last 30 days
        $sales_data = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total_amount) as revenue')
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get order status distribution
        $status_data = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Get top selling products
        $top_products = \App\Models\Backend\OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'sales_data' => $sales_data,
            'status_data' => $status_data,
            'top_products' => $top_products,
        ]);
    }
}
