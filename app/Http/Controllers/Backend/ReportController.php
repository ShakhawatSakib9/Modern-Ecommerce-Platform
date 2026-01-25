<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Order;
use App\Models\Backend\Product;
use App\Models\Backend\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $timeRange = $request->get('time_range', 'month');

        // 1. Sales Statistics
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // 2. Sales Over Time (Chart Data)
        $salesData = $this->getSalesData($timeRange);

        // 3. Top Selling Products
        $topProducts = Product::withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw('sum(quantity)'));
        }])
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // 4. Inventory Insights
        $totalStock = Product::sum('stock_quantity');
        $lowStockCount = Product::where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10)->count();
        $outOfStockCount = Product::where('stock_quantity', '<=', 0)->count();

        // 5. Category Distribution
        $categoryStats = Category::withCount('products')->get();

        return view('backend.reports.index', compact(
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'salesData',
            'topProducts',
            'totalStock',
            'lowStockCount',
            'outOfStockCount',
            'categoryStats',
            'timeRange'
        ));
    }

    private function getSalesData($range)
    {
        $query = Order::where('status', '!=', 'cancelled');

        if ($range == 'week') {
            $startDate = Carbon::now()->startOfWeek();
            $dateFormat = '%W'; // Day name
            $groupBy = 'day';
        } elseif ($range == 'year') {
            $startDate = Carbon::now()->startOfYear();
            $dateFormat = '%M'; // Month name
            $groupBy = 'month';
        } else { // month default
            $startDate = Carbon::now()->startOfMonth();
            $dateFormat = '%d %M'; // Day of month
            $groupBy = 'day';
        }

        $results = $query->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date")
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return [
            'labels' => $results->pluck('date')->toArray(),
            'revenue' => $results->pluck('revenue')->toArray(),
            'orders' => $results->pluck('orders')->toArray(),
        ];
    }
}
