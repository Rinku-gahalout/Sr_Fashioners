<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        Product::all()->each(function ($product) {

            for ($i = 1; $i <= 3; $i++) {

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => "products/sample{$i}.jpg",
                    'sort_order' => $i,
                ]);
            }
        });
    }
}