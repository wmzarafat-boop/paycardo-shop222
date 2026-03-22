<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $sessionId = session()->getId();
        $carts = Cart::with('product', 'variant')
            ->where('session_id', $sessionId)
            ->orWhere('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $subtotal = $carts->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('frontend.checkout', compact('carts', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'payment_method' => 'required|in:cod,bkash,rocket,nagad',
            'payment_number' => 'nullable|string|max:20',
        ]);

        $sessionId = session()->getId();
        $carts = Cart::with('product', 'variant')
            ->where('session_id', $sessionId)
            ->orWhere('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $subtotal = $carts->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal,
            'payment_method' => $request->payment_method,
            'payment_number' => $request->payment_number,
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'variant_id' => $cart->variant_id,
                'product_name' => $cart->product->name,
                'variant_name' => $cart->variant?->name,
                'quantity' => $cart->quantity,
                'price' => $cart->price,
                'total' => $cart->price * $cart->quantity,
                'user_id_field' => $cart->user_id_field ?? null,
            ]);
        }

        $carts->each->delete();

        return redirect()->route('order.success', $order->id)->with('success', 'Order placed successfully!');
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('frontend.order-success', compact('order'));
    }
}
