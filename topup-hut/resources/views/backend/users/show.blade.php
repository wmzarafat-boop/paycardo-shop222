@extends('backend.layouts.main')
@section('title', 'Customer Details')
@section('page_title', 'Customer Details')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Customer Info</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
                <p><strong>Address:</strong> {{ $user->address ?? '-' }}</p>
                <p><strong>City:</strong> {{ $user->city ?? '-' }}</p>
                <p><strong>Joined:</strong> {{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Order History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->orders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a></td>
                                <td>{{ settings('currency_symbol', '৳') }}{{ number_format($order->total, 2) }}</td>
                                <td><span class="badge bg-{{ $order->status_color }}">{{ ucfirst($order->order_status) }}</span></td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No orders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
