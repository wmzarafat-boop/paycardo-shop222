<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->createAdminUser();
        $this->createCategories();
        $this->createProducts();
        $this->createSettings();
        $this->createPages();
    }

    protected function createAdminUser()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@topuphut.com',
            'password' => Hash::make('password'),
            'phone' => '01XXXXXXXXX',
            'role' => 'admin',
            'status' => true,
        ]);
    }

    protected function createCategories()
    {
        $categories = [
            ['name' => 'SMM Services', 'slug' => 'smm-services', 'icon' => 'fa-share-alt', 'is_featured' => true, 'children' => [
                ['name' => 'Facebook', 'slug' => 'facebook'],
                ['name' => 'YouTube', 'slug' => 'youtube'],
                ['name' => 'Instagram', 'slug' => 'instagram'],
                ['name' => 'TikTok', 'slug' => 'tiktok'],
            ]],
            ['name' => 'Visa Card', 'slug' => 'visa-card', 'icon' => 'fa-credit-card', 'is_featured' => true, 'children' => [
                ['name' => 'RedotPay', 'slug' => 'redotpay'],
                ['name' => 'Pyypl', 'slug' => 'pyypl'],
            ]],
            ['name' => 'Subscriptions', 'slug' => 'subscriptions', 'icon' => 'fa-play-circle', 'is_featured' => true, 'children' => [
                ['name' => 'Netflix', 'slug' => 'netflix'],
                ['name' => 'YouTube Premium', 'slug' => 'youtube-premium'],
                ['name' => 'Disney+', 'slug' => 'disney-plus'],
                ['name' => 'Canva Pro', 'slug' => 'canva-pro'],
            ]],
            ['name' => 'Gift Cards', 'slug' => 'gift-cards', 'icon' => 'fa-gift', 'is_featured' => true, 'children' => [
                ['name' => 'UniPin', 'slug' => 'unipin'],
                ['name' => 'Garena Shell', 'slug' => 'garena-shell'],
                ['name' => 'Apple iTunes', 'slug' => 'apple-itunes'],
            ]],
            ['name' => 'Games Top Up', 'slug' => 'games-top-up', 'icon' => 'fa-gamepad', 'is_featured' => true, 'children' => [
                ['name' => 'Free Fire', 'slug' => 'free-fire'],
                ['name' => 'PUBG Mobile', 'slug' => 'pubg-mobile'],
                ['name' => 'Mobile Legends', 'slug' => 'mobile-legends'],
                ['name' => 'Farlight 84', 'slug' => 'farlight-84'],
            ]],
            ['name' => 'USD Top Up', 'slug' => 'usd-top-up', 'icon' => 'fa-dollar-sign', 'is_featured' => true, 'children' => [
                ['name' => 'USDT', 'slug' => 'usdt'],
            ]],
        ];

        foreach ($categories as $order => $cat) {
            $children = $cat['children'] ?? [];
            unset($cat['children']);

            $cat['sort_order'] = $order;
            $parent = Category::create($cat);

            foreach ($children as $childOrder => $child) {
                $child['parent_id'] = $parent->id;
                $child['sort_order'] = $childOrder;
                Category::create($child);
            }
        }
    }

    protected function createProducts()
    {
        $products = [
            [
                'category' => 'facebook',
                'name' => 'Facebook Page Likes + Followers',
                'short_description' => 'Boost your Facebook page with real likes and followers',
                'price' => 45,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2024/05/Facebook-Page-Likes-Followers-800x800.png',
                'variants' => [
                    ['name' => '100 Likes', 'price' => 45],
                    ['name' => '500 Likes', 'price' => 200],
                    ['name' => '1000 Likes', 'price' => 380],
                    ['name' => '5000 Likes', 'price' => 2490],
                ]
            ],
            [
                'category' => 'youtube',
                'name' => 'Buy YouTube Subscribers',
                'short_description' => 'Grow your YouTube channel with real subscribers',
                'price' => 250,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2024/11/Buy-Youtube-Subscribers.png',
                'variants' => [
                    ['name' => '100 Subscribers', 'price' => 250],
                    ['name' => '500 Subscribers', 'price' => 1100],
                    ['name' => '1000 Subscribers', 'price' => 2000],
                    ['name' => '5000 Subscribers', 'price' => 12900],
                ]
            ],
            [
                'category' => 'youtube',
                'name' => 'Buy YouTube Views',
                'short_description' => 'Increase your YouTube video views',
                'price' => 30,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/09/Buy-YouTube-Views-800x800.png',
                'variants' => [
                    ['name' => '1000 Views', 'price' => 30],
                    ['name' => '5000 Views', 'price' => 120],
                    ['name' => '10000 Views', 'price' => 220],
                ]
            ],
            [
                'category' => 'tiktok',
                'name' => 'Buy TikTok Followers',
                'short_description' => 'Get real TikTok followers quickly',
                'price' => 35,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/09/TikTok-Followers-800x800.png',
                'variants' => [
                    ['name' => '100 Followers', 'price' => 35],
                    ['name' => '500 Followers', 'price' => 150],
                    ['name' => '1000 Followers', 'price' => 280],
                ]
            ],
            [
                'category' => 'instagram',
                'name' => 'Buy Instagram Followers',
                'short_description' => 'Boost your Instagram profile with followers',
                'price' => 40,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/09/Instagram-Followers-800x800.png',
                'variants' => [
                    ['name' => '100 Followers', 'price' => 40],
                    ['name' => '500 Followers', 'price' => 180],
                    ['name' => '1000 Followers', 'price' => 350],
                ]
            ],
            [
                'category' => 'redotpay',
                'name' => 'Reloadable Virtual Visa Card',
                'short_description' => 'Get your own reloadable virtual Visa card',
                'price' => 1500,
                'sale_price' => 500,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2024/05/buy-redotpay-account-800x800.png',
                'variants' => [
                    ['name' => 'Basic Plan', 'price' => 500],
                    ['name' => 'Standard Plan', 'price' => 1000],
                    ['name' => 'Premium Plan', 'price' => 1500],
                ]
            ],
            [
                'category' => 'youtube-premium',
                'name' => 'YouTube Premium Subscription',
                'short_description' => 'Ad-free YouTube with offline downloads',
                'price' => 199,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/03/YouTube-Premium-Subscription.png',
                'variants' => [
                    ['name' => '1 Month', 'price' => 199],
                    ['name' => '3 Months', 'price' => 550],
                    ['name' => '6 Months', 'price' => 1000],
                ]
            ],
            [
                'category' => 'canva-pro',
                'name' => 'Canva Pro Subscription',
                'short_description' => 'Premium design tools with Canva Pro',
                'price' => 299,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/03/Canva-Pro-Subscriptions.webp',
                'variants' => [
                    ['name' => '1 Month', 'price' => 299],
                    ['name' => '3 Months', 'price' => 799],
                    ['name' => '6 Months', 'price' => 1499],
                ]
            ],
            [
                'category' => 'free-fire',
                'name' => 'Free Fire Diamond Top Up BD',
                'short_description' => 'Top up your Free Fire diamonds instantly',
                'price' => 50,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/03/unnamed.png',
                'variants' => [
                    ['name' => '50 Diamonds', 'price' => 50],
                    ['name' => '100 Diamonds', 'price' => 95],
                    ['name' => '310 Diamonds', 'price' => 280],
                    ['name' => '520 Diamonds', 'price' => 450],
                ]
            ],
            [
                'category' => 'free-fire',
                'name' => 'Free Fire Membership BD',
                'short_description' => 'Weekly and monthly Free Fire memberships',
                'price' => 180,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/08/Free-Fire-Membership-BD-800x800.png',
                'variants' => [
                    ['name' => 'Weekly', 'price' => 180],
                    ['name' => 'Monthly', 'price' => 650],
                ]
            ],
            [
                'category' => 'unipin',
                'name' => 'UniPin 2000 UC BDT',
                'short_description' => 'Buy UniPin vouchers for games',
                'price' => 200,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2024/07/UniPin-2000-UC-BDT-Gift-Card.png',
                'variants' => [
                    ['name' => '1000 UC', 'price' => 100],
                    ['name' => '2000 UC', 'price' => 200],
                    ['name' => '5000 UC', 'price' => 480],
                ]
            ],
            [
                'category' => 'pubg-mobile',
                'name' => 'PUBG Mobile UC Top Up',
                'short_description' => 'Top up PUBG Mobile UC instantly',
                'price' => 60,
                'sale_price' => null,
                'is_featured' => true,
                'image' => 'https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/04/PUBG-Mobile-UC-Global-PIN-800x800.webp',
                'variants' => [
                    ['name' => '60 UC', 'price' => 60],
                    ['name' => '300 UC', 'price' => 280],
                    ['name' => '600 UC', 'price' => 550],
                    ['name' => '1500 UC', 'price' => 1350],
                ]
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category'])->first();
            $variants = $productData['variants'];
            $productImage = $productData['image'] ?? null;
            unset($productData['variants'], $productData['category'], $productData['image']);

            $productData['category_id'] = $category->id;
            $productData['slug'] = Str::slug($productData['name']);
            $productData['status'] = 'published';
            $productData['has_variants'] = count($variants) > 1;
            $productData['stock'] = 999;
            $productData['sku'] = strtoupper(Str::random(8));

            $product = Product::create($productData);

            foreach ($variants as $variantData) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $variantData['name'],
                    'sku' => strtoupper(Str::random(6)),
                    'price' => $variantData['price'],
                    'stock' => 999,
                    'status' => true,
                ]);
            }

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $productImage ?? 'https://placehold.co/400x400/16213e/FF6B00?text=' . urlencode(substr($productData['name'], 0, 10)),
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }
    }

    protected function createSettings()
    {
        $settings = [
            'site_name' => 'Paycardo Shop',
            'site_tagline' => 'Your Trusted Online Store',
            'logo' => 'logo.png',
            'favicon' => 'favicon.ico',
            'currency' => 'BDT',
            'currency_symbol' => '৳',
            'phone' => '+8801850603187',
            'email' => 'wmzarafat@gmail.com',
            'address' => 'Dhaka, Bangladesh',
            'facebook' => 'https://facebook.com/topuphut',
            'youtube' => 'https://youtube.com/@topuphut',
            'bkash_number' => '01850603187',
            'rocket_number' => '01850603187',
            'nagad_number' => '01850603187',
        ];

        foreach ($settings as $key => $value) {
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => is_numeric($value) ? 'number' : 'text',
            ]);
        }
    }

    protected function createPages()
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<div class="text-center py-5"><h1 class="mb-4">About Paycardo Shop</h1><p class="lead">Your trusted online top-up store in Bangladesh.</p><p>We provide instant delivery for gaming credits, social media services, visa cards, subscriptions, and more. Our mission is to deliver quality services at affordable prices with 24/7 customer support.</p><div class="row mt-5"><div class="col-md-4"><div class="p-4 bg-card rounded"><i class="fas fa-bolt text-primary fs-1 mb-3"></i><h4>Instant Delivery</h4><p>Get your products delivered instantly after payment</p></div></div><div class="col-md-4"><div class="p-4 bg-card rounded"><i class="fas fa-shield-alt text-primary fs-1 mb-3"></i><h4>100% Secure</h4><p>Your payment information is always protected</p></div></div><div class="col-md-4"><div class="p-4 bg-card rounded"><i class="fas fa-headset text-primary fs-1 mb-3"></i><h4>24/7 Support</h4><p>Our team is always here to help you anytime</p></div></div></div></div>',
                'status' => 'active',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<div class="py-5"><h1 class="text-center mb-4">Contact Us</h1><div class="row"><div class="col-md-6 mb-4"><h4>Contact Information</h4><p class="mt-4"><i class="fas fa-envelope me-2 text-primary"></i> Email: wmzarafat@gmail.com</p><p><i class="fas fa-phone me-2 text-primary"></i> Phone: +8801850603187</p><p><i class="fab fa-whatsapp me-2 text-primary"></i> WhatsApp: +8801850603187</p><p><i class="fas fa-map-marker-alt me-2 text-primary"></i> Address: Dhaka, Bangladesh</p></div><div class="col-md-6"><h4>Send us a Message</h4><form class="mt-4"><div class="mb-3"><input type="text" class="form-control" placeholder="Your Name"></div><div class="mb-3"><input type="email" class="form-control" placeholder="Your Email"></div><div class="mb-3"><textarea class="form-control" rows="4" placeholder="Your Message"></textarea></div><button type="submit" class="btn btn-primary-custom">Send Message</button></form></div></div></div>',
                'status' => 'active',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<div class="py-5"><h1 class="text-center mb-4">Privacy Policy</h1><div class="card p-4"><p>Last updated: 2024</p><h4>1. Information We Collect</h4><p>We collect information you provide directly to us, such as when you create an account, place an order, or contact us for support.</p><h4>2. How We Use Your Information</h4><p>We use the information we collect to process orders, provide customer support, and improve our services.</p><h4>3. Information Sharing</h4><p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent.</p><h4>4. Data Security</h4><p>We implement appropriate security measures to protect your personal information.</p></div></div>',
                'status' => 'active',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'content' => '<div class="py-5"><h1 class="text-center mb-4">Terms & Conditions</h1><div class="card p-4"><p>Last updated: 2024</p><h4>1. Acceptance of Terms</h4><p>By accessing and using Paycardo Shop, you accept and agree to be bound by the terms and provisions of this agreement.</p><h4>2. Products & Services</h4><p>All products and services are subject to availability. We reserve the right to modify or discontinue any product without notice.</p><h4>3. Payment Terms</h4><p>Payment must be made in full before order processing. We accept bKash, Nagad, Rocket, and Cash on Delivery.</p><h4>4. Delivery</h4><p>Digital products are delivered instantly after payment confirmation. Physical products are delivered within 24-48 hours.</p><h4>5. Refund Policy</h4><p>Refunds are only available for failed deliveries. Once a product is delivered, no refunds will be issued.</p></div></div>',
                'status' => 'active',
            ],
            [
                'title' => 'Refund Policy',
                'slug' => 'refund-policy',
                'content' => '<div class="py-5"><h1 class="text-center mb-4">Refund Policy</h1><div class="card p-4"><p>We want you to be satisfied with your purchase. Here is our refund policy:</p><h4>Eligibility for Refund</h4><ul><li>Refunds are only available if the product/service is not delivered within the specified time</li><li>Technical issues that prevent product activation</li><li>Duplicate charges</li></ul><h4>How to Request a Refund</h4><p>Contact us via email or WhatsApp with your order number and reason for refund request.</p><h4>Processing Time</h4><p>Refund requests are processed within 24-48 hours after approval.</p></div></div>',
                'status' => 'active',
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'content' => '<div class="py-5"><h1 class="text-center mb-4">Frequently Asked Questions</h1><div class="card p-4"><div class="mb-4"><h4>How do I place an order?</h4><p>Select your desired product, add to cart, proceed to checkout, and complete payment via bKash, Nagad, or Rocket.</p></div><div class="mb-4"><h4>How long does delivery take?</h4><p>Digital products are delivered instantly (usually within 5-30 minutes) after payment confirmation.</p></div><div class="mb-4"><h4>What payment methods do you accept?</h4><p>We accept bKash, Nagad, Rocket, and Cash on Delivery.</p></div><div class="mb-4"><h4>Is my payment secure?</h4><p>Yes, all payments are processed securely through official payment gateways.</p></div><div class="mb-4"><h4>How can I contact customer support?</h4><p>You can reach us via email (wmzarafat@gmail.com) or WhatsApp (+8801850603187).</p></div></div></div>',
                'status' => 'active',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
