<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\WishlistResource;
use App\Models\Wishlist;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $items = Wishlist::query()
            ->where('user_id', $request->user()->id)
            ->with('product.category')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Wishlist fetched successfully',
            'data' => WishlistResource::collection($items),
        ], Response::HTTP_OK);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $user = $request->user();

        $wishlist = Wishlist::query()->firstOrCreate([
            'user_id' => $user->id,
            'product_id' => $validated['product_id'],
        ]);

        // If it already existed, return 200; otherwise 201.
        $status = $wishlist->wasRecentlyCreated ? Response::HTTP_CREATED : Response::HTTP_OK;

        $wishlist->load('product.category');

        return response()->json([
            'message' => $wishlist->wasRecentlyCreated
                ? 'Product added to wishlist'
                : 'Product already exists in wishlist',
            'data' => new WishlistResource($wishlist),
        ], $status);

    }

    public function destroy(Request $request, int $id)
    {
        $user = $request->user();

        $wishlist = Wishlist::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$wishlist) {
            return response()->json([
                'message' => 'Wishlist item not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $wishlist->delete();

        return response()->json([
            'message' => 'Wishlist item deleted successfully',
        ], Response::HTTP_OK);
    }
}

