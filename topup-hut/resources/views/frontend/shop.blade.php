@extends('frontend.layouts.main')
@section('title', 'Shop')
@section('content')

<section class="py-4" style="background-color: var(--card-bg); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Shop</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm mb-4" style="background-color: var(--card-bg); border: 1px solid var(--border-color);">
                    <div class="card-header" style="background-color: var(--dark-bg); border-bottom: 1px solid var(--border-color);">
                        <h6 class="mb-0 text-white">Categories</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="{{ route('shop') }}" class="text-decoration-none {{ !isset($category) ? 'text-primary-custom fw-bold' : 'text-secondary' }}">
                                    All Products
                                </a>
                            </li>
                            @foreach($categories as $cat)
                            <li class="mb-2">
                                <a href="{{ route('shop.category', $cat->slug) }}" class="text-decoration-none {{ isset($category) && $category->id == $cat->id ? 'text-primary-custom fw-bold' : 'text-secondary' }}">
                                    <i class="fas {{ $cat->icon ?? 'fa-folder' }} me-2"></i>{{ $cat->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 text-white">{{ isset($category) ? $category->name : (isset($searchQuery) ? 'Search Results: ' . $searchQuery : 'All Products') }}</h4>
                    <span class="text-secondary">{{ $products->total() }} Products</span>
                </div>

                @if($products->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No products found.
                </div>
                @endif

                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card card-custom h-100 position-relative">
                            @if($product->sale_price)
                            <span class="product-badge">-{{ $product->discount_percent }}%</span>
                            @endif
                            @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                            <img src="https://via.placeholder.com/300x200/1e1e3f/6c5ce7?text={{ urlencode($product->name) }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <div class="card-body text-center">
                                <h6 class="card-title text-white">{{ Str::limit($product->name, 35) }}</h6>
                                <p class="text-muted small mb-2">{{ $product->category->name ?? '' }}</p>
                                <div class="mb-2">
                                    @if($product->sale_price)
                                    <span class="text-decoration-line-through text-muted">{{ settings('currency_symbol', '৳') }}{{ number_format($product->price, 0) }}</span>
                                    <span class="text-danger fw-bold">{{ settings('currency_symbol', '৳') }}{{ number_format($product->sale_price, 0) }}</span>
                                    @else
                                    <span class="fw-bold text-primary-custom">{{ settings('currency_symbol', '৳') }}{{ number_format($product->price, 0) }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('product', $product->slug) }}" class="btn btn-sm btn-primary-custom w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
