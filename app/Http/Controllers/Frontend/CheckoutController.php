<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Order;
use App\Models\Backend\OrderItem;
use App\Models\Backend\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty!');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $itemTotal = $product->selling_price * $item['quantity'];
                $cartItems[] = [
                    'key' => $key,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'total' => $itemTotal,
                ];
                $subtotal += $itemTotal;
            }
        }

        $settings = \App\Models\Backend\Setting::first();
        $delivery_charge = $settings->delivery_charge ?? 0;
        $total = $subtotal + $delivery_charge;

        return view('frontend.checkout', compact('cartItems', 'subtotal', 'delivery_charge', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:cash_on_delivery,card',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // Calculate total
        $subtotal = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $subtotal += $product->selling_price * $item['quantity'];
            }
        }

        $settings = \App\Models\Backend\Setting::first();
        $delivery_charge = $settings->delivery_charge ?? 0;
        $total = $subtotal + $delivery_charge;

        // Create order
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total_amount' => $total,
            'delivery_charge' => $delivery_charge,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Create order items and update stock
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->selling_price,
                    'size' => $item['size'],
                    'color' => $item['color'],
                ]);

                // Update product stock
                $product->decrement('stock_quantity', $item['quantity']);

                if ($product->stock_quantity <= 0) {
                    $product->update(['status' => 'inactive']);
                }
            }
        }

        // Clear cart
        Session::forget('cart');

        return redirect()->route('checkout.success', $order->order_number)->with('success', 'Order placed successfully!');
    }

    public function success($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return view('frontend.order-success', compact('order'));
    }

    public function trackForm()
    {
        return view('frontend.order-tracking');
    }

    public function trackOrder(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('customer_email', $request->email)
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found with these details.');
        }

        return view('frontend.order-tracking', compact('order'));
    }
}
