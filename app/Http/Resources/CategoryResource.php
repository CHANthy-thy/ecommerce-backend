<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    private static function resolveImg(?string $raw): ?string
    {
        if (! $raw) return null;
        return filter_var($raw, FILTER_VALIDATE_URL) ? $raw : asset('storage/' . $raw);
    }

    /** @var Category */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
            'products' => $this->whenLoaded('products', function () {
                return $this->products->map(fn ($product) => [
                    'id' => $product->id,
                    'category_id' => $product->category_id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image' => self::resolveImg($product->image_url ?? $product->image),
                    'created_at' => optional($product->created_at)->toISOString(),
                    'updated_at' => optional($product->updated_at)->toISOString(),
                ]);
            }),
        ];
    }
}

