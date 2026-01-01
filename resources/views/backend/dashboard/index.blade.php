@extends('backend.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <!-- Total Products -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_products'] }}</h3>
                <p>Total Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-tshirt"></i>
            </div>
            <a href="{{ route('admin.products.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Categories -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_categories'] }}</h3>
                <p>Total Categories</p>
            </div>
            <div class="icon">
                <i class="fas fa-list"></i>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['total_orders'] }}</h3>
                <p>Total Orders</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>${{ number_format($stats['total_revenue'], 2) }}</h3>
                <p>Total Revenue</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Today's Stats -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Today's Statistics</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Orders Today:</span>
                    <span class="badge badge-primary">{{ $stats['today_orders'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Revenue Today:</span>
                    <span class="badge badge-success">${{ number_format($stats['today_revenue'], 2) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Pending Orders:</span>
                    <span class="badge badge-warning">{{ $stats['pending_orders'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Processing Orders:</span>
                    <span class="badge badge-info">{{ $stats['processing_orders'] }}</span>
                </div>
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Low Stock Products (< 10)</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($low_stock_products as $product)
                            <tr>
                                <td>{{ Str::limit($product->name, 20) }}</td>
                                <td>
                                    <span class="badge badge-{{ $product->stock_quantity <= 5 ? 'danger' : 'warning' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="btn btn-xs btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No low stock products
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Orders</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status === 'pending' ? 'warning' :
                                                              ($order->status === 'confirmed' ? 'info' :
                                                              ($order->status === 'processing' ? 'primary' :
                                                              ($order->status === 'delivered' ? 'success' : 'danger'))) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">
                                    No orders found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Order Status Distribution</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pending</span>
                                <span class="info-box-number">{{ $stats['pending_orders'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Confirmed</span>
                                <span class="info-box-number">{{ $stats['confirmed_orders'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-cog"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Processing</span>
                                <span class="info-box-number">{{ $stats['processing_orders'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-truck"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Delivered</span>
                                <span class="info-box-number">{{ $stats['delivered_orders'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Out of Stock Products -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Out of Stock Products</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($out_of_stock_products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>${{ number_format($product->selling_price, 2) }}</td>
                                <td>{{ $product->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Update Stock
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    No out of stock products
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-refresh dashboard every 60 seconds
        setInterval(function() {
            $.ajax({
                url: "{{ route('admin.dashboard.chart-data') }}",
                method: 'GET',
                success: function(data) {
                    // Update statistics here if needed
                    console.log('Dashboard data refreshed');
                }
            });
        }, 60000);
    });
</script>
@endpush
