@extends('backend.layouts.main')
@section('title', 'Orders')
@section('page_title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="" method="GET" class="d-flex gap-2">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <input type="text" name="search" class="form-control" placeholder="Order #, Name, Email..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Orders</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>
                            {{ $order->name }}
                            <br><small class="text-muted">{{ $order->phone }}</small>
                        </td>
                        <td>{{ $order->items->count() }}</td>
                        <td>{{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 2) }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ strtoupper($order->payment_method) }}</span>
                            <br>
                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
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
                        <td colspan="8" class="text-center py-4">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
</div>
@endsection
