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
        <div class="card bg-primary text-white border-0 shadow-lg mb-4 hover-lift">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small font-weight-bold text-uppercase mb-1">Total Products</div>
                        <h3 class="font-weight-bold mb-0 display-5">{{ $stats['total_products'] }}</h3>
                    </div>
                    <div class="icon-circle bg-white-20 glass">
                        <i class="fas fa-tshirt text-white fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.products.index') }}" class="card-footer bg-white-10 text-white d-flex align-items-center justify-content-between py-2 px-4 text-decoration-none small">
                Explore Gallery <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Categories -->
    <div class="col-lg-3 col-6">
        <div class="card bg-success text-white border-0 shadow-lg mb-4 hover-lift">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small font-weight-bold text-uppercase mb-1">Categories</div>
                        <h3 class="font-weight-bold mb-0 display-5">{{ $stats['total_categories'] }}</h3>
                    </div>
                    <div class="icon-circle bg-white-20 glass">
                        <i class="fas fa-sitemap text-white fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="card-footer bg-white-10 text-white d-flex align-items-center justify-content-between py-2 px-4 text-decoration-none small">
                Manage List <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-lg-3 col-6">
        <div class="card bg-warning text-white border-0 shadow-lg mb-4 hover-lift">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small font-weight-bold text-uppercase mb-1">Total Orders</div>
                        <h3 class="font-weight-bold mb-0 display-5">{{ $stats['total_orders'] }}</h3>
                    </div>
                    <div class="icon-circle bg-white-20 glass">
                        <i class="fas fa-shopping-cart text-white fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="card-footer bg-white-10 text-white d-flex align-items-center justify-content-between py-2 px-4 text-decoration-none small">
                Track Sales <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-lg-3 col-6">
        <div class="card bg-danger text-white border-0 shadow-lg mb-4 hover-lift">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small font-weight-bold text-uppercase mb-1">Total Revenue</div>
                        <h3 class="font-weight-bold mb-0 display-5">${{ number_format($stats['total_revenue'], 2) }}</h3>
                    </div>
                    <div class="icon-circle bg-white-20 glass">
                        <i class="fas fa-dollar-sign text-white fa-2x"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="card-footer bg-white-10 text-white d-flex align-items-center justify-content-between py-2 px-4 text-decoration-none small">
                Financials <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-white-10 {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .bg-white-20 {
        background-color: rgba(255, 255, 255, 0.2) !important;
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    .icon-circle {
        height: 4rem;
        width: 4rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .display-5 {
        font-size: 2.2rem;
        line-height: 1.2;
    }

    .bg-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }

    .bg-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%) !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%) !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%) !important;
    }
</style>
@endpush

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
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
                <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i>Low Stock Products</h3>
                <div class="card-tools ml-auto"></div>
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
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
                <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-shopping-bag mr-2"></i>Recent Orders</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                        View All Orders <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="pl-4">Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th class="text-center">Status</th>
                                <th>Date</th>
                                <th class="text-center pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr>
                                <td class="pl-4 align-middle">
                                    <span class="font-weight-bold text-dark">{{ $order->order_number }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="font-weight-bold">{{ $order->customer_name }}</div>
                                    <small class="text-muted"><i class="far fa-envelope mr-1"></i>{{ Str::limit($order->customer_email, 20) }}</small>
                                </td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-dark">${{ number_format($order->total_amount, 2) }}</div>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge badge-{{ $order->status === 'pending' ? 'warning' :
                                                               ($order->status === 'confirmed' ? 'info' :
                                                               ($order->status === 'processing' ? 'primary' :
                                                               ($order->status === 'delivered' ? 'success' : 'danger'))) }} shadow-sm">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="align-middle text-muted small">
                                    <i class="far fa-clock mr-1"></i>{{ $order->created_at->diffForHumans() }}
                                </td>
                                <td class="text-center align-middle pr-4">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="btn btn-sm btn-light shadow-sm" title="View Details">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-shopping-basket fa-3x mb-3 d-block opacity-25"></i>
                                    No orders found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header bg-white glass border-bottom">
                <h3 class="card-title text-primary"><i class="fas fa-chart-pie mr-2"></i>Status Distribution</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <div class="p-3 rounded bg-light hover-lift h-100 shadow-sm">
                            <i class="fas fa-clock text-warning fa-2x mb-2"></i>
                            <div class="h4 font-weight-bold mb-0">{{ $stats['pending_orders'] }}</div>
                            <div class="text-muted small font-weight-bold">Pending</div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <div class="p-3 rounded bg-light hover-lift h-100 shadow-sm">
                            <i class="fas fa-check-circle text-info fa-2x mb-2"></i>
                            <div class="h4 font-weight-bold mb-0">{{ $stats['confirmed_orders'] }}</div>
                            <div class="text-muted small font-weight-bold">Confirmed</div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <div class="p-3 rounded bg-light hover-lift h-100 shadow-sm">
                            <i class="fas fa-cog text-primary fa-2x mb-2"></i>
                            <div class="h4 font-weight-bold mb-0">{{ $stats['processing_orders'] }}</div>
                            <div class="text-muted small font-weight-bold">Processing</div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-3 rounded bg-light hover-lift h-100 shadow-sm">
                            <i class="fas fa-truck text-success fa-2x mb-2"></i>
                            <div class="h4 font-weight-bold mb-0">{{ $stats['delivered_orders'] }}</div>
                            <div class="text-muted small font-weight-bold">Delivered</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Out of Stock Products -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white glass border-bottom">
                <h3 class="card-title text-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Out of Stock Inventory</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-light shadow-sm px-3">
                        Inventory Management <i class="fas fa-boxes ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="pl-4">Product Name</th>
                                <th>Category</th>
                                <th>Pricing</th>
                                <th>Last Inventory Update</th>
                                <th class="text-center pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($out_of_stock_products as $product)
                            <tr>
                                <td class="pl-4 align-middle">
                                    <div class="font-weight-bold text-dark">{{ $product->name }}</div>
                                    <small class="text-muted text-uppercase">{{ $product->sku ?? 'No SKU' }}</small>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-info shadow-sm">{{ $product->category->name ?? 'N/A' }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-danger">${{ number_format($product->selling_price, 2) }}</div>
                                </td>
                                <td class="align-middle text-muted small">
                                    <i class="far fa-clock mr-1"></i>{{ $product->updated_at->diffForHumans() }}
                                </td>
                                <td class="text-center align-middle pr-4">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="btn btn-sm btn-primary shadow-sm hover-lift">
                                        <i class="fas fa-plus mr-1"></i> Restock
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-check-circle fa-3x mb-3 d-block text-success opacity-25"></i>
                                    All products are currently in stock.
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