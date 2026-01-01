<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $itemTotal = $product->selling_price * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'total' => $itemTotal,
                ];
                $total += $itemTotal;
            }
        }

        return view('frontend.shop-cart', compact('cartItems', 'total'));
    }
    public static function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'] ?? 0;
        }

        return $count;
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string',
            'color' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock available.');
        }

        $cart = Session::get('cart', []);
        $key = $product->id . '-' . $request->size . '-' . $request->color;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'color' => $request->color,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart!'
        ]);
    }

    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            Session::put('cart', $cart);

            return redirect()->route('cart')->with('success', 'Product removed from cart!');
        }

        return redirect()->route('cart')->with('error', 'Product not found in cart!');
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart')->with('success', 'Cart cleared successfully!');
    }
}
