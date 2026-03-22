<?php

require 'vendor/autoload.php';

$products = [
    ['name' => 'facebook-page-likes-followers', 'color' => '#1877F2'],
    ['name' => 'youtube-subscribers', 'color' => '#FF0000'],
    ['name' => 'youtube-views', 'color' => '#FF0000'],
    ['name' => 'tiktok-followers', 'color' => '#000000'],
    ['name' => 'instagram-followers', 'color' => '#E4405F'],
    ['name' => 'redotpay', 'color' => '#6C5CE7'],
    ['name' => 'youtube-premium', 'color' => '#FF0000'],
    ['name' => 'canva-pro', 'color' => '#00C4CC'],
    ['name' => 'free-fire-diamond', 'color' => '#F39C12'],
    ['name' => 'free-fire-membership', 'color' => '#F39C12'],
    ['name' => 'unipin', 'color' => '#3498DB'],
    ['name' => 'pubg-mobile-uc', 'color' => '#F7DC6F'],
    ['name' => 'default', 'color' => '#6C5CE7'],
];

foreach ($products as $product) {
    $width = 400;
    $height = 300;
    
    $image = imagecreatetruecolor($width, $height);
    
    $bgColor = imagecolorallocate($image, 30, 30, 50);
    imagefill($image, 0, 0, $bgColor);
    
    $hex = ltrim($product['color'], '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $accentColor = imagecolorallocate($image, $r, $g, $b);
    
    $textColor = imagecolorallocate($image, 255, 255, 255);
    
    imagestring($image, 5, 120, 130, 'TOPUP', $textColor);
    imagestring($image, 5, 100, 150, 'HUT', $accentColor);
    
    $filename = 'storage/app/public/products/' . $product['name'] . '.png';
    imagepng($image, $filename);
    imagedestroy($image);
    
    echo "Created: " . $filename . "\n";
}

echo "\nAll images created successfully!";
