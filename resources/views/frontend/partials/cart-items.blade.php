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
                    @foreach($cartItems as $item)
                    @php
                        $safeKey = str_replace(['-', ' ', '.'], '_', $item['key']);
                    @endphp
                    <tr class="cart-row-{{ $safeKey }}">
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
                                <input type="text"
                                       value="{{ $item['quantity'] }}"
                                       data-key="{{ $item['key'] }}"
                                       class="cart-quantity-input">
                            </div>
                        </td>
                        <td class="cart__total item-total-{{ $safeKey }}">
                            ${{ number_format($item['total'], 2) }}
                        </td>
                        <td class="cart__close">
                            <a href="javascript:void(0)"
                               class="remove-cart-item"
                               data-key="{{ $item['key'] }}">
                                <span class="icon_close"></span>
                            </a>
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
            <button id="clearCartBtn" class="site-btn" style="border: none; cursor: pointer;">
                <span class="icon_close"></span> Clear Cart
            </button>
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
                <li>Subtotal <span id="cart-subtotal">${{ number_format($subtotal, 2) }}</span></li>
                <li>Total <span id="cart-total">${{ number_format($total, 2) }}</span></li>
            </ul>
            <a href="{{ route('checkout') }}" class="primary-btn">Proceed to checkout</a>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-lg-12 text-center">
        <div class="empty-cart">
            <i class="fa fa-shopping-cart fa-4x mb-4" style="color: #ddd;"></i>
            <h4>Your cart is empty</h4>
            <p>Start shopping to add items to your cart.</p>
            <a href="{{ route('shop') }}" class="site-btn mt-3">Continue Shopping</a>
        </div>
    </div>
</div>
@endif
