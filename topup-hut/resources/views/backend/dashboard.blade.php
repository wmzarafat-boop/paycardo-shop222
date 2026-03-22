@extends('backend.layouts.main')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="text-primary mb-2"><i class="fas fa-shopping-cart fa-2x"></i></div>
                <h3 class="mb-0">{{ $stats['total_orders'] }}</h3>
                <small class="text-muted">Total Orders</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="text-warning mb-2"><i class="fas fa-clock fa-2x"></i></div>
                <h3 class="mb-0">{{ $stats['pending_orders'] }}</h3>
                <small class="text-muted">Pending Orders</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="text-info mb-2"><i class="fas fa-box fa-2x"></i></div>
                <h3 class="mb-0">{{ $stats['total_products'] }}</h3>
                <small class="text-muted">Total Products</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="text-success mb-2"><i class="fas fa-users fa-2x"></i></div>
                <h3 class="mb-0">{{ $stats['total_customers'] }}</h3>
                <small class="text-muted">Total Customers</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i> Recent Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ $order->name }}</td>
                                <td>{{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No orders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Low Stock Alert</h5>
            </div>
            <div class="card-body">
                @forelse($low_stock_products as $product)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>{{ $product->name }}</strong>
                        <br><small class="text-muted">Stock: {{ $product->stock }}</small>
                    </div>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                @empty
                <p class="text-muted mb-0">All products are well stocked</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-star me-2"></i> Top Products</h5>
            </div>
            <div class="card-body">
                @forelse($top_products as $product)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ Str::limit($product->name, 25) }}</span>
                    <span class="badge bg-primary">{{ $product->order_items_count ?? 0 }} sold</span>
                </div>
                @empty
                <p class="text-muted mb-0">No sales yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
