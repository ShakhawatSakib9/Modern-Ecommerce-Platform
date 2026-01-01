@extends('backend.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>
                            <div>{{ $order->customer_name }}</div>
                            <small class="text-muted">{{ $order->customer_email }}</small>
                        </td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.orders.update-status', $order) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm"
                                        onchange="this.form.submit()" style="width: auto;">
                                    @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.invoice', $order) }}"
                                   class="btn btn-sm btn-outline-secondary" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
