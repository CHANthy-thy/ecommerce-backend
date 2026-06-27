<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'CeraVe',
            'COSRX',
            'Beauty of Joseon',
            'SKIN1004',
            'Anua',
            'Round Lab',
            'La Roche-Posay',
            'Cetaphil',
            'The Ordinary',
            'Eucerin',
        ];

        foreach ($brands as $name) {
            Brand::query()->updateOrCreate(
                ['name' => $name],
                ['description' => null]
            );
        }
    }
}

