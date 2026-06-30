<?php

namespace App\Http\Resources;

use App\Models\Wishlist;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    private static function resolveImageUrl(?string $raw): ?string
    {
        if (! $raw) return null;
        return filter_var($raw, FILTER_VALIDATE_URL) ? $raw : asset('storage/' . $raw);
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
            'product' => $this->whenLoaded('product', function () {
                return [
                    'id' => $this->product->id,
                    'name' => $this->product->name,
                    'price' => $this->product->price,
                    'rating' => $this->product->rating ?? 0,
                    'image' => self::resolveImageUrl($this->product->image ?? $this->product->image_url),
                    'image_url' => self::resolveImageUrl($this->product->image_url ?? $this->product->image),
                ];
            }),
        ];
    }
}

