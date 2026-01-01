@extends('backend.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(!empty($item->product->images[0]))
                                        <img src="{{ asset('storage/' . $item->product->images[0]) }}"
                                             class="rounded me-3" width="40" height="40">
                                        @endif
                                        <div>{{ $item->product->name }}</div>
                                    </div>
                                </td>
                                <td>{{ $item->size }}</td>
                                <td>{{ $item->color }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->total_amount - $order->delivery_charge, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Delivery:</span>
                    <span>${{ number_format($order->delivery_charge, 2) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <strong>Total:</strong>
                    <strong>${{ number_format($order->total_amount, 2) }}</strong>
                </div>

                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Update Status</label>
                        <select name="status" class="form-select">
                            @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Customer Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                @if($order->notes)
                <p><strong>Notes:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mt-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
    <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-primary" target="_blank">
        <i class="fas fa-print"></i> Print Invoice
    </a>
</div>
@endsection
