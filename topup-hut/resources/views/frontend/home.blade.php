@extends('frontend.layouts.main')
@section('title', 'Home')
@section('content')

<!-- Promo Banner for Mobile -->
<div class="promo-banner d-lg-none">
    <h3><i class="fas fa-gift me-2"></i>Special Offer</h3>
    <p>Get instant delivery on all top-ups!</p>
</div>

<!-- Hero Section -->
<section class="hero-gradient py-5 d-none d-lg-block">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-6 text-center text-lg-start">
                <h2 class="display-5 fw-bold mb-3">
                    <span class="logo-gradient">Welcome to</span>
                    <br>
                    <span class="text-white">{{ settings('site_name', 'Paycardo Shop') }}</span>
                </h2>
                <p class="text-muted-custom mb-4">{{ settings('site_tagline', 'Your Trusted Online Store') }}. Get instant delivery for gaming credits, social media services, visa cards, and more!</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('shop') }}" class="btn btn-primary-custom glow-btn">
                        <i class="fas fa-shopping-bag me-2"></i> Shop Now
                    </a>
                    <a href="{{ route('page', 'contact-us') }}" class="btn btn-outline-custom">
                        <i class="fas fa-headset me-2"></i> Contact Us
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center position-relative">
                <div class="position-absolute top-0 start-50 translate-middle-x w-75 h-75 rounded-circle" style="background: linear-gradient(135deg, rgba(255, 107, 0, 0.2), transparent); filter: blur(60px);"></div>
                <img src="https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2025/05/buy-virtual-card-bd.png" alt="Virtual Card" class="img-fluid rounded-3 shadow-lg position-relative" style="max-height: 350px;">
                <div class="position-absolute bottom-0 end-0 bg-primary text-white px-4 py-2 rounded-pill fw-bold shadow-lg mb-4 me-4" style="animation: bounce 2s infinite;">
                    <i class="fas fa-bolt me-2"></i>Instant Delivery
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trending Items -->
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-title mb-0">
                <i class="fas fa-fire text-primary-custom me-2"></i>Trending Items
            </h2>
            <a href="{{ route('shop') }}" class="text-primary-custom small">View All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="product-grid">
            @forelse($featuredProducts as $product)
            <div class="product-card-new">
                <div class="product-card-image">
                    @if($product->sale_price)
                    <span class="product-card-discount">-{{ $product->discount_percent }}%</span>
                    @else
                    <span class="product-card-badge"><i class="fas fa-bolt me-1"></i> Auto</span>
                    @endif
                    <a href="{{ route('product', $product->slug) }}">
                        <img src="{{ product_image($product) }}" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/400x400/16213e/FF6B00?text={{ urlencode(substr($product->name, 0, 10)) }}'">
                    </a>
                </div>
                <div class="product-card-content">
                    <h6 class="product-card-title">{{ Str::limit($product->name, 40) }}</h6>
                    <div class="product-card-price">
                        <span class="current-price">{{ settings('currency_symbol', '৳') }}{{ number_format($product->current_price, 0) }}</span>
                        @if($product->sale_price)
                        <span class="original-price">{{ settings('currency_symbol', '৳') }}{{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                    <a href="{{ route('product', $product->slug) }}" class="product-card-btn">
                        <i class="fas fa-shopping-cart me-2"></i> Buy Now
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted-custom">No trending products available.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Special Offer Banner -->
<section class="py-5">
    <div class="container">
        <div class="bg-gradient-to-r from-primary-custom/20 via-card to-primary-custom/20 rounded-3xl p-4 p-md-5 border border-primary-custom/30">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <span class="badge bg-primary mb-3">SPECIAL OFFER</span>
                    <h2 class="display-6 fw-bold text-white mb-3">Get <span class="text-primary-custom">67% OFF</span> on Virtual Visa Cards!</h2>
                    <p class="text-muted-custom mb-4">Limited time offer. Grab your reloadable virtual visa card now with instant activation.</p>
                    <a href="{{ route('shop.category', 'visa-card') }}" class="btn btn-primary-custom glow-btn">
                        <i class="fas fa-bolt me-2"></i> Claim Offer
                    </a>
                </div>
                <div class="col-lg-5 text-center">
                    <img src="https://gamingdemo7.wpcreatorbd.com/wp-content/uploads/2024/05/buy-redotpay-account-800x800.png" alt="Visa Card Offer" class="img-fluid rounded-3 shadow-lg" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Services -->
<section class="py-5" style="background: rgba(26, 26, 46, 0.3);">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-title mb-0">
                <i class="fas fa-share-alt text-primary-custom me-2"></i>Social Services
            </h2>
        </div>
        
        <!-- Filter Tabs -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button class="filter-btn active" onclick="filterSocial(this, 'all')">ALL</button>
            <button class="filter-btn" onclick="filterSocial(this, 'facebook')">Facebook</button>
            <button class="filter-btn" onclick="filterSocial(this, 'youtube')">YouTube</button>
            <button class="filter-btn" onclick="filterSocial(this, 'instagram')">Instagram</button>
            <button class="filter-btn" onclick="filterSocial(this, 'tiktok')">TikTok</button>
        </div>

        <div class="row g-4" id="socialProducts">
            @php
            $socialProducts = \App\Models\Product::whereHas('category', function($q) {
                $q->whereIn('slug', ['facebook', 'youtube', 'instagram', 'tiktok']);
            })->where('status', 'published')->limit(10)->get();
            @endphp
            @forelse($socialProducts as $product)
            <div class="col-lg-2 col-md-3 col-4 product-card" data-category="{{ $product->category->slug ?? 'other' }}">
                <a href="{{ route('product', $product->slug) }}">
                    <img src="{{ product_image($product) }}" class="card-img-top" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/200x200/16213e/FF6B00?text={{ urlencode(substr($product->name, 0, 8)) }}'">
                </a>
                <div class="p-3 text-center">
                    <h6 class="text-white mb-2" style="font-size: 0.8rem; line-height: 1.3;">{{ Str::limit($product->name, 30) }}</h6>
                    <a href="{{ route('product', $product->slug) }}" class="btn btn-outline-custom w-100 btn-sm">
                        Select Options
                    </a>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</section>

<!-- OTT Subscription -->
<section class="py-5" id="subscription">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-title mb-0">
                <i class="fas fa-tv text-primary-custom me-2"></i>OTT Subscription
            </h2>
        </div>
        <div class="row g-4">
            @php
            $subscriptionProducts = \App\Models\Product::whereHas('category', function($q) {
                $q->whereIn('slug', ['subscriptions', 'netflix', 'youtube-premium', 'canva-pro', 'disney-plus']);
            })->where('status', 'published')->limit(8)->get();
            @endphp
            @forelse($subscriptionProducts as $product)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product-card h-100">
                    <a href="{{ route('product', $product->slug) }}">
                        <img src="{{ product_image($product) }}" class="card-img-top" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/300x300/16213e/FF6B00?text={{ urlencode(substr($product->name, 0, 10)) }}'">
                    </a>
                    <div class="p-3 text-center">
                        <h6 class="text-white mb-2" style="font-size: 0.9rem;">{{ Str::limit($product->name, 35) }}</h6>
                        <a href="{{ route('product', $product->slug) }}" class="btn btn-primary-custom w-100 btn-sm">
                            Go Payment
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-3">
                <p class="text-muted-custom">No subscription products available.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Game Top Up -->
<section class="py-5" style="background: rgba(26, 26, 46, 0.3);" id="games">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-title mb-0">
                <i class="fas fa-gamepad text-primary-custom me-2"></i>Game Top Up
            </h2>
            <a href="{{ route('shop.category', 'games-top-up') }}" class="text-primary-custom small">View All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            @php
            $gameProducts = \App\Models\Product::whereHas('category', function($q) {
                $q->where('slug', 'games-top-up');
            })->orWhereHas('category', function($q) {
                $q->whereIn('slug', ['free-fire', 'pubg-mobile', 'mobile-legends', 'farlight-84']);
            })->where('status', 'published')->limit(10)->get();
            @endphp
            @forelse($gameProducts as $product)
            <div class="col-lg-2 col-md-3 col-4">
                <div class="product-card h-100">
                    <a href="{{ route('product', $product->slug) }}">
                        <img src="{{ product_image($product) }}" class="card-img-top" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/200x200/16213e/FF6B00?text={{ urlencode(substr($product->name, 0, 8)) }}'">
                    </a>
                    <div class="p-3 text-center">
                        <h6 class="text-white mb-2" style="font-size: 0.8rem;">{{ Str::limit($product->name, 30) }}</h6>
                        <a href="{{ route('product', $product->slug) }}" class="btn btn-outline-custom w-100 btn-sm">
                            Select Options
                        </a>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="feature-card">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-orange-600 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="fas fa-bolt text-2xl text-white"></i>
                    </div>
                    <h5 class="text-white fw-semibold mb-2">Instant Delivery</h5>
                    <p class="text-muted-custom small mb-0">Get your products delivered instantly after payment</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="feature-card">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-orange-600 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                    <h5 class="text-white fw-semibold mb-2">100% Secure</h5>
                    <p class="text-muted-custom small mb-0">Your payment information is always protected</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="feature-card">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-orange-600 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="fas fa-headset text-2xl text-white"></i>
                    </div>
                    <h5 class="text-white fw-semibold mb-2">24/7 Support</h5>
                    <p class="text-muted-custom small mb-0">Our team is always here to help you anytime</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="feature-card">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-orange-600 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-2xl text-white"></i>
                    </div>
                    <h5 class="text-white fw-semibold mb-2">Verified Quality</h5>
                    <p class="text-muted-custom small mb-0">All products are verified and guaranteed</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function filterSocial(btn, category) {
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(b => {
        b.classList.remove('active');
    });
    btn.classList.add('active');

    const products = document.querySelectorAll('#socialProducts .product-card');
    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}
</script>
@endpush
