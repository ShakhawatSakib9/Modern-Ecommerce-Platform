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
        $subtotal = 0;
        $total = 0;

        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $itemTotal = $product->selling_price * $item['quantity'];
                $subtotal += $itemTotal;

                $cartItems[] = [
                    'key' => $key,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'total' => $itemTotal,
                ];
            }
        }

        $total = $subtotal; // Add shipping/tax here if needed

        return view('frontend.shop-cart', compact('cartItems', 'subtotal', 'total'));
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

        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available.',
                'cart_count' => self::getCartCount()
            ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => self::getCartCount(),
            'product_name' => $product->name
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->key])) {
            // Get product to check stock
            $product = Product::find($cart[$request->key]['product_id']);

            if ($product && $product->stock_quantity < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $product->stock_quantity . ' items in stock.'
                ]);
            }

            $cart[$request->key]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            // Calculate new totals
            $itemTotal = $product->selling_price * $request->quantity;
            $cartCount = self::getCartCount();

            // Calculate new cart totals
            $newSubtotal = 0;
            foreach ($cart as $item) {
                $prod = Product::find($item['product_id']);
                if ($prod) {
                    $newSubtotal += $prod->selling_price * $item['quantity'];
                }
            }
            $newTotal = $newSubtotal;

            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'cart_count' => $cartCount,
                'item_total' => '$' . number_format($itemTotal, 2),
                'subtotal' => '$' . number_format($newSubtotal, 2),
                'total' => '$' . number_format($newTotal, 2)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart!'
        ]);
    }

    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->key])) {
            unset($cart[$request->key]);
            Session::put('cart', $cart);

            // Calculate new totals
            $newSubtotal = 0;
            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $newSubtotal += $product->selling_price * $item['quantity'];
                }
            }
            $newTotal = $newSubtotal;

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cart_count' => self::getCartCount(),
                'subtotal' => '$' . number_format($newSubtotal, 2),
                'total' => '$' . number_format($newTotal, 2)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart!'
        ]);
    }

    public function clear()
    {
        Session::forget('cart');
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared!',
            'cart_count' => 0,
            'subtotal' => '$0.00',
            'total' => '$0.00'
        ]);
    }

    public function getCartSummary()
    {
        $cart = Session::get('cart', []);
        $cartCount = self::getCartCount();
        $subtotal = 0;

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $subtotal += $product->selling_price * $item['quantity'];
            }
        }

        $total = $subtotal;

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'subtotal' => '$' . number_format($subtotal, 2),
            'total' => '$' . number_format($total, 2)
        ]);
    }
}
