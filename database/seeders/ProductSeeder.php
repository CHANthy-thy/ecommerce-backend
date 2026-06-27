<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure categories exist (create if seeder ran standalone)
        $categoryByName = function (string $name): Category {
            return Category::query()->firstOrCreate(
                ['name' => $name],
                ['description' => null]
            );
        };

        // Ensure brands exist (create if seeder ran standalone)
        $brandByName = function (string $name): Brand {
            return Brand::query()->firstOrCreate(
                ['name' => $name],
                ['description' => null]
            );
        };

        // Exactly 50 skincare products.
        // Fields required by schema:
        // - slug, brand_id, skin_type, volume, ingredients, status
        $products = [
            // Cleanser (5)
            ['category' => 'Cleanser', 'brand' => 'CeraVe', 'name' => 'Gentle Foaming Cleanser', 'description' => 'A gentle daily cleanser that helps remove dirt and excess oil without stripping your skin barrier.', 'price' => 14.99, 'stock' => 120, 'skin_type' => 'normal-oily', 'volume' => '150ml', 'ingredients' => 'ceramides, niacinamide, glycerin', 'status' => 'active', 'image' => 'https://example.com/cleanser-foaming.jpg'],
            ['category' => 'Cleanser', 'brand' => 'COSRX', 'name' => 'Hydrating Gel Cleanser', 'description' => 'Lightweight gel cleanser that rinses clean while supporting a soft, comfortable feel.', 'price' => 16.50, 'stock' => 95, 'skin_type' => 'dry', 'volume' => '150ml', 'ingredients' => 'hyaluronic acid, panthenol, allantoin', 'status' => 'active', 'image' => 'https://example.com/cleanser-hydrating-gel.jpg'],
            ['category' => 'Cleanser', 'brand' => 'Beauty of Joseon', 'name' => 'Red Bean Gentle Cleanser', 'description' => 'A comforting cleanser designed to leave skin feeling clean and refreshed.', 'price' => 18.40, 'stock' => 70, 'skin_type' => 'combination', 'volume' => '150ml', 'ingredients' => 'red bean extract, rice enzymes', 'status' => 'active', 'image' => 'https://example.com/cleanser-red-bean.jpg'],
            ['category' => 'Cleanser', 'brand' => 'SKIN1004', 'name' => 'Madagascar Centella Cleanser', 'description' => 'A soothing cleanser to help calm the look of stressed skin while cleansing.', 'price' => 17.20, 'stock' => 85, 'skin_type' => 'sensitive', 'volume' => '210ml', 'ingredients' => 'centella asiatica, betaine, zinc', 'status' => 'active', 'image' => 'https://example.com/cleanser-centella.jpg'],
            ['category' => 'Cleanser', 'brand' => 'Anua', 'name' => 'Heartleaf Low pH Cleanser', 'description' => 'Low pH cleansing support for a balanced, comfortable skin feel.', 'price' => 15.80, 'stock' => 100, 'skin_type' => 'oily-acne', 'volume' => '150ml', 'ingredients' => 'heartleaf extract, allantoin, surfactant blend', 'status' => 'active', 'image' => 'https://example.com/cleanser-heartleaf.jpg'],

            // Toner (5)
            ['category' => 'Toner', 'brand' => 'Round Lab', 'name' => 'Dokdo Hydrating Toner', 'description' => 'Hydrating toner that helps replenish moisture and support a healthy-looking complexion.', 'price' => 13.20, 'stock' => 110, 'skin_type' => 'normal', 'volume' => '200ml', 'ingredients' => 'beta-glucan, panthenol, hyaluronic acid', 'status' => 'active', 'image' => 'https://example.com/toner-dokdo.jpg'],
            ['category' => 'Toner', 'brand' => 'La Roche-Posay', 'name' => 'Toleriane Soothing Toner', 'description' => 'Soothing hydration toner designed for sensitive skin.', 'price' => 19.60, 'stock' => 60, 'skin_type' => 'sensitive', 'volume' => '200ml', 'ingredients' => 'thermal spring water, ceramides', 'status' => 'active', 'image' => 'https://example.com/toner-toleriane.jpg'],
            ['category' => 'Toner', 'brand' => 'COSRX', 'name' => 'AHA Glow Toner', 'description' => 'Gentle AHA support to help refine the look of texture for a brighter-looking finish.', 'price' => 18.40, 'stock' => 65, 'skin_type' => 'combination', 'volume' => '150ml', 'ingredients' => 'AHA complex, willow bark', 'status' => 'active', 'image' => 'https://example.com/toner-aha.jpg'],
            ['category' => 'Toner', 'brand' => 'Cetaphil', 'name' => 'Daily Hydrating Toner', 'description' => 'A lightweight toner that helps hydrate and balance after cleansing.', 'price' => 12.90, 'stock' => 140, 'skin_type' => 'normal', 'volume' => '200ml', 'ingredients' => 'glycerin, aloe vera', 'status' => 'active', 'image' => 'https://example.com/toner-daily-hydrating.jpg'],
            ['category' => 'Toner', 'brand' => 'The Ordinary', 'name' => 'Glycolic Exfoliating Toner', 'description' => 'Exfoliating support toner to help gently smooth the look of texture.', 'price' => 11.75, 'stock' => 75, 'skin_type' => 'oily-acne', 'volume' => '240ml', 'ingredients' => 'glycolic acid, soothing humectants', 'status' => 'active', 'image' => 'https://example.com/toner-glycolic.jpg'],

            // Serum (5)
            ['category' => 'Serum', 'brand' => 'CeraVe', 'name' => 'Vitamin C Brightening Serum', 'description' => 'Helps brighten the look of dullness and supports a more even-looking tone.', 'price' => 24.00, 'stock' => 80, 'skin_type' => 'normal', 'volume' => '30ml', 'ingredients' => 'vitamin C, niacinamide', 'status' => 'active', 'image' => 'https://example.com/serum-vitamin-c.jpg'],
            ['category' => 'Serum', 'brand' => 'COSRX', 'name' => 'Hyaluronic Acid Hydration Serum', 'description' => 'Plumps and hydrates for a smoother, more moisturized look.', 'price' => 22.75, 'stock' => 110, 'skin_type' => 'dry', 'volume' => '30ml', 'ingredients' => 'hyaluronic acid, betaine', 'status' => 'active', 'image' => 'https://example.com/serum-hyaluronic-acid.jpg'],
            ['category' => 'Serum', 'brand' => 'Beauty of Joseon', 'name' => 'Glow Deep Serum', 'description' => 'A lightweight serum designed to brighten and support a healthy-looking glow.', 'price' => 26.50, 'stock' => 55, 'skin_type' => 'combination', 'volume' => '40ml', 'ingredients' => 'ginseng extract, rice enzymes', 'status' => 'active', 'image' => 'https://example.com/serum-glow-deep.jpg'],
            ['category' => 'Serum', 'brand' => 'SKIN1004', 'name' => 'Centella Ampoule Serum', 'description' => 'Soothing ampoule serum that helps calm the look of stressed skin.', 'price' => 25.40, 'stock' => 90, 'skin_type' => 'sensitive', 'volume' => '50ml', 'ingredients' => 'centella asiatica, tea tree', 'status' => 'active', 'image' => 'https://example.com/serum-centella-ampoule.jpg'],
            ['category' => 'Serum', 'brand' => 'The Ordinary', 'name' => 'Niacinamide 10% Serum', 'description' => 'Helps support a clearer-looking complexion and visibly reduce the look of uneven tone.', 'price' => 16.20, 'stock' => 125, 'skin_type' => 'oily-acne', 'volume' => '30ml', 'ingredients' => 'niacinamide, zinc PCA', 'status' => 'active', 'image' => 'https://example.com/serum-niacinamide.jpg'],

            // Moisturizer (5)
            ['category' => 'Moisturizer', 'brand' => 'CeraVe', 'name' => 'Ceramide Barrier Cream', 'description' => 'Rich moisturizer that helps support barrier function and comfort.', 'price' => 19.95, 'stock' => 140, 'skin_type' => 'dry', 'volume' => '50ml', 'ingredients' => 'ceramides, cholesterol, hyaluronic acid', 'status' => 'active', 'image' => 'https://example.com/moisturizer-ceramide-cream.jpg'],
            ['category' => 'Moisturizer', 'brand' => 'COSRX', 'name' => 'Lightweight Gel Moisturizer', 'description' => 'Fast-absorbing gel moisturizer for balanced hydration and a refreshed finish.', 'price' => 17.25, 'stock' => 75, 'skin_type' => 'combination', 'volume' => '75ml', 'ingredients' => 'hyaluronic acid, glycerin', 'status' => 'active', 'image' => 'https://example.com/moisturizer-gel.jpg'],
            ['category' => 'Moisturizer', 'brand' => 'Anua', 'name' => 'Heartleaf Soothing Cream', 'description' => 'Soothing cream moisturizer for calmer-looking, comfortable skin.', 'price' => 21.60, 'stock' => 65, 'skin_type' => 'sensitive', 'volume' => '80ml', 'ingredients' => 'heartleaf extract, beta-glucan', 'status' => 'active', 'image' => 'https://example.com/moisturizer-heartleaf.jpg'],
            ['category' => 'Moisturizer', 'brand' => 'Cetaphil', 'name' => 'Daily Hydrating Lotion', 'description' => 'Light daily hydration to support softer-looking, comfortable skin.', 'price' => 16.10, 'stock' => 150, 'skin_type' => 'normal', 'volume' => '100ml', 'ingredients' => 'glycerin, panthenol', 'status' => 'active', 'image' => 'https://example.com/moisturizer-daily-lotion.jpg'],
            ['category' => 'Moisturizer', 'brand' => 'Eucerin', 'name' => 'Urea Repair Cream', 'description' => 'Helps nourish and support the look of smoother hydrated skin.', 'price' => 18.90, 'stock' => 88, 'skin_type' => 'dry', 'volume' => '50ml', 'ingredients' => 'urea, ceramides', 'status' => 'active', 'image' => 'https://example.com/moisturizer-urea-repair.jpg'],

            // Sunscreen (5)
            ['category' => 'Sunscreen', 'brand' => 'La Roche-Posay', 'name' => 'Anthelios SPF 50', 'description' => 'Broad spectrum SPF with a lightweight non-greasy finish.', 'price' => 21.00, 'stock' => 200, 'skin_type' => 'normal', 'volume' => '50ml', 'ingredients' => 'UV filters, antioxidants', 'status' => 'active', 'image' => 'https://example.com/sunscreen-spf50.jpg'],
            ['category' => 'Sunscreen', 'brand' => 'Cetaphil', 'name' => 'Daily Facial Sunscreen SPF 30', 'description' => 'Everyday protection designed to feel comfortable on skin.', 'price' => 16.75, 'stock' => 145, 'skin_type' => 'combination', 'volume' => '50ml', 'ingredients' => 'UV filters, vitamin E', 'status' => 'active', 'image' => 'https://example.com/sunscreen-spf30.jpg'],
            ['category' => 'Sunscreen', 'brand' => 'Round Lab', 'name' => 'Birch Moist Suncream SPF 50', 'description' => 'Moist-feeling sun protection with skin-friendly finish.', 'price' => 24.25, 'stock' => 60, 'skin_type' => 'dry', 'volume' => '50ml', 'ingredients' => 'birch extract, UV filters', 'status' => 'active', 'image' => 'https://example.com/sunscreen-birch.jpg'],
            ['category' => 'Sunscreen', 'brand' => 'The Ordinary', 'name' => 'Lightweight SPF 40 Fluid', 'description' => 'Light SPF formula that blends for daily wear.', 'price' => 14.95, 'stock' => 120, 'skin_type' => 'oily-acne', 'volume' => '60ml', 'ingredients' => 'UV filters, humectants', 'status' => 'active', 'image' => 'https://example.com/sunscreen-fluid.jpg'],
            ['category' => 'Sunscreen', 'brand' => 'SKIN1004', 'name' => 'Centella Sun Cream SPF 50+', 'description' => 'Soothing sun care with centella-inspired comfort.', 'price' => 22.40, 'stock' => 90, 'skin_type' => 'sensitive', 'volume' => '50ml', 'ingredients' => 'centella, UV filters', 'status' => 'active', 'image' => 'https://example.com/sunscreen-centella.jpg'],

            // Face Mask (5)
            ['category' => 'Face Mask', 'brand' => 'CeraVe', 'name' => 'Hydrating Face Sheet Mask', 'description' => 'A moisture-boosting sheet mask to refresh and soften skin.', 'price' => 8.50, 'stock' => 160, 'skin_type' => 'dry', 'volume' => '25ml', 'ingredients' => 'hyaluronic acid, ceramides', 'status' => 'active', 'image' => 'https://example.com/face-mask-hydrating.jpg'],
            ['category' => 'Face Mask', 'brand' => 'COSRX', 'name' => 'Calming BHA Clay Mask', 'description' => 'Helps refine the look of texture with gentle exfoliating support.', 'price' => 12.90, 'stock' => 110, 'skin_type' => 'oily-acne', 'volume' => '60ml', 'ingredients' => 'BHA, clay, soothing extracts', 'status' => 'active', 'image' => 'https://example.com/face-mask-bha.jpg'],
            ['category' => 'Face Mask', 'brand' => 'Beauty of Joseon', 'name' => 'Ginseng Relax Mask', 'description' => 'Designed to help skin feel refreshed and comfortable after mask time.', 'price' => 14.20, 'stock' => 85, 'skin_type' => 'normal', 'volume' => '30ml', 'ingredients' => 'ginseng, antioxidants', 'status' => 'active', 'image' => 'https://example.com/face-mask-ginseng.jpg'],
            ['category' => 'Face Mask', 'brand' => 'Anua', 'name' => 'Heartleaf Soothing Mask', 'description' => 'A comforting mask to support calmer-looking skin.', 'price' => 10.10, 'stock' => 95, 'skin_type' => 'sensitive', 'volume' => '25ml', 'ingredients' => 'heartleaf extract, panthenol', 'status' => 'active', 'image' => 'https://example.com/face-mask-heartleaf.jpg'],
            ['category' => 'Face Mask', 'brand' => 'Eucerin', 'name' => 'Repairing Comfort Mask', 'description' => 'Supports a smoother feel with replenishing comfort.', 'price' => 13.60, 'stock' => 70, 'skin_type' => 'dry', 'volume' => '50ml', 'ingredients' => 'urea, lipids', 'status' => 'active', 'image' => 'https://example.com/face-mask-repair.jpg'],

            // Eye Care (5)
            ['category' => 'Eye Care', 'brand' => 'La Roche-Posay', 'name' => 'Brightening Eye Gel', 'description' => 'A cooling eye gel designed to help reduce the look of fatigue.', 'price' => 15.90, 'stock' => 90, 'skin_type' => 'normal', 'volume' => '15ml', 'ingredients' => 'caffeine, peptides', 'status' => 'active', 'image' => 'https://example.com/eye-care-brightening.jpg'],
            ['category' => 'Eye Care', 'brand' => 'Beauty of Joseon', 'name' => 'Revitalizing Eye Serum', 'description' => 'Helps support brighter-looking under-eye appearance.', 'price' => 18.80, 'stock' => 65, 'skin_type' => 'dry', 'volume' => '20ml', 'ingredients' => 'ginseng, niacinamide', 'status' => 'active', 'image' => 'https://example.com/eye-care-serum.jpg'],
            ['category' => 'Eye Care', 'brand' => 'COSRX', 'name' => 'Soothing Hydro Eye Patch', 'description' => 'Hydro patches designed to soothe and hydrate the eye area.', 'price' => 11.50, 'stock' => 120, 'skin_type' => 'sensitive', 'volume' => '14ml', 'ingredients' => 'hyaluronic acid, allantoin', 'status' => 'active', 'image' => 'https://example.com/eye-patch.jpg'],
            ['category' => 'Eye Care', 'brand' => 'Cetaphil', 'name' => 'Hydrating Eye Cream', 'description' => 'Light eye cream that helps moisturize and comfort.', 'price' => 14.25, 'stock' => 100, 'skin_type' => 'combination', 'volume' => '20ml', 'ingredients' => 'glycerin, bisabolol', 'status' => 'active', 'image' => 'https://example.com/eye-cream.jpg'],
            ['category' => 'Eye Care', 'brand' => 'Eucerin', 'name' => 'Anti-Dark Circle Eye Roll-On', 'description' => 'Roll-on eye product designed to help refresh the look of tired eyes.', 'price' => 17.75, 'stock' => 80, 'skin_type' => 'normal', 'volume' => '12ml', 'ingredients' => 'caffeine, antioxidants', 'status' => 'active', 'image' => 'https://example.com/eye-rollon.jpg'],

            // Lip Care (5)
            ['category' => 'Lip Care', 'brand' => 'CeraVe', 'name' => 'Nourishing Lip Balm', 'description' => 'Moisturizing lip balm that helps keep lips smooth and comfortable.', 'price' => 7.25, 'stock' => 220, 'skin_type' => 'dry', 'volume' => '10g', 'ingredients' => 'ceramides, petrolatum', 'status' => 'active', 'image' => 'https://example.com/lip-care-balm.jpg'],
            ['category' => 'Lip Care', 'brand' => 'COSRX', 'name' => 'Berry Lip Treatment', 'description' => 'A hydrating lip treatment designed for soft, comfortable lips.', 'price' => 8.90, 'stock' => 160, 'skin_type' => 'normal', 'volume' => '12g', 'ingredients' => 'berry extracts, vitamin E', 'status' => 'active', 'image' => 'https://example.com/lip-berry.jpg'],
            ['category' => 'Lip Care', 'brand' => 'La Roche-Posay', 'name' => 'Soothing Lip Balm SPF', 'description' => 'Lip balm with SPF and a comfortable protective feel.', 'price' => 10.40, 'stock' => 140, 'skin_type' => 'sensitive', 'volume' => '12g', 'ingredients' => 'UV filters, shea butter', 'status' => 'active', 'image' => 'https://example.com/lip-spf.jpg'],
            ['category' => 'Lip Care', 'brand' => 'Beauty of Joseon', 'name' => 'Rice Lip Glaze', 'description' => 'Lightweight lip glaze to support moisture and a soft look.', 'price' => 9.60, 'stock' => 110, 'skin_type' => 'combination', 'volume' => '10g', 'ingredients' => 'rice extract, humectants', 'status' => 'active', 'image' => 'https://example.com/lip-rice.jpg'],
            ['category' => 'Lip Care', 'brand' => 'Cetaphil', 'name' => 'Daily Lip Moisturizer', 'description' => 'Daily moisturizing lip care to help prevent dryness.', 'price' => 7.95, 'stock' => 190, 'skin_type' => 'dry', 'volume' => '10g', 'ingredients' => 'glycerin, soothing agents', 'status' => 'active', 'image' => 'https://example.com/lip-daily.jpg'],

            // Acne Care (5)
            ['category' => 'Acne Care', 'brand' => 'SKIN1004', 'name' => 'Calming BHA Pore-Refining Serum', 'description' => 'Helps unclog pores and supports a clearer-looking complexion.', 'price' => 26.99, 'stock' => 60, 'skin_type' => 'oily-acne', 'volume' => '30ml', 'ingredients' => 'BHA, centella, zinc PCA', 'status' => 'active', 'image' => 'https://example.com/acne-bha-serum.jpg'],
            ['category' => 'Acne Care', 'brand' => 'The Ordinary', 'name' => 'Salicylic Acid Serum', 'description' => 'Helps reduce the look of blemishes with gentle exfoliating support.', 'price' => 13.99, 'stock' => 120, 'skin_type' => 'oily-acne', 'volume' => '30ml', 'ingredients' => 'salicylic acid, soothing humectants', 'status' => 'active', 'image' => 'https://example.com/acne-salicylic-serum.jpg'],
            ['category' => 'Acne Care', 'brand' => 'La Roche-Posay', 'name' => 'Effaclar Spot Treatment', 'description' => 'Targeted treatment designed to support clearer-looking skin.', 'price' => 15.80, 'stock' => 100, 'skin_type' => 'oily-acne', 'volume' => '15ml', 'ingredients' => 'micro-amount actives, soothing agents', 'status' => 'active', 'image' => 'https://example.com/acne-spot.jpg'],
            ['category' => 'Acne Care', 'brand' => 'Anua', 'name' => 'Heartleaf Acne Gel', 'description' => 'Lightweight acne-support gel designed to feel non-greasy.', 'price' => 14.90, 'stock' => 95, 'skin_type' => 'oily-acne', 'volume' => '50ml', 'ingredients' => 'heartleaf extract, niacinamide', 'status' => 'active', 'image' => 'https://example.com/acne-heartleaf-gel.jpg'],
            ['category' => 'Acne Care', 'brand' => 'Eucerin', 'name' => 'Clear Skin Serum', 'description' => 'Supports a clearer-looking complexion with a comfort-focused formula.', 'price' => 17.35, 'stock' => 80, 'skin_type' => 'oily-acne', 'volume' => '30ml', 'ingredients' => 'thiamidol, licochalcone', 'status' => 'active', 'image' => 'https://example.com/acne-clear-serum.jpg'],

            // Body Care (5)
            ['category' => 'Body Care', 'brand' => 'CeraVe', 'name' => 'Smooth & Hydrate Body Lotion', 'description' => 'A lightweight body lotion that supports smoother-looking, hydrated skin.', 'price' => 12.75, 'stock' => 130, 'skin_type' => 'dry', 'volume' => '250ml', 'ingredients' => 'ceramides, glycerin', 'status' => 'active', 'image' => 'https://example.com/body-care-lotion.jpg'],
            ['category' => 'Body Care', 'brand' => 'Cetaphil', 'name' => 'Daily Moisturizing Body Cream', 'description' => 'Daily body cream designed to support soft, comfortable skin.', 'price' => 14.20, 'stock' => 140, 'skin_type' => 'normal', 'volume' => '300ml', 'ingredients' => 'glycerin, vitamin E', 'status' => 'active', 'image' => 'https://example.com/body-care-cream.jpg'],
            ['category' => 'Body Care', 'brand' => 'Eucerin', 'name' => 'Urea Repair Body Lotion', 'description' => 'Helps nourish and support the look of smoother hydrated body skin.', 'price' => 16.40, 'stock' => 90, 'skin_type' => 'dry', 'volume' => '250ml', 'ingredients' => 'urea, ceramides', 'status' => 'active', 'image' => 'https://example.com/body-urea-lotion.jpg'],
            ['category' => 'Body Care', 'brand' => 'La Roche-Posay', 'name' => 'Lipid Replenishing Body Emulsion', 'description' => 'Replenishing body care to help comfort dry-looking skin.', 'price' => 18.10, 'stock' => 75, 'skin_type' => 'dry', 'volume' => '400ml', 'ingredients' => 'lipids, soothing agents', 'status' => 'active', 'image' => 'https://example.com/body-emulsion.jpg'],
            ['category' => 'Body Care', 'brand' => 'Round Lab', 'name' => 'Moisture Body Lotion', 'description' => 'Hydrating body lotion for a refreshed and comfortable feel.', 'price' => 13.70, 'stock' => 115, 'skin_type' => 'normal', 'volume' => '300ml', 'ingredients' => 'hyaluronic acid, glycerin', 'status' => 'active', 'image' => 'https://example.com/body-moist-lotion.jpg'],

            // (Repeat/expand with additional brand variations to reach exactly 50)
            // We'll generate remaining 25 with deterministic variants.
        ];

        // If you want more variety, we can expand the static list above.
        // For now, ensure we reach exactly 50 products deterministically.
        $needed = 50 - count($products);
        $categories = [
            'Cleanser', 'Toner', 'Serum', 'Moisturizer', 'Sunscreen', 'Face Mask',
            'Eye Care', 'Lip Care', 'Acne Care', 'Body Care',
        ];
        $brands = [
            'CeraVe', 'COSRX', 'Beauty of Joseon', 'SKIN1004', 'Anua', 'Round Lab',
            'La Roche-Posay', 'Cetaphil', 'The Ordinary', 'Eucerin',
        ];
        $skinTypes = ['dry', 'normal', 'combination', 'sensitive', 'oily-acne', 'normal-oily'];
        $volumes = ['30ml', '50ml', '100ml', '150ml', '200ml', '250ml'];
        $ingredientSets = [
            'ceramides, niacinamide, glycerin',
            'hyaluronic acid, panthenol, allantoin',
            'centella asiatica, tea tree, glycerin',
            'vitamin C, niacinamide',
            'AHA complex, soothing humectants',
            'BHA, zinc PCA, centella',
            'urea, ceramides, lipids',
            'glycerin, aloe vera, bisabolol',
        ];
        $statuses = ['active', 'active', 'inactive'];

        for ($i = 0; $i < $needed; $i++) {
            $categoryName = $categories[($i + 3) % count($categories)];
            $brandName = $brands[($i + 5) % count($brands)];
            $skinType = $skinTypes[($i + 1) % count($skinTypes)];
            $volume = $volumes[($i + 2) % count($volumes)];
            $ingredients = $ingredientSets[($i + 4) % count($ingredientSets)];
            $status = $statuses[($i + 7) % count($statuses)];

            $name = $brandName . ' ' . $categoryName . ' ' . ($i + 1);
            $products[] = [
                'category' => $categoryName,
                'brand' => $brandName,
                'name' => $name,
                'description' => 'Skincare product: ' . $categoryName . ' by ' . $brandName . ', formulated for comfort and visible skin support.',
                'price' => round(9.99 + (($i % 30) * 0.75), 2),
                'stock' => 30 + ($i * 3) % 200,
                'skin_type' => $skinType,
                'volume' => $volume,
                'ingredients' => $ingredients,
                'status' => $status,
                'image' => 'https://example.com/' . Str::slug($categoryName . '-' . $brandName . '-' . $i) . '.jpg',
            ];
        }

        // Safety: enforce exactly 50
        $products = array_slice($products, 0, 50);

        foreach ($products as $product) {
            $category = $categoryByName($product['category']);
            $brand = $brandByName($product['brand']);
            $slug = Str::slug($product['name']);

            Product::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'name' => $product['name'],
                    'slug' => $slug,
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'image' => $product['image'],
                    'skin_type' => $product['skin_type'],
                    'volume' => $product['volume'],
                    'ingredients' => $product['ingredients'],
                    'status' => $product['status'],
                ]
            );
        }
    }
}


