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

        return view('admin.dashboard', $dashboardData);
    }
}


