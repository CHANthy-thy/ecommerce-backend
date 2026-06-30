<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::query()->orderBy('name')->get();
        $brands = Brand::query()->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'skin_type' => ['nullable', 'string', 'max:255'],
            'volume' => ['nullable', 'string', 'max:255'],
            'ingredients' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:active,inactive,archived'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'image_url' => ['nullable', 'string', 'max:2048', 'url'],
        ]);

        $imageValue = null;

        if ($request->hasFile('image')) {
            $imageValue = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            $imageValue = $validated['image_url'];
        }

        Product::create([
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'] ?? null,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => filter_var($imageValue, FILTER_VALIDATE_URL) ? null : $imageValue,
            'image_url' => filter_var($imageValue, FILTER_VALIDATE_URL) ? $imageValue : null,
            'skin_type' => $validated['skin_type'] ?? null,
            'volume' => $validated['volume'] ?? null,
            'ingredients' => $validated['ingredients'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::query()->orderBy('name')->get();
        $brands = Brand::query()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'skin_type' => ['nullable', 'string', 'max:255'],
            'volume' => ['nullable', 'string', 'max:255'],
            'ingredients' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:active,inactive,archived'],
            'image_url' => ['nullable', 'string', 'max:2048', 'url'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data = [
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'] ?? $product->brand_id,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'skin_type' => $validated['skin_type'] ?? null,
            'volume' => $validated['volume'] ?? null,
            'ingredients' => $validated['ingredients'] ?? null,
            'status' => $validated['status'] ?? $product->status,
        ];

        if ($request->hasFile('image')) {
            $storedPath = $request->file('image')->store('products', 'public');
            $data['image'] = $storedPath;
            $data['image_url'] = null;
        } elseif ($request->filled('image_url')) {
            $data['image_url'] = $validated['image_url'];
            $data['image'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}