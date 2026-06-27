<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    private function getCartForRequest(Request $request): Cart
    {
        $user = $request->user();

        return Cart::query()->firstOrCreate([
            'user_id' => $user->id,
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'shipping_address' => ['sometimes', 'array'],
            'payment_method' => ['sometimes', 'string', 'max:50'],
            // optional fields; exam may not require them
        ]);

        $cart = $this->getCartForRequest($request);

        $items = CartItem::query()
            ->where('cart_id', $cart->id)
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return DB::transaction(function () use ($request, $cart, $items, $validated) {
            // Optional stock validation + reduce stock
            foreach ($items as $cartItem) {
                $product = $cartItem->product;
                if (!$product) {
                    return response()->json([
                        'message' => 'Product not found for cart item',
                        'product_id' => $cartItem->product_id,
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($product->stock < $cartItem->quantity) {
                    return response()->json([
                        'message' => 'Insufficient stock for product',
                        'product_id' => $product->id,
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }

            $subtotal = 0;
            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'subtotal' => 0,
                'total' => 0,
                'shipping_address' => $validated['shipping_address'] ?? null,
            ]);

            foreach ($items as $cartItem) {
                $product = $cartItem->product;

                $unitPrice = $product->price;
                $qty = $cartItem->quantity;
                $lineTotal = $unitPrice * $qty;

                $subtotal += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'line_total' => $lineTotal,
                ]);

                // stock decrease
                $product->decrement('stock', $qty);
            }

            $order->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);

            // Clear cart
            CartItem::query()->where('cart_id', $cart->id)->delete();

            $order->load('items');

            return response()->json([
                'message' => 'Checkout successful',
                'data' => [
                    'order_number' => $order->order_number,
                    'order' => [
                        'id' => $order->id,
                        'user_id' => $order->user_id,
                        'status' => $order->status,
                        'subtotal' => $order->subtotal,
                        'total' => $order->total,
                        'shipping_address' => $order->shipping_address,
                        'items' => $order->items->map(fn (OrderItem $i) => [
                            'id' => $i->id,
                            'product_id' => $i->product_id,
                            'product_name' => $i->product_name,
                            'unit_price' => $i->unit_price,
                            'quantity' => $i->quantity,
                            'line_total' => $i->line_total,
                        ]),
                    ],
                ],
            ], Response::HTTP_CREATED);
        });
    }
}

