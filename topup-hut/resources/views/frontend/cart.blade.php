@extends('frontend.layouts.main')
@section('title', 'Shopping Cart')
@section('content')

<section class="py-4 bg-white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Cart</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Shopping Cart</h2>

        @if($carts->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-shopping-cart fa-4x mb-3 text-muted"></i>
            <h4>Your cart is empty</h4>
            <p class="text-muted">Browse our products and add items to your cart.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary-custom">Continue Shopping</a>
        </div>
        @else
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $cart)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($cart->product && $cart->product->primaryImage)
                                                <img src="{{ product_image($cart->product) }}" alt="" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                                                @else
                                                <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                                @endif
                                                <div>
                                                    <strong class="text-white">{{ $cart->product->name ?? 'Product' }}</strong>
                                                    @if($cart->variant)
                                                    <br><small class="text-muted">{{ $cart->variant->name }}</small>
                                                    @endif
                                                    @if($cart->user_id_field)
                                                    <br><small class="text-primary-custom"><i class="fas fa-user me-1"></i> UID: {{ $cart->user_id_field }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-white">{{ settings('currency_symbol', '৳') }}{{ number_format($cart->price, 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="d-flex gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" class="form-control" style="width: 70px;">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                            </form>
                                        </td>
                                        <td class="text-white">{{ settings('currency_symbol', '৳') }}{{ number_format($cart->price * $cart->quantity, 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Clear Cart</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>{{ settings('currency_symbol', '৳') }}{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Discount</span>
                            <span>{{ settings('currency_symbol', '৳') }}0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong class="text-primary-custom h5">{{ settings('currency_symbol', '৳') }}{{ number_format($subtotal, 2) }}</strong>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-primary-custom w-100">
                            Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
