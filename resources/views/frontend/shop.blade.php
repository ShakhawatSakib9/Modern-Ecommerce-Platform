@extends('frontend.layout')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <div class="sidebar__categories">
                            <div class="section-title">
                                <h4>Categories</h4>
                            </div>
                            <div class="categories__accordion">
                                <div class="accordion" id="accordionExample">
                                    @foreach($categories as $index => $category)
                                    <div class="card">
                                        <div class="card-heading {{ $index == 0 ? 'active' : '' }}">
                                            <a data-toggle="collapse" data-target="#collapse{{ $category->id }}">{{ $category->name }}</a>
                                        </div>
                                        <div id="collapse{{ $category->id }}" class="collapse {{ $index == 0 ? 'show' : '' }}" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul>
                                                    <li><a href="{{ route('shop', ['category' => $category->id]) }}">All {{ $category->name }}</a></li>
                                                    @foreach($category->subCategories as $subCategory)
                                                    <li><a href="{{ route('shop', ['subcategory' => $subCategory->id]) }}">{{ $subCategory->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__filter">
                            <div class="section-title">
                                <h4>Shop by price</h4>
                            </div>
                            <div class="filter-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="33" data-max="99"></div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <p>Price:</p>
                                        <input type="text" id="minamount" value="33">
                                        <input type="text" id="maxamount" value="99">
                                    </div>
                                </div>
                            </div>
                            <a href="#" id="priceFilterBtn">Filter</a>
                        </div>
                        <div class="sidebar__sizes">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list">
                                @php
                                    $sizes = ['xxs', 'xs', 'xss', 's', 'm', 'ml', 'l', 'xl'];
                                @endphp
                                @foreach($sizes as $size)
                                <label for="{{ $size }}">
                                    {{ $size }}
                                    <input type="checkbox" id="{{ $size }}" class="size-filter">
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="sidebar__color">
                            <div class="section-title">
                                <h4>Shop by color</h4>
                            </div>
                            <div class="size__list color__list">
                                @php
                                    $colors = ['black', 'whites', 'reds', 'greys', 'blues', 'beige', 'greens', 'yellows'];
                                    $colorNames = ['Blacks', 'Whites', 'Reds', 'Greys', 'Blues', 'Beige Tones', 'Greens', 'Yellows'];
                                @endphp
                                @foreach($colors as $index => $color)
                                <label for="{{ $color }}">
                                    {{ $colorNames[$index] }}
                                    <input type="checkbox" id="{{ $color }}" class="color-filter">
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="product__item {{ $product->is_on_sale ? 'sale' : '' }}">
                                <div class="product__item__pic set-bg" data-setbg="{{ $product->getFirstImageUrl() ?? asset('frontend/img/shop/shop-1.jpg') }}">
                                    @if($product->isNew())
                                    <div class="label new">New</div>
                                    @endif
                                    @if($product->is_on_sale)
                                    <div class="label">Sale</div>
                                    @endif
                                    @if($product->stock_quantity <= 0)
                                    <div class="label stockout stockblue">Out Of Stock</div>
                                    @endif
                                    <ul class="product__hover">
                                        <li><a href="{{ $product->getFirstImageUrl() ?? asset('frontend/img/shop/shop-1.jpg') }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                        <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                        <li><a href="#" class="add-to-cart-btn" data-product-id="{{ $product->id }}"><span class="icon_bag_alt"></span></a></li>
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
                                        ${{ number_format($product->discount_price, 2) }} <span>${{ number_format($product->regular_price, 2) }}</span>
                                        @else
                                        ${{ number_format($product->regular_price, 2) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Static fallback -->
                        @if(count($products) == 0)
                        @php
                            $staticProducts = [
                                ['image' => 'shop-1.jpg', 'label' => 'new', 'title' => 'Furry hooded parka', 'price' => '59.0'],
                                ['image' => 'shop-2.jpg', 'label' => '', 'title' => 'Flowy striped skirt', 'price' => '49.0'],
                                ['image' => 'shop-3.jpg', 'label' => '', 'title' => 'Croc-effect bag', 'price' => '59.0'],
                                ['image' => 'shop-4.jpg', 'label' => '', 'title' => 'Dark wash Xavi jeans', 'price' => '59.0'],
                                ['image' => 'shop-5.jpg', 'label' => 'sale', 'title' => 'Ankle-cuff sandals', 'price' => '49.0', 'old_price' => '59.0'],
                                ['image' => 'shop-6.jpg', 'label' => '', 'title' => 'Contrasting sunglasses', 'price' => '59.0'],
                                ['image' => 'shop-7.jpg', 'label' => '', 'title' => 'Circular pendant earrings', 'price' => '59.0'],
                                ['image' => 'shop-8.jpg', 'label' => 'stockout', 'title' => 'Cotton T-Shirt', 'price' => '59.0'],
                                ['image' => 'shop-9.jpg', 'label' => 'sale', 'title' => 'Water resistant zips backpack', 'price' => '49.0', 'old_price' => '59.0'],
                            ];
                        @endphp

                        @foreach($staticProducts as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="product__item {{ $item['label'] == 'sale' ? 'sale' : '' }}">
                                <div class="product__item__pic set-bg" data-setbg="{{ asset('frontend/img/shop/' . $item['image']) }}">
                                    @if($item['label'] == 'new')
                                    <div class="label new">New</div>
                                    @elseif($item['label'] == 'sale')
                                    <div class="label">Sale</div>
                                    @elseif($item['label'] == 'stockout')
                                    <div class="label stockout stockblue">Out Of Stock</div>
                                    @endif
                                    <ul class="product__hover">
                                        <li><a href="{{ asset('frontend/img/shop/' . $item['image']) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                        <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                        <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="#">{{ $item['title'] }}</a></h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product__price">
                                        ${{ $item['price'] }}
                                        @if(isset($item['old_price']))
                                        <span>${{ $item['old_price'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        <div class="col-lg-12 text-center">
                            <div class="pagination__option">
                                {{ $products->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

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
            <form class="search-model-form" action="{{ route('shop') }}" method="GET">
                <input type="text" name="search" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Price range slider
    if ($(".price-range").length) {
        $(".price-range").slider({
            range: true,
            min: 33,
            max: 99,
            values: [33, 99],
            slide: function (event, ui) {
                $("#minamount").val(ui.values[0]);
                $("#maxamount").val(ui.values[1]);
            }
        });

        $("#minamount").val($(".price-range").slider("values", 0));
        $("#maxamount").val($(".price-range").slider("values", 1));
    }

    // Price filter button
    $('#priceFilterBtn').click(function(e) {
        e.preventDefault();
        var minPrice = $('#minamount').val();
        var maxPrice = $('#maxamount').val();
        window.location.href = '{{ route("shop") }}?min_price=' + minPrice + '&max_price=' + maxPrice;
    });

    // Size filter
    $('.size-filter').change(function() {
        var sizes = [];
        $('.size-filter:checked').each(function() {
            sizes.push($(this).attr('id').toUpperCase());
        });

        if(sizes.length > 0) {
            window.location.href = '{{ route("shop") }}?size=' + sizes.join(',');
        }
    });

    // Color filter
    $('.color-filter').change(function() {
        var colors = [];
        $('.color-filter:checked').each(function() {
            colors.push($(this).attr('id'));
        });

        if(colors.length > 0) {
            window.location.href = '{{ route("shop") }}?color=' + colors.join(',');
        }
    });
});
</script>
@endsection
