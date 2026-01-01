/*  ---------------------------------------------------
Template Name: Ashion
Description: Ashion ecommerce template
Author: Colorib
Author URI: https://colorlib.com/
Version: 1.0
Created: Colorib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Product filter
        --------------------*/
        $('.filter__controls li').on('click', function () {
            $('.filter__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.property__gallery').length > 0) {
            var containerEl = document.querySelector('.property__gallery');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Search Switch
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    //Canvas Menu
    $(".canvas__open").on('click', function () {
        $(".offcanvas-menu-wrapper").addClass("active");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".offcanvas-menu-overlay, .offcanvas__close").on('click', function () {
        $(".offcanvas-menu-wrapper").removeClass("active");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".header__menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Accordin Active
    --------------------*/
    $('.collapse').on('shown.bs.collapse', function () {
        $(this).prev().addClass('active');
    });

    $('.collapse').on('hidden.bs.collapse', function () {
        $(this).prev().removeClass('active');
    });

    /*--------------------------
        Dynamic Banner Slider with Background Change
    ----------------------------*/
    $(document).ready(function() {
        // Check if we have a dynamic banner
        if ($('#dynamic-banner').length > 0 && $('#banner-carousel').length > 0) {

            // Initialize Owl Carousel with dynamic background support
            var bannerSlider = $("#banner-carousel").owlCarousel({
                loop: true,
                margin: 0,
                items: 1,
                dots: true,
                smartSpeed: 1200,
                autoHeight: false,
                autoplay: true,
                autoplayTimeout: 5000,
                onInitialized: function(event) {
                    updateBannerBackground(event);
                },
                onChanged: function(event) {
                    updateBannerBackground(event);
                }
            });

            // Function to update banner background
            function updateBannerBackground(event) {
                var currentItem;

                if (event && event.item) {
                    // Get current slide item
                    currentItem = $(event.target)
                        .find('.owl-item')
                        .eq(event.item.index)
                        .find('.banner__item');
                } else {
                    // Get initial active item
                    currentItem = $('#banner-carousel .owl-item.active .banner__item');
                }

                // Get background image from data-bg attribute
                var bgImage = currentItem.data('bg');

                if (bgImage) {
                    // Apply background to the main banner section
                    $('#dynamic-banner').css({
                        'background-image': 'url(' + bgImage + ')',
                        'background-size': 'cover',
                        'background-position': 'center',
                        'background-repeat': 'no-repeat'
                    });
                }
            }

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

    /*--------------------------
        Product Details Slider
    ----------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: false,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<i class='arrow_carrot-left'></i>","<i class='arrow_carrot-right'></i>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: false,
        mouseDrag: false,
        startPosition: 'URLHash'
    }).on('changed.owl.carousel', function(event) {
        var indexNum = event.item.index + 1;
        product_thumbs(indexNum);
    });

    function product_thumbs (num) {
        var thumbs = document.querySelectorAll('.product__thumb a');
        thumbs.forEach(function (e) {
            e.classList.remove("active");
            if(e.hash.split("-")[1] == num) {
                e.classList.add("active");
            }
        })
    }


    /*------------------
		Magnific
    --------------------*/
    $('.image-popup').magnificPopup({
        type: 'image'
    });


    $(".nice-scroll").niceScroll({
        cursorborder:"",
        cursorcolor:"#dddddd",
        boxzoom:false,
        cursorwidth: 5,
        background: 'rgba(0, 0, 0, 0.2)',
        cursorborderradius:50,
        horizrailenabled: false
    });

    /*------------------
        CountDown
    --------------------*/
    // For demo preview start
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    if(mm == 12) {
        mm = '01';
        yyyy = yyyy + 1;
    } else {
        mm = parseInt(mm) + 1;
        mm = String(mm).padStart(2, '0');
    }
    var timerdate = mm + '/' + dd + '/' + yyyy;
    // For demo preview end


    // Uncomment below and use your date //

    /* var timerdate = "2020/12/30" */

	$("#countdown-time").countdown(timerdate, function(event) {
        $(this).html(event.strftime("<div class='countdown__item'><span>%D</span> <p>Day</p> </div>" + "<div class='countdown__item'><span>%H</span> <p>Hour</p> </div>" + "<div class='countdown__item'><span>%M</span> <p>Min</p> </div>" + "<div class='countdown__item'><span>%S</span> <p>Sec</p> </div>"));
    });

    /*-------------------
		Range Slider
	--------------------- */
	var rangeSlider = $(".price-range"),
    minamount = $("#minamount"),
    maxamount = $("#maxamount"),
    minPrice = rangeSlider.data('min'),
    maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
    range: true,
    min: minPrice,
    max: maxPrice,
    values: [minPrice, maxPrice],
    slide: function (event, ui) {
        minamount.val('$' + ui.values[0]);
        maxamount.val('$' + ui.values[1]);
        }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));

    /*------------------
		Single Product
	--------------------*/
	$('.product__thumb .pt').on('click', function(){
		var imgurl = $(this).data('imgbigurl');
		var bigImg = $('.product__big__img').attr('src');
		if(imgurl != bigImg) {
			$('.product__big__img').attr({src: imgurl});
		}
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
	proQty.prepend('<span class="dec qtybtn">-</span>');
	proQty.append('<span class="inc qtybtn">+</span>');
	proQty.on('click', '.qtybtn', function () {
		var $button = $(this);
		var oldValue = $button.parent().find('input').val();
		if ($button.hasClass('inc')) {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}
		$button.parent().find('input').val(newVal);
    });

    /*-------------------
		Radio Btn
	--------------------- */
    $(".size__btn label").on('click', function () {
        $(".size__btn label").removeClass('active');
        $(this).addClass('active');
    });
        /*------------------
        Trend Section
    --------------------*/

    // Add to cart from trend items
    $(document).on('click', '.trend__item .add-to-cart-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var $button = $(this);
        var productId = $button.data('product-id');

        if (!productId) return;

        // Store original content
        var originalHtml = $button.html();

        // Show loading
        $button.html('<i class="fa fa-spinner fa-spin"></i>');
        $button.prop('disabled', true);

        $.ajax({
            url: '{{ route("cart.add") }}',
            type: 'POST',
            data: { product_id: productId, quantity: 1 },
            success: function(response) {
                // Update cart count
                $('.tip').each(function() {
                    $(this).text(response.cart_count || 0);
                });

                // Show success
                alert('Product added to cart!');

                // Reset button
                setTimeout(() => {
                    $button.html(originalHtml);
                    $button.prop('disabled', false);
                }, 500);
            },
            error: function() {
                alert('Error adding to cart');
                $button.html(originalHtml);
                $button.prop('disabled', false);
            }
        });
    });

    // Hover effects for trend items
    $(document).on('mouseenter', '.trend__item', function() {
        $(this).css({
            'transform': 'translateY(-5px)',
            'transition': 'all 0.3s ease',
            'box-shadow': '0 5px 15px rgba(0,0,0,0.1)'
        });
    }).on('mouseleave', '.trend__item', function() {
        $(this).css({
            'transform': 'translateY(0)',
            'box-shadow': 'none'
        });
    });

    // Initialize product filters in trend section
    $('.filter__controls li').on('click', function() {
        $('.filter__controls li').removeClass('active');
        $(this).addClass('active');
    });
        /*--------------------------
        Dynamic Countdown
    ----------------------------*/
    function initDiscountCountdown() {
        const countdownEl = $('#countdown-time');

        if (countdownEl.length && countdownEl.data('end-date')) {
            const endDate = new Date(countdownEl.data('end-date')).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance < 0) {
                    $('.countdown__item span').text('00');
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $('#countdown-days').text(days.toString().padStart(2, '0'));
                $('#countdown-hours').text(hours.toString().padStart(2, '0'));
                $('#countdown-minutes').text(minutes.toString().padStart(2, '0'));
                $('#countdown-seconds').text(seconds.toString().padStart(2, '0'));
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
    }

    // Initialize on page load
    $(window).on('load', function() {
        initDiscountCountdown();
    });
        /*--------------------------
        Discount Banner Slider
    ----------------------------*/
    function initDiscountSlider() {
        if ($('#discount-slider').length) {
            $('#discount-slider').owlCarousel({
                loop: true,
                items: 1,
                dots: true,
                nav: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                smartSpeed: 800,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                margin: 0,
                stagePadding: 0,
                onInitialized: function(event) {
                    initDiscountCountdowns();
                },
                onChanged: function(event) {
                    initDiscountCountdowns();
                }
            });
        }
    }

    /*--------------------------
        Discount Countdowns
    ----------------------------*/
    function initDiscountCountdowns() {
        $('.discount__countdown').each(function() {
            const $this = $(this);
            const endDate = $this.data('end-date');

            if (!endDate) return;

            const endDateTime = new Date(endDate).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endDateTime - now;

                if (distance < 0) {
                    $this.find('.countdown-days').text('00');
                    $this.find('.countdown-hours').text('00');
                    $this.find('.countdown-minutes').text('00');
                    $this.find('.countdown-seconds').text('00');
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $this.find('.countdown-days').text(days.toString().padStart(2, '0'));
                $this.find('.countdown-hours').text(hours.toString().padStart(2, '0'));
                $this.find('.countdown-minutes').text(minutes.toString().padStart(2, '0'));
                $this.find('.countdown-seconds').text(seconds.toString().padStart(2, '0'));
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    }

    // Initialize on page load
    $(window).on('load', function() {
        initDiscountSlider();
    });
    /* Instagram Slider */
    function initInstagramSlider() {
        if ($('.instagram__slider').length) {
            $('.instagram__slider').owlCarousel({
                loop: true,
                margin: 10,
                dots: true,
                nav: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                autoplay: true,
                autoplayTimeout: 3000,
                responsive: {
                    0: { items: 2 },
                    576: { items: 3 },
                    768: { items: 4 },
                    992: { items: 6 }
                }
            });
        }
    }

    // Initialize
    $(window).on('load', function() {
        initInstagramSlider();
    });
    /* Fix Instagram square background images */
function fixInstagramBackgrounds() {
    $('.instagram__item[data-setbg]').each(function() {
        var bg = $(this).data('setbg');
        if (bg) {
            $(this).css({
                'background-image': 'url(' + bg + ')',
                'background-position': 'center center',
                'background-size': 'cover',
                'background-repeat': 'no-repeat'
            });
        }
    });
}

// Initialize
$(document).ready(function() {
    fixInstagramBackgrounds();
});

})(jQuery);
