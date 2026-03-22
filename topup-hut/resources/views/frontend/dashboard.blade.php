@extends('frontend.layouts.main')
@section('title', 'Dashboard')

@section('content')
<section class="py-4" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-orange">Home</a></li>
                <li class="breadcrumb-item active text-light">Dashboard</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5" style="background: linear-gradient(180deg, #0f0f23 0%, #1a1a2e 100%); min-height: 70vh;">
    <div class="container">
        <h2 class="mb-4 text-light">My Dashboard</h2>

        <div class="row">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center py-4" style="background: #1a1a2e;">
                    <i class="fas fa-box fa-3x text-orange mb-3"></i>
                    <h3 class="text-light">{{ auth()->user()->orders->count() }}</h3>
                    <p class="text-secondary mb-0">Total Orders</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center py-4" style="background: #1a1a2e;">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h3 class="text-light">{{ auth()->user()->orders()->where('order_status', 'delivered')->count() }}</h3>
                    <p class="text-secondary mb-0">Completed</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center py-4" style="background: #1a1a2e;">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h3 class="text-light">{{ auth()->user()->orders()->where('order_status', 'pending')->count() }}</h3>
                    <p class="text-secondary mb-0">Pending</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center py-4" style="background: #1a1a2e;">
                    <i class="fas fa-spinner fa-3x text-info mb-3"></i>
                    <h3 class="text-light">{{ auth()->user()->orders()->where('order_status', 'processing')->count() }}</h3>
                    <p class="text-secondary mb-0">Processing</p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm" style="background: #1a1a2e;">
                    <div class="card-header" style="background: #16213e;">
                        <h5 class="mb-0 text-light">Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-light"><strong>Name:</strong> {{ auth()->user()->name }}</p>
                        <p class="text-light"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p class="text-light"><strong>Phone:</strong> {{ auth()->user()->phone ?? 'Not set' }}</p>
                        <p class="text-light"><strong>Member Since:</strong> {{ auth()->user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm" style="background: #1a1a2e;">
                    <div class="card-header" style="background: #16213e;">
                        <h5 class="mb-0 text-light">Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        @forelse(auth()->user()->orders()->latest()->take(3)->get() as $order)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong class="text-light">{{ $order->order_number }}</strong>
                                <br><small class="text-secondary">{{ $order->created_at->format('d M Y') }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status_color }}">{{ ucfirst($order->order_status) }}</span>
                                <br>
                                <small class="text-orange">{{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 2) }}</small>
                            </div>
                        </div>
                        @empty
                        <p class="text-secondary mb-0">No orders yet</p>
                        @endforelse
                        <a href="{{ route('account.orders') }}" class="btn btn-sm btn-outline-orange mt-3">View All Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
