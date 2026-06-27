<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cleanser',
                'description' => 'Gentle cleansing to remove impurities and prep skin for the rest of your routine.',
            ],
            [
                'name' => 'Toner',
                'description' => 'Lightweight hydration and balancing step to support a healthier-looking complexion.',
            ],
            [
                'name' => 'Serum',
                'description' => 'Targeted treatment to help address concerns like hydration, glow, and clarity.',
            ],
            [
                'name' => 'Moisturizer',
                'description' => 'Nourishing hydration to support a healthy-looking skin barrier.',
            ],
            [
                'name' => 'Sunscreen',
                'description' => 'Daily SPF protection to help shield skin and support long-term skin health.',
            ],
            [
                'name' => 'Face Mask',
                'description' => 'Intensive at-home treatment to refresh, hydrate, and visibly improve skin.',
            ],
            [
                'name' => 'Eye Care',
                'description' => 'Care for the delicate eye area to help reduce the look of fatigue.',
            ],
            [
                'name' => 'Lip Care',
                'description' => 'Moisture and comfort for softer-looking, healthier lips.',
            ],
            [
                'name' => 'Acne Care',
                'description' => 'Support clearer-looking skin with targeted acne-focused actives.',
            ],
            [
                'name' => 'Body Care',
                'description' => 'Skincare for your body to keep skin smooth, hydrated, and comfortable.',
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}

