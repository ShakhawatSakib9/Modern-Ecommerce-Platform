@extends('frontend.layout')

@section('title', 'Order Success - ' . config('app.name'))

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                    <span>Order Success</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Order Success Section Begin -->
<section class="order-success spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="order-success__content">
                    <i class="fa fa-check-circle fa-5x text-success mb-4"></i>
                    <h2>Thank You for Your Order!</h2>
                    <p class="mt-3">Your order has been placed successfully. We are now processing it.</p>
                    <div class="order-details mt-5 p-4 border rounded bg-light d-inline-block text-left">
                        <h5>Order Information</h5>
                        <hr>
                        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                        <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                        <p><strong>Status:</strong> <span class="badge badge-warning">{{ ucfirst($order->status) }}</span></p>
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('shop') }}" class="site-btn">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Order Success Section End -->
@endsection