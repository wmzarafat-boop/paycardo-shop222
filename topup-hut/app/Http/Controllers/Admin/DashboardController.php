<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total'),
        ];

        $recent_orders = Order::with('user')->latest()->take(10)->get();
        $top_products = Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get();
        $low_stock_products = Product::where('stock', '<', 10)->where('has_variants', false)->take(5)->get();

        return view('backend.dashboard', compact('stats', 'recent_orders', 'top_products', 'low_stock_products'));
    }
}
