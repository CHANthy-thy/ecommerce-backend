<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AdminDashboardSeeder extends Seeder
{
    public function run(): void
    {
        // Deterministic dataset: do not rely on existing ProductSeeder stocks.
        // We fully reset the core tables so counts used by the dashboard are consistent.
        DB::transaction(function () {
            OrderItem::query()->delete();
            Order::query()->delete();
            Product::query()->delete();

            // Keep categories/brands/users; recreate if missing.
            $categories = $this->ensureCategories();
            $brands = $this->ensureBrands();
            $users = $this->ensureUsers();

            $products = $this->seedProducts($categories, $brands);

            $this->seedOrders($users, $products);
        });
    }

    private function ensureCategories(): array
    {
        $names = [
            'Cleanser', 'Toner', 'Serum', 'Moisturizer', 'Sunscreen',
            'Face Mask', 'Eye Care', 'Lip Care', 'Acne Care', 'Body Care',
        ];

        $out = [];
        foreach ($names as $name) {
            $out[$name] = Category::query()->firstOrCreate(
                ['name' => $name],
                ['description' => null]
            );
        }
        return $out;
    }

    private function ensureBrands(): array
    {
        $names = [
            'CeraVe', 'COSRX', 'Beauty of Joseon', 'SKIN1004', 'Anua',
            'Round Lab', 'La Roche-Posay', 'Cetaphil', 'The Ordinary', 'Eucerin',
        ];

        $out = [];
        foreach ($names as $name) {
            $out[$name] = Brand::query()->firstOrCreate(
                ['name' => $name],
                ['description' => null]
            );
        }
        return $out;
    }

    private function ensureUsers(): array
    {
        // Dashboard needs Total Users; admin UI likely uses all users count.
        // We'll create 20 deterministic users (idempotent by email).
        $out = [];
        for ($i = 1; $i <= 20; $i++) {
            $email = "user{$i}@example.com";
            $out[] = User::query()->updateOrCreate(
                ['email' => $email],
                [
                    'name' => "User {$i}",
                    'role' => 'user',
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                ]
            );
        }

        // Also ensure the existing test user exists.
        $out[] = User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'role' => 'user',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ]
        );

        return array_values(array_unique(array_map(fn ($u) => $u->id, $out)));
    }

    private function seedProducts(array $categories, array $brands): array
    {
        $categoryNames = array_keys($categories);
        $brandNames = array_keys($brands);

        $image = function (string $seed, int $w = 400, int $h = 400): string {
            return "https://picsum.photos/seed/{$seed}/{$w}/{$h}";
        };

        // Build 50 products.
        // Requirement: exactly 10 products have stock between 0 and 10 (inclusive).
        $lowStockValues = [0, 1, 2, 3, 4, 5, 6, 7, 9, 10]; // exactly 10 values

        $products = [];
        $productIndex = 0;

        // Pre-select the 10 products (by index) that will have low stock.
        // Choose the first 10 for deterministic mapping.
        $lowStockIndices = range(0, 9);
        $zeroIndex = 0; // ensure at least one product has stock = 0

        for ($i = 0; $i < 50; $i++) {
            $productIndex++;

            $categoryName = $categoryNames[$i % count($categoryNames)];
            $brandName = $brandNames[($i + 3) % count($brandNames)];

            $name = $brandName . ' ' . $categoryName . ' ' . ($i + 1);
            $slug = Str::slug($name);

            $stock = null;
            if (in_array($i, $lowStockIndices, true)) {
                $stock = $lowStockValues[array_search($i, $lowStockIndices, true)];
            } else {
                // High stock: strictly > 10 to avoid affecting the low stock counter.
                // deterministic 11..250
                $stock = 11 + (($i * 17) % 240);
            }

            $price = round(9.99 + (($i % 30) * 0.85), 2);

            $status = 'active'; // admin UI examples use in/out stock + status

            $products[] = Product::query()->create([
                'category_id' => $categories[$categoryName]->id,
                'brand_id' => $brands[$brandName]->id,
                'name' => $name,
                'slug' => $slug,
                'description' => 'Seeded for Admin Dashboard metrics testing.',
                'price' => $price,
                'stock' => $stock,
                'image' => null,
                'image_url' => $image($slug . '-' . $i),
                'skin_type' => ['dry', 'normal', 'combination', 'sensitive', 'oily-acne'][$i % 5],
                'volume' => ['30ml', '50ml', '100ml', '150ml', '200ml'][$i % 5],
                'ingredients' => 'ceramides, glycerin, hyaluronic acid',
                'status' => $status,
                'created_at' => Carbon::now()->subDays(50 - $i),
                'updated_at' => Carbon::now()->subDays(50 - $i),
            ]);
        }

        // Sanity assertion in-memory (no DB queries) is not enough; ensure by querying.
        // If this fails, it will throw and stop seeding.
        $lowCount = Product::query()->where('stock', '<=', 10)->count();
        if ($lowCount !== 10) {
            throw new \RuntimeException("AdminDashboardSeeder expected exactly 10 low-stock products (<=10), got {$lowCount}");
        }

        return $products;
    }

    private function seedOrders(array $userIds, array $products): void
    {
        $statuses = ['pending', 'completed', 'cancelled'];

        // Ensure we have at least one completed order for revenue.
        // Create 18 orders distributed over last 6 months.
        $orders = [];

        for ($i = 0; $i < 18; $i++) {
            $monthOffset = 5 - intdiv($i, 3); // roughly 6 months buckets
            $createdAt = Carbon::now()->subMonths($monthOffset)->subDays(($i * 3) % 27)->setTime(10, 15, 0);

            $status = $i % 3 === 0 ? 'pending' : ($i % 3 === 1 ? 'completed' : 'cancelled');

            $userId = $userIds[$i % count($userIds)];

            // Order number snapshot for UI.
            $orderNumber = 'ORD-' . str_pad((string) ($i + 1), 6, '0', STR_PAD_LEFT);

            // Create with temporary totals; we will compute based on items.
            $orders[] = Order::query()->create([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'status' => $status,
                'subtotal' => 0,
                'total' => 0,
                'shipping_address' => null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        // Seed order items.
        foreach ($orders as $idx => $order) {
            $itemCount = 1 + ($idx % 3); // 1..3 items

            $subtotal = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products[($idx * 7 + $j * 3) % count($products)];

                $qty = 1 + (($idx + $j) % 4); // 1..4
                $unitPrice = (float) $product->price;
                $lineTotal = $unitPrice * $qty;

                $subtotal += $lineTotal;

                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => round($unitPrice, 2),
                    'quantity' => $qty,
                    'line_total' => round($lineTotal, 2),
                    'created_at' => $order->created_at,
                    'updated_at' => $order->created_at,
                ]);
            }

            // Set totals consistent with items.
            $order->subtotal = round($subtotal, 2);

            // For canceled/pending we keep totals the same; UI metrics that use revenue will filter by completed.
            $order->total = round($subtotal, 2);
            $order->save();
        }

        // Final invariant for revenue consistency is implicit.
    }
}

