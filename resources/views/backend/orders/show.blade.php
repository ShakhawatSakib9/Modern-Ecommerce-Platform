@extends('backend.layouts.app')

@section('title', 'Order Details #' . $order->order_number)
@section('page_title', 'Order Details')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
<li class="breadcrumb-item active">#{{ $order->order_number }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary mb-3">
                <i class="fas fa-arrow-left mr-1"></i> Back to Orders
            </a>
            <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-info mb-3 float-right shadow-sm" target="_blank">
                <i class="fas fa-file-invoice mr-1"></i> Print Invoice
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Order Items Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white glass border-bottom">
                    <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-shopping-bag mr-2"></i>Order Items</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pl-4">Product</th>
                                    <th class="text-center">Specs</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right pr-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="pl-4">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->getFirstImageUrl() }}" class="rounded shadow-sm mr-3" width="50" height="50" style="object-fit: cover;">
                                            <div>
                                                <div class="font-weight-bold">{{ $item->product->name }}</div>
                                                @if($item->product->sku)
                                                <small class="text-muted text-uppercase">SKU: {{ $item->product->sku }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($item->size)
                                        <span class="badge badge-outline-secondary mr-1">Size: {{ $item->size }}</span>
                                        @endif
                                        @if($item->color)
                                        <span class="badge badge-outline-secondary">Color: {{ $item->color }}</span>
                                        @endif
                                        @if(!$item->size && !$item->color)
                                        -
                                        @endif
                                    </td>
                                    <td class="text-center font-weight-bold">x {{ $item->quantity }}</td>
                                    <td class="text-right">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-right pr-4 font-weight-bold">${{ number_format($item->quantity * $item->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Notes Card -->
            @if($order->notes)
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white glass border-bottom">
                    <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-sticky-note mr-2"></i>Order Notes</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted p-2" style="background: #fdfdfd; border-left: 4px solid #4e73df;">
                        {{ $order->notes }}
                    </p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <!-- Summary Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white glass border-bottom">
                    <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-receipt mr-2"></i>Payment Summary</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Subtotal
                            <span class="font-weight-bold">${{ number_format($order->total_amount - $order->delivery_charge, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Delivery Charge
                            <span class="font-weight-bold">${{ number_format($order->delivery_charge, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                            <span class="h5 mb-0 text-primary">Total Amount</span>
                            <span class="h5 mb-0 text-primary font-weight-bold">${{ number_format($order->total_amount, 2) }}</span>
                        </li>
                    </ul>

                    <div class="mt-4 p-3 rounded" style="background: rgba(78, 115, 223, 0.05);">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">Order Status</label>
                                <select name="status" class="form-control select2 shadow-sm border-0">
                                    @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block shadow-sm">
                                <i class="fas fa-save mr-1"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Customer Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white glass border-bottom">
                    <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-user-circle mr-2"></i>Customer Info</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-primary-soft mr-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <div class="font-weight-bold">{{ $order->customer_name }}</div>
                            <small class="text-muted">Registered Customer</small>
                        </div>
                    </div>

                    <p class="mb-2"><i class="fas fa-envelope text-muted mr-3"></i> {{ $order->customer_email }}</p>
                    <p class="mb-2"><i class="fas fa-phone text-muted mr-3"></i> {{ $order->customer_phone }}</p>
                    <hr>
                    <p class="mb-0"><i class="fas fa-map-marker-alt text-muted mr-3"></i> <strong>Shipping Address:</strong></p>
                    <p class="mt-2 text-muted px-4 ml-1">
                        {{ $order->customer_address }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-primary-soft {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }

    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge-outline-secondary {
        background: transparent;
        color: #6c757d;
        border: 1px solid #6c757d;
    }
</style>
@endpush