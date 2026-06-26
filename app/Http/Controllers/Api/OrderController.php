<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->with('items')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'message' => 'Orders fetched successfully',
            'data' => $orders->map(function (Order $order) {
                return [
                    'id' => $order->id,
                    'status' => $order->status,
                    'subtotal' => $order->subtotal,
                    'total' => $order->total,
                    'shipping_address' => $order->shipping_address,
                    'created_at' => optional($order->created_at)->toISOString(),
                    'items' => $order->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product_name,
                            'unit_price' => $item->unit_price,
                            'quantity' => $item->quantity,
                            'line_total' => $item->line_total,
                        ];
                    }),
                ];
            }),
        ], Response::HTTP_OK);
    }

    public function show(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $order = Order::query()
            ->where('user_id', $request->user()->id)
            ->with('items')
            ->findOrFail($id);

        return response()->json([
            'message' => 'Order fetched successfully',
            'data' => [
                'id' => $order->id,
                'status' => $order->status,
                'subtotal' => $order->subtotal,
                'total' => $order->total,
                'shipping_address' => $order->shipping_address,
                'created_at' => optional($order->created_at)->toISOString(),
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'unit_price' => $item->unit_price,
                        'quantity' => $item->quantity,
                        'line_total' => $item->line_total,
                    ];
                }),
            ],
        ], Response::HTTP_OK);
    }
}

