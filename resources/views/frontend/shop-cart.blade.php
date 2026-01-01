@extends('frontend.layout')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            @if(count($cartItems) > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $key => $item)
                                <tr>
                                    <td class="cart__product__item">
                                        <img src="{{ $item['product']->getFirstImageUrl() ?? asset('frontend/img/shop-cart/cp-1.jpg') }}" alt="" style="width: 100px; height: 100px;">
                                        <div class="cart__product__item__title">
                                            <h6>{{ $item['product']->name }}</h6>
                                            @if($item['size'])
                                            <p>Size: {{ $item['size'] }}</p>
                                            @endif
                                            @if($item['color'])
                                            <p>Color: {{ $item['color'] }}</p>
                                            @endif
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star{{ $i <= 4 ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">${{ number_format($item['product']->selling_price, 2) }}</td>
                                    <td class="cart__quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="{{ $item['quantity'] }}"
                                                   data-key="{{ $key }}"
                                                   class="cart-quantity-input">
                                        </div>
                                    </td>
                                    <td class="cart__total">${{ number_format($item['total'], 2) }}</td>
                                    <td class="cart__close">
                                        <form action="{{ route('cart.remove') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $key }}">
                                            <button type="submit" style="border: none; background: none; cursor: pointer;">
                                                <span class="icon_close"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ route('shop') }}">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <a href="#" id="updateCartBtn"><span class="icon_loading"></span> Update cart</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="discount__content">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">Apply</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span>${{ number_format($total, 2) }}</span></li>
                            <li>Total <span>${{ number_format($total, 2) }}</span></li>
                        </ul>
                        <a href="{{ route('checkout') }}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="alert alert-info">
                        <h4>Your cart is empty</h4>
                        <p>Start shopping to add items to your cart.</p>
                        <a href="{{ route('shop') }}" class="site-btn">Continue Shopping</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- Shop Cart Section End -->

    <!-- Instagram Begin -->
    <div class="instagram">
        <div class="container-fluid">
            <div class="row">
                @for($i = 1; $i <= 6; $i++)
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="{{ asset('frontend/img/instagram/insta-' . $i . '.jpg') }}">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ fashion_shop</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
    <!-- Instagram End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Update cart button
    $('#updateCartBtn').click(function(e) {
        e.preventDefault();

        var updates = [];
        $('.cart-quantity-input').each(function() {
            updates.push({
                key: $(this).data('key'),
                quantity: $(this).val()
            });
        });

        $.ajax({
            url: '{{ route("cart.update") }}',
            type: 'POST',
            data: {
                updates: updates
            },
            success: function(response) {
                if(response.success) {
                    location.reload();
                }
            }
        });
    });

    // Quantity input change
    $('.cart-quantity-input').on('change', function() {
        var key = $(this).data('key');
        var quantity = $(this).val();

        if(quantity < 1) {
            $(this).val(1);
            quantity = 1;
        }
    });
});
</script>
@endsection
