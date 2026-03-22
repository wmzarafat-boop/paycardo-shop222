@extends('frontend.layouts.main')
@section('title', 'Checkout')
@section('content')

<section class="py-4 bg-white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Checkout</h2>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Billing Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name ?? '' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email ?? '' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone *</label>
                                    <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone ?? '' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" value="{{ auth()->user()->city ?? '' }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control" rows="2">{{ auth()->user()->address ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Payment Method</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" checked>
                                        <label class="form-check-label" for="cod">
                                            <i class="fas fa-money-bill-wave text-success me-2"></i> Cash on Delivery
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="payment_method" value="bkash" id="bkash">
                                        <label class="form-check-label" for="bkash">
                                            <i class="fas fa-mobile-alt text-danger me-2"></i> bKash
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="payment_method" value="rocket" id="rocket">
                                        <label class="form-check-label" for="rocket">
                                            <i class="fas fa-rocket text-warning me-2"></i> Rocket
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="payment_method" value="nagad" id="nagad">
                                        <label class="form-check-label" for="nagad">
                                            <i class="fas fa-dot-circle text-warning me-2"></i> Nagad
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3" id="paymentNumberField" style="display: none;">
                                <div class="alert alert-info mb-3">
                                    <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i> Payment Instructions</h6>
                                    <p class="mb-1 small">Go to your bKash / Nagad / Rocket app.</p>
                                    <p class="mb-1 small">Select "Send Money".</p>
                                    <p class="mb-1 small">Enter the number: <strong id="paymentNumberDisplay">{{ settings('bkash_number', '01850603187') }}</strong></p>
                                    <p class="mb-1 small">Enter the amount: <strong>{{ settings('currency_symbol', '৳') }}{{ number_format($subtotal, 0) }}</strong></p>
                                    <p class="mb-0 small">Enter your PIN to complete the transaction.</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Send Money To</label>
                                    <div class="d-flex gap-2 flex-wrap mb-2">
                                        <span class="badge bg-danger px-3 py-2">bKash: {{ settings('bkash_number', '01850603187') }}</span>
                                        <span class="badge bg-warning text-dark px-3 py-2">Nagad: {{ settings('nagad_number', '01850603187') }}</span>
                                        <span class="badge bg-secondary px-3 py-2">Rocket: {{ settings('rocket_number', '01850603187') }}</span>
                                    </div>
                                </div>
                                <label class="form-label">Transaction ID *</label>
                                <input type="text" name="transaction_id" class="form-control" placeholder="Enter your transaction ID">
                                <small class="text-muted">After successful payment, you will receive a Transaction ID. Please enter it here.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            @foreach($carts as $cart)
                            <div class="d-flex justify-content-between mb-2">
                                <small>{{ $cart->product->name ?? 'Product' }} x {{ $cart->quantity }}</small>
                                <small>{{ settings('currency_symbol', '৳') }}{{ number_format($cart->price * $cart->quantity, 2) }}</small>
                            </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>{{ settings('currency_symbol', '৳') }}{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total</strong>
                                <strong class="text-primary-custom h5">{{ settings('currency_symbol', '৳') }}{{ number_format($subtotal, 2) }}</strong>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-check me-2"></i> Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var field = document.getElementById('paymentNumberField');
        var displayNumber = document.getElementById('paymentNumberDisplay');
        var paymentNumber = '{{ settings('bkash_number', '01850603187') }}';
        
        if (this.value === 'bkash') {
            paymentNumber = '{{ settings('bkash_number', '01850603187') }}';
        } else if (this.value === 'rocket') {
            paymentNumber = '{{ settings('rocket_number', '01850603187') }}';
        } else if (this.value === 'nagad') {
            paymentNumber = '{{ settings('nagad_number', '01850603187') }}';
        }
        
        if (this.value !== 'cod') {
            field.style.display = 'block';
            displayNumber.textContent = paymentNumber;
        } else {
            field.style.display = 'none';
        }
    });
});
</script>
@endpush
