<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::with('subCategories')->get();

        foreach ($categories as $category) {

            if ($category->subCategories->isEmpty()) {
                continue;
            }

            for ($i = 1; $i <= 6; $i++) {

                $subcategory = $category->subCategories->random();

                $mrp = rand(1200, 3000);
                $discount = rand(5, 30);
                $sellingPrice = $mrp - ($mrp * $discount / 100);

                Product::create([
                    'category_id'       => $category->id,
                    'subcategory_id'    => $subcategory->id,

                    'name'              => $category->name . ' Product ' . $i,
                    'sku'               => strtoupper(Str::random(8)),
                    'short_description' => 'Premium quality ' . $category->name,
                    'description'       => 'Comfortable and stylish product for daily wear.',

                    'fabric'            => collect([
                        'Cotton',
                        'Linen',
                        'Denim',
                        'Cotton Blend'
                    ])->random(),

                    'season'            => collect([
                        'Summer',
                        'Winter',
                        'All Season'
                    ])->random(),

                    'tags'              => 'fashion,pants,men',

                    'mrp'               => $mrp,
                    'discount_percent'  => $discount,
                    'selling_price'     => round($sellingPrice, 2),

                    'stock_quantity'    => rand(10, 100),
                    'low_stock_threshold' => 10,

                    'sizes' => json_encode([
                        '30', '32', '34', '36', '38'
                    ]),

                    'colors' => json_encode([
                        'Black', 'Blue', 'Grey'
                    ]),

                    'main_image' => 'products/default-product.jpg',

                    'status' => 'active',
                ]);
            }
        }
    }
}