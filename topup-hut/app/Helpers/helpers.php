<?php

if (!function_exists('settings')) {
    function settings($key, $default = null) {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('cart_count')) {
    function cart_count() {
        return \App\Models\Cart::where('session_id', session()->getId())
            ->orWhere('user_id', auth()->id())
            ->sum('quantity');
    }
}

if (!function_exists('product_image')) {
    function product_image($product, $default = null) {
        $image = $product->primaryImage;
        
        // If no primary image, try first image
        if (!$image) {
            $image = $product->images()->first();
        }
        
        if ($image) {
            $url = $image->image;
            
            // If it's already a full URL
            if (str_starts_with($url, 'http')) {
                return $url;
            }
            
            // Return as storage asset with /storage/ prefix
            return url('storage/' . $url);
        }
        
        // Return placeholder with product name
        return $default ?? 'https://placehold.co/400x400/16213e/FF6B00?text=' . urlencode(substr($product->name ?? 'Product', 0, 15));
    }
}
