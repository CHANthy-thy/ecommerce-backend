<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{

    public function index(Request $request)
    {
        // Future-ready structure: $dashboardData can be extended for charts later.
        $dashboardData = [
            'stats' => [],
            'recentOrders' => collect(),
            'latestProducts' => collect(),
            'lowStockProducts' => collect(),
        ];

        $dashboardData['stats'] = [
            'total_categories' => Category::query()->count(),
            'total_brands' => Brand::query()->count(),
            'total_products' => Product::query()->count(),
            'total_users' => User::query()->count(),
            'total_orders' => Order::query()->count(),
            'pending_orders' => Order::query()->where('status', 'pending')->count(),
            'completed_orders' => Order::query()->where('status', 'completed')->count(),
            'in_stock_products' => Product::query()->where('stock', '>', 0)->count(),
            // Low stock products: stock <= 10 (includes out-of-stock)
            'low_stock_products' => Product::query()->where('stock', '<=', 10)->count(),
            'out_of_stock_products' => Product::query()->where('stock', '=', 0)->count(),
            'total_revenue' => (float) Order::query()
                ->where('status', 'completed')
                ->sum('total'),
        ];


        $dashboardData['recentOrders'] = Order::query()
            ->orderByDesc('created_at')
            ->with(['user'])
            ->limit(10)
            ->get()
            ->map(function (Order $order) {
                // Dashboard needs customer name even if relation is missing.
                $order->customer_name = optional($order->user)->name ?? '—';
                return $order;
            });

        $dashboardData['latestProducts'] = Product::query()
            ->with(['category', 'brand'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $dashboardData['lowStockProducts'] = Product::query()
            ->with(['category', 'brand'])
            ->where('stock', '<=', 10)
            ->orderByDesc('stock')
            ->get();

        $dashboardData['today_revenue'] = (float) Order::query()
            ->where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total');

        $dashboardData['month_revenue'] = (float) Order::query()
            ->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $dashboardData['paymentStatus'] = [
            'paid' => Order::query()->where('status', 'completed')->count(),
            'pending' => Order::query()->where('status', 'pending')->count(),
            'failed' => Order::query()->where('status', 'failed')->count(),
        ];

        $monthlyRaw = Order::query()
            ->selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $monthlySales = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlySales[] = (float) ($monthlyRaw[$m] ?? 0);
        }
        $dashboardData['monthlySales'] = $monthlySales;

        return view('admin.dashboard', $dashboardData);
    }
}


