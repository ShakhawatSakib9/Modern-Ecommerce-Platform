<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Clothing Store')</title>

    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" type="text/css">

    @yield('styles')
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder"><div class="loader"></div></div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="{{ route('cart') }}"><span class="icon_heart_alt"></span>
                <div class="tip">{{ \App\Http\Controllers\Frontend\CartController::getCartCount() }}</div></a></li>
            <li><a href="{{ route('cart') }}"><span class="icon_bag_alt"></span>
                <div class="tip">{{ \App\Http\Controllers\Frontend\CartController::getCartCount() }}</div></a></li>
        </ul>
        <div class="offcanvas__logo">
            <a href="{{ url('/') }}"><img src="{{ asset('frontend/img/logo.png') }}" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth"><a href="{{ route('admin.login') }}">Admin</a></div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo"><a href="{{ url('/') }}"><img src="{{ asset('frontend/img/logo.png') }}" alt=""></a></div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="#">Women's</a></li>
                            <li><a href="#">Men's</a></li>
                            <li class="{{ request()->is('shop') ? 'active' : '' }}"><a href="{{ route('shop') }}">Shop</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="{{ route('product.details', 'sample-product') }}">Product Details</a></li>
                                    <li><a href="{{ route('cart') }}">Shop Cart</a></li>
                                    <li><a href="{{ route('checkout') }}">Checkout</a></li>
                                    <li><a href="{{ route('blog') }}">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li class="{{ request()->is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        <div class="header__right__auth"><a href="{{ route('admin.login') }}">Admin</a></div>
                        <ul class="header__right__widget">
                            <li><span class="icon_search search-switch"></span></li>
                            <li><a href="#"><span class="icon_heart_alt"></span><div class="tip">2</div></a></li>
                            <li><a href="{{ route('cart') }}"><span class="icon_bag_alt"></span><div class="tip">{{ \App\Http\Controllers\Frontend\CartController::getCartCount() }}</div></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

    {{-- Page content --}}
    @yield('content')

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-7">
                    <div class="footer__about">
                        <div class="footer__logo"><a href="{{ url('/') }}"><img src="{{ asset('frontend/img/logo.png') }}" alt=""></a></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt cilisis.</p>
                        <div class="footer__payment">
                            <a href="#"><img src="{{ asset('frontend/img/payment/payment-1.png') }}" alt=""></a>
                            <a href="#"><img src="{{ asset('frontend/img/payment/payment-2.png') }}" alt=""></a>
                            <a href="#"><img src="{{ asset('frontend/img/payment/payment-3.png') }}" alt=""></a>
                            <a href="#"><img src="{{ asset('frontend/img/payment/payment-4.png') }}" alt=""></a>
                            <a href="#"><img src="{{ asset('frontend/img/payment/payment-5.png') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-5">
                    <div class="footer__widget"><h6>Quick links</h6><ul><li><a href="#">About</a></li><li><a href="#">Blogs</a></li><li><a href="{{ route('contact') }}">Contact</a></li><li><a href="#">FAQ</a></li></ul></div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="footer__widget"><h6>Account</h6><ul><li><a href="#">My Account</a></li><li><a href="#">Orders Tracking</a></li><li><a href="{{ route('checkout') }}">Checkout</a></li><li><a href="#">Wishlist</a></li></ul></div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-8">
                    <div class="footer__newslatter">
                        <h6>NEWSLETTER</h6>
                        <form action="#"><input type="text" placeholder="Email"><button type="submit" class="site-btn">Subscribe</button></form>
                        <div class="footer__social"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-youtube-play"></i></a><a href="#"><i class="fa fa-instagram"></i></a><a href="#"><i class="fa fa-pinterest"></i></a></div>
                    </div>
                </div>
            </div>
            <div class="row"><div class="col-lg-12"><div class="footer__copyright__text"><p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p></div></div></div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form" action="{{ route('shop') }}" method="GET">
                <input type="text" name="search" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="position: fixed; top: 80px; right: 20px; z-index: 9999;">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" style="position: fixed; top: 80px; right: 20px; z-index: 9999;">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    <script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);

    // Image path fix (keeping your existing code)
    document.addEventListener('DOMContentLoaded', function(){
        var imgPrefix = '{{ asset("frontend/img") }}' + '/';
        document.querySelectorAll('[data-setbg]').forEach(function(el){
            var bg = el.getAttribute('data-setbg');
            if(bg && bg.indexOf('img/')===0) el.setAttribute('data-setbg', bg.replace(/^img\//, imgPrefix));
        });
        document.querySelectorAll('img').forEach(function(img){
            var s = img.getAttribute('src');
            if(s && s.indexOf('img/')===0) img.setAttribute('src', s.replace(/^img\//, imgPrefix));
        });
    });
    </script>

    <!-- Js Plugins -->
    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <!-- Custom JavaScript for AJAX -->
    <script>
    $(document).ready(function() {
        // AJAX setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add to cart functionality
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            var quantity = $(this).data('quantity') || 1;
            var size = $(this).data('size') || 'M';
            var color = $(this).data('color') || 'Black';

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
                    // Update cart count
                    $('.tip').text(response.cart_count || 0);

                    // Show success message
                    alert('Product added to cart successfully!');
                },
                error: function(xhr) {
                    alert('Error adding product to cart');
                }
            });
        });
    });
    /*--------------------------
    Banner Slider with Dynamic Background
----------------------------*/
$(document).ready(function() {
    // Check if we have a dynamic banner
    if ($('#dynamic-banner').length > 0 && $('#banner-carousel').length > 0) {

        // Initialize Owl Carousel
        var bannerSlider = $("#banner-carousel").owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            dots: true,
            smartSpeed: 1200,
            autoHeight: false,
            autoplay: true
        });

        // Function to update banner background
        function updateBannerBackground() {
            var currentItem = $('#banner-carousel .owl-item.active .banner__item');
            var bgImage = currentItem.data('bg');

            if (bgImage) {
                $('#dynamic-banner').css({
                    'background-image': 'url(' + bgImage + ')',
                    'background-size': 'cover',
                    'background-position': 'center',
                    'background-repeat': 'no-repeat'
                });
            }
        }

        // Update background when slide changes
        $('#banner-carousel').on('changed.owl.carousel', function(event) {
            updateBannerBackground();
        });

        // Set initial background
        setTimeout(updateBannerBackground, 100);

    } else {
        // Fallback for regular banner sliders (non-dynamic)
        $(".banner__slider").owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            dots: true,
            smartSpeed: 1200,
            autoHeight: false,
            autoplay: true
        });
    }
});
    </script>
    @yield('scripts')
</body>
</html>
