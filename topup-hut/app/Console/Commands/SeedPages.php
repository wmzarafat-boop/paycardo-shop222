<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;

class SeedPages extends Command
{
    protected $signature = 'seed:pages';
    protected $description = 'Seed default pages';

    public function handle()
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<div class="text-center py-5"><h1 class="mb-4">About Paycardo Shop</h1><p class="lead">Your trusted online top-up store in Bangladesh.</p><p>We provide instant delivery for gaming credits, social media services, visa cards, subscriptions, and more.</p></div>',
                'status' => 'active',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<div class="py-5"><h1 class="text-center mb-4">Contact Us</h1><div class="row"><div class="col-md-6 mb-4"><h4>Contact Information</h4><p class="mt-4"><i class="fas fa-envelope me-2"></i> Email: wmzarafat@gmail.com</p><p><i class="fas fa-phone me-2"></i> Phone: +8801850603187</p><p><i class="fab fa-whatsapp me-2"></i> WhatsApp: +8801850603187</p><p><i class="fas fa-map-marker-alt me-2"></i> Address: Dhaka, Bangladesh</p></div></div></div>',
                'status' => 'active',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<div class="py-5"><h1 class="text-center mb-4">Privacy Policy</h1><p>Last updated: 2024</p><p>We collect information you provide directly to us. We use the information to process orders and improve our services.</p></div>',
                'status' => 'active',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'content' => '<div class="py-5"><h1 class="text-center mb-4">Terms & Conditions</h1><p>By accessing Paycardo Shop, you agree to our terms. All products are subject to availability.</p></div>',
                'status' => 'active',
            ],
        ];

        foreach ($pages as $pageData) {
            $page = Page::where('slug', $pageData['slug'])->first();
            if (!$page) {
                Page::create($pageData);
                $this->info("Created page: " . $pageData['title']);
            } else {
                $this->info("Page exists: " . $pageData['title']);
            }
        }

        $this->info('Done!');
    }
}
