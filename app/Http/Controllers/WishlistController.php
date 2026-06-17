<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
public function wishlist()
{
    $wishlistItems = Wishlist::with('product.category')
        ->where('user_id', Auth::id())
        ->get();

    // Related products — same category, exclude already wishlisted items
    $relatedProducts = collect();

    if ($wishlistItems->isNotEmpty()) {

        $wishlistedIds = $wishlistItems->pluck('product_id')->toArray();

        $categoryId = $wishlistItems->first()->product->category_id ?? null;

        $relatedProducts = Product::where('status', 'active')
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->whereNotIn('id', $wishlistedIds)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    return view('user_account.wishlist', compact(
        'wishlistItems',
        'relatedProducts'
    ));
}

    public function store(Request $request)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist'
            ]);
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist'
        ]);
    }

    public function destroy($id)
{
    $wishlist = Wishlist::where('id', $id)
        ->where('user_id', auth()->id())
        ->first();

    if (!$wishlist) {
        return response()->json([
            'success' => false,
            'message' => 'Wishlist item not found.'
        ]);
    }

    $wishlist->delete();

    return response()->json([
        'success' => true,
        'message' => 'Removed from wishlist.'
    ]);
}
}
