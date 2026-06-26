<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    public function index(int $productId)
    {
        $product = Product::query()->findOrFail($productId);

        $reviews = $product->reviews()
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'message' => 'Product reviews fetched successfully',
            'data' => $reviews->map(function (Review $review) {
                return [
                    'id' => $review->id,
                    'user' => [
                        'id' => $review->user->id,
                        'name' => $review->user->name,
                    ],
                    'rating' => (int) $review->rating,
                    'comment' => $review->comment,
                    'created_at' => optional($review->created_at)->toISOString(),
                ];
            }),
        ], Response::HTTP_OK);
    }

    public function store(Request $request, int $productId)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string'],
        ]);

        $product = Product::query()->findOrFail($productId);
        $user = $request->user();

        // create (or update) review. If you want strict one-review-per-user, keep unique constraint.
        $review = Review::query()
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($review) {
            $review->update([
                'rating' => (int) $validated['rating'],
                'comment' => $validated['comment'],
            ]);

            $review->load('user');

            return response()->json([
                'message' => 'Review updated successfully',
                'data' => [
                    'id' => $review->id,
                    'user' => [
                        'id' => $review->user->id,
                        'name' => $review->user->name,
                    ],
                    'rating' => (int) $review->rating,
                    'comment' => $review->comment,
                    'created_at' => optional($review->created_at)->toISOString(),
                ],
            ], Response::HTTP_OK);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => (int) $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        $review->load('user');

        return response()->json([
            'message' => 'Review created successfully',
            'data' => [
                'id' => $review->id,
                'user' => [
                    'id' => $review->user->id,
                    'name' => $review->user->name,
                ],
                'rating' => (int) $review->rating,
                'comment' => $review->comment,
                'created_at' => optional($review->created_at)->toISOString(),
            ],
        ], Response::HTTP_CREATED);
    }

    public function destroy(Request $request, int $id)
    {
        $user = $request->user();

        $review = Review::query()->with('user')->findOrFail($id);

        $isAdmin = ($user->role ?? 'user') === 'admin';
        $isOwner = $review->user_id === $user->id;

        if (!$isAdmin && !$isOwner) {
            return response()->json([
                'message' => 'Forbidden',
            ], Response::HTTP_FORBIDDEN);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully',
        ], Response::HTTP_OK);
    }
}

