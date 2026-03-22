@extends('frontend.layouts.main')
@section('title', $product->name)
@section('content')

<section class="py-4" style="background-color: var(--card-bg); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.category', $product->category->slug ?? '') }}">{{ $product->category->name ?? '' }}</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm" style="background-color: var(--card-bg); border: 1px solid var(--border-color);">
                    @if($product->primaryImage)
                    <img src="{{ asset('storage/' . $product->primaryImage->image) }}" class="img-fluid rounded" alt="{{ $product->name }}" id="mainImage">
                    @else
                    <img src="https://via.placeholder.com/500x500/1e1e3f/6c5ce7?text={{ urlencode($product->name) }}" class="img-fluid rounded" alt="{{ $product->name }}" id="mainImage">
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="h3 mb-3 text-white">{{ $product->name }}</h1>
                <p class="text-muted mb-3">{{ $product->category->name ?? '' }}</p>

                <div class="mb-3">
                    @if($product->sale_price)
                    <span class="text-decoration-line-through text-muted h4">{{ settings('currency_symbol', '৳') }}{{ number_format($product->price, 2) }}</span>
                    <span class="text-danger h3 fw-bold ms-2">{{ settings('currency_symbol', '৳') }}{{ number_format($product->sale_price, 2) }}</span>
                    <span class="badge bg-danger ms-2">-{{ $product->discount_percent }}%</span>
                    @else
                    <span class="h3 fw-bold text-primary-custom">{{ settings('currency_symbol', '৳') }}{{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <p class="text-muted mb-4">{{ $product->short_description }}</p>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="variant_id" id="variantId" value="">

                    @if($product->has_variants && $product->variants->count() > 0)
                    <div class="mb-4">
                        <h6 class="text-white">Select Option:</h6>
                        <select name="variant_id" id="variantSelect" class="form-select" onchange="document.getElementById('variantId').value = this.value">
                            <option value="">Select an option</option>
                            @foreach($product->variants as $variant)
                            <option value="{{ $variant->id }}" data-price="{{ $variant->sale_price ?? $variant->price }}">
                                {{ $variant->name }} - {{ settings('currency_symbol', '৳') }}{{ number_format($variant->sale_price ?? $variant->price, 2) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    <div class="mb-4">
                        <h6 class="text-white">{{ $product->category->name ?? 'Game' }} UID *</h6>
                        <input type="text" name="user_id" id="userId" class="form-control" placeholder="Enter your {{ $product->category->name ?? 'Game' }} UID" required>
                        <small class="text-muted-custom">Please enter your correct {{ $product->category->name ?? 'Game' }} UID to receive your order</small>
                    </div>

                    <div class="mb-4">
                        <div class="input-group" style="width: 150px;">
                            <span class="input-group-text" style="background-color: var(--card-bg); border-color: var(--border-color); color: var(--text-primary);">Qty</span>
                            <input type="number" name="quantity" class="form-control" value="1" min="1">
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary-custom flex-grow-1">
                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="addToWishlist()">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </form>

                <hr class="my-4" style="border-color: var(--border-color);">

                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bolt text-primary-custom me-2"></i>
                            <small class="text-secondary">Instant Delivery</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt text-success me-2"></i>
                            <small class="text-secondary">Secure Payment</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-headset text-info me-2"></i>
                            <small class="text-secondary">24/7 Support</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-undo text-warning me-2"></i>
                            <small class="text-secondary">Easy Returns</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($product->description)
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="background-color: var(--card-bg); border: 1px solid var(--border-color);">
                    <div class="card-header" style="background-color: var(--dark-bg); border-bottom: 1px solid var(--border-color);">
                        <h5 class="mb-0 text-white">Description</h5>
                    </div>
                    <div class="card-body text-secondary">
                        {!! nl2br($product->description) !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-lg-12">
                <h4 class="section-title">Related Products</h4>
                <div class="row g-4">
                    @foreach($relatedProducts as $relProduct)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card card-custom h-100">
                            @if($relProduct->primaryImage)
                            <img src="{{ asset('storage/' . $relProduct->primaryImage->image) }}" class="card-img-top" alt="{{ $relProduct->name }}">
                            @else
                            <img src="https://via.placeholder.com/300x200/1e1e3f/6c5ce7?text={{ urlencode($relProduct->name) }}" class="card-img-top" alt="{{ $relProduct->name }}">
                            @endif
                            <div class="card-body text-center">
                                <h6 class="text-white">{{ Str::limit($relProduct->name, 30) }}</h6>
                                <span class="fw-bold text-primary-custom">{{ settings('currency_symbol', '৳') }}{{ number_format($relProduct->current_price, 0) }}</span>
                                <a href="{{ route('product', $relProduct->slug) }}" class="btn btn-sm btn-outline-primary-custom w-100 mt-2">View</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
document.getElementById('variantSelect').addEventListener('change', function() {
    document.getElementById('variantId').value = this.value;
});

function addToWishlist() {
    toastr.info('Wishlist feature coming soon!', 'Info');
}
</script>
@endpush
