@extends('frontend.layout')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Wishlist</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Wishlist Section Begin -->
    <section class="shop spad">
        <div class="container">
            @if(count($wishlists) > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="shop__product__option__left">
                                    <p>Showing {{ count($wishlists) }} items in wishlist</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="shop__product__option__right">
                                    <button id="clearWishlistBtn" class="site-btn">Clear Wishlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($wishlists as $wishlist)
                @php $product = $wishlist->product; @endphp
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{ $product->getFirstImageUrl() }}">
                            @if($product->isNew())
                            <div class="label new">New</div>
                            @endif
                            @if($product->is_on_sale)
                            <div class="label">Sale</div>
                            @endif
                            <ul class="product__hover">
                                <li><a href="{{ $product->getFirstImageUrl() }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                <li><a href="javascript:void(0)" class="wishlist-btn active"
                                       data-product-id="{{ $product->id }}">
                                    <span class="icon_heart_alt"></span></a></li>
                                <li><a href="#" class="add-to-cart-btn" data-product-id="{{ $product->id }}">
                                    <span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="{{ route('product.details', $product->slug) }}">{{ $product->name }}</a></h6>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star{{ $i <= 4 ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            <div class="product__price">
                                @if($product->is_on_sale)
                                ${{ number_format($product->discount_price, 2) }}
                                <span>${{ number_format($product->regular_price, 2) }}</span>
                                @else
                                ${{ number_format($product->regular_price, 2) }}
                                @endif
                            </div>
                            <div class="mt-2">
                                <a href="javascript:void(0)" class="remove-wishlist-btn"
                                   data-product-id="{{ $product->id }}">
                                    <i class="fa fa-trash"></i> Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="empty-wishlist">
                        <i class="fa fa-heart fa-4x mb-4" style="color: #ddd;"></i>
                        <h4>Your wishlist is empty</h4>
                        <p>Start adding products you love to your wishlist!</p>
                        <a href="{{ route('shop') }}" class="site-btn mt-3">Continue Shopping</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- Wishlist Section End -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Remove from wishlist
    $('.remove-wishlist-btn').click(function() {
        let productId = $(this).data('product-id');
        let productItem = $(this).closest('.col-lg-3, .col-md-4, .col-sm-6');

        $.ajax({
            url: '{{ route("wishlist.remove") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    productItem.fadeOut(300, function() {
                        $(this).remove();
                        updateWishlistCount();

                        // Reload if empty
                        if ($('.product__item').length === 0) {
                            location.reload();
                        }
                    });

                    showSwalToast('success', response.message);
                }
            }
        });
    });

    // Clear wishlist
    $('#clearWishlistBtn').click(function() {
        Swal.fire({
            title: 'Clear Wishlist?',
            text: 'Are you sure you want to clear your entire wishlist?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53637',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, clear it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("wishlist.clear") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    }
                });
            }
        });
    });

    // Add to cart from wishlist
    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();
        // Use your existing cart add functionality
    });
});
</script>
@endsection
