<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Order;
use App\Models\Backend\OrderItem;
use App\Models\Backend\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product'])
            ->latest()
            ->paginate(10);

        $statuses = ['pending', 'confirmed', 'processing', 'delivered', 'cancelled'];

        return view('backend.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product']);
        $statuses = ['pending', 'confirmed', 'processing', 'delivered', 'cancelled'];

        return view('backend.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Handle stock management based on status change
        if ($newStatus === 'cancelled' && in_array($oldStatus, ['confirmed', 'processing'])) {
            // Restore stock
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->increment('stock_quantity', $item->quantity);

                if ($product->stock_quantity > 0 && $product->status === 'inactive') {
                    $product->update(['status' => 'active']);
                }
            }
        } elseif ($newStatus === 'confirmed' && $oldStatus === 'pending') {
            // Reserve stock (deduct from available stock)
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->decrement('stock_quantity', $item->quantity);

                if ($product->stock_quantity <= 0) {
                    $product->update(['status' => 'inactive']);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        // If order is not cancelled, restore stock
        if ($order->status !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->increment('stock_quantity', $item->quantity);

                if ($product->stock_quantity > 0 && $product->status === 'inactive') {
                    $product->update(['status' => 'active']);
                }
            }
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function printInvoice(Order $order)
    {
        $order->load(['items.product']);
        return view('backend.orders.invoice', compact('order'));
    }
}
