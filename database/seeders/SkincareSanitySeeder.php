<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class SkincareSanitySeeder extends Seeder
{
    public function run(): void
    {
        // Remove any electronics-related records (category, products)
        $electronicsCategoryIds = Category::query()
            ->whereRaw('lower(name) = ?', ['electronics'])
            ->pluck('id');

        if ($electronicsCategoryIds->isNotEmpty()) {
            Product::query()->whereIn('category_id', $electronicsCategoryIds)->delete();
            Category::query()->whereIn('id', $electronicsCategoryIds)->delete();
        }

        // Remove placeholder sample images only if they were created in an earlier dataset.
        // Current ProductSeeder uses example.com images, but we do NOT want to delete all
        // products because it breaks the demo dataset.
        // Product::query()->where('image_url', 'like', '%example.com%')->delete();


        // Pruning unused brands breaks the demo dataset if products were not seeded
        // (or if running the seeder in isolation). The product/brand seeders
        // should be responsible for creating the expected dataset.
        //
        // Brand::query()->whereDoesntHave('products')->delete();

    }
}

