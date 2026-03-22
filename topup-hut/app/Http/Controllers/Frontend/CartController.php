<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = $this->getCartItems();
        $subtotal = $carts->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('frontend.cart', compact('carts', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        $variantId = $request->variant_id ? ProductVariant::find($request->variant_id) : null;

        $sessionId = session()->getId();

        // Check if product has variants and require variant selection
        if ($product->has_variants && $product->variants->count() > 0 && !$request->variant_id) {
            return redirect()->back()->with('error', 'Please select an option');
        }

        // Check if product has variants and require user_id
        if ($product->has_variants && $product->variants->count() > 0 && !$request->user_id) {
            return redirect()->back()->with('error', 'Please enter your ' . ($product->category->name ?? 'Game') . ' UID');
        }

        $cart = Cart::where('session_id', $sessionId)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $variantId?->id)
            ->first();

        if ($cart) {
            $cart->update([
                'quantity' => $cart->quantity + $request->quantity,
            ]);
            if ($request->user_id) {
                $cart->update(['user_id_field' => $request->user_id]);
            }
        } else {
            Cart::create([
                'session_id' => $sessionId,
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'variant_id' => $variantId?->id,
                'quantity' => $request->quantity,
                'user_id_field' => $request->user_id ?? null,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        Cart::truncate();
        return redirect()->route('cart')->with('success', 'Cart cleared!');
    }

    private function getCartItems()
    {
        $sessionId = session()->getId();
        return Cart::with('product.primaryImage', 'variant')
            ->where('session_id', $sessionId)
            ->orWhere('user_id', auth()->id())
            ->get();
    }

    public function count()
    {
        return Cart::where('session_id', session()->getId())
            ->orWhere('user_id', auth()->id())
            ->sum('quantity');
    }
}
