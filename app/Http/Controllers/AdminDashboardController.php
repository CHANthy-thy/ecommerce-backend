<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_categories' => Category::query()->count(),
            'total_products' => Product::query()->count(),
            'total_orders' => Order::query()->count(),
            'total_users' => User::query()->count(),
        ];

        return view('admin.dashboard', $stats);
    }
}

