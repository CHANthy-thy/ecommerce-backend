<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $products = Product::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate((int) ($validated['per_page'] ?? 10));

        return ProductResource::collection($products);
    }

    public function show(int $id)
    {
        $product = Product::query()->with('category')->findOrFail($id);

        return new ProductResource($product);
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'q' => ['sometimes', 'string', 'max:255'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $query = isset($validated['q']) ? (string) $validated['q'] : '';
        $query = trim($query);

        $productsQuery = Product::query()->with('category');

        if ($query !== '') {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        }

        $products = $productsQuery
            ->orderByDesc('created_at')
            ->paginate((int) ($validated['per_page'] ?? 10));

        return ProductResource::collection($products);
    }
}

