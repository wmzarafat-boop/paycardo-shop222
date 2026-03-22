@extends('frontend.layouts.main')
@section('title', 'My Orders')

@section('content')
<section class="py-4" style="background-color: var(--card-bg); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-muted-custom">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('account.index') }}" class="text-muted-custom">Dashboard</a></li>
                <li class="breadcrumb-item active text-primary-custom">My Orders</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4 text-white">My Orders</h2>

        @if($orders->isEmpty())
        <div class="alert text-center py-5" style="background-color: var(--card-bg); border: 1px solid var(--border-color);">
            <i class="fas fa-box fa-4x mb-3 text-muted"></i>
            <h4 class="text-white">No orders yet</h4>
            <p class="text-muted">Start shopping to place your first order!</p>
            <a href="{{ route('shop') }}" class="btn btn-primary-custom">Shop Now</a>
        </div>
        @else
        <div class="row g-4">
            @foreach($orders as $order)
            <div class="col-md-6">
                <div class="card h-100" style="background-color: var(--card-bg); border: 1px solid var(--border-color);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="text-white mb-1">{{ $order->order_number }}</h5>
                                <small class="text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</small>
                            </div>
                            <span class="badge bg-{{ $order->status_color }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted">{{ $order->items->count() }} items</small>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="text-primary-custom mb-0">{{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 0) }}</h4>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="background-color: var(--card-bg);">
                        <div class="modal-header" style="border-color: var(--border-color);">
                            <h5 class="modal-title text-white">Order {{ $order->order_number }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-white">Order Info</h6>
                                    <p class="text-muted mb-1"><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                                    <p class="text-muted mb-1"><strong>Payment:</strong> {{ strtoupper($order->payment_method) }}</p>
                                    <p class="text-muted mb-1"><strong>Total:</strong> {{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 2) }}</p>
                                    @if($order->transaction_id)
                                    <p class="text-muted mb-0"><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-white">Shipping Info</h6>
                                    <p class="text-muted mb-1"><strong>Name:</strong> {{ $order->name }}</p>
                                    <p class="text-muted mb-1"><strong>Phone:</strong> {{ $order->phone }}</p>
                                    <p class="text-muted mb-0"><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <hr style="border-color: var(--border-color);">
                            <h6 class="text-white">Order Items</h6>
                            @foreach($order->items as $item)
                            <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--border-color) !important;">
                                <div>
                                    <span class="text-white">{{ $item->product_name }}</span>
                                    @if($item->variant_name)
                                    <br><small class="text-muted">{{ $item->variant_name }}</small>
                                    @endif
                                    @if($item->user_id_field)
                                    <br><small class="text-primary-custom"><i class="fas fa-user me-1"></i> UID: {{ $item->user_id_field }}</small>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <span class="text-white">{{ settings('currency_symbol', '৳') }}{{ number_format($item->total, 2) }}</span>
                                    <br><small class="text-muted">x{{ $item->quantity }}</small>
                                </div>
                            </div>
                            @endforeach
                            <div class="d-flex justify-content-between mt-3 pt-3 border-top" style="border-color: var(--border-color) !important;">
                                <strong class="text-white">Total</strong>
                                <strong class="text-primary-custom">{{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
