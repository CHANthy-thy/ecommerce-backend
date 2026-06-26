<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->with('items');

        $search = $request->string('search')->trim();
        if ($search->isNotEmpty()) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders', 'search'));
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,processing,completed,cancelled'],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}

