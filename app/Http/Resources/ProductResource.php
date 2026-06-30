<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    private static function resolveImageUrl(?string $raw): ?string
    {
        if (! $raw) return null;
        if (filter_var($raw, FILTER_VALIDATE_URL)) return $raw;
        return asset('storage/' . $raw);
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'description' => $this->category->description,
                ];
            }),
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => self::resolveImageUrl($this->image),
            'image_url' => self::resolveImageUrl($this->image_url ?? $this->image),
            'rating' => $this->rating ?? 0,
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
        ];
    }
}