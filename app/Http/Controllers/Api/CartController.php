<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Http\Resources\ProductResource;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    private function getCartForRequest(Request $request): Cart
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        return Cart::query()->firstOrCreate([
            'user_id' => $user->id,
        ]);
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $cart = $this->getCartForRequest($request);

        $items = CartItem::query()
            ->where('cart_id', $cart->id)
            ->with('product.category')
            ->get();

        $data = $items->map(function (CartItem $item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => (int) $item->quantity,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'description' => $item->product->description,
                    'price' => $item->product->price,
                    'stock' => $item->product->stock,
                    'image' => $item->product->image ? asset('storage/' . $item->product->image) : null,
                    'category' => $item->product->category ? [
                        'id' => $item->product->category->id,
                        'name' => $item->product->category->name,
                    ] : null,
                ],
                'line_total' => $item->product->price * $item->quantity,
            ];
        });

        $subtotal = $data->sum('line_total');

        return response()->json([
            'message' => 'Cart fetched successfully',
            'data' => [
                'cart_id' => $cart->id,
                'items' => $data,
                'subtotal' => $subtotal,
            ],
        ], Response::HTTP_OK);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCartForRequest($request);

        $product = Product::query()->findOrFail($validated['product_id']);

        // Optional: stock validation
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'message' => 'Insufficient stock',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $item = CartItem::query()->firstOrCreate([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ], [
            'quantity' => 0,
        ]);

        $item->quantity = (int) $item->quantity + (int) $validated['quantity'];

        // Re-validate stock after increment
        if ($product->stock < $item->quantity) {
            return response()->json([
                'message' => 'Insufficient stock',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $item->save();

        $item->load('product.category');

        return response()->json([
            'message' => 'Product added to cart',
            'data' => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => (int) $item->quantity,
                'product' => new ProductResource($item->product),
            ],
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, int $productId): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCartForRequest($request);

        $product = Product::query()->findOrFail($productId);

        // Optional: stock validation
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'message' => 'Insufficient stock',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $item = CartItem::query()
            ->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$item) {
            return response()->json([
                'message' => 'Cart item not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $item->quantity = (int) $validated['quantity'];
        $item->save();

        $item->load('product.category');

        return response()->json([
            'message' => 'Cart item updated',
            'data' => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => (int) $item->quantity,
                'product' => new ProductResource($item->product),
            ],
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request, int $productId): \Illuminate\Http\JsonResponse
    {
        $cart = $this->getCartForRequest($request);

        $item = CartItem::query()
            ->where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if (!$item) {
            return response()->json([
                'message' => 'Cart item not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $item->delete();

        return response()->json([
            'message' => 'Cart item deleted successfully',
        ], Response::HTTP_OK);
    }
}

