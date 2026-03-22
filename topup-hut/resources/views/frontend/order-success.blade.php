@extends('frontend.layouts.main')
@section('title', 'Order Success')
@section('content')

<section class="py-5">
    <div class="container">
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success fa-5x"></i>
            </div>
            <h1 class="mb-3">Order Placed Successfully!</h1>
            <p class="lead text-muted">Thank you for your order. Your order number is <strong>{{ $order->order_number }}</strong></p>

            <div class="card border-0 shadow-sm mx-auto mt-4" style="max-width: 500px;">
                <div class="card-body text-start">
                    <h5>Order Details</h5>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Order Number:</div>
                        <div class="col-6 fw-bold">{{ $order->order_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Total Amount:</div>
                        <div class="col-6 fw-bold text-primary-custom">{{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 2) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Payment Method:</div>
                        <div class="col-6">{{ strtoupper($order->payment_method) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Status:</div>
                        <div class="col-6">
                            <span class="badge bg-warning">Pending</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($order->payment_method !== 'cod')
            <div class="card border-0 shadow-sm mx-auto mt-4" style="max-width: 500px;">
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-mobile-alt text-danger me-2"></i> Payment Instructions</h5>
                    <hr>
                    <p class="mb-2"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                    <p class="mb-2"><strong>Amount:</strong> {{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 0) }}</p>
                    <p class="mb-3"><strong>Send Money To:</strong></p>
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <span class="badge bg-danger px-3 py-2">bKash: {{ settings('bkash_number', '01850603187') }}</span>
                        <span class="badge bg-warning text-dark px-3 py-2">Nagad: {{ settings('nagad_number', '01850603187') }}</span>
                        <span class="badge bg-secondary px-3 py-2">Rocket: {{ settings('rocket_number', '01850603187') }}</span>
                    </div>
                    <hr>
                    <h6>How to Pay:</h6>
                    <ol class="small text-muted mb-0">
                        <li>Go to your bKash / Nagad / Rocket app</li>
                        <li>Select "Send Money"</li>
                        <li>Enter the number above</li>
                        <li>Enter the amount: {{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 0) }}</li>
                        <li>Enter your PIN to complete the transaction</li>
                        <li>After successful payment, note your Transaction ID</li>
                    </ol>
                    @if($order->transaction_id)
                    <div class="alert alert-success mt-3 mb-0">
                        <strong>Transaction ID:</strong> {{ $order->transaction_id }}
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="mt-5">
                <a href="{{ route('shop') }}" class="btn btn-primary-custom me-3">
                    <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                </a>
                @auth
                <a href="{{ route('my.orders') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-box me-2"></i> View My Orders
                </a>
                @endauth
            </div>
        </div>
    </div>
</section>

@endsection
