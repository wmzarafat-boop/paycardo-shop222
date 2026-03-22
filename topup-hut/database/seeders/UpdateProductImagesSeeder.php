<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Database\Seeder;

class UpdateProductImagesSeeder extends Seeder
{
    public function run()
    {
        ProductImage::truncate();
        
        $colors = [
            '1877F2', 'FF0000', 'E4405F', '000000', 
            '6C5CE7', '00C4CC', 'F39C12', '3498DB'
        ];
        
        $i = 0;
        foreach (Product::all() as $product) {
            $color = $colors[$i % count($colors)];
            ProductImage::create([
                'product_id' => $product->id,
                'image' => "https://placehold.co/400x300/{$color}/ffffff?text=" . urlencode(substr($product->name, 0, 20)),
                'is_primary' => true,
                'sort_order' => 0,
            ]);
            $i++;
        }
        
        echo "Product images updated successfully!\n";
    }
}
