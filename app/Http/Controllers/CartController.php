<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // public function cart_list(){
    //     return view('cart.list');
    // }

    public function index()
    {
        $cartItems = Cart::with('product.category')
            ->where('user_id', Auth::id())
            ->get();
 
        // Related products — same category, exclude already-carted items
        $relatedProducts = collect();
 
        if ($cartItems->isNotEmpty()) {
            $cartedIds  = $cartItems->pluck('product_id')->toArray();
            $categoryId = $cartItems->first()->product->category_id ?? null;
 
            $relatedProducts = Product::where('status', 'active')
                ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
                ->whereNotIn('id', $cartedIds)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        }
 
        return view('cart.list', compact('cartItems', 'relatedProducts'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'integer|min:1',
        ]);
 
        $quantity = $request->input('quantity', 1);
 
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
 
        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $quantity,
            ]);
        }
 
        return back()->with('cart_success', 'Product added to cart!');
    }

     public function update(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== Auth::id(), 403);
 
        $request->validate(['quantity' => 'required|integer|min:1']);
 
        $cart->update(['quantity' => $request->quantity]);
 
        // ── AJAX response ────────────────────────────────────────────────
        if ($request->expectsJson() || $request->hasHeader('X-HTTP-Method-Override')) {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();
 
            $originalTotal = $cartItems->sum(fn($i) =>
                ($i->product->original_price ?? $i->product->price) * $i->quantity
            );
            $currentTotal  = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
            $discount      = $originalTotal - $currentTotal;
            $fee           = 25.00;
            $finalTotal    = $currentTotal + $fee;
 
            return response()->json([
                'success'        => true,
                'original_total' => $originalTotal,
                'discount'       => $discount,
                'final_total'    => $finalTotal,
            ]);
        }
 
        // ── Normal form submit ───────────────────────────────────────────
        return back()->with('cart_success', 'Cart updated!');
    }

     public function destroy(Cart $cart)
    {
        abort_if($cart->user_id !== Auth::id(), 403);
 
        $cart->delete();
 
        return back()->with('cart_success', 'Item removed from cart.');
    }
}
