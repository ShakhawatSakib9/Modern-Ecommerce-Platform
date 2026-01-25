@extends('frontend.layout')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ route('shop', ['category' => $product->category_id]) }}">{{ $product->category->name ?? 'Shop' }}</a>
                        <span>{{ $product->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__left product__thumb nice-scroll">
                            @foreach($product->getImageUrls() as $index => $imageUrl)
                            <a class="pt {{ $index == 0 ? 'active' : '' }}" href="#product-{{ $index + 1 }}">
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                            </a>
                            @endforeach
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                @foreach($product->getImageUrls() as $index => $imageUrl)
                                <img data-hash="product-{{ $index + 1 }}" class="product__big__img" src="{{ $imageUrl }}" alt="{{ $product->name }}">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3>{{ $product->name }} <span>Category: {{ $product->category->name ?? 'N/A' }}</span></h3>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star{{ $i <= 4 ? '' : '-o' }}"></i>
                            @endfor
                            <span>( {{ rand(10, 200) }} reviews )</span>
                        </div>
                        <div class="product__details__price">
                            @if($product->is_on_sale)
                            ${{ number_format($product->discount_price, 2) }} <span>${{ number_format($product->regular_price, 2) }}</span>
                            @else
                            ${{ number_format($product->regular_price, 2) }}
                            @endif
                        </div>
                        <p>{{ $product->short_description ?? $product->description }}</p>
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input type="text" value="1" id="product-quantity">
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="cart-btn add-to-cart-btn"
                               data-product-id="{{ $product->id }}">
                                <span class="icon_bag_alt"></span> Add to cart
                            </a>
                            <ul>
                                <li><a href="javascript:void(0)" class="wishlist-btn"
                                       data-product-id="{{ $product->id }}">
                                    <span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Availability:</span>
                                    <div class="stock__checkbox">
                                        <label for="stockin">
                                            @if($product->stock_quantity > 0)
                                                In Stock ({{ $product->stock_quantity }} available)
                                            @else
                                                Out of Stock
                                            @endif
                                            <input type="checkbox" id="stockin" {{ $product->stock_quantity > 0 ? 'checked' : 'disabled' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available color:</span>
                                    <div class="color__checkbox">
                                        @foreach($product->getAvailableColors() as $color)
                                        <label for="color_{{ $color }}">
                                            <input type="radio" name="color__radio" id="color_{{ $color }}"
                                                   value="{{ $color }}" {{ $loop->first ? 'checked' : '' }}>
                                            <span class="checkmark {{ strtolower($color) }}-bg"></span>
                                        </label>
                                        @endforeach
                                    </div>
                                </li>
                                <li>
                                    <span>Available size:</span>
                                    <div class="size__btn">
                                        @foreach($product->getAvailableSizes() as $size)
                                        <label for="size_{{ $size }}" class="{{ $loop->first ? 'active' : '' }}">
                                            <input type="radio" id="size_{{ $size }}" name="size"
                                                   value="{{ $size }}" {{ $loop->first ? 'checked' : '' }}>
                                            {{ $size }}
                                        </label>
                                        @endforeach
                                    </div>
                                </li>
                                <li>
                                    <span>SKU:</span>
                                    <p>{{ $product->sku ?? 'N/A' }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( {{ rand(1, 50) }} )</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Description</h6>
                                <p>{{ $product->description }}</p>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <h6>Product Details</h6>
                                <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                                @if($product->subCategory)
                                <p><strong>Subcategory:</strong> {{ $product->subCategory->name }}</p>
                                @endif
                                <p><strong>Regular Price:</strong> ${{ number_format($product->regular_price, 2) }}</p>
                                @if($product->is_on_sale)
                                <p><strong>Sale Price:</strong> ${{ number_format($product->discount_price, 2) }}</p>
                                <p><strong>You Save:</strong> ${{ number_format($product->regular_price - $product->discount_price, 2) }} ({{ $product->discount_percentage }}%)</p>
                                @endif
                                <p><strong>Stock:</strong> {{ $product->stock_quantity }} units</p>
                                <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <h6>Customer Reviews</h6>
                                <p>No reviews yet. Be the first to review this product!</p>
                                <!-- You can add review form here later -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if(count($related_products) > 0)
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                </div>
                @foreach($related_products as $related_product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{ $related_product->getFirstImageUrl() }}">
                            @if($related_product->isNew())
                            <div class="label new">New</div>
                            @endif
                            @if($related_product->is_on_sale)
                            <div class="label sale">Sale</div>
                            @endif
                            @if($related_product->stock_quantity <= 0)
                            <div class="label stockout">out of stock</div>
                            @endif
                            <ul class="product__hover">
                                <li><a href="{{ $related_product->getFirstImageUrl() }}" class="image-popup">
                                    <span class="arrow_expand"></span></a></li>
                                <li><a href="javascript:void(0)" class="wishlist-btn"
                                       data-product-id="{{ $related_product->id }}">
                                    <span class="icon_heart_alt"></span></a></li>
                                <li><a href="#" class="add-to-cart-btn"
                                       data-product-id="{{ $related_product->id }}">
                                    <span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="{{ route('product.details', $related_product->slug) }}">{{ $related_product->name }}</a></h6>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star{{ $i <= 4 ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            <div class="product__price">
                                @if($related_product->is_on_sale)
                                ${{ number_format($related_product->discount_price, 2) }}
                                <span>${{ number_format($related_product->regular_price, 2) }}</span>
                                @else
                                ${{ number_format($related_product->regular_price, 2) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>
    <!-- Product Details Section End -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Product image slider
    $('.product__details__pic__slider').owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        smartSpeed: 1200,
        autoHeight: false
    });

    // Product thumbnail click
    $('.product__thumb .pt').on('click', function(e) {
        e.preventDefault();
        $('.product__thumb .pt').removeClass('active');
        $(this).addClass('active');

        var hash = $(this).attr('href');
        $('.product__details__pic__slider').trigger('to.owl.carousel', $(hash).index());
    });

    // Add to cart from product details
    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();

        var productId = $(this).data('product-id');
        var quantity = $('#product-quantity').val();
        var size = $('input[name="size"]:checked').val();
        var color = $('input[name="color__radio"]:checked').val();
        var productName = $('.product__details__text h3').text().split('<')[0].trim();

        $.ajax({
            url: '{{ route("cart.add") }}',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                size: size,
                color: color
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.cart_count || 0);
                    showSwalToast('success', `${productName} added to cart!`);
                } else {
                    showSwalToast('error', response.message || 'Failed to add to cart');
                }
            },
            error: function(xhr) {
                showSwalToast('error', 'Error adding product to cart');
            }
        });
    });


    $('.qtybtn').on('click', function() {
        var $input = $(this).parent().find('input');
        var oldValue = parseInt($input.val());

        if ($(this).hasClass('inc')) {
            var newVal = oldValue + 1;
        } else {
            if (oldValue > 1) {
                var newVal = oldValue - 1;
            } else {
                var newVal = 1;
            }
        }

        $input.val(newVal);
    });

    // Size selection
    $('.size__btn label').click(function() {
        $('.size__btn label').removeClass('active');
        $(this).addClass('active');
        $(this).find('input').prop('checked', true);
    });

    // Color selection
    $('.color__checkbox label').click(function() {
        $('.color__checkbox input').prop('checked', false);
        $(this).find('input').prop('checked', true);
    });
});
</script>
@endsection
