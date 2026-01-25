<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($settings->meta_title ?? $settings->site_name ?? 'Innoflexia'))</title>
    <meta name="description" content="{{ $settings->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $settings->meta_keywords ?? '' }}">

    @if($settings && $settings->favicon)
    <link rel="shortcut icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/x-icon">
    @endif

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
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('styles')
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="{{ route('wishlist') }}"><span class="icon_heart_alt"></span>
                    <div class="tip wishlist-count">{{ \App\Http\Controllers\Frontend\WishlistController::getWishlistCount() }}</div>
                </a></li>
            <li><a href="{{ route('cart') }}"><span class="icon_bag_alt"></span>
                    <div class="tip cart-count">{{ \App\Http\Controllers\Frontend\CartController::getCartCount() }}</div>
                </a></li>
        </ul>
        <div class="offcanvas__logo">
            <a href="{{ url('/') }}">
                @if($settings && $settings->logo)
                <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name }}" style="max-height: 50px;">
                @else
                <img src="{{ asset('frontend/img/logo.png') }}" alt="">
                @endif
            </a>
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
                    <div class="header__logo">
                        <a href="{{ url('/') }}">
                            @if($settings && $settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name }}" style="max-height: 50px;">
                            @else
                            <img src="{{ asset('frontend/img/logo.png') }}" alt="">
                            @endif
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu" align="center">
                        <ul>
                            <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                            <li class="{{ request()->is('shop*') ? 'active' : '' }}"><a href="{{ route('shop') }}">Shop</a>
                                @if($global_categories->count() > 0)
                                <ul class="dropdown">
                                    @foreach($global_categories as $cat)
                                    <li><a href="{{ route('shop', ['category' => $cat->id]) }}">{{ $cat->name }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            <li class="{{ request()->is('blog*') ? 'active' : '' }}"><a href="{{ route('blog') }}">Blog</a></li>
                            <li class="{{ request()->is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        <div class="header__right__auth"><a href="{{ route('admin.login') }}">Admin</a></div>
                        <ul class="header__right__widget">
                            <li><span class="icon_search search-switch"></span></li>
                            <li><a href="{{ route('wishlist') }}"><span class="icon_heart_alt"></span>
                                    <div class="tip wishlist-count">{{ \App\Http\Controllers\Frontend\WishlistController::getWishlistCount() }}</div>
                                </a></li>
                            <li><a href="{{ route('cart') }}"><span class="icon_bag_alt"></span>
                                    <div class="tip cart-count">{{ \App\Http\Controllers\Frontend\CartController::getCartCount() }}</div>
                                </a></li>
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
    {{-- Instagram Section --}}
    @include('frontend.partials.instagram')
    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-7">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="{{ url('/') }}">
                                @if($settings && $settings->logo)
                                <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name }}" style="max-height: 50px;">
                                @else
                                <img src="{{ asset('frontend/img/logo.png') }}" alt="">
                                @endif
                            </a>
                        </div>
                        <p>{{ $settings->about_text ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt cilisis.' }}</p>
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
                    <div class="footer__widget">
                        <h6>Quick links</h6>
                        <ul>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('blog') }}">Blogs</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            <li><a href="{{ route('shop') }}">Shop</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="footer__widget">
                        <h6>Account</h6>
                        <ul>
                            <li><a href="{{ route('order.track') }}">Orders Tracking</a></li>
                            <li><a href="{{ route('checkout') }}">Checkout</a></li>
                            <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                            <li><a href="{{ route('cart') }}">Cart</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-8">
                    <div class="footer__newslatter">
                        <h6>NEWSLETTER</h6>
                        <form action="#"><input type="text" placeholder="Email"><button type="submit" class="site-btn">Subscribe</button></form>
                        <div class="footer__social">
                            @if($settings && $settings->facebook_url)<a href="{{ $settings->facebook_url }}"><i class="fa fa-facebook"></i></a>@endif
                            @if($settings && $settings->twitter_url)<a href="{{ $settings->twitter_url }}"><i class="fa fa-twitter"></i></a>@endif
                            @if($settings && $settings->youtube_url)<a href="{{ $settings->youtube_url }}"><i class="fa fa-youtube-play"></i></a>@endif
                            @if($settings && $settings->instagram_url)<a href="{{ $settings->instagram_url }}"><i class="fa fa-instagram"></i></a>@endif
                            @if($settings && $settings->pinterest_url)<a href="{{ $settings->pinterest_url }}"><i class="fa fa-pinterest"></i></a>@endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright__text">
                        <p>Copyright &copy; <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is refined with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://innoflexia.com" target="_blank" class="text-primary font-weight-bold">Innoflexia</a></p>
                    </div>
                </div>
            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            var imgPrefix = '{{ asset("frontend/img") }}' + '/';
            document.querySelectorAll('[data-setbg]').forEach(function(el) {
                var bg = el.getAttribute('data-setbg');
                if (bg && bg.indexOf('img/') === 0) el.setAttribute('data-setbg', bg.replace(/^img\//, imgPrefix));
            });
            document.querySelectorAll('img').forEach(function(img) {
                var s = img.getAttribute('src');
                if (s && s.indexOf('img/') === 0) img.setAttribute('src', s.replace(/^img\//, imgPrefix));
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

            // SweetAlert2 Toast function
            function showSwalToast(icon, title, position = 'top-end') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: position,
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: icon,
                    title: title
                });
            }

            // Add to cart functionality
            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();

                var productId = $(this).data('product-id');
                var quantity = $(this).data('quantity') || 1;
                var size = $(this).data('size') || 'M';
                var color = $(this).data('color') || 'Black';
                var productName = $(this).closest('.product__item').find('h6 a').text();

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
                            // Update cart count
                            $('.cart-count').text(response.cart_count || 0);

                            // Show success toast
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

            // Wishlist functionality
            $(document).on('click', '.wishlist-btn', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                var $btn = $(this);
                var $icon = $btn.find('.icon_heart_alt');
                var isActive = $btn.hasClass('active');

                var url = isActive ? '{{ route("wishlist.remove") }}' : '{{ route("wishlist.add") }}';
                var successMessage = isActive ? 'Product removed from wishlist!' : 'Product added to wishlist!';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update wishlist count
                            $('.wishlist-count').text(response.count);

                            // Toggle button state
                            $btn.toggleClass('active');

                            showSwalToast('success', successMessage);
                        } else {
                            showSwalToast('info', response.message);
                        }
                    },
                    error: function() {
                        showSwalToast('error', 'Failed to update wishlist');
                    }
                });
            });

            // Check wishlist status on page load
            function checkWishlistStatus() {
                $('.wishlist-btn').each(function() {
                    var productId = $(this).data('product-id');
                    var $btn = $(this);

                    $.ajax({
                        url: '{{ route("wishlist.check") }}',
                        type: 'POST',
                        data: {
                            product_id: productId
                        },
                        success: function(response) {
                            if (response.success && response.in_wishlist) {
                                $btn.addClass('active');
                            }
                        }
                    });
                });
            }

            // Image path fix
            document.addEventListener('DOMContentLoaded', function() {
                var imgPrefix = '{{ asset("frontend/img") }}' + '/';
                document.querySelectorAll('[data-setbg]').forEach(function(el) {
                    var bg = el.getAttribute('data-setbg');
                    if (bg && bg.indexOf('img/') === 0) el.setAttribute('data-setbg', bg.replace(/^img\//, imgPrefix));
                });
                document.querySelectorAll('img').forEach(function(img) {
                    var s = img.getAttribute('src');
                    if (s && s.indexOf('img/') === 0) img.setAttribute('src', s.replace(/^img\//, imgPrefix));
                });
            });

            /*--------------------------
            Banner Slider with Dynamic Background
            ----------------------------*/
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

            // Run wishlist check on page load
            checkWishlistStatus();

            // Frontend Theme Toggle Logic
            const themeToggleFrontend = $('#theme-toggle-frontend');
            const body = $('body');

            // Check saved theme
            if (localStorage.getItem('frontend-theme') === 'dark') {
                body.addClass('dark-mode');
                themeToggleFrontend.removeClass('icon_moon_alt').addClass('icon_sun');
            }

            themeToggleFrontend.on('click', function() {
                body.toggleClass('dark-mode');

                if (body.hasClass('dark-mode')) {
                    localStorage.setItem('frontend-theme', 'dark');
                    $(this).removeClass('icon_moon_alt').addClass('icon_sun');
                } else {
                    localStorage.setItem('frontend-theme', 'light');
                    $(this).removeClass('icon_sun').addClass('icon_moon_alt');
                }
            });
        });
    </script>
    @yield('scripts')
</body>

</html>