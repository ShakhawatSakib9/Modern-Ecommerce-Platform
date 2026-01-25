@extends('frontend.layout')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                    <a href="{{ route('cart') }}">Shopping cart</a>
                    <span>Checkout</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('checkout.place-order') }}" method="POST" class="checkout__form">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <h5>Billing detail</h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>Full Name <span>*</span></p>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>Address <span>*</span></p>
                                <input type="text" name="customer_address" placeholder="Street Address" value="{{ old('customer_address') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Phone <span>*</span></p>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Email <span>*</span></p>
                                <input type="email" name="customer_email" value="{{ old('customer_email') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>Order notes</p>
                                <input type="text" name="notes" placeholder="Note about your order, e.g, special note for delivery" value="{{ old('notes') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout__order">
                        <h5>Your order</h5>
                        <div class="checkout__order__product">
                            <ul>
                                <li>
                                    <span class="top__text">Product</span>
                                    <span class="top__text__right">Total</span>
                                </li>
                                @foreach($cartItems as $item)
                                <li>
                                    {{ $loop->iteration }}. {{ Str::limit($item['product']->name, 20) }} x {{ $item['quantity'] }}
                                    <span>${{ number_format($item['total'], 2) }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="checkout__order__total">
                            <ul>
                                <li>Subtotal <span>${{ number_format($subtotal, 2) }}</span></li>
                                <li>Shipping <span>${{ number_format($delivery_charge, 2) }}</span></li>
                                <li>Total <span>${{ number_format($total, 2) }}</span></li>
                            </ul>
                        </div>
                        <div class="checkout__order__widget">
                            <p>Select Payment Method <span>*</span></p>
                            <div class="checkout__order__widget__item">
                                <label for="cod">
                                    Cash on Delivery
                                    <input type="radio" id="cod" name="payment_method" value="cash_on_delivery" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__order__widget__item">
                                <label for="card">
                                    Card Payment (Coming Soon)
                                    <input type="radio" id="card" name="payment_method" value="card" disabled>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="site-btn">Place order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Checkout Section End -->
@endsection