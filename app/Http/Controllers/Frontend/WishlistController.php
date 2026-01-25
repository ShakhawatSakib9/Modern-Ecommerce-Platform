<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Product;
use App\Models\Backend\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WishlistController extends Controller
{
    // Get current wishlist identifier (user_id or session_id)
    private function getWishlistIdentifier()
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id(), 'session_id' => null];
        } else {
            $sessionId = session()->get('wishlist_session_id', function () {
                $sessionId = Str::random(40);
                session()->put('wishlist_session_id', $sessionId);
                return $sessionId;
            });

            return ['user_id' => null, 'session_id' => $sessionId];
        }
    }

    // Get wishlist items
    public function index()
    {
        $identifier = $this->getWishlistIdentifier();

        if ($identifier['user_id']) {
            $wishlists = Wishlist::with('product.category', 'product.subCategory')
                ->where('user_id', $identifier['user_id'])
                ->latest()
                ->get();
        } else {
            $wishlists = Wishlist::with('product.category', 'product.subCategory')
                ->where('session_id', $identifier['session_id'])
                ->latest()
                ->get();
        }

        return view('frontend.wishlist', compact('wishlists'));
    }

    // Add to wishlist
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);
        $identifier = $this->getWishlistIdentifier();

        // Check if already in wishlist
        $existing = Wishlist::where('product_id', $product->id);

        if ($identifier['user_id']) {
            $existing = $existing->where('user_id', $identifier['user_id']);
        } else {
            $existing = $existing->where('session_id', $identifier['session_id']);
        }

        if ($existing->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist!'
            ]);
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => $identifier['user_id'],
            'session_id' => $identifier['session_id'],
            'product_id' => $product->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!',
            'count' => $this->getWishlistCount()
        ]);
    }

    // Remove from wishlist
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $identifier = $this->getWishlistIdentifier();

        $wishlist = Wishlist::where('product_id', $request->product_id);

        if ($identifier['user_id']) {
            $wishlist = $wishlist->where('user_id', $identifier['user_id']);
        } else {
            $wishlist = $wishlist->where('session_id', $identifier['session_id']);
        }

        if ($wishlist->exists()) {
            $wishlist->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist!',
                'count' => $this->getWishlistCount()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in wishlist!'
        ]);
    }

    // Get wishlist count
    public function getCount()
    {
        return response()->json([
            'success' => true,
            'count' => $this->getWishlistCount()
        ]);
    }

    // Helper to get count
    public static function getWishlistCount()
    {
        $controller = new self();
        $identifier = $controller->getWishlistIdentifier();

        if ($identifier['user_id']) {
            return Wishlist::where('user_id', $identifier['user_id'])->count();
        } else {
            return Wishlist::where('session_id', $identifier['session_id'])->count();
        }
    }

    // Check if product is in wishlist
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $identifier = $this->getWishlistIdentifier();

        $exists = Wishlist::where('product_id', $request->product_id);

        if ($identifier['user_id']) {
            $exists = $exists->where('user_id', $identifier['user_id']);
        } else {
            $exists = $exists->where('session_id', $identifier['session_id']);
        }

        return response()->json([
            'success' => true,
            'in_wishlist' => $exists->exists()
        ]);
    }

    // Clear wishlist
    public function clear()
    {
        $identifier = $this->getWishlistIdentifier();

        if ($identifier['user_id']) {
            Wishlist::where('user_id', $identifier['user_id'])->delete();
        } else {
            Wishlist::where('session_id', $identifier['session_id'])->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Wishlist cleared!',
            'count' => 0
        ]);
    }
}
