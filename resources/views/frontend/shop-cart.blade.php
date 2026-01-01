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
            <div id="cart-container">
                @include('frontend.partials.cart-items')
            </div>
        </div>
    </section>
    <!-- Shop Cart Section End -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // SweetAlert2 Toast function
    function showSwalToast(icon, title, position = 'top-end') {
        const Toast = Swal.mixin({
            toast: true,
            position: position,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: icon,
            title: title
        });
    }

    // SweetAlert2 Confirm function
    function showSwalConfirm(title, text, confirmButtonText = 'Yes', cancelButtonText = 'No') {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#e53637',
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText
        });
    }

    // Initialize quantity plus/minus buttons
    function initQuantityButtons() {
        $('.qtybtn').off('click').on('click', function() {
            var $input = $(this).siblings('.cart-quantity-input');
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

            // Update cart immediately
            var key = $input.data('key');
            updateCartItem(key, newVal);
        });
    }

    // Global cart update function
    function updateCartItem(key, quantity) {
        $.ajax({
            url: '{{ route("cart.update") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                key: key,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    // Update specific item total
                    $('.item-total-' + key.replace(/[^a-zA-Z0-9]/g, '_')).text(response.item_total);

                    // Update cart summary
                    updateCartSummary();

                    // Update cart count in header
                    updateHeaderCartCount();

                    // No toast for quantity changes - too spammy
                } else {
                    showSwalToast('error', response.message);
                }
            },
            error: function() {
                showSwalToast('error', 'Failed to update cart');
            }
        });
    }

    // Update cart summary
    function updateCartSummary() {
        $.ajax({
            url: '{{ route("cart.summary") }}',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#cart-subtotal').text(response.subtotal);
                    $('#cart-total').text(response.total);
                }
            }
        });
    }

    // Update header cart count
    function updateHeaderCartCount() {
        $.ajax({
            url: '{{ route("cart.summary") }}',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('.tip').text(response.cart_count);
                }
            }
        });
    }

    // Quantity input direct change
    $(document).on('change', '.cart-quantity-input', function() {
        let key = $(this).data('key');
        let quantity = $(this).val();

        if (quantity < 1) {
            $(this).val(1);
            quantity = 1;
        }

        updateCartItem(key, quantity);
    });

    // Remove item from cart
    $(document).on('click', '.remove-cart-item', function(e) {
        e.preventDefault();
        let key = $(this).data('key');
        let productName = $(this).closest('tr').find('.cart__product__item__title h6').text();

        showSwalConfirm(
            'Remove Item',
            `Are you sure you want to remove "${productName}" from your cart?`,
            'Yes, remove it!',
            'Cancel'
        ).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("cart.remove") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        key: key
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove row from table
                            $('.cart-row-' + key.replace(/[^a-zA-Z0-9]/g, '_')).fadeOut(300, function() {
                                $(this).remove();
                                // Reload cart if empty
                                if ($('.shop__cart__table tbody tr').length === 0) {
                                    location.reload();
                                }
                            });

                            // Update cart summary
                            $('#cart-subtotal').text(response.subtotal);
                            $('#cart-total').text(response.total);

                            // Update header cart count
                            $('.tip').text(response.cart_count);

                            showSwalToast('success', response.message);
                        }
                    },
                    error: function() {
                        showSwalToast('error', 'Failed to remove item');
                    }
                });
            }
        });
    });

    // Clear cart button
    $(document).on('click', '#clearCartBtn', function(e) {
        e.preventDefault();

        showSwalConfirm(
            'Clear Cart',
            'Are you sure you want to clear your entire cart? This action cannot be undone.',
            'Yes, clear cart!',
            'Cancel'
        ).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("cart.clear") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Reload the page to show empty cart
                            location.reload();
                        }
                    },
                    error: function() {
                        showSwalToast('error', 'Failed to clear cart');
                    }
                });
            }
        });
    });

    // Initialize quantity buttons on page load
    initQuantityButtons();

    // Initialize cart summary
    updateCartSummary();
});
</script>
@endsection
