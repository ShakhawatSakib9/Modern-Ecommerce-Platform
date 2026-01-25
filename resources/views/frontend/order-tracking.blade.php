@extends('frontend.layout')

@section('title', 'Track Order - ' . config('app.name'))

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                    <span>Order Tracking</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Order Tracking Section Begin -->
<section class="order-tracking spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="contact__form">
                    <h5 class="text-center mb-4">Track Your Order</h5>

                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('order.track.post') }}" method="POST">
                        @csrf
                        <input type="text" name="order_number" placeholder="Order Number (e.g. ORD-2026...)" required>
                        <input type="email" name="email" placeholder="Billing Email" required>
                        <div class="text-center">
                            <button type="submit" class="site-btn">Track Order</button>
                        </div>
                    </form>
                </div>

                @isset($order)
                <div class="order-result mt-5 p-4 border rounded bg-light">
                    <h5>Order Status: <span class="badge badge-{{ $order->status_color }}">{{ ucfirst($order->status) }}</span></h5>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-6">
                            <p><strong>Order Number:</strong></p>
                            <p><strong>Customer:</strong></p>
                            <p><strong>Date:</strong></p>
                            <p><strong>Total:</strong></p>
                        </div>
                        <div class="col-6 text-right">
                            <p>{{ $order->order_number }}</p>
                            <p>{{ $order->customer_name }}</p>
                            <p>{{ $order->created_at->format('M d, Y') }}</p>
                            <p>${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <div class="order-timeline mt-4">
                        <h6 class="mb-3">Order Progress:</h6>
                        <div class="progress" style="height: 25px;">
                            @php
                            $progress = 20;
                            if($order->status == 'confirmed') $progress = 40;
                            if($order->status == 'processing') $progress = 70;
                            if($order->status == 'delivered') $progress = 100;
                            if($order->status == 'cancelled') $progress = 0;
                            @endphp
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $order->status_color }}"
                                role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $progress }}% Completed
                            </div>
                        </div>
                    </div>
                </div>
                @endisset
            </div>
        </div>
    </div>
</section>
<!-- Order Tracking Section End -->
@endsection