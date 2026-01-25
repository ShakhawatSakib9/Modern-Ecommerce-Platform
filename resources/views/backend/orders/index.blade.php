@extends('backend.layouts.app')

@section('title', 'Manage Orders')
@section('page_title', 'Manage Orders')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-shopping-bag mr-2"></i>All Customer Orders</h3>
        <div class="card-tools ml-auto">
            <div class="input-group input-group-sm" style="width: 200px;">
                <input type="text" name="table_search" class="form-control shadow-none" placeholder="Search orders...">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="pl-4">Order #</th>
                        <th>Customer</th>
                        <th class="text-center">Items</th>
                        <th class="text-right">Total Amount</th>
                        <th class="text-center">Status</th>
                        <th>Order Date</th>
                        <th class="text-center pr-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="pl-4">
                            <span class="text-primary font-weight-bold">{{ $order->order_number }}</span>
                        </td>
                        <td>
                            <div class="font-weight-bold">{{ $order->customer_name }}</div>
                            <small class="text-muted"><i class="fas fa-envelope mr-1"></i>{{ $order->customer_email }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-secondary badge-pill">{{ $order->items->count() }}</span>
                        </td>
                        <td class="text-right font-weight-bold text-dark">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="status-form">
                                @csrf
                                <select name="status" class="form-control form-control-sm badge badge-{{ $order->status_color }} border-0"
                                    onchange="this.form.submit()" style="appearance: none; -webkit-appearance: none; cursor: pointer; text-align-last: center;">
                                    @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }} class="bg-white text-dark">
                                        {{ ucfirst($status) }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="text-center pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.invoice', $order) }}"
                                    class="btn btn-sm btn-info shadow-sm" target="_blank" title="Print Invoice">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-shopping-basket fa-3x mb-3 d-block"></i>
                            No orders found in the database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer clearfix">
        <div class="float-right">
            {{ $orders->links() }}
        </div>
    </div>
    @endif
</div>
@endsection